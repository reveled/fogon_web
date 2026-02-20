<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for custom meta image.
 *
 * @package Crafto
 */

// If class `Custom_Post_Meta_Image` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Custom_Post_Meta_Image' ) ) {
	/**
	 * Define `Custom_Post_Meta_Image` class.
	 */
	class Custom_Post_Meta_Image extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'custom-post-meta-image';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Meta Image', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
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
			return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
		}

		/**
		 * Register post featured image controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'crafto_custom_meta_image',
				[
					'label'  => esc_html__( 'Meta Images', 'crafto-addons' ),
					'type'   => 'select',
					'groups' => $this->get_meta_fields(),
				]
			);
		}

		/**
		 * @param array $options The arguments array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			$meta_data = get_option( 'crafto_register_post_meta', array() );
			$meta_type = $this->get_settings( 'crafto_custom_meta_image' );
			// Check if meta data exists.
			if ( ! empty( $meta_data ) ) {
				if ( is_admin() && is_elementor_activated() && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					?>
					<img src="<?php echo esc_url( CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/placeholder.png' ); ?>">
					<?php
				} else {
					foreach ( $meta_data as $meta_val ) {
						if ( 'file' === $meta_val['field_type'] ) {
							if ( 'post' === $meta_val['meta_for'] ) {
								$meta_value      = get_post_meta( get_the_ID(), 'crafto_custom_meta_' . $meta_val['meta_slug'], true );
								$image_src_array = wp_get_attachment_image_src( $meta_value, '', true );

								if ( $meta_type === $meta_val['meta_slug'] ) {
									// Ensure the meta value exists and is valid.
									if ( ! empty( $meta_value ) ) {
										// Return a valid image tag if the URL is valid.
										return [
											'id'  => $meta_value,
											'url' => $image_src_array[0],
										];
									} else {
										// Return an empty string to avoid invalid JSON.
										return '';
									}
								}
							} elseif ( 'taxonomy' === $meta_val['meta_for'] ) {
								$current_term_id = get_queried_object_id();
								$tax_meta_value  = get_term_meta( $current_term_id, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

								$image_src_array = wp_get_attachment_image_src( $tax_meta_value, '', true );
								if ( $meta_type === $meta_val['meta_slug'] ) {
									// Ensure the meta value exists and is valid.
									if ( ! empty( $tax_meta_value ) ) {
										// Return a valid image tag if the URL is valid.
										return [
											'id'  => $tax_meta_value,
											'url' => $image_src_array[0],
										];
									} else {
										// Return an empty string to avoid invalid JSON.
										return '';
									}
								}
							} elseif ( 'user' === $meta_val['meta_for'] ) {
								$user_id         = get_queried_object_id();
								$user_meta_value = get_user_meta( $user_id, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

								$image_src_array = wp_get_attachment_image_src( $user_meta_value, '', true );
								if ( $meta_type === $meta_val['meta_slug'] ) {
									// Ensure the meta value exists and is valid.
									if ( ! empty( $user_meta_value ) ) {
										// Return a valid image tag if the URL is valid.
										return [
											'id'  => $user_meta_value,
											'url' => $image_src_array[0],
										];
									} else {
										// Return an empty string to avoid invalid JSON.
										return '';
									}
								}
							}
						}
					}
					return ''; // Return empty string if no valid meta found.
				}
			}
		}

		/**
		 * Register current meta controls.
		 *
		 * @access private
		 */
		private function get_meta_fields() {
			$groups = [];

			$meta_option_data = get_option( 'crafto_register_post_meta', [] );
			// Iterate through the meta data and collect labels.
			foreach ( $meta_option_data as $meta_option_val ) {
				$meta_option_value = crafto_post_meta_by_id( get_the_ID(), 'crafto_custom_meta_' . $meta_option_val['meta_slug'], true );
				if ( 'file' === $meta_option_val['field_type'] || ! empty( $meta_option_value ) ) {
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
						foreach ( $options as $value => $text ) {
							if ( $value === $meta_option_val['visible_at'] ) {
								$group_exists = false;
								foreach ( $groups as $key => $group ) {
									if ( esc_html( $text ) === $group['label'] ) {
										$group_exists = true;
										// Add the option to the existing group.
										$groups[ $key ]['options'][ $meta_option_val['meta_slug'] ] = esc_html( $meta_option_val['meta_label'] );
										break;
									}
								}
								if ( ! $group_exists ) {
									$groups[] = [
										'label'   => html_entity_decode( esc_html( $text ) ),
										'options' => [
											$meta_option_val['meta_slug'] => esc_html( $meta_option_val['meta_label'] ),
										],
									];
								}
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
