<?php
/**
 * The template for displaying the default archive
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) :
	?>
	<ul class="row-cols-1 row-cols-lg-2 row-cols-sm-2 row grid blog-classic list-unstyled default-blog-grid">
		<?php
		if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
			?>
			<li class="grid-sizer p-0 m-0 d-none"></li>
			<?php
		}

		while ( have_posts() ) :
			the_post();
			if ( ! is_sticky() ) {
				?>
				<li id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class( 'grid-item grid-gutter' ); ?>>
					<div class="blog-post">
						<?php
						if ( ! post_password_required() ) {
							if ( has_post_thumbnail() ) {
								?>
								<div class="blog-post-images">
									<?php
									if ( has_post_thumbnail() ) {
										?>
										<a href="<?php the_permalink(); ?>">
											<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
										</a>
										<?php
									}
									?>
								</div>
								<?php
							}
						}
						?>
						<div class="post-details">
							<?php
							if ( get_the_author() ) {
								?>
								<span class="author-name">
									<?php echo esc_html__( 'By&nbsp;', 'crafto-addons' ); ?>
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php echo esc_html( get_the_author() ); ?></a>
								</span>
								<?php
							}
							if ( get_the_author() ) {
								?>
								<div class="post-author-meta">
									<?php
										$blog_category_data = crafto_post_category( get_the_ID(), false, $count = '1' );
										echo sprintf( '%s', $blog_category_data ); // phpcs:ignore
									?>
									<span class="post-date published">
										<?php echo esc_html( get_the_date( 'F j, Y', get_the_ID() ) ); ?>
									</span>
									<time class="updated d-none" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'F j, Y' ) ); ?>
									</time>
								</div>
								<?php
							}
							?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-title alt-font">
								<?php the_title(); // phpcs:ignore ?>
							</a>
							<p class="entry-content">
								<?php echo sprintf( '%s', wp_kses_post( crafto_get_the_excerpt_theme( 15 ) ) ); // phpcs:ignore ?>
							</p>
							<div class="crafto-button-wrapper default-button-wrapper">
								<a href="<?php the_permalink(); ?>" class="btn crafto-button-link" role="button">
									<span class="button-text alt-font">
										<?php echo esc_html__( 'Read more', 'crafto-addons' ); ?>
									</span>
								</a>
							</div>
						</div>
					</div>
				</li>
				<?php
			}
			endwhile;
		?>
	</ul>
	<?php
	crafto_get_pagination();
else :
	get_template_part( 'templates/content', 'none' );
endif;
