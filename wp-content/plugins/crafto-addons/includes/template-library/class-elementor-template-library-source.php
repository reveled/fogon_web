<?php
/**
 * Template Library Data
 *
 * @package Crafto
 */

namespace CraftoAddons\Template_Library;

use Elementor\TemplateLibrary\Source_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Template_Library_Source extends Source_Base {

	/**
	 * Template library data cache
	 */
	const LIBRARY_CACHE_ID = 'crafto_temp_library_cache';

	/**
	 * Template info api url
	 */
	const TEMPLATE_LIBRARY_API_INFO = 'https://cralib.themezaa.com/wp-json/crafto/v1';

	/**
	 * Template data api url
	 */
	const TEMPLATE_LIBRARY_ITEMS_API_TEMPLATES = 'https://cralib.themezaa.com/wp-json/crafto/v1/templates/';


	/**
	 * Get ID.
	 */
	public function get_id() {
		return 'crafto-addons-library';
	}
	/**
	 * Template Library Title.
	 */
	public function get_title() {
		return esc_html__( 'Template Library', 'crafto-addons' );
	}
	/**
	 * Registers data with the system or component.
	 */
	public function register_data() {}
	/**
	 * Saves the provided template data.
	 *
	 * @param array $template_data An associative array containing the data to be saved.
	 */
	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to Template Library' );
	}
	/**
	 * Updates an item with new data.
	 *
	 * @param array $new_data An associative array containing the new data for the item.
	 */
	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to Template Library' );
	}
	/**
	 * Deletes a template based on its ID.
	 *
	 * @param int $template_id The ID of the template to be deleted.
	 */
	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from Template Library' );
	}
	/**
	 * Exports a template based on its ID.
	 *
	 * @param int $template_id The ID of the template to be exported.
	 */
	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from Template Library' );
	}
	/**
	 * Retrieves a list of items based on the provided arguments.
	 *
	 * @param array $args Optional.
	 */
	public function get_items( $args = [] ) {
		$templates    = [];
		$library_data = self::get_library_data();

		if ( ! empty( $library_data['data'] ) ) {
			foreach ( $library_data['data'] as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}
		return $templates;
	}
	/**
	 * Retrieves a list of categories.
	 */
	public function get_categories() {
		$data          = [];
		$category_data = self::crafto_get_remote_categories();

		foreach ( $category_data as $value ) {
			$key          = strtolower( str_replace( ' ', '-', $value ) );
			$data[ $key ] = $value;
		}

		return ( ! empty( $data ) ? $data : [] );
	}
	/**
	 * Retrieves the type of category.
	 */
	public function get_type_category() {
		$data          = [];
		$category_data = self::crafto_get_remote_categories();

		foreach ( $category_data as $value ) {
			$key    = strtolower( str_replace( ' ', '-', $value ) );
			$data[] = $key;
		}

		$result['section'] = $data;
		return ( ! empty( $result ) ? $result : [] );
	}
	/**
	 * Retrieves remote categories from an external source.
	 */
	public static function crafto_get_remote_categories() {
		$cat_arr  = [];
		$url      = self::TEMPLATE_LIBRARY_API_INFO . '/categories/';
		$response = wp_remote_get(
			$url,
			[
				'headers' => [
					'Accept'       => 'application/json', // Or text/xml depending on the API.
					'Content-Type' => 'application/json', // Only needed in POST usually.
				],
				'timeout' => 120,
			],
		);

		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body, true );

		return ! empty( $body['data'] ) ? $body['data'] : [];
	}

	/**
	 * Prepare template items to match model
	 *
	 * @param array $template_data Prepare template items to match model.
	 * @return array
	 */
	private function prepare_template( array $template_data ) {
		return [
			'template_id' => $template_data['template_id'],
			'title'       => $template_data['title'],
			'type'        => ( 'block' === $template_data['type'] ) ? 'section' : 'page',
			'thumbnail'   => $template_data['thumbnail'],
			'category'    => ( 'block' === $template_data['type'] && $template_data['subtype'] ) ? array( strtolower( str_replace( ' ', '-', $template_data['subtype'] ) ), 'section' ) : '',
			'isPro'       => $template_data['isPro'],
			'url'         => $template_data['url'],
			'alert'       => $template_data['alert'],
		];
	}

	/**
	 * Get library data from remote source and cache
	 *
	 * @param boolean $force_update Get library data from remote source and cache.
	 * @return array
	 */
	private static function request_library_data( $force_update = false ) {
		$data = get_option( self::LIBRARY_CACHE_ID );

		if ( $force_update || false === $data ) {
			$timeout = 120; // set 120 because huge data coming!

			$response = wp_remote_get(
				self::TEMPLATE_LIBRARY_ITEMS_API_TEMPLATES,
				[
					'headers' => [
						'Accept'       => 'application/json', // Or text/xml depending on the API.
						'Content-Type' => 'application/json', // Only needed in POST usually.
					],
					'timeout' => $timeout,
				],
			);

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				update_option( self::LIBRARY_CACHE_ID, [] );
				return false;
			}

			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $data ) || ! is_array( $data ) ) {
				update_option( self::LIBRARY_CACHE_ID, [] );
				return false;
			}

			update_option( self::LIBRARY_CACHE_ID, $data, 'no' );
		}

		return $data;
	}

	/**
	 * Get library data
	 *
	 * @param boolean $force_update Get library data.
	 * @return array
	 */
	public static function get_library_data( $force_update = false ) {
		self::request_library_data( $force_update );

		$data = get_option( self::LIBRARY_CACHE_ID );

		if ( empty( $data ) ) {
			return [];
		}

		return $data;
	}

	/**
	 * Get remote template.
	 *
	 * Retrieve a single remote template from Elementor.com servers.
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array Remote template.
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	/**
	 * Get remote template data.
	 *
	 * Retrieve the data of a single remote template
	 *
	 * @param array  $args An associative array of arguments to filter or specify the template data retrieval.
	 * @param string $context Optional.
	 * @return array|\WP_Error Remote Template data.
	 */
	public function get_data( array $args, $context = 'display' ) {
		$id       = $args['template_id'];
		$url      = self::TEMPLATE_LIBRARY_API_INFO . '/template/' . $id;
		$response = wp_remote_get(
			$url,
			[
				'headers' => [
					'Accept'       => 'application/json', // Or text/xml depending on the API.
					'Content-Type' => 'application/json', // Only needed in POST usually.
				],
				'timeout' => 60,
			],
		);

		$body   = wp_remote_retrieve_body( $response );
		$body   = json_decode( $body, true );
		$data   = ! empty( $body['data'] ) ? $body['data'] : false;
		$result = array();

		$result['content']       = $this->replace_elements_ids( $data );
		$result['content']       = $this->process_export_import_content( $result['content'], 'on_import' );
		$result['page_settings'] = [];

		return $result;
	}
}
