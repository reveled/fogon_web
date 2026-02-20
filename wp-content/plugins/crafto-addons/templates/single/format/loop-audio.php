<?php
/**
 * Displaying audio for single post
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_blog_audio = crafto_post_meta( 'crafto_audio' );
if ( $crafto_blog_audio ) {
	?>
	<div class="blog-image fit-videos crafto-blog-audio">
		<?php
		if ( $crafto_blog_audio ) {
			echo wp_oembed_get( $crafto_blog_audio ); // phpcs:ignore
		} else {
			echo sprintf( '%s', $crafto_blog_audio ); // phpcs:ignore
		}
		?>
	</div>
	<?php
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
