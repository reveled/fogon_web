<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;

/**
 * Crafto dynamic tag for post custom field.
 *
 * @package Crafto
 */

// If class `Post_Custom_Field` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Custom_Field' ) ) {
	/**
	 * Define `Post_Custom_Field` class.
	 */
	class Post_Custom_Field extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-custom-field';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post Custom Field', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'post';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::URL_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::POST_META_CATEGORY,
			];
		}

		/**
		 * Retrieve the panel template settings.
		 *
		 * @access public
		 *
		 * @return string template key.
		 */
		public function get_panel_template_setting_key() {
			return 'key';
		}

		/**
		 * Retrieve settings required.
		 *
		 * @access public
		 *
		 * @return string settings.
		 */
		public function is_settings_required() {
			return true;
		}

		/**
		 * Register post custom fields controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'crafto_key',
				[
					'label'     => esc_html__( 'Crafto Meta Key', 'crafto-addons' ),
					'type'      => 'select',
					'options'   => $this->get_custom_crafto_keys_array(),
					'condition' => [
						'key'        => '',
						'custom_key' => '',
					],
				]
			);

			$this->add_control(
				'key',
				[
					'label'     => esc_html__( 'Meta Key', 'crafto-addons' ),
					'type'      => 'select',
					'options'   => $this->get_custom_keys_array(),
					'condition' => [
						'crafto_key' => '',
					],
				]
			);

			$this->add_control(
				'custom_key',
				[
					'label'       => esc_html__( 'Custom Meta Key', 'crafto-addons' ),
					'type'        => 'text',
					'placeholder' => 'key',
					'condition'   => [
						'key'        => '',
						'crafto_key' => '',
					],
				]
			);
		}

		/**
		 * Render post custom fields.
		 *
		 * @access public
		 */
		public function render() {
			$select_key = $this->get_settings( 'key' );
			$custom_key = $this->get_settings( 'custom_key' );
			$crafto_key = $this->get_settings( 'crafto_key' );

			if ( empty( $select_key ) ) {
				$select_key = $custom_key;
			}

			if ( ! empty( $crafto_key ) ) {
				$custom_keys = get_post_meta( get_the_ID(), 'crafto_global_meta', true );
				$options     = [];
				if ( ! empty( $custom_keys ) ) {
					foreach ( $custom_keys as $custom_key_get ) {
						foreach ( $custom_key_get as $single_key => $single_value ) {
							if ( ! is_array( $single_value ) ) {
								$options[ $single_key ] = $single_value;
							}
						}
					}
				}

				if ( ! empty( $options ) ) {
					echo wp_kses_post( $options[ $crafto_key ] );
				}
			}

			if ( ! empty( $select_key ) ) {
				$value = get_post_meta( get_the_ID(), $select_key, true );

				if ( ! empty( $value ) ) {
					if ( is_array( $value ) ) {
						foreach ( $value as $val ) {
							echo wp_kses_post( $val );
						}
					} else {
						echo wp_kses_post( $value );
					}
				}
			}
		}

		/**
		 * Retrive custom keys.
		 *
		 * @access private
		 */
		private function get_custom_keys_array() {
			$custom_keys = get_post_custom_keys();
			$options     = [
				'' => esc_html__( 'Select...', 'crafto-addons' ),
			];

			if ( ! empty( $custom_keys ) ) {
				foreach ( $custom_keys as $custom_key ) {
					if ( 'crafto_global_meta' !== $custom_key ) {
						if ( '_' !== substr( $custom_key, 0, 1 ) ) {
							$options[ $custom_key ] = $custom_key;
						}
					}
				}
			}

			return $options;
		}

		/**
		 * Get Crafto custom meta keys for dropdown.
		 *
		 * - Page/Post (in Elementor editor): show all Crafto keys site-wide
		 * - Other CPTs (in Elementor editor): show only current post keys
		 * - Frontend render: show only current post keys
		 *
		 * @return array
		 */
		private function get_custom_crafto_keys_array() {
			global $wpdb;

			$options = [
				'' => esc_html__( 'Select...', 'crafto-addons' ),
			];

			$post_id = get_the_ID();

			// Elementor edit mode check.
			$is_elementor_editor = ( defined( 'ELEMENTOR_VERSION' ) && Plugin::$instance->editor->is_edit_mode() );

			// Detect current post type if in editor.
			$current_post_type = '';
			if ( $is_elementor_editor && isset( $_GET['post'] ) ) {
				$current_post_type = get_post_type( absint( $_GET['post'] ) );
			} elseif ( $post_id ) {
				$current_post_type = get_post_type( $post_id );
			}

			// ---- Case 1: Elementor + Page/Post → show ALL site-wide keys ----
			if ( $is_elementor_editor && 'themebuilder' === $current_post_type ) {
				$meta_keys = $wpdb->get_col(
					"SELECT DISTINCT meta_key 
					FROM {$wpdb->postmeta} 
					WHERE meta_key LIKE 'crafto_%'"
				);

				foreach ( $meta_keys as $meta_key ) {
					if ( '_' === substr( $meta_key, 0, 1 ) ) {
						continue;
					}

					if ( 'crafto_global_meta' === $meta_key ) {
						$results = $wpdb->get_results(
							"SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'crafto_global_meta'"
						);
						foreach ( $results as $row ) {
							$meta_value = maybe_unserialize( $row->meta_value );
							if ( is_array( $meta_value ) ) {
								foreach ( $meta_value as $group ) {
									if ( is_array( $group ) ) {
										foreach ( $group as $single_key => $single_value ) {
											$options[ $single_key ] = $single_key;
										}
									}
								}
							}
						}
					} else {
						$options[ $meta_key ] = $meta_key;
					}
				}

			// ---- Case 2 + 3: Other CPTs in Elementor OR frontend → current post keys ----
			} else {
				if ( $post_id ) {
					$meta_keys = $wpdb->get_col( $wpdb->prepare(
						"SELECT DISTINCT meta_key 
						FROM {$wpdb->postmeta} 
						WHERE post_id = %d 
						AND meta_key LIKE %s",
						$post_id,
						'crafto_%'
					));

					foreach ( $meta_keys as $meta_key ) {
						if ( '_' === substr( $meta_key, 0, 1 ) ) {
							continue;
						}

						if ( 'crafto_global_meta' === $meta_key ) {
							$custom_meta = get_post_meta( $post_id, 'crafto_global_meta', true );
							if ( is_array( $custom_meta ) ) {
								foreach ( $custom_meta as $group ) {
									if ( is_array( $group ) ) {
										foreach ( $group as $single_key => $single_value ) {
											$options[ $single_key ] = $single_key;
										}
									}
								}
							}
						} else {
							$options[ $meta_key ] = $meta_key;
						}
					}
				}
			}
			return $options;
		}
	}
}
