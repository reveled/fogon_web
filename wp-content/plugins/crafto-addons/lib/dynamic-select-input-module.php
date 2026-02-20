<?php
/**
 * Dynamic Select Input Class
 *
 * @package Crafto
 * @since   1.0
 */

namespace CraftoAddons\Controls;

use Exception;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Dynamic Select Input class
 */
class Dynamic_Select_Input_Module {

	const ACTION = '';

	private static $instance = null;

	/**
	 * Returns the instance.
	 *
	 * @return object
	 * @since  1.0
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Init method
	 */

	/**
	 * Constructor.
	 */
	public function init() {
		add_action( 'wp_ajax_crafto_dynamic_select_input_data', array( $this, 'getSelectInputData' ) );
	}

	/**
	 * Handles the AJAX request for dynamic select input data.
	 *
	 * @return void
	 */
	public function getSelectInputData() {
		$nonce = isset( $_POST['security'] ) ? sanitize_text_field( $_POST['security'] ) : ''; // phpcs:ignore

		try {
			if ( ! wp_verify_nonce( $nonce, 'crafto_dynamic_select' ) ) {
				throw new Exception( 'Invalid request' );
			}

			if ( ! current_user_can( 'edit_posts' ) ) {
				throw new Exception( 'Unauthorized request' );
			}

			$query     = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : ''; // phpcs:ignore
			$post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : ''; // phpcs:ignore

			if ( 'terms' === $query ) {
				$data = $this->getTerms();
			} elseif ( $query == 'authors' ) {
				$data = $this->getAuthors();
			} elseif ( $query == 'authors_role' ) {
				$data = $this->getAuthorRoles();
			} elseif ( $query == 'only_post' ) {
				$data = $this->getOnlyPosts( $post_type );
			} else {
				$data = $this->getPosts();
			}

			wp_send_json_success( $data );
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Get Post Type
	 * @return string
	 */
	protected function getPostType() {
		return isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : ''; // phpcs:ignore
	}

	/**
	 * @return string[]|\WP_Post_Type[]
	 */
	protected function getAllPublicPostTypes() {
		$post_types = get_post_types( array( 'public' => true ), 'names' );
		unset( $post_types['attachment'] );
		unset( $post_types['elementor_library'] );
		unset( $post_types['e-landing-page'] );
		unset( $post_types['e-floating-buttons'] );
		unset( $post_types['crafto-mega-menu'] );
		unset( $post_types['themebuilder'] );
		$post_types = apply_filters( 'crafto_get_all_public_post_types', $post_types );
		return array_values( $post_types );
	}

	/**
	 * @return string
	 */
	protected function getSearchQuery() {
		return isset( $_POST['search_text'] ) ? sanitize_text_field( $_POST['search_text'] ) : ''; // phpcs:ignore
	}

	/**
	 * @return array|mixed
	 */
	protected function getselectedIds() {
		return isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : []; // phpcs:ignore
	}

	/**
	 * Get the label of a specified taxonomy.
	 *
	 * @param string $taxonomy The name of the taxonomy.
	 * @return string The label of the taxonomy or an empty string if not found.
	 */
	public function getTaxonomyName( $taxonomy = '') {
		$taxonomies = get_taxonomies(
			[
				'public' => true,
			],
			'objects'
		);

		// Map taxonomy names to their labels.
		$taxonomies = array_column( $taxonomies, 'label', 'name' );

		return isset( $taxonomies[ $taxonomy ] ) ? $taxonomies[ $taxonomy ] : '';
	}

	/**
	 * @return string[]|\WP_Taxonomy[]
	 */
	protected function getAllPublicTaxonomies() {
		return array_values(
			get_taxonomies(
				[
					'public' => true,
				]
			)
		);
	}

	/**
	 * Get Post Query Data
	 *
	 * @return array
	 */
	public function getPosts() {
		$include    = $this->getselectedIds();
		$searchText = $this->getSearchQuery();

		$args = [];

		if ( $this->getPostType() && $this->getPostType() !== '_related_post_type' ) {
			$args['post_type'] = $this->getPostType();
		} else {
			$args['post_type'] = $this->getAllPublicPostTypes();
		}

		if ( ! empty( $include ) ) {
			$args['post__in']       = $include;
			$args['posts_per_page'] = count( $include );
		} else {
			$args['posts_per_page'] = 20;
		}

		if ( $searchText ) {
			$args['s'] = $searchText;
		}

		$query   = new WP_Query( $args );
		$results = [];

		foreach ( $query->posts as $post ) {

			$post_type_obj = get_post_type_object( $post->post_type );
			if ( ! empty( $data['include_type'] ) ) {
				$text = $post_type_obj->labels->name . ': ' . $post->post_title;
			} else {
				$text = ( $post_type_obj->hierarchical) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
			}

			$results[] = [
				'id'   => $post->ID,
				'text' => esc_html( $text ),
			];
		}

		return $results;
	}

	public function getOnlyPosts( $post_type = 'post' ) {

		$args              = [];
		$include           = $this->getselectedIds();
		$searchText        = $this->getSearchQuery();
		$args['post_type'] = $post_type;

		if ( ! empty( $include ) ) {
			$args['post__in']       = $include;
			$args['posts_per_page'] = count( $include );
		} else {
			$args['posts_per_page'] = 20;
		}

		if ( $searchText ) {
			$args['s'] = $searchText;
		}

		$query   = new WP_Query( $args );
		$results = [];

		foreach ( $query->posts as $post ) {
			$post_type_obj = get_post_type_object( $post->post_type );
			if ( ! empty( $data['include_type'] ) ) {
				$text = $post_type_obj->labels->name . ': ' . $post->post_title;
			} else {
				$text = ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
			}

			$results[] = [
				'id'   => $post->ID,
				'text' => esc_html( $text ),
			];
		}

		return $results;
	}

	private function get_post_name_with_parents( $post, $max = 3 ) {

		if ( 0 === $post->post_parent ) {
			return $post->post_title;
		}

		$separator = is_rtl() ? ' < ' : ' > ';
		$test_post = $post;
		$names     = [];

		while ( $test_post->post_parent > 0 ) {
			$test_post = get_post( $test_post->post_parent );

			if ( ! $test_post ) {
				break;
			}

			$names[] = $test_post->post_title;
		}

		$names = array_reverse( $names );
		if ( count( $names ) < ( $max ) ) {
			return implode( $separator, $names ) . $separator . $post->post_title;
		}

		$name_string = '';
		for ( $i = 0; $i < ( $max - 1 ); $i++) {
			$name_string .= $names[ $i ] . $separator;
		}

		return $name_string . '...' . $separator . $post->post_title;
	}

	/**
	 * Get Terms query data
	 *
	 * @return array
	 */
	public function getTerms() {

		$search_text = $this->getSearchQuery();
		$taxonomies  = $this->getAllPublicTaxonomies();
		$include     = $this->getselectedIds();

		if ( $this->getPostType() == '_related_post_type' ) {
			$post_type = $this->getAllPublicPostTypes();
		} elseif ( $this->getPostType() ) {
			$post_type = $this->getPostType();
		}

		$post_taxonomies = get_object_taxonomies( $post_type );
		$taxonomies      = array_intersect( $post_taxonomies, $taxonomies );
		$data            = [];

		if ( empty( $taxonomies ) ) {
			return $data;
		}

		$args = [
			'taxonomy'   => $taxonomies,
			'hide_empty' => false,
		];

		if ( ! empty( $include ) ) {
			$args['include'] = $include;
		}

		if ( $search_text) {
			$args['number'] = 20;
			$args['search'] = $search_text;
		}

		$terms = get_terms( $args);

		if ( is_wp_error( $terms) || empty( $terms ) ) {
			return $data;
		}

		foreach ( $terms as $term) {
			$label         = $term->name;
			$taxonomy_name = $this->getTaxonomyName( $term->taxonomy);

			if ( $taxonomy_name) {
				$label = "{$taxonomy_name}: {$label}";
			}

			$data[] = [
				'id'   => $term->term_taxonomy_id,
				'text' => $label,
			];
		}

		return $data;
	}

	/**
	 * Get Authors query Data
	 *
	 * @return array
	 */
	public function getAuthors() {
		$include     = $this->getselectedIds();
		$search_text = $this->getSearchQuery();

		$args = [
			'fields'  => ['ID', 'display_name'],
			'orderby' => 'display_name',
		];

		if ( ! empty( $include ) ) {
			$args['include'] = $include;
		}

		if ( $search_text ) {
			$args['number'] = 20;
			$args['search'] = "*$search_text*";
		}

		$users = get_users( $args);

		$data = [];

		if ( empty( $users ) ) {
			return $data;
		}

		foreach ( $users as $user) {
			$data[] = [
				'id'   => $user->ID,
				'text' => $user->display_name,
			];
		}

		return $data;
	}

	/**
	 * Get Authors Roles query Data
	 *
	 * @return array
	 */
	public function getAuthorRoles() {
		global $wp_roles;

		$all_roles = $wp_roles->roles;
		$roles     = [];
		foreach ( $all_roles as $key => $role ) {
			$roles[] = [
				'id'   => $key,
				'text' => $role['name'],
			];
		}

		return $roles;
	}

}

function Dynamic_Select_Input_Module() {
	return Dynamic_Select_Input_Module::get_instance();
}

Dynamic_Select_Input_Module()->init();
