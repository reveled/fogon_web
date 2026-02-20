<?php
/**
 * Metabox For Title Wrapper.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Get all register custom title section list. */
$crafto_custom_title_section_array = crafto_get_builder_section_data( 'custom-title', true );

/* If WooCommerce plugin is activated */
if ( 'product' === $post->post_type && is_woocommerce_activated() ) {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_enable_custom_title_single',
		esc_html__( 'Show Title', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Enable or disable title display on this page.', 'crafto-addons' )
	);

	crafto_meta_box_dropdown(
		'crafto_custom_title_section_single',
		esc_html__( 'Title Template', 'crafto-addons' ),
		$crafto_custom_title_section_array,
		esc_html__( 'Choose a title template for this page.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		)
	);

	crafto_meta_box_text(
		'crafto_single_product_title_subtitle_single',
		esc_html__( 'Subtitle', 'crafto-addons' ),
		esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_product_title_content_single',
		esc_html__( 'Short Description', 'crafto-addons' ),
		esc_html__( 'Add a short description for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload(
		'crafto_single_product_title_bg_image_single',
		esc_html__( 'Background Image', 'crafto-addons' ),
		esc_html__( 'Recommended image size is 1920px X 700px.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload_multiple(
		'crafto_single_product_title_bg_multiple_image_single',
		esc_html__( 'Background Gallery Images', 'crafto-addons' ),
		esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_product_title_callto_section_id_single',
		esc_html__( 'Next Section ID', 'crafto-addons' ),
		esc_html__( 'Applicable only for big typography & gallery background title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_product_title_video_mp4_single',
		esc_html__( 'Video MP4', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_product_title_video_ogg_single',
		esc_html__( 'Video OGG', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_product_title_video_webm_single',
		esc_html__( 'Video WEBM', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_product_title_video_youtube_single',
		esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
		'',
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);
} elseif ( 'portfolio' === $post->post_type ) {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_enable_custom_title_single',
		esc_html__( 'Show Title', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Enable or disable title display on this page.', 'crafto-addons' )
	);

	crafto_meta_box_dropdown(
		'crafto_custom_title_section_single',
		esc_html__( 'Title Template', 'crafto-addons' ),
		$crafto_custom_title_section_array,
		esc_html__( 'Choose a title template for this page.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		)
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_subtitle_single',
		esc_html__( 'Subtitle', 'crafto-addons' ),
		esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_content_single',
		esc_html__( 'Short Description', 'crafto-addons' ),
		esc_html__( 'Add a short description for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload(
		'crafto_single_portfolio_title_bg_image_single',
		esc_html__( 'Background Image', 'crafto-addons' ),
		esc_html__( 'Recommended image size is 1920px X 700px.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload_multiple(
		'crafto_single_portfolio_title_bg_multiple_image_single',
		esc_html__( 'Background Gallery Images', 'crafto-addons' ),
		esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_callto_section_id_single',
		esc_html__( 'Next Section ID', 'crafto-addons' ),
		esc_html__( 'Applicable only for big typography & gallery background title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_video_mp4_single',
		esc_html__( 'Video MP4', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_video_ogg_single',
		esc_html__( 'Video OGG', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_video_webm_single',
		esc_html__( 'Video WEBM', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_portfolio_title_video_youtube_single',
		esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		esc_html__( 'Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the "src" attribute of the video’s embed iframe code.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
		'',
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);

} elseif ( 'post' === $post->post_type ) {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_enable_custom_title_single',
		esc_html__( 'Show Title', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Enable or disable title display on this page.', 'crafto-addons' )
	);
	crafto_meta_box_dropdown(
		'crafto_custom_title_section_single',
		esc_html__( 'Title Template', 'crafto-addons' ),
		$crafto_custom_title_section_array,
		esc_html__( 'Choose a title template for this page.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		)
	);

	crafto_meta_box_text(
		'crafto_single_post_title_subtitle_single',
		esc_html__( 'Subtitle', 'crafto-addons' ),
		esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_post_title_content_single',
		esc_html__( 'Short Description', 'crafto-addons' ),
		esc_html__( 'Add a short description for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload(
		'crafto_single_post_title_bg_image_single',
		esc_html__( 'Background Image', 'crafto-addons' ),
		esc_html__( 'Recommended image size is 1920px X 700px.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload_multiple(
		'crafto_single_post_title_bg_multiple_image_single',
		esc_html__( 'Background Gallery Images', 'crafto-addons' ),
		esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_post_title_callto_section_id_single',
		esc_html__( 'Next Section ID', 'crafto-addons' ),
		esc_html__( 'Applicable only for big typography & gallery background title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_post_title_video_mp4_single',
		esc_html__( 'Video MP4', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_post_title_video_ogg_single',
		esc_html__( 'Video OGG', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_post_title_video_webm_single',
		esc_html__( 'Video WEBM', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_post_title_video_youtube_single',
		esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
		'',
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);

} elseif ( 'properties' === $post->post_type ) {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_enable_custom_title_single',
		esc_html__( 'Show Title', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Enable or disable title display on this page.', 'crafto-addons' )
	);
	crafto_meta_box_dropdown(
		'crafto_custom_title_section_single',
		esc_html__( 'Title Template', 'crafto-addons' ),
		$crafto_custom_title_section_array,
		esc_html__( 'Choose a title template for this page.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		)
	);
	crafto_meta_box_text(
		'crafto_single_property_title_subtitle_single',
		esc_html__( 'Subtitle', 'crafto-addons' ),
		esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_textarea(
		'crafto_single_property_title_content_single',
		esc_html__( 'Short Description', 'crafto-addons' ),
		esc_html__( 'Add a short description for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload(
		'crafto_single_property_title_bg_image_single',
		esc_html__( 'Background Image', 'crafto-addons' ),
		esc_html__( 'Recommended image size is 1920px X 700px.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload_multiple(
		'crafto_single_property_title_bg_multiple_image_single',
		esc_html__( 'Background Gallery Images', 'crafto-addons' ),
		esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' )
	);
	crafto_meta_box_text(
		'crafto_single_property_title_callto_section_id_single',
		esc_html__( 'Next Section ID', 'crafto-addons' ),
		esc_html__( 'Applicable only for big typography & gallery background title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_property_title_video_mp4_single',
		esc_html__( 'Video MP4', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_property_title_video_ogg_single',
		esc_html__( 'Video OGG', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_property_title_video_webm_single',
		esc_html__( 'Video WEBM', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_property_title_video_youtube_single',
		esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
		'',
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);
} elseif ( 'tours' === $post->post_type ) {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_enable_custom_title_single',
		esc_html__( 'Show Title', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Enable or disable title display on this page.', 'crafto-addons' )
	);
	crafto_meta_box_dropdown(
		'crafto_custom_title_section_single',
		esc_html__( 'Title Template', 'crafto-addons' ),
		$crafto_custom_title_section_array,
		esc_html__( 'Choose a title template for this page.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		)
	);
	crafto_meta_box_text(
		'crafto_single_tours_title_subtitle_single',
		esc_html__( 'Subtitle', 'crafto-addons' ),
		esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_textarea(
		'crafto_single_tours_title_content_single',
		esc_html__( 'Short Description', 'crafto-addons' ),
		esc_html__( 'Add a short description for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload(
		'crafto_single_tours_title_bg_image_single',
		esc_html__( 'Background Image', 'crafto-addons' ),
		esc_html__( 'Recommended image size is 1920px X 700px.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload_multiple(
		'crafto_single_tours_title_bg_multiple_image_single',
		esc_html__( 'Background Gallery Images', 'crafto-addons' ),
		esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_tours_title_callto_section_id_single',
		esc_html__( 'Next Section ID', 'crafto-addons' ),
		esc_html__( 'Applicable only for big typography & gallery background title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_tours_title_video_mp4_single',
		esc_html__( 'Video MP4', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_tours_title_video_ogg_single',
		esc_html__( 'Video OGG', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_tours_title_video_webm_single',
		esc_html__( 'Video WEBM', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_single_tours_title_video_youtube_single',
		esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
		'',
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);
} else {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_enable_custom_title_single',
		esc_html__( 'Show Title', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Enable or disable title display on this page.', 'crafto-addons' )
	);
	crafto_meta_box_dropdown(
		'crafto_custom_title_section_single',
		esc_html__( 'Title Template', 'crafto-addons' ),
		$crafto_custom_title_section_array,
		esc_html__( 'Choose a title template for this page.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_page_title_subtitle_single',
		esc_html__( 'Subtitle', 'crafto-addons' ),
		esc_html__( 'Add a subtitle for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_textarea(
		'crafto_page_title_content_single',
		esc_html__( 'Short Description', 'crafto-addons' ),
		esc_html__( 'Add a short description for this page.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload(
		'crafto_page_title_bg_image_single',
		esc_html__( 'Background Image', 'crafto-addons' ),
		esc_html__( 'Recommended image size is 1920px X 700px.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_upload_multiple(
		'crafto_page_title_bg_multiple_image_single',
		esc_html__( 'Background Gallery Images', 'crafto-addons' ),
		esc_html__( 'Applicable only for gallery background title style.', 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_page_title_callto_section_id_single',
		esc_html__( 'Next Section ID', 'crafto-addons' ),
		esc_html__( 'Applicable only for big typography & gallery background title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		)
	);
	crafto_meta_box_text(
		'crafto_page_title_video_mp4_single',
		esc_html__( 'Video MP4', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_page_title_video_ogg_single',
		esc_html__( 'Video OGG', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_page_title_video_webm_single',
		esc_html__( 'Video WEBM', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		'',
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
	);
	crafto_meta_box_text(
		'crafto_page_title_video_youtube_single',
		esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
		esc_html__( 'Applicable only for background video title style.', 'crafto-addons' ),
		esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' ),
		array(
			'element' => 'crafto_enable_custom_title_single',
			'value'   => array( 'default', '1' ),
		),
		'',
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);
}
