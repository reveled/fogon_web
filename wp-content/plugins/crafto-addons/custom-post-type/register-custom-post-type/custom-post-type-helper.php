<?php
/**
 * Helper for new registered custom post types.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_slug_has_quotes' ) ) {
	/**
	 * Returns error message for if trying to use quotes in slugs or rewrite slugs.
	 *
	 * @return string
	 */
	function crafto_slug_has_quotes() {
		return sprintf(
			esc_html__( 'Please do not use quotes in post type/taxonomy names or rewrite slugs', 'crafto-addons' ),
			crafto_get_object_from_post_global()
		);
	}
}

if ( ! function_exists( 'crafto_add_success_admin_notice' ) ) {
	/**
	 * Successful add callback.
	 */
	function crafto_add_success_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( '%s has been successfully added', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			)
		);
	}
}

if ( ! function_exists( 'crafto_add_fail_admin_notice' ) ) {
	/**
	 * Fail to add callback.
	 */
	function crafto_add_fail_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( '%s has failed to be added', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			),
			false
		);
	}
}

if ( ! function_exists( 'crafto_update_success_admin_notice' ) ) {
	/**
	 * Successful update callback.
	 */
	function crafto_update_success_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( '%s has been successfully updated', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			)
		);
	}
}

if ( ! function_exists( 'crafto_update_fail_admin_notice' ) ) {
	/**
	 * Fail to update callback.
	 */
	function crafto_update_fail_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( '%s has failed to be updated', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			),
			false
		);
	}
}

if ( ! function_exists( 'crafto_delete_success_admin_notice' ) ) {
	/**
	 * Successful delete callback.
	 */
	function crafto_delete_success_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( '%s has been successfully deleted', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			)
		);
	}
}

if ( ! function_exists( 'crafto_delete_fail_admin_notice' ) ) {
	/**
	 * Fail to delete callback.
	 */
	function crafto_delete_fail_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( '%s has failed to be deleted', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			),
			false
		);
	}
}

if ( ! function_exists( 'crafto_error_admin_notice' ) ) {
	/**
	 * Error admin notice.
	 */
	function crafto_error_admin_notice() {
		echo crafto_admin_notices_helper( // phpcs:ignore WordPress.Security.EscapeOutput
			apply_filters( 'crafto_custom_error_message', '' ),
			false
		);
	}
}

if ( ! function_exists( 'crafto_admin_notices_helper' ) ) {
	/**
	 * Secondary admin notices function for use with admin_notices hook.
	 *
	 * Constructs admin notice HTML.
	 *
	 * @param string $message Message to use in admin notice. Optional. Default empty string.
	 * @param bool   $success Whether or not a success. Optional. Default true.
	 * @return mixed
	 */
	function crafto_admin_notices_helper( $message = '', $success = true ) {

		$class   = [];
		$class[] = $success ? 'updated' : 'error';
		$class[] = 'notice is-dismissible';

		$messagewrapstart = '<div id="message" class="' . implode( ' ', $class ) . '"><p>';

		$messagewrapend = '</p></div>';

		$action = '';

		/**
		 * Filters the custom admin notice for Crafto.
		 *
		 * @param string $value            Complete HTML output for notice.
		 * @param string $action           Action whose message is being generated.
		 * @param string $message          The message to be displayed.
		 * @param string $messagewrapstart Beginning wrap HTML.
		 * @param string $messagewrapend   Ending wrap HTML.
		 */
		return apply_filters( 'crafto_admin_notice', $messagewrapstart . $message . $messagewrapend, $action, $message, $messagewrapstart, $messagewrapend );
	}
}

if ( ! function_exists( 'crafto_get_object_from_post_global' ) ) {
	/**
	 * Grab post type or taxonomy slug from $_POST global, if available.
	 *
	 * @internal
	 *
	 * @return string
	 */
	function crafto_get_object_from_post_global() {
		if ( isset( $_POST['crafto_custom_post_type']['name'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$type_item = filter_input( INPUT_POST, 'crafto_custom_post_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );
			if ( $type_item ) {
				return sanitize_text_field( $type_item['name'] );
			}
		}

		if ( isset( $_POST['crafto_custom_tax']['name'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$tax_item = filter_input( INPUT_POST, 'crafto_custom_tax', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );
			if ( $tax_item ) {
				return sanitize_text_field( $tax_item['name'] );
			}
		}

		if ( isset( $_POST['crafto_custom_meta']['meta_label'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$meta_item = filter_input( INPUT_POST, 'crafto_custom_meta', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );
			if ( $meta_item ) {
				return sanitize_text_field( $meta_item['meta_label'] );
			}
		}

		return esc_html__( 'Object', 'crafto-addons' );
	}
}

if ( ! function_exists( 'crafto_admin_notices' ) ) {
	/**
	 * Return a notice based on conditions.
	 *
	 * @param string $action       The type of action that occurred. Optional. Default empty string.
	 * @param string $object_type  Whether it's from a post type or taxonomy. Optional. Default empty string.
	 * @param bool   $success      Whether the action succeeded or not. Optional. Default true.
	 * @param string $custom       Custom message if necessary. Optional. Default empty string.
	 * @return bool|string false on no message, else HTML div with our notice message.
	 */
	function crafto_admin_notices( $action = '', $object_type = '', $success = true, $custom = '' ) {
		$class       = [];
		$class[]     = $success ? 'updated' : 'error';
		$class[]     = 'notice is-dismissible';
		$object_type = esc_attr( $object_type );

		$messagewrapstart = '<div id="message" class="' . implode( ' ', $class ) . '"><p>';
		$messagewrapend   = '</p></div>';

		$message = '';
		if ( 'add' === $action ) {
			if ( $success ) {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has been successfully added.', 'crafto-addons' ) );
			} else {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has failed to be added.', 'crafto-addons' ) );
			}
		} elseif ( 'update' === $action ) {
			if ( $success ) {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has been successfully updated.', 'crafto-addons' ) );
			} else {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has failed to be updated.', 'crafto-addons' ) );
			}
		} elseif ( 'delete' === $action ) {
			if ( $success ) {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has been successfully deleted.', 'crafto-addons' ) );
			} else {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has failed to be deleted.', 'crafto-addons' ) );
			}
		} elseif ( 'import' === $action ) {
			if ( $success ) {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has been successfully imported.', 'crafto-addons' ) );
			} else {
				$message .= sprintf( '%1$s %2$s', $object_type, esc_html__( 'has failed to be imported.', 'crafto-addons' ) );
			}
		} elseif ( 'error' === $action ) {
			if ( ! empty( $custom ) ) {
				$message = $custom;
			}
		}

		if ( $message ) {

			/**
			 * Filters the custom admin notice for Crafto.
			 *
			 * @since 1.0.0
			 *
			 * @param string $value            Complete HTML output for notice.
			 * @param string $action           Action whose message is being generated.
			 * @param string $message          The message to be displayed.
			 * @param string $messagewrapstart Beginning wrap HTML.
			 * @param string $messagewrapend   Ending wrap HTML.
			 */
			return apply_filters( 'crafto_admin_notice', $messagewrapstart . $message . $messagewrapend, $action, $message, $messagewrapstart, $messagewrapend );
		}

		return false;
	}
}
