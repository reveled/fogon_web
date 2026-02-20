<?php
/**
 * Post archive meta
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Crafto_Archive_Meta' ) ) {

	/**
	 * Define class
	 */
	class Crafto_Archive_Meta {

		/**
		 * Construct
		 */
		public function __construct() {

			/**
			 * Post category/tags custom meta fields.
			 */
			add_action( 'category_add_form_fields', array( $this, 'crafto_category_add_meta_field' ), 10, 2 );
			add_action( 'post_tag_add_form_fields', array( $this, 'crafto_category_add_meta_field' ), 10, 2 );
			add_action( 'category_edit_form_fields', array( $this, 'crafto_category_edit_meta_field' ), 10, 2 );
			add_action( 'post_tag_edit_form_fields', array( $this, 'crafto_category_edit_meta_field' ), 10, 2 );
			add_action( 'edited_category', array( $this, 'crafto_save_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_category', array( $this, 'crafto_save_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'edited_post_tag', array( $this, 'crafto_save_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_post_tag', array( $this, 'crafto_save_taxonomy_custom_meta' ), 10, 2 );

			/**
			 * Property types / agents custom meta fields.
			 */
			add_action( 'properties-types_add_form_fields', array( $this, 'crafto_properties_taxonomy_add_meta_field' ), 10, 2 );
			add_action( 'properties-types_edit_form_fields', array( $this, 'crafto_properties_taxonomy_edit_meta_field' ), 10, 2 );
			add_action( 'properties-agents_add_form_fields', array( $this, 'crafto_properties_taxonomy_add_meta_field' ), 10, 2 );
			add_action( 'properties-agents_edit_form_fields', array( $this, 'crafto_properties_taxonomy_edit_meta_field' ), 10, 2 );

			add_action( 'edited_properties-types', array( $this, 'crafto_save_properties_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_properties-types', array( $this, 'crafto_save_properties_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'edited_properties-agents', array( $this, 'crafto_save_properties_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_properties-agents', array( $this, 'crafto_save_properties_taxonomy_custom_meta' ), 10, 2 );

			/**
			 * Tour destination / activity custom meta fields.
			 */
			add_action( 'tour-activity_add_form_fields', array( $this, 'crafto_tour_taxonomy_add_icon_field' ), 10, 2 );
			add_action( 'tour-activity_edit_form_fields', array( $this, 'crafto_tour_taxonomy_edit_icon_field' ), 10, 2 );
			add_action( 'edited_tour-activity', array( $this, 'crafto_save_tour_taxonomy_icon_field' ), 10, 2 );

			add_action( 'tour-destination_add_form_fields', array( $this, 'crafto_tour_taxonomy_add_meta_field' ), 10, 2 );
			add_action( 'tour-destination_edit_form_fields', array( $this, 'crafto_tour_taxonomy_edit_meta_field' ), 10, 2 );

			add_action( 'tour-activity_add_form_fields', array( $this, 'crafto_tour_taxonomy_add_meta_field' ), 10, 2 );
			add_action( 'tour-activity_edit_form_fields', array( $this, 'crafto_tour_taxonomy_edit_meta_field' ), 10, 2 );

			add_action( 'edited_tour-destination', array( $this, 'crafto_save_tour_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_tour-destination', array( $this, 'crafto_save_tour_taxonomy_custom_meta' ), 10, 2 );

			add_action( 'edited_tour-activity', array( $this, 'crafto_save_tour_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_tour-activity', array( $this, 'crafto_save_tour_taxonomy_custom_meta' ), 10, 2 );
			/**
			 * Portfolio category/tags custom meta fields.
			 */
			add_action( 'portfolio-category_add_form_fields', array( $this, 'crafto_portfolio_taxonomy_add_meta_field' ), 10, 2 );
			add_action( 'portfolio-category_edit_form_fields', array( $this, 'crafto_portfolio_taxonomy_edit_meta_field' ), 10, 2 );
			add_action( 'portfolio-tags_add_form_fields', array( $this, 'crafto_portfolio_taxonomy_add_meta_field' ), 10, 2 );
			add_action( 'portfolio-tags_edit_form_fields', array( $this, 'crafto_portfolio_taxonomy_edit_meta_field' ), 10, 2 );

			add_action( 'edited_portfolio-category', array( $this, 'crafto_save_portfolio_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_portfolio-category', array( $this, 'crafto_save_portfolio_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'edited_portfolio-tags', array( $this, 'crafto_save_portfolio_taxonomy_custom_meta' ), 10, 2 );
			add_action( 'create_portfolio-tags', array( $this, 'crafto_save_portfolio_taxonomy_custom_meta' ), 10, 2 );

			if ( is_woocommerce_activated() ) {
				add_action( 'product_cat_add_form_fields', array( $this, 'crafto_product_taxonomy_add_meta_field' ), 99, 2 );
				add_action( 'product_tag_add_form_fields', array( $this, 'crafto_product_taxonomy_add_meta_field' ), 99, 2 );

				add_action( 'product_cat_edit_form_fields', array( $this, 'crafto_product_taxonomy_edit_meta_field' ), 99, 2 );
				add_action( 'product_tag_edit_form_fields', array( $this, 'crafto_product_taxonomy_edit_meta_field' ), 99, 2 );

				add_action( 'edited_product_cat', array( $this, 'crafto_save_product_taxonomy_custom_meta' ), 10, 2 );
				add_action( 'create_product_cat', array( $this, 'crafto_save_product_taxonomy_custom_meta' ), 10, 2 );
				add_action( 'edited_product_tag', array( $this, 'crafto_save_product_taxonomy_custom_meta' ), 10, 2 );
				add_action( 'create_product_tag', array( $this, 'crafto_save_product_taxonomy_custom_meta' ), 10, 2 );
			}
		}

		/**
		 * Add category meta fields.
		 */
		public function crafto_category_add_meta_field() {
			// This will add the custom meta field to the add new term page.
			?>
			<div class="form-field">
				<label for="crafto_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_archive_title_subtitle" id="crafto_archive_title_subtitle" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				<input id="crafto_upload" name="crafto_archive_title_bg_image" class="upload_field hidden" type="text" value="" />
				<img class="upload_image_screenshort" src="" />
				<input id="crafto_upload_button_category" class="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
				<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
			</div>

			<div class="form-field">
				<label for="crafto_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				<input name="crafto_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
				<div class="multiple_images">
				</div>
				<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
				<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_archive_title_video_mp4" id="crafto_archive_title_video_mp4" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_archive_title_video_ogg" id="crafto_archive_title_video_ogg" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_archive_title_video_webm" id="crafto_archive_title_video_webm" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_archive_title_video_youtube" id="crafto_archive_title_video_youtube" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
			</div>
			<?php
		}

		/**
		 * Edit category meta fields.
		 *
		 * @param object $term Terms Objects.
		 */
		public function crafto_category_edit_meta_field( $term ) {
			$crafto_subtitle          = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_subtitle', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_subtitle', true ) : '';
			$crafto_bg_image_id       = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_bg_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_bg_image', true ) : '';
			$crafto_bg_multiple_image = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_bg_multiple_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_bg_multiple_image', true ) : '';
			$crafto_video_mp4         = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_video_mp4', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_video_mp4', true ) : '';
			$crafto_video_ogg         = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_video_ogg', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_video_ogg', true ) : '';
			$crafto_video_webm        = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_video_webm', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_video_webm', true ) : '';
			$crafto_video_youtube     = ! empty( get_term_meta( $term->term_id, 'crafto_archive_title_video_youtube', true ) ) ? get_term_meta( $term->term_id, 'crafto_archive_title_video_youtube', true ) : '';
			$crafto_bg_image_url      = wp_get_attachment_url( $crafto_bg_image_id );
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_archive_title_subtitle" id="crafto_archive_title_subtitle" value="<?php echo esc_attr( $crafto_subtitle ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input id="crafto_upload" name="crafto_archive_title_bg_image" class="upload_field hidden" type="text" value="<?php echo $crafto_bg_image_id; // phpcs:ignore ?>" />
					<img class="upload_image_screenshort" src="<?php echo esc_url( $crafto_bg_image_url ); ?>">
					<input id="crafto_upload_button_category" class="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
					<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
					<div class="multiple_images">
						<?php
						$crafto_val = explode( ',', $crafto_bg_multiple_image );
						foreach ( $crafto_val as $key => $value ) {
							if ( ! empty( $value ) ) :
								$crafto_image_url   = wp_get_attachment_url( $value );
								$crafto_img_alt     = crafto_option_image_alt( $value );
								$crafto_img_title   = crafto_option_image_title( $value );
								$crafto_image_alt   = ! empty( $crafto_img_alt['alt'] ) ? ' alt="' . esc_attr( $crafto_img_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
								$crafto_image_title = ! empty( $crafto_img_title['title'] ) ? ' title="' . esc_attr( $crafto_img_title['title'] ) . '"' : '';

								echo '<div id=' . esc_attr( $value ) . '>';
									echo '<img class="upload_image_screenshort_multiple width-100px"' . $crafto_image_alt . $crafto_image_title . ' src="' . $crafto_image_url . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo '<a href="javascript:void(0)" class="remove">' . esc_html__( 'Remove', 'crafto-addons' ) . '</a>';
								echo '</div>';
							endif;
						}
						?>
					</div>
					<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_attr__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
					<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_archive_title_video_mp4" id="crafto_archive_title_video_mp4" value="<?php echo esc_url( $crafto_video_mp4 ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_archive_title_video_ogg" id="crafto_archive_title_video_ogg" value="<?php echo esc_url( $crafto_video_ogg ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_archive_title_video_webm" id="crafto_archive_title_video_webm" value="<?php echo esc_url( $crafto_video_webm ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_archive_title_video_youtube" id="crafto_archive_title_video_youtube" value="<?php echo esc_attr( $crafto_video_youtube ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
					<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Save category taxonomy meta
		 *
		 * @param object $crafto_term_id Taxonomy id.
		 */
		public function crafto_save_taxonomy_custom_meta( $crafto_term_id ) {
			$meta_keys = [
				'crafto_archive_title_subtitle',
				'crafto_archive_title_bg_image',
				'crafto_archive_title_bg_multiple_image',
				'crafto_archive_title_video_mp4',
				'crafto_archive_title_video_ogg',
				'crafto_archive_title_video_webm',
				'crafto_archive_title_video_youtube',
			];

			foreach ( $meta_keys as $key ) {
				if ( isset( $_POST[$key] ) ) { // phpcs:ignore
					update_term_meta( $crafto_term_id, $key, $_POST[$key] ); // phpcs:ignore
				}
			}
		}

		/**
		 * Adds a custom meta field to the properties taxonomy.
		 */
		public function crafto_properties_taxonomy_add_meta_field() {
			?>
			<div class="form-field">
				<label for="crafto_properties_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_properties_archive_title_subtitle" id="crafto_properties_archive_title_subtitle" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_properties_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				<input name="crafto_properties_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="" />				
				<img class="upload_image_screenshort" src="" />
				<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
				<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
			</div>
			<div class="form-field">
				<label for="crafto_properties_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				<input name="crafto_properties_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
				<div class="multiple_images">
				</div>
				<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
				<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_properties_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_properties_archive_title_video_mp4" id="crafto_properties_archive_title_video_mp4" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_properties_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_properties_archive_title_video_ogg" id="crafto_properties_archive_title_video_ogg" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_properties_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_properties_archive_title_video_webm" id="crafto_properties_archive_title_video_webm" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_properties_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_properties_archive_title_video_youtube" id="crafto_properties_archive_title_video_youtube" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
			</div>
			<?php
		}
		/**
		 * Displays and handles the editing of custom meta fields for the properties taxonomy.
		 *
		 * @param object $term The term object being edited.
		 */
		public function crafto_properties_taxonomy_edit_meta_field( $term ) {
			$crafto_property_subtitle          = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_subtitle', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_subtitle', true ) : '';
			$crafto_property_bg_image_id       = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_bg_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_bg_image', true ) : '';
			$crafto_property_bg_multiple_image = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_bg_multiple_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_bg_multiple_image', true ) : '';
			$crafto_property_video_mp4         = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_mp4', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_mp4', true ) : '';
			$crafto_property_video_ogg         = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_ogg', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_ogg', true ) : '';
			$crafto_property_video_webm        = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_webm', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_webm', true ) : '';
			$crafto_property_video_youtube     = ! empty( get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_youtube', true ) ) ? get_term_meta( $term->term_id, 'crafto_properties_archive_title_video_youtube', true ) : '';
			$crafto_property_bg_image_url      = wp_get_attachment_url( $crafto_property_bg_image_id );
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_properties_archive_title_subtitle" id="crafto_properties_archive_title_subtitle" value="<?php echo esc_attr( $crafto_property_subtitle ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_properties_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="<?php echo $crafto_property_bg_image_id; // phpcs:ignore ?>" />					
					<img class="upload_image_screenshort" src="<?php echo esc_url( $crafto_property_bg_image_url ); ?>">
					<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
					<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_properties_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
					<div class="multiple_images">
						<?php
						$crafto_val = explode( ',', $crafto_property_bg_multiple_image );
						foreach ( $crafto_val as $key => $value ) {
							if ( ! empty( $value ) ) :
								$crafto_image_url   = wp_get_attachment_url( $value );
								$crafto_img_alt     = crafto_option_image_alt( $value );
								$crafto_img_title   = crafto_option_image_title( $value );
								$crafto_image_alt   = ! empty( $crafto_img_alt['alt'] ) ? ' alt="' . esc_attr( $crafto_img_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
								$crafto_image_title = ! empty( $crafto_img_title['title'] ) ? ' title="' . esc_attr( $crafto_img_title['title'] ) . '"' : '';

								echo '<div id=' . esc_attr( $value ) . '>';
									echo '<img class="upload_image_screenshort_multiple width-100px"' . $crafto_image_alt . $crafto_image_title . ' src="' . esc_url( $crafto_image_url ) . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo '<a href="javascript:void(0)" class="remove">' . esc_html__( 'Remove', 'crafto-addons' ) . '</a>';
								echo '</div>';
							endif;
						}
						?>
					</div>
					<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_attr__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
					<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_properties_archive_title_video_mp4" id="crafto_properties_archive_title_video_mp4" value="<?php echo esc_url( $crafto_property_video_mp4 ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_properties_archive_title_video_ogg" id="crafto_properties_archive_title_video_ogg" value="<?php echo esc_url( $crafto_property_video_ogg ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_properties_archive_title_video_webm" id="crafto_properties_archive_title_video_webm" value="<?php echo esc_url( $crafto_property_video_webm ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_properties_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_properties_archive_title_video_youtube" id="crafto_properties_archive_title_video_youtube" value="<?php echo esc_url( $crafto_property_video_youtube ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
					<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Saves custom meta data for a term in the properties taxonomy.
		 *
		 * @param int $crafto_term_id The ID of the term whose meta data is being saved.
		 */
		public function crafto_save_properties_taxonomy_custom_meta( $crafto_term_id ) {
			$meta_keys = [
				'crafto_properties_archive_title_subtitle',
				'crafto_properties_archive_title_bg_image',
				'crafto_properties_archive_title_bg_multiple_image',
				'crafto_properties_archive_title_video_mp4',
				'crafto_properties_archive_title_video_ogg',
				'crafto_properties_archive_title_video_webm',
				'crafto_properties_archive_title_video_youtube',
			];

			foreach ( $meta_keys as $key ) {
				if ( isset( $_POST[$key] ) ) { // phpcs:ignore
					update_term_meta( $crafto_term_id, $key, $_POST[$key] ); // phpcs:ignore
				}
			}
		}

		/**
		 * Adds a custom icon meta field to the tour activity taxonomy.
		 */
		public function crafto_tour_taxonomy_add_icon_field() {
			$crafto_bootstrap_icons = crafto_bootstrap_icons();
			?>
			<div class="form-field">
				<label for="crafto_activity_icon"><?php echo esc_html__( 'Select Icon', 'crafto-addons' ); ?></label>
				<select id="crafto_activity_icon" class="crafto-menu-icons" name="crafto_activity_icon">
					<option></option>
					<?php
					if ( ! empty( $crafto_bootstrap_icons ) ) {
						foreach ( $crafto_bootstrap_icons as $val ) {
							?>
							<option data="value, <?php echo esc_attr( $val ); ?> val," data-icon="bi <?php echo esc_attr( $val ); ?>" value="<?php echo $val; ?>">bi <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<?php
		}

		/**
		 * Displays and handles the editing of custom icon meta field for the tour activity taxonomy.
		 *
		 * @param object $term The term object being edited.
		 */
		public function crafto_tour_taxonomy_edit_icon_field( $term ) {
			$crafto_bootstrap_icons = crafto_bootstrap_icons();
			$crafto_activity_icon   = ! empty( get_term_meta( $term->term_id, 'crafto_activity_icon', true ) ) ? get_term_meta( $term->term_id, 'crafto_activity_icon', true ) : '';
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_activity_icon"><?php echo esc_html__( 'Select Icon', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<select id="crafto_activity_icon" class="crafto-tours-activity-icon" name="crafto_activity_icon">
						<option></option>
						<?php
						foreach ( $crafto_bootstrap_icons as $val ) {
							$selected = ( $val === $crafto_activity_icon ) ? ' selected="selected"' : '';
							?>
							<option <?php echo esc_attr( $selected ); ?> data="value, <?php echo esc_attr( $val ); ?> val," data-icon="bi <?php echo esc_attr( $val ); ?>" value="<?php echo $val; ?>">bi <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<?php
		}

		/**
		 * Saves custom icon meta data for a term in the tour activity taxonomy.
		 *
		 * @param int $crafto_term_id The ID of the term whose meta data is being saved.
		 */
		public function crafto_save_tour_taxonomy_icon_field( $crafto_term_id ) {
			$meta_keys = [
				'crafto_activity_icon',
			];

			foreach ( $meta_keys as $key ) {
				if ( isset( $_POST[$key] ) ) { // phpcs:ignore
					update_term_meta( $crafto_term_id, $key, $_POST[$key] ); // phpcs:ignore
				}
			}
		}

		/**
		 * Adds a custom meta field to the tour taxonomy.
		 */
		public function crafto_tour_taxonomy_add_meta_field() {
			?>			
			<div class="form-field">
				<label for="crafto_tour_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_tour_archive_title_subtitle" id="crafto_tour_archive_title_subtitle" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_tour_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				<input name="crafto_tour_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="" />			
				<img class="upload_image_screenshort" src="" />
				<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
				<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
			</div>	
			<div class="form-field">
				<label for="crafto_tour_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				<input name="crafto_tour_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
				<div class="multiple_images">
				</div>
				<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
				<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_tour_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_tour_archive_title_video_mp4" id="crafto_tour_archive_title_video_mp4" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_tour_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_tour_archive_title_video_ogg" id="crafto_tour_archive_title_video_ogg" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_tour_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_tour_archive_title_video_webm" id="crafto_tour_archive_title_video_webm" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_tour_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_tour_archive_title_video_youtube" id="crafto_tour_archive_title_video_youtube" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
			</div>
			<?php
		}

		/**
		 * Displays and handles the editing of custom meta fields for the tour taxonomy.
		 *
		 * @param object $term The term object being edited.
		 */
		public function crafto_tour_taxonomy_edit_meta_field( $term ) {
			$crafto_tour_subtitle          = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_subtitle', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_subtitle', true ) : '';
			$crafto_tour_bg_image_id       = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_bg_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_bg_image', true ) : '';
			$crafto_tour_bg_multiple_image = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_bg_multiple_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_bg_multiple_image', true ) : '';
			$crafto_tour_video_mp4         = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_mp4', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_mp4', true ) : '';
			$crafto_tour_video_ogg         = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_ogg', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_ogg', true ) : '';
			$crafto_tour_video_webm        = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_webm', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_webm', true ) : '';
			$crafto_tour_video_youtube     = ! empty( get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_youtube', true ) ) ? get_term_meta( $term->term_id, 'crafto_tour_archive_title_video_youtube', true ) : '';
			$crafto_tour_bg_image_url      = wp_get_attachment_url( $crafto_tour_bg_image_id );
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_tour_archive_title_subtitle" id="crafto_tour_archive_title_subtitle" value="<?php echo esc_attr( $crafto_tour_subtitle ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_tour_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="<?php echo $crafto_tour_bg_image_id; // phpcs:ignore ?>" />					
					<img class="upload_image_screenshort" src="<?php echo esc_url( $crafto_tour_bg_image_url ); ?>">
					<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
					<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_tour_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
					<div class="multiple_images">
						<?php
						$crafto_val = explode( ',', $crafto_tour_bg_multiple_image );
						foreach ( $crafto_val as $key => $value ) {
							if ( ! empty( $value ) ) :
								$crafto_image_url   = wp_get_attachment_url( $value );
								$crafto_img_alt     = crafto_option_image_alt( $value );
								$crafto_img_title   = crafto_option_image_title( $value );
								$crafto_image_alt   = ! empty( $crafto_img_alt['alt'] ) ? ' alt="' . esc_attr( $crafto_img_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
								$crafto_image_title = ! empty( $crafto_img_title['title'] ) ? ' title="' . esc_attr( $crafto_img_title['title'] ) . '"' : '';

								echo '<div id=' . esc_attr( $value ) . '>';
									echo '<img class="upload_image_screenshort_multiple width-100px"' . $crafto_image_alt . $crafto_image_title . ' src="' . esc_url( $crafto_image_url ) . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo '<a href="javascript:void(0)" class="remove">' . esc_html__( 'Remove', 'crafto-addons' ) . '</a>';
								echo '</div>';
							endif;
						}
						?>
					</div>
					<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_attr__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
					<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_tour_archive_title_video_mp4" id="crafto_tour_archive_title_video_mp4" value="<?php echo esc_url( $crafto_tour_video_mp4 ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_tour_archive_title_video_ogg" id="crafto_tour_archive_title_video_ogg" value="<?php echo esc_url( $crafto_tour_video_ogg ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_tour_archive_title_video_webm" id="crafto_tour_archive_title_video_webm" value="<?php echo esc_url( $crafto_tour_video_webm ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_tour_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_tour_archive_title_video_youtube" id="crafto_tour_archive_title_video_youtube" value="<?php echo esc_url( $crafto_tour_video_youtube ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
					<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Saves custom meta data for a term in the tour taxonomy.
		 *
		 * @param int $crafto_term_id The ID of the term whose meta data is being saved.
		 */
		public function crafto_save_tour_taxonomy_custom_meta( $crafto_term_id ) {
			$meta_keys = [
				'crafto_tour_archive_title_subtitle',
				'crafto_tour_archive_title_bg_image',
				'crafto_tour_archive_title_bg_multiple_image',
				'crafto_tour_archive_title_video_mp4',
				'crafto_tour_archive_title_video_ogg',
				'crafto_tour_archive_title_video_webm',
				'crafto_tour_archive_title_video_youtube',
			];

			foreach ( $meta_keys as $key ) {
				if ( isset( $_POST[$key] ) ) { // phpcs:ignore
					update_term_meta( $crafto_term_id, $key, $_POST[$key] ); // phpcs:ignore
				}
			}
		}

		/**
		 * Adds a custom meta field to the portfolio taxonomy.
		 */
		public function crafto_portfolio_taxonomy_add_meta_field() {
			?>
			<div class="form-field">
				<label for="crafto_portfolio_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_portfolio_archive_title_subtitle" id="crafto_portfolio_archive_title_subtitle" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_portfolio_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				<input name="crafto_portfolio_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="" />				
				<img class="upload_image_screenshort" src="" />
				<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
				<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
			</div>

			<div class="form-field">
				<label for="crafto_portfolio_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				<input name="crafto_portfolio_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
				<div class="multiple_images">
				</div>
				<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
				<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_portfolio_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_portfolio_archive_title_video_mp4" id="crafto_portfolio_archive_title_video_mp4" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_portfolio_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_portfolio_archive_title_video_ogg" id="crafto_portfolio_archive_title_video_ogg" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_portfolio_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_portfolio_archive_title_video_webm" id="crafto_portfolio_archive_title_video_webm" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_portfolio_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_portfolio_archive_title_video_youtube" id="crafto_portfolio_archive_title_video_youtube" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
			</div>
			<?php
		}
		/**
		 * Displays and handles the editing of custom meta fields for the portfolio taxonomy.
		 *
		 * @param object $term The term object being edited.
		 */
		public function crafto_portfolio_taxonomy_edit_meta_field( $term ) {
			$crafto_portfolio_subtitle          = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_subtitle', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_subtitle', true ) : '';
			$crafto_portfolio_bg_image_id       = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_bg_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_bg_image', true ) : '';
			$crafto_portfolio_bg_multiple_image = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_bg_multiple_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_bg_multiple_image', true ) : '';
			$crafto_portfolio_video_mp4         = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_mp4', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_mp4', true ) : '';
			$crafto_portfolio_video_ogg         = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_ogg', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_ogg', true ) : '';
			$crafto_portfolio_video_webm        = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_webm', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_webm', true ) : '';
			$crafto_portfolio_video_youtube     = ! empty( get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_youtube', true ) ) ? get_term_meta( $term->term_id, 'crafto_portfolio_archive_title_video_youtube', true ) : '';
			$crafto_portfolio_bg_image_url      = wp_get_attachment_url( $crafto_portfolio_bg_image_id );
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_portfolio_archive_title_subtitle" id="crafto_portfolio_archive_title_subtitle" value="<?php echo esc_attr( $crafto_portfolio_subtitle ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_portfolio_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="<?php echo $crafto_portfolio_bg_image_id; // phpcs:ignore ?>" />					
					<img class="upload_image_screenshort" src="<?php echo esc_url( $crafto_portfolio_bg_image_url ); ?>">
					<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
					<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_portfolio_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
					<div class="multiple_images">
						<?php
						$crafto_val = explode( ',', $crafto_portfolio_bg_multiple_image );
						foreach ( $crafto_val as $key => $value ) {
							if ( ! empty( $value ) ) :
								$crafto_image_url   = wp_get_attachment_url( $value );
								$crafto_img_alt     = crafto_option_image_alt( $value );
								$crafto_img_title   = crafto_option_image_title( $value );
								$crafto_image_alt   = ! empty( $crafto_img_alt['alt'] ) ? ' alt="' . esc_attr( $crafto_img_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
								$crafto_image_title = ! empty( $crafto_img_title['title'] ) ? ' title="' . esc_attr( $crafto_img_title['title'] ) . '"' : '';

								echo '<div id=' . esc_attr( $value ) . '>';
									echo '<img class="upload_image_screenshort_multiple width-100px"' . $crafto_image_alt . $crafto_image_title . ' src="' . esc_url( $crafto_image_url ) . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo '<a href="javascript:void(0)" class="remove">' . esc_html__( 'Remove', 'crafto-addons' ) . '</a>';
								echo '</div>';
							endif;
						}
						?>
					</div>
					<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_attr__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
					<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_portfolio_archive_title_video_mp4" id="crafto_portfolio_archive_title_video_mp4" value="<?php echo esc_url( $crafto_portfolio_video_mp4 ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_portfolio_archive_title_video_ogg" id="crafto_portfolio_archive_title_video_ogg" value="<?php echo esc_url( $crafto_portfolio_video_ogg ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_portfolio_archive_title_video_webm" id="crafto_portfolio_archive_title_video_webm" value="<?php echo esc_url( $crafto_portfolio_video_webm ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_portfolio_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_portfolio_archive_title_video_youtube" id="crafto_portfolio_archive_title_video_youtube" value="<?php echo esc_url( $crafto_portfolio_video_youtube ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
					<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<?php
		}
		/**
		 * Saves custom meta data for a term in the portfolio taxonomy.
		 *
		 * @param int $crafto_term_id The ID of the term whose meta data is being saved.
		 */
		public function crafto_save_portfolio_taxonomy_custom_meta( $crafto_term_id ) {
			$meta_keys = [
				'crafto_portfolio_archive_title_subtitle',
				'crafto_portfolio_archive_title_bg_image',
				'crafto_portfolio_archive_title_bg_multiple_image',
				'crafto_portfolio_archive_title_video_mp4',
				'crafto_portfolio_archive_title_video_ogg',
				'crafto_portfolio_archive_title_video_webm',
				'crafto_portfolio_archive_title_video_youtube',
			];

			foreach ( $meta_keys as $key ) {
				if ( isset( $_POST[$key] ) ) { // phpcs:ignore
					update_term_meta( $crafto_term_id, $key, $_POST[$key] ); // phpcs:ignore
				}
			}
		}
		/**
		 * Adds a custom meta field to the product taxonomy.
		 */
		public function crafto_product_taxonomy_add_meta_field() {
			?>
			<div class="form-field">
				<label for="crafto_product_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_product_archive_title_subtitle" id="crafto_product_archive_title_subtitle" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_product_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				<input name="crafto_product_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="" />				
				<img class="upload_image_screenshort" src="" />
				<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
				<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
			</div>
			<div class="form-field">
				<label for="crafto_product_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				<input name="crafto_product_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
				<div class="multiple_images"></div>
				<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
				<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_product_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_product_archive_title_video_mp4" id="crafto_product_archive_title_video_mp4" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_product_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_product_archive_title_video_ogg" id="crafto_product_archive_title_video_ogg" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_product_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_product_archive_title_video_webm" id="crafto_product_archive_title_video_webm" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
			</div>
			<div class="form-field">
				<label for="crafto_product_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				<input type="text" name="crafto_product_archive_title_video_youtube" id="crafto_product_archive_title_video_youtube" value="" class="category-custom-field-input">
				<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
			</div>
			<?php
		}

		/**
		 * Displays and processes custom meta fields for the product taxonomy.
		 *
		 * @param object $term The term object being edited.
		 */
		public function crafto_product_taxonomy_edit_meta_field( $term ) {
			$crafto_product_subtitle          = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_subtitle', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_subtitle', true ) : '';
			$crafto_product_bg_image_id       = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_bg_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_bg_image', true ) : '';
			$crafto_product_bg_multiple_image = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_bg_multiple_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_bg_multiple_image', true ) : '';
			$crafto_product_video_mp4         = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_video_mp4', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_video_mp4', true ) : '';
			$crafto_product_video_ogg         = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_video_ogg', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_video_ogg', true ) : '';
			$crafto_product_video_webm        = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_video_webm', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_video_webm', true ) : '';
			$crafto_product_video_youtube     = ! empty( get_term_meta( $term->term_id, 'crafto_product_archive_title_video_youtube', true ) ) ? get_term_meta( $term->term_id, 'crafto_product_archive_title_video_youtube', true ) : '';
			$crafto_product_bg_image_url      = wp_get_attachment_url( $crafto_product_bg_image_id );
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_subtitle"><?php echo esc_html__( 'Subtitle', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_product_archive_title_subtitle" id="crafto_product_archive_title_subtitle" value="<?php echo esc_attr( $crafto_product_subtitle ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_bg_image"><?php echo esc_html__( 'Hero Background Image', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_product_archive_title_bg_image" class="upload_field hidden" id="crafto_upload" type="text" value="<?php echo $crafto_product_bg_image_id; // phpcs:ignore ?>" />
					<img class="upload_image_screenshort" src="<?php echo esc_url( $crafto_product_bg_image_url ); ?>">
					<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
					<span class="crafto_remove_button_category button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_bg_multiple_image"><?php echo esc_html__( 'Background Gallery Images', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input name="crafto_product_archive_title_bg_multiple_image" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="" />
					<div class="multiple_images">
						<?php
						$crafto_val = explode( ',', $crafto_product_bg_multiple_image );
						foreach ( $crafto_val as $key => $value ) {
							if ( ! empty( $value ) ) :
								$crafto_image_url   = wp_get_attachment_url( $value );
								$crafto_img_alt     = crafto_option_image_alt( $value );
								$crafto_img_title   = crafto_option_image_title( $value );
								$crafto_image_alt   = ! empty( $crafto_img_alt['alt'] ) ? ' alt="' . esc_attr( $crafto_img_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
								$crafto_image_title = ! empty( $crafto_img_title['title'] ) ? ' title="' . esc_attr( $crafto_img_title['title'] ) . '"' : '';

								echo '<div id=' . esc_attr( $value ) . '>';
									echo '<img class="upload_image_screenshort_multiple width-100px"' . $crafto_image_alt . $crafto_image_title . ' src="' . esc_url( $crafto_image_url ) . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo '<a href="javascript:void(0)" class="remove">' . esc_html__( 'Remove', 'crafto-addons' ) . '</a>';
								echo '</div>';
							endif;
						}
						?>
					</div>
					<input class="crafto_upload_button_multiple_category" id="crafto_upload_button_multiple_category" type="button" value="<?php echo esc_attr__( 'Browse', 'crafto-addons' ); ?>" /><?php echo esc_html__( 'Select Files', 'crafto-addons' ); ?>
					<p class="description"><?php echo esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_video_mp4"><?php echo esc_html__( 'Video MP4', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_product_archive_title_video_mp4" id="crafto_product_archive_title_video_mp4" value="<?php echo esc_url( $crafto_product_video_mp4 ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_video_ogg"><?php echo esc_html__( 'Video OGG', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_product_archive_title_video_ogg" id="crafto_product_archive_title_video_ogg" value="<?php echo esc_url( $crafto_product_video_ogg ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_video_webm"><?php echo esc_html__( 'Video WEBM', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_product_archive_title_video_webm" id="crafto_product_archive_title_video_webm" value="<?php echo esc_url( $crafto_product_video_webm ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="crafto_product_archive_title_video_youtube"><?php echo esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ); ?></label>
				</th>
				<td>
					<input type="text" name="crafto_product_archive_title_video_youtube" id="crafto_product_archive_title_video_youtube" value="<?php echo esc_url( $crafto_product_video_youtube ); ?>" class="category-custom-field-input">
					<p class="description"><?php echo esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ); ?></p>
					<p class="short-description"><?php echo esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ); ?></p>
				</td>
			</tr>
			<?php
		}
		/**
		 * Saves custom meta data for a product taxonomy term.
		 *
		 * @param int $crafto_term_id The ID of the product taxonomy term whose meta data is being saved.
		 */
		public function crafto_save_product_taxonomy_custom_meta( $crafto_term_id ) {
			$meta_keys = [
				'crafto_product_archive_title_subtitle',
				'crafto_product_archive_title_bg_image',
				'crafto_product_archive_title_bg_multiple_image',
				'crafto_product_archive_title_video_mp4',
				'crafto_product_archive_title_video_ogg',
				'crafto_product_archive_title_video_webm',
				'crafto_product_archive_title_video_youtube',
			];

			foreach ( $meta_keys as $key ) {
				if ( isset( $_POST[$key] ) ) { // phpcs:ignore
					update_term_meta( $crafto_term_id, $key, $_POST[$key] ); // phpcs:ignore
				}
			}
		}
	}

	new Crafto_Archive_Meta();
}
