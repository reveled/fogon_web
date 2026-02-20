<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package Crafto
 * @since   1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="alert alert-warning" role="alert">
	<?php
	if ( is_search() ) :
		$content_not_found = apply_filters( 'crafto_search_content_not_found', esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'crafto-addons' ) );
		?>
		<strong><?php echo esc_html( $content_not_found ); ?></strong>
		<?php
	else :
		$content_not_found = apply_filters( 'crafto_content_not_found', esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'crafto-addons' ) );
		?>
		<strong><?php echo esc_html( $content_not_found ); ?></strong>
		<?php
	endif;
	?>
</div>
