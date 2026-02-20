<?php
/**
 * The template for displaying the default tours archive
 *
 * @package Crafto
 * @since   1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) :
	?>
	<div class="tours-packages-wrapper">
		<ul class="grid grid-3col xl-grid-col lg-grid-2col md-grid-col sm-grid-1col xs-grid-col grid-masonry tours-classic tours-wrap default-tours-grid">
			<li class="grid-sizer p-0 m-0"></li>
			<?php
			while ( have_posts() ) :
				the_post();
				$destination                 = [];
				$crafto_tours_days           = crafto_post_meta( 'crafto_single_tours_days' );
				$crafto_tours_price          = crafto_post_meta( 'crafto_single_tours_price' );
				$crafto_tours_discount_price = crafto_post_meta( 'crafto_single_tours_discount_price' );
				$crafto_tours_review         = crafto_post_meta( 'crafto_single_tours_review' );
				$categories                  = get_the_terms( get_the_ID(), 'tour-destination' );

				if ( ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						$category_link = get_category_link( $category->term_id );
						$destination[] = '<a rel="category tag" href="' . esc_url( $category_link ) . '"><i class="feather icon-feather-map-pin"></i>' . esc_html( $category->name ) . '</a>';
					}
				}
				$tour_destination = ( is_array( $destination ) && ! empty( $destination ) ) ? implode( ' ', $destination ) : '';
				?>
				<li class="grid-item grid-gutter">
					<div class="tours-box-content-wrap">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php the_post_thumbnail( 'full' ); ?>
						</a>
						<div class="tours-content-wrapper">
							<?php
							if ( $crafto_tours_days ) {
								?>
								<div class="tours-day"><?php echo esc_html( $crafto_tours_days ); ?></div>
								<?php
							}
							if ( $crafto_tours_price && $crafto_tours_discount_price ) {
								?>
								<div class="price-wrap">
									<span class="text-label"><?php echo esc_html__( 'JUST', 'crafto-addons' ); ?></span>
									<span class="tours-price"><?php echo esc_html( $crafto_tours_price ); ?></span>
									<span class="tours-discount-price"><?php echo esc_html( $crafto_tours_discount_price ); ?>
										<span class="discount-price-separator"></span>
									</span>		
								</div>
								<?php
							}
							?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="tours-title"><?php echo esc_html( get_the_title() ); ?></a>
							<?php
							$show_excerpt_grid = ! empty( $crafto_tours_excerpt_length ) ? crafto_get_the_excerpt_theme( $crafto_tours_excerpt_length ) : crafto_get_the_excerpt_theme( 15 );
							?>
							<p class="entry-content">
								<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
							</p>
							<div class="destination-review-wrap">
								<?php
								if ( $tour_destination ) {
									?>
									<div class="destinations">
										<?php echo sprintf( '%s', $tour_destination ); // phpcs:ignore ?>
									</div>
									<?php
								}

								if ( $crafto_tours_review ) {
									?>
									<div class="review-wrap">
										<span class="review-star-icon">
											<?php
											$icon_html = '';
											for ( $stars = 1; $stars <= 5; $stars++ ) {
												if ( $stars <= 5 ) {
													$icon_html .= '<i class="fa-solid fa-star"></i>';
												}
											}
											?>
											<div class="elementor-star-rating"><?php echo sprintf( '%s', $icon_html ); // phpcs:ignore ?></div>
										</span>
										<?php
										if ( $crafto_tours_review ) {
											?>
											<span class="tours-reviews">
												<?php echo sprintf( '%s', $crafto_tours_review ); // phpcs:ignore ?>
											</span>
											<?php
										}
										?>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</li>
				<?php
			endwhile;
			?>
		</ul>
	</div>
	<?php
	crafto_get_pagination();
else :
	get_template_part( 'templates/content', 'none' );
endif;
