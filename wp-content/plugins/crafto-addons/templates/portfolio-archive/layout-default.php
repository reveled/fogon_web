<?php
/**
 * The template for displaying the default portfolio archive
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) :
	?>
	<ul class="row-cols-1 row-cols-md-3 row-cols-sm-2 row list-unstyled grid-masonry portfolio-classic portfolio-wrap portfolio-grid grid default-portfolio-grid">
		<?php
		if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
			?>
			<li class="grid-sizer p-0 m-0"></li>
			<?php
		}

		while ( have_posts() ) :
			the_post();

			$crafto_subtitle = crafto_post_meta( 'crafto_subtitle' );
			$has_post_format = crafto_post_meta( 'crafto_portfolio_post_type' );

			if ( 'link' === $has_post_format || has_post_format( 'link', get_the_ID() ) ) {
				$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_external_link' );
				$portfolio_link_target   = crafto_post_meta( 'crafto_portfolio_link_target' );
				$portfolio_external_link = ( ! empty( $portfolio_external_link ) ) ? $portfolio_external_link : '#';
				$portfolio_link_target   = ( ! empty( $portfolio_link_target ) ) ? $portfolio_link_target : '_self';
			} else {
				$portfolio_external_link = get_permalink();
				$portfolio_link_target   = '_self';
			}

			$crafto_subtitle = ( $crafto_subtitle ) ? str_replace( '||', '<br />', $crafto_subtitle ) : '';
			?>
			<li id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class( 'portfolio-item grid-item portfolio-single-post' ); ?>>
				<a href="<?php echo esc_url( $portfolio_external_link ); ?>" target="<?php echo esc_attr( $portfolio_link_target ); ?>" class="rounded-circle">
					<div class="portfolio-box">
						<div class="portfolio-image">
							<?php the_post_thumbnail(); ?>
							<div class="portfolio-hover">
								<span class="title"><?php the_title(); ?></span>
								<?php
								if ( $crafto_subtitle ) {
									printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
								}
								?>
							</div>
						</div>
					</div>
				</a>
			</li>
			<?php
			endwhile;
		?>
	</ul>
	<?php
	crafto_get_pagination();
else :
	get_template_part( 'templates/content', 'none' );
endif;
