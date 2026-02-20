<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for custom meta.
 *
 * @package Crafto
 */

// If class `Custom_Post_Meta` doesn't exist yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Custom_Post_Meta' ) ) {
	/**
	 * Define `Custom_Post_Meta` class.
	 */
	class Custom_Post_Meta extends Tag {
		/**
		 * Retrieve the name of the tag.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'custom-post-meta';
		}

		/**
		 * Retrieve the title of the tag.
		 *
		 * @access public
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Meta', 'crafto-addons' );
		}

		/**
		 * Retrieve the group for the dynamic tag.
		 *
		 * @access public
		 * @return string group.
		 */
		public function get_group() {
			return 'meta';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
		}


		/**
		 * Register current meta controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'crafto_custom_meta_field',
				array(
					'label'  => esc_html__( 'Field', 'crafto-addons' ),
					'type'   => 'select',
					'groups' => $this->get_meta_fields(),
				)
			);
		}

		/**
		 * Render the content of the dynamic tag.
		 *
		 * @access public
		 * @return void
		 */
		public function render() {

			$meta_type = $this->get_settings( 'crafto_custom_meta_field' );

			// Get your custom meta data option.
			$meta_data = get_option( 'crafto_register_post_meta', [] );
			// Check if meta data exists.
			if ( ! empty( $meta_data ) ) {
				if ( is_admin() && is_elementor_activated() && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					echo esc_html__( 'This is a dummy text', 'crafto-addons' );
				} else {
					// Iterate through meta data to render the correct label.
					foreach ( $meta_data as $meta_val ) {
						$meta_slug = isset( $meta_val['meta_slug'] ) ? $meta_val['meta_slug'] : '';
						if ( 'file' !== $meta_val['field_type'] ) {
							if ( 'post' === $meta_val['meta_for'] ) {
								$meta_value = get_post_meta( get_the_ID(), 'crafto_custom_meta_' . $meta_slug, true );
								if ( $meta_type === $meta_slug ) {
									if ( ! empty( $meta_value ) ) {
										// Check if it's an array (you can modify this part depending on how your fields are structured).
										if ( is_array( $meta_value ) ) {
											// If it's an array, you may want to join the values with a delimiter.
											echo implode( ', ', $meta_value ); // phpcs:ignore
										} else {
											// If it's a single value, just echo it directly.
											echo $meta_value; // phpcs:ignore
										}
									}
								}
							} elseif ( 'taxonomy' === $meta_val['meta_for'] ) {
								$current_term_id = get_queried_object_id();
								$tax_meta_value  = get_term_meta( $current_term_id, 'crafto_custom_meta_' . $meta_slug, true );

								if ( ! empty( $tax_meta_value ) ) {
									if ( $meta_type === $meta_slug ) {
										if ( is_array( $tax_meta_value ) ) {
											// If it's an array, you may want to join the values with a delimiter.
											echo implode( ', ', $tax_meta_value ); // phpcs:ignore
										} else {
											// If it's a single value, just echo it directly.
											echo $tax_meta_value; // phpcs:ignore
										}
									}
								}
							} elseif ( 'user' === $meta_val['meta_for'] ) {
								$user_id         = get_queried_object_id();
								$user_meta_value = get_user_meta( $user_id, 'crafto_custom_meta_' . $meta_slug, true );

								if ( ! empty( $user_meta_value ) ) {
									if ( $meta_type === $meta_slug ) {
										if ( is_array( $user_meta_value ) ) {
											// If it's an array, you may want to join the values with a delimiter.
											echo implode( ', ', $user_meta_value ); // phpcs:ignore
										} else {
											// If it's a single value, just echo it directly.
											echo $user_meta_value; // phpcs:ignore
										}
									}
								}
							}
						}
					}
				}
			}
		}

		/**
		 * Register current meta controls.
		 *
		 * @access private
		 */
		private function get_meta_fields() {
			$meta_option_data = get_option( 'crafto_register_post_meta', [] );
			$groups           = [];

			// Iterate through the meta data and collect labels.
			foreach ( $meta_option_data as $meta_option_val ) {
				$meta_option_value = crafto_post_meta_by_id( get_the_ID(), 'crafto_custom_meta_' . $meta_option_val['meta_slug'], true );
				if ( 'file' !== $meta_option_val['field_type'] || ! empty( $meta_option_value ) ) {
					// Check if it's a post and handle 'post_type_for' or handle taxonomies.
					if ( 'post' === $meta_option_val['meta_for'] ) {
						$custom_post_types = get_post_types( [ 'public' => true ], 'objects' );

						// Loop through custom post types.
						foreach ( $custom_post_types as $post_type_object ) {
							// Ensure that post_type_for is an array and split values if needed.
							$post_types = is_array( $meta_option_val['post_type_for'] ) ? $meta_option_val['post_type_for'] : explode( ',', $meta_option_val['post_type_for'] );
							// Check if the current post type is in the array of post types.
							if ( in_array( $post_type_object->name, $post_types, true ) ) {
								// Collect the label name in the array.
								$post_group_exists = false;

								foreach ( $groups as $key => $group ) {
									if ( esc_html( $post_type_object->label ) === $group['label'] && $group['slug'] === $post_type_object->name ) {
										$post_group_exists = true;
										// Add the option to the existing group.
										$groups[ $key ]['options'][ $meta_option_val['meta_slug'] ] = esc_html( $meta_option_val['meta_label'] );
										break;
									}
								}
								// If the group does not exist, add it.
								if ( ! $post_group_exists ) {
									$groups[] = [
										'slug'    => esc_html( $post_type_object->name ),
										'label'   => esc_html( $post_type_object->label ),
										'options' => [
											$meta_option_val['meta_slug'] => esc_html( $meta_option_val['meta_label'] ),
										],
									];
								}
							}
						}
					} elseif ( 'taxonomy' === $meta_option_val['meta_for'] ) {
						// Handle taxonomies.
						$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );

						// Loop through taxonomies and check against the 'taxonomies_for'.
						foreach ( $taxonomies as $taxonomy_object ) {
							// Split the 'taxonomies_for' into an array if it's a string.
							$tax_types = is_array( $meta_option_val['taxonomies_for'] ) ? $meta_option_val['taxonomies_for'] : explode( ',', $meta_option_val['taxonomies_for'] );

							// If the current taxonomy matches one in 'taxonomies_for', add it as an option.
							if ( in_array( $taxonomy_object->name, $tax_types, true ) ) {
								// Check if the group for this taxonomy already exists.
								$group_exists = false;
								foreach ( $groups as $key => $group ) {
									if ( esc_html( $taxonomy_object->label ) === $group['label'] ) {
										$group_exists = true;
										// Add the option to the existing group.
										$groups[ $key ]['options'][ $meta_option_val['meta_slug'] ] = esc_html( $meta_option_val['meta_label'] );
										break;
									}
								}

								// If the group does not exist, add it.
								if ( ! $group_exists ) {
									$groups[] = [
										'label'   => esc_html( $taxonomy_object->label ),
										'options' => [
											$meta_option_val['meta_slug'] => esc_html( $meta_option_val['meta_label'] ),
										],
									];
								}
							}
						}
					} elseif ( 'user' === $meta_option_val['meta_for'] ) {
						$options = [
							'edit'         => esc_html__( 'Edit User', 'crafto-addons' ),
							'edit-profile' => esc_html__( 'Edit User & Profile', 'crafto-addons' ),
						];

						$visible_key = $meta_option_val['visible_at'];

						if ( isset( $options[ $visible_key ] ) ) {
							$label = esc_html( $options[ $visible_key ] );

							// Find the group by label and reuse it.
							$group_found = false;
							foreach ( $groups as $key => $group ) {
								if ( $group['label'] === $label ) {
									$groups[ $key ]['options'][ $meta_option_val['meta_slug'] ] = esc_html( $meta_option_val['meta_label'] );
									$group_found = true;
									break;
								}
							}

							// If group does not exist, add it.
							if ( ! $group_found ) {
								$groups[] = [
									'label'   => $label,
									'options' => [
										$meta_option_val['meta_slug'] => esc_html( $meta_option_val['meta_label'] ),
									],
								];
							}
						}
					}
				}
			}
			// Return all the dynamically created groups.
			return $groups;
		}
	}
}
