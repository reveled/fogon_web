<?php
/**
 * Metabox For Portfolio Setting.
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
crafto_meta_box_text(
	'crafto_subtitle_single',
	esc_html__( 'Subtitle', 'crafto-addons' ),
	esc_html__( 'Add a subtitle to be displayed in the portfolio grid.', 'crafto-addons' )
);
crafto_meta_box_text(
	'crafto_portfolio_external_link_single',
	esc_html__( 'External Link URL', 'crafto-addons' ),
	esc_html__( 'Enter the external URL for this link portfolio.', 'crafto-addons' )
);
crafto_meta_box_dropdown(
	'crafto_portfolio_link_target_single',
	esc_html__( 'Link Target', 'crafto-addons' ),
	array(
		'_self'  => esc_html__( 'Self', 'crafto-addons' ),
		'_blank' => esc_html__( 'New Window', 'crafto-addons' ),
	),
	esc_html__( 'Choose to open the link in the same or a new window.', 'crafto-addons' ),
);
crafto_meta_box_upload_multiple(
	'crafto_portfolio_gallery_single',
	esc_html__( 'Gallery Images', 'crafto-addons' ),
	esc_html__( 'Upload or select multiple images for the gallery.', 'crafto-addons' )
);
crafto_meta_box_dropdown(
	'crafto_portfolio_video_type_single',
	esc_html__( 'Video Source Type', 'crafto-addons' ),
	array(
		'self'     => esc_html__( 'Self-Hosted', 'crafto-addons' ),
		'external' => esc_html__( 'External Video', 'crafto-addons' ),
	),
	esc_html__( 'Select the source for the video: either self-hosted or an external video.', 'crafto-addons' )
);
crafto_meta_box_dropdown(
	'crafto_portfolio_enable_mute_single',
	esc_html__( 'Mute Video', 'crafto-addons' ),
	array(
		'1' => esc_html__( 'On', 'crafto-addons' ),
		'0' => esc_html__( 'Off', 'crafto-addons' ),
	),
	esc_html__( 'Enable to mute the video audio during playback.', 'crafto-addons' )
);
crafto_meta_box_text(
	'crafto_portfolio_video_mp4_single',
	esc_html__( 'Video MP4', 'crafto-addons' ),
	esc_html__( 'Enter the URL for the MP4 video file.', 'crafto-addons' ),
	''
);
crafto_meta_box_text(
	'crafto_portfolio_external_video_single',
	esc_html__( 'External Video URL', 'crafto-addons' ),
	esc_html__( 'Video URL is required here if external URL option is selected.', 'crafto-addons' ),
	esc_html__( 'Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the src attribute of the video’s embed iframe code.', 'crafto-addons' )
);
crafto_before_main_separator_end(
	'separator_main_end',
	''
);
