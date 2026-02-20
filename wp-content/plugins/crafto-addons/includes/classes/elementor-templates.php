<?php
namespace CraftoAddons\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;

// If class `Elementor_Templates` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Elementor_Templates' ) ) {
	/**
	 * Elementor template list
	 *
	 * @package Crafto
	 */
	class Elementor_Templates {

		/**
		 * Get elementor templates list for options.
		 *
		 * @return array
		 */
		public static function get_elementor_templates_options() {
			$options = [
				'0' => '— ' . esc_html__( 'Select', 'crafto-addons' ) . ' —',
			];

			$ids = get_posts(
				[
					'post_type'              => 'elementor_library',
					'post_status'            => 'publish',
					'posts_per_page'         => -1,
					'orderby'                => 'title',
					'order'                  => 'ASC',
					'fields'                 => 'ids', // Only fetch IDs, more memory-efficient.
					'no_found_rows'          => true, // Disable pagination count.
					'update_post_meta_cache' => false, // Save memory.
					'update_post_term_cache' => false,
				]
			);

			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					$title = get_the_title( $id );
					$type  = get_post_meta( $id, '_elementor_template_type', true );

					// Fallback for missing type.
					$type = $type ? $type : 'unknown';

					$options[ $id ] = $title . ' (' . $type . ')';
				}
			}

			return $options;
		}

	}
}
