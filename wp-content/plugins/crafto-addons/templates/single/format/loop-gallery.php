<?php
/**
 * Displaying in gallery for single post
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_gallery               = '';
$crafto_blog_lightbox_gallery = crafto_post_meta( 'crafto_lightbox_image' );
$crafto_blog_gallery          = crafto_post_meta( 'crafto_gallery' );

if ( ! empty( $crafto_blog_gallery ) ) {
	$crafto_gallery = explode( ',', $crafto_blog_gallery );
}

$crafto_popup_id = 'blog-' . get_the_ID();
if ( '1' === $crafto_blog_lightbox_gallery ) {
	if ( ( is_array( $crafto_gallery ) ) || ( ! empty( $crafto_gallery ) ) ) {
		?>
		<ul class="blog-post-gallery-type grid-masonry grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col">
		<?php
		if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
			?>
			<li class="grid-sizer p-0 m-0"></li>
			<?php
		}

		foreach ( $crafto_gallery as $key => $value ) {
			$crafto_thumb = wp_get_attachment_url( $value );
			if ( $crafto_thumb ) {
				/* Lightbox */
				$crafto_attachment_attributes        = '';
				$crafto_image_title_lightbox_popup   = get_theme_mod( 'crafto_image_title_lightbox_popup', '0' );
				$crafto_image_caption_lightbox_popup = get_theme_mod( 'crafto_image_caption_lightbox_popup', '0' );

				if ( '1' === $crafto_image_title_lightbox_popup ) {
					$crafto_attachment_title       = get_the_title( $value );
					$crafto_attachment_attributes .= ! empty( $crafto_attachment_title ) ? ' title="' . $crafto_attachment_title . '"' : '';
				}

				if ( '1' === $crafto_image_caption_lightbox_popup ) {
					$crafto_lightbox_caption       = wp_get_attachment_caption( $value );
					$crafto_attachment_attributes .= ! empty( $crafto_lightbox_caption ) ? ' data-lightbox-caption="' . $crafto_lightbox_caption . '"' : '';
				}
				?>
				<li class="grid-item">
					<a href="<?php echo esc_url( $crafto_thumb ); ?>" data-elementor-open-lightbox="no" data-group="lightbox-gallery-<?php echo esc_attr( $crafto_popup_id ); ?>" class="lightbox-group-gallery-item"<?php echo sprintf( '%s', $crafto_attachment_attributes ); // phpcs:ignore ?>>
						<figure>
							<div class="blog-post-gallery-img portfolio-image">
								<?php echo wp_get_attachment_image( $value, 'full' ); ?>
							</div>
							<figcaption>
								<div class="portfolio-hover">
									<?php
									$gallery_item_hover_icon = apply_filters( 'crafto_single_post_gallery_hover_icon', '<i class="feather icon-feather-search" aria-hidden="true"></i>' );
									echo sprintf( '%s', $gallery_item_hover_icon ); // phpcs:ignore
									?>
								</div>
							</figcaption>
						</figure>
					</a>
				</li>
				<?php
			}
		}
		?>
		</ul>
		<?php
	}
} elseif ( ( is_array( $crafto_gallery ) ) || ( ! empty( $crafto_gallery ) ) ) {
	?>
	<div class="blog-image">
		<div class="crafto-post-single-slider swiper">
			<div class="swiper-wrapper">
				<?php
				foreach ( $crafto_gallery as $key => $value ) {
					if ( ! empty( $value ) ) {
						?>
						<div class="swiper-slide">
							<?php echo wp_get_attachment_image( $value, 'full', '', array( 'class' => 'swiper-slide-image' ) ); ?>
						</div>
						<?php
					}
				}
				?>
			</div>
			<div class="swiper-button-next"><i class="feather icon-feather-arrow-right"></i></div>
			<div class="swiper-button-prev"><i class="feather icon-feather-arrow-left"></i></div>
		</div>
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
