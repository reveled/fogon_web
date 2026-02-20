<?php
/**
 * Metabox For Post Setting.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
crafto_after_main_separator_start(
	'separator_main_start',
	''
);
crafto_meta_box_dropdown(
	'crafto_featured_image_single',
	esc_html__( 'Show Featured Image in Post Page', 'crafto-addons' ),
	array(
		'default' => esc_html__( 'Default', 'crafto-addons' ),
		'1'       => esc_html__( 'On', 'crafto-addons' ),
		'0'       => esc_html__( 'Off', 'crafto-addons' ),
	),
	esc_html__( 'Enable or disable the featured image display on this post.', 'crafto-addons' )
);
crafto_meta_box_textarea(
	'crafto_quote_single',
	esc_html__( 'Blockquote Text', 'crafto-addons' ),
	esc_html__( 'Enter the main quote content for this post.', 'crafto-addons' )
);
crafto_meta_box_text(
	'crafto_quote_author_single',
	esc_html__( 'Blockquote Author', 'crafto-addons' ),
	esc_html__( 'Enter the author name of the blockquote.', 'crafto-addons' ),
	''
);
crafto_meta_box_dropdown(
	'crafto_lightbox_image_single',
	esc_html__( 'Gallery Display Style', 'crafto-addons' ),
	array(
		'1' => esc_html__( 'Grid with Lightbox Popup', 'crafto-addons' ),
		'0' => esc_html__( 'Slider', 'crafto-addons' ),
	),
	esc_html__( 'Select how to display the gallery: grid or slider.', 'crafto-addons' )
);
crafto_meta_box_upload_multiple(
	'crafto_gallery_single',
	esc_html__( 'Gallery Images', 'crafto-addons' ),
	esc_html__( 'Upload or select multiple images for the gallery.', 'crafto-addons' )
);
crafto_meta_box_dropdown(
	'crafto_video_type_single',
	esc_html__( 'Video Source Type', 'crafto-addons' ),
	array(
		'self'     => esc_html__( 'Self-Hosted', 'crafto-addons' ),
		'external' => esc_html__( 'External Video', 'crafto-addons' ),
	),
	esc_html__( 'Select the source for the video: either self-hosted or an external video.', 'crafto-addons' )
);
crafto_meta_box_dropdown(
	'crafto_enable_mute_single',
	esc_html__( 'Mute Video', 'crafto-addons' ),
	array(
		'1' => esc_html__( 'On', 'crafto-addons' ),
		'0' => esc_html__( 'Off', 'crafto-addons' ),
	),
	esc_html__( 'Enable to mute the video audio during playback.', 'crafto-addons' )
);
crafto_meta_box_text(
	'crafto_video_mp4_single',
	esc_html__( 'Video MP4', 'crafto-addons' ),
	esc_html__( 'Enter the URL for the MP4 video file.', 'crafto-addons' ),
	''
);
crafto_meta_box_text(
	'crafto_video_ogg_single',
	esc_html__( 'Video OGG', 'crafto-addons' ),
	esc_html__( 'Enter the URL for the OGG video file.', 'crafto-addons' ),
	''
);
crafto_meta_box_text(
	'crafto_video_webm_single',
	esc_html__( 'Video WEBM', 'crafto-addons' ),
	esc_html__( 'Enter the URL for the WEBM video file.', 'crafto-addons' ),
	''
);
crafto_meta_box_text(
	'crafto_video_single',
	esc_html__( 'External Video URL (YouTube or Vimeo)', 'crafto-addons' ),
	esc_html__( 'Video URL is required here if external URL option is selected.', 'crafto-addons' ),
	esc_html__( "Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the 'src' attribute of the video’s embed iframe code.", 'crafto-addons' )
);
crafto_meta_box_textarea(
	'crafto_audio_single',
	esc_html__( 'Audio Embed Code/URL', 'crafto-addons' ),
	esc_html__( 'Insert the audio embed code or URL for this post.', 'crafto-addons' )
);
crafto_meta_box_text(
	'crafto_post_external_link_single',
	esc_html__( 'External Link URL', 'crafto-addons' ),
	esc_html__( 'Enter the external URL for this link post.', 'crafto-addons' )
);
crafto_meta_box_dropdown(
	'crafto_post_link_target_single',
	esc_html__( 'Link Target', 'crafto-addons' ),
	array(
		'_self'  => esc_html__( 'Self', 'crafto-addons' ),
		'_blank' => esc_html__( 'New Window', 'crafto-addons' ),
	),
	esc_html__( 'Choose to open the link in the same or a new window.', 'crafto-addons' ),
);
crafto_before_main_separator_end(
	'separator_main_end',
	''
);
