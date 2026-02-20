<?php
/**
 * Displaying quote for single post
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_blog_quote   = crafto_post_meta( 'crafto_quote' );
$crafto_quote_author = crafto_post_meta( 'crafto_quote_author' );
$crafto_blog_image   = crafto_post_meta( 'crafto_featured_image' );
if ( $crafto_blog_quote ) {
	?>
	<div class="blog-image crafto-blog-blockquote crafto-post-format">
		<blockquote>
			<?php
			$blockquote_icon = apply_filters( 'crafto_single_post_blockquote_icon', '<i class="bi bi-chat-quote" aria-hidden="true"></i>' );
			echo sprintf( '%s', $blockquote_icon ); // phpcs:ignore
			?>
			<div class="blockquote-content"><div class="blockquote-content-inner"><?php echo nl2br( $crafto_blog_quote ); // phpcs:ignore ?></div>
			<?php
			if ( $crafto_quote_author ) {
				echo '<div class="blockquote-author">' . esc_html( $crafto_quote_author ) . '</div>';
			}
			?>
			</div>
		</blockquote>
	</div>
	<?php
}

if ( has_post_thumbnail() && '1' === $crafto_blog_image ) {
	?>
	<div class="blog-image">
		<?php
		// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
		the_post_thumbnail( 'full', array( 'loading' => false ) );

		if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) :
			?>
			<figcaption class="wp-caption-text">
				<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
			</figcaption>
			<?php
		endif;
		?>
	</div>
	<?php
}
