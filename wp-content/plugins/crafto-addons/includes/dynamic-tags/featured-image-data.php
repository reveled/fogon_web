<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for featured image data.
 *
 * @package Crafto
 */

// If class `Featured_Image_Data` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Featured_Image_Data' ) ) {
	/**
	 * Define `Featured_Image_Data` class.
	 */
	class Featured_Image_Data extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'featured-image-data';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Featured Image Data', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'media';
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
		 * Retrieve the attchment.
		 *
		 * @access private
		 */
		private function get_attacment() {
			$thumbnail_id = get_post_thumbnail_id();

			if ( ! $thumbnail_id ) {
				return false;
			}

			return get_post( $thumbnail_id );
		}

		/**
		 * Register feature image controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->add_control(
				'attachment_data',
				[
					'label'   => esc_html__( 'Data', 'crafto-addons' ),
					'type'    => 'select',
					'default' => 'title',
					'options' => [
						'title'       => esc_html__( 'Title', 'crafto-addons' ),
						'alt'         => esc_html__( 'Alt', 'crafto-addons' ),
						'caption'     => esc_html__( 'Caption', 'crafto-addons' ),
						'description' => esc_html__( 'Description', 'crafto-addons' ),
						'src'         => esc_html__( 'File URL', 'crafto-addons' ),
						'href'        => esc_html__( 'Attachment URL', 'crafto-addons' ),
					],
				]
			);
		}

		/**
		 * Render feature image.
		 *
		 * @access public
		 */
		public function render() {
			$settings   = $this->get_settings();
			$attachment = $this->get_attacment();

			if ( ! $attachment ) {
				return '';
			}

			$value = '';

			switch ( $settings['attachment_data'] ) {
				case 'alt':
					$value = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
					break;
				case 'caption':
					$value = $attachment->post_excerpt;
					break;
				case 'description':
					$value = $attachment->post_content;
					break;
				case 'href':
					$value = get_permalink( $attachment->ID );
					break;
				case 'src':
					$value = $attachment->guid;
					break;
				case 'title':
					$value = $attachment->post_title;
					break;
			}
			echo wp_kses_post( $value );
		}
	}
}
