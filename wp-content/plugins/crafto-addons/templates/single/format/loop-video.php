<?php
/**
 * Displaying video for single post
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_video_type = crafto_post_meta( 'crafto_video_type' );
$crafto_video      = crafto_post_meta( 'crafto_video' );

if ( 'self' === $crafto_video_type ) {
	$crafto_video_mp4   = crafto_post_meta( 'crafto_video_mp4' );
	$crafto_video_ogg   = crafto_post_meta( 'crafto_video_ogg' );
	$crafto_video_webm  = crafto_post_meta( 'crafto_video_webm' );
	$crafto_mute        = crafto_post_meta( 'crafto_enable_mute' );
	$crafto_enable_mute = ( '1' === $crafto_mute ) ? ' muted' : '';

	if ( $crafto_video_mp4 || $crafto_video_ogg || $crafto_video_webm ) {
		?>
		<div class="blog-image crafto-blog-video-html5">
			<video<?php echo sprintf( '%s', $crafto_enable_mute ); ?> playsinline autoplay loop controls><?php // phpcs:ignore ?>
				<?php
				if ( ! empty( $crafto_video_mp4 ) ) {
					?>
					<source src="<?php echo esc_url( $crafto_video_mp4 ); ?>" type="video/mp4">
					<?php
				}
				if ( ! empty( $crafto_video_ogg ) ) {
					?>
					<source src="<?php echo esc_url( $crafto_video_ogg ); ?>" type="video/ogg">
					<?php
				}
				if ( ! empty( $crafto_video_webm ) ) {
					?>
					<source src="<?php echo esc_url( $crafto_video_webm ); ?>" type="video/webm">
					<?php
				}
				?>
			</video>
		</div>
		<?php
	}
} else {
	$crafto_video_url = crafto_post_meta( 'crafto_video' );
	if ( ! empty( $crafto_video_url ) ) {
		?>
		<div class="blog-image fit-videos">
			<iframe src="<?php echo esc_url( $crafto_video_url ); ?>" width="640" height="360" allowFullScreen allow="autoplay; fullscreen"></iframe>
		</div>
		<?php
	}
}

$crafto_blog_image = crafto_post_meta( 'crafto_featured_image' );
if ( has_post_thumbnail() && '1' === $crafto_blog_image ) {
	?>
	<div class="blog-image">
		<?php
		// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
		the_post_thumbnail( 'full', array( 'loading' => false ) );

		if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) {
			?>
			<figcaption class="wp-caption-text">
				<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
			</figcaption>
			<?php
		}
		?>
	</div>
	<?php
}
