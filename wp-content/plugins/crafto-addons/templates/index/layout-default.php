<?php
/**
 * The template for displaying the default/blog default archive
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) :
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; // phpcs:ignore
	if ( $paged < 2 ) {
		while ( have_posts() ) :
			the_post();

			if ( is_sticky() && is_home() ) {
				/* Check if post thumbnail hide or show */
				$crafto_show_post_thumbnail_sticky = get_theme_mod( 'crafto_show_post_thumbnail_sticky', '1' );
				/* Check Image SRCSET */
				$crafto_srcset_sticky = get_theme_mod( 'crafto_image_srcset_sticky', 'full' );
				/* Check if title hide or show */
				$crafto_show_post_title_sticky = get_theme_mod( 'crafto_show_post_title_sticky', '1' );
				/* Check if author hide or show */
				$crafto_show_post_author_sticky = get_theme_mod( 'crafto_show_post_author_sticky', '1' );
				/* Check if author image hide or show */
				$crafto_show_post_author_image_sticky = get_theme_mod( 'crafto_show_post_author_image_sticky', '0' );
				/* Check if date hide or show */
				$crafto_show_post_date_sticky = get_theme_mod( 'crafto_show_post_date_sticky', '1' );
				/* Check date format to show */
				$crafto_date_format_sticky = get_theme_mod( 'crafto_date_format_sticky', '' );
				/* Check if post excerpt hide or show */
				$crafto_show_excerpt_sticky = get_theme_mod( 'crafto_show_excerpt_sticky', '1' );
				/* Check post excerpt length to show */
				$crafto_excerpt_length_sticky = get_theme_mod( 'crafto_excerpt_length_sticky', '35' );
				/* Check if post content like hide or show */
				$crafto_show_content_sticky = get_theme_mod( 'crafto_show_content_sticky', '1' );
				/* Check if category like hide or show */
				$crafto_show_category_sticky = get_theme_mod( 'crafto_show_category_sticky', '1' );
				/* Check if post like hide or show */
				$crafto_show_like_sticky = get_theme_mod( 'crafto_show_like_sticky', '1' );
				/* Check if post comment hide or show */
				$crafto_show_comment_sticky = get_theme_mod( 'crafto_show_comment_sticky', '1' );
				/* Check if button hide or show */
				$crafto_show_button_sticky = get_theme_mod( 'crafto_show_button_sticky', '0' );
				/* Check button text to show */
				$crafto_button_text_sticky = get_theme_mod( 'crafto_button_text_sticky', esc_html__( 'Read more', 'crafto-addons' ) );
				$post_separator            = '<span class="post-meta-separator">' . esc_html__( '•', 'crafto-addons' ) . '</span>';

				$post_meta_array = array();
				if ( '1' === $crafto_show_category_sticky ) {
					$post_meta_array[] = '<span class="blog-category alt-font">' . crafto_post_category( get_the_ID(), true, '3' ) . '</span>';
				}
				?>
				<div class="blog-standard blog-post-sticky default-blog-post-sticky">
					<div id="post-<?php the_ID(); ?>" <?php post_class( array( 'grid-item', 'grid-gutter' ) ); ?>>
						<div class="blog-post text-center">
							<?php
							if ( ! post_password_required() && '1' === $crafto_show_post_thumbnail_sticky && has_post_thumbnail() ) {
								?>
								<div class="blog-post-images">
									<a href="<?php the_permalink(); ?>">
										<?php echo get_the_post_thumbnail( get_the_ID(), $crafto_srcset_sticky ); // phpcs:ignore ?>
									</a>
								</div>
								<?php
							}

							if ( '1' === $crafto_show_post_title_sticky || '1' === $crafto_show_excerpt_sticky || '1' === $crafto_show_content_sticky ) {
								?>
								<div class="post-details">
									<?php
									if ( '1' === $crafto_show_post_date_sticky ) {
										?>
										<div class="post-meta alt-font">
											<?php
											if ( '1' === $crafto_show_post_date_sticky ) {
												?>
												<span class="post-date published">
													<?php echo esc_html( get_the_date( $crafto_date_format_sticky, get_the_ID() ) ); ?>
												</span>
												<?php
												if ( ! empty( $post_meta_array )  ) {
													?>
													<span class="post-meta-separator">•</span>
													<?php
												}
											}
											?>
											<?php echo implode( $post_separator, $post_meta_array ); // phpcs:ignore ?>
										</div>
										<?php
									}

									if ( '1' === $crafto_show_post_title_sticky ) {
										?>
										<a class="entry-title alt-font" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										<?php
									}

									if ( '1' === $crafto_show_excerpt_sticky ) {
										$show_excerpt_grid = ! empty( $crafto_excerpt_length_sticky ) ? crafto_get_the_excerpt_theme( $crafto_excerpt_length_sticky ) : crafto_get_the_excerpt_theme( 35 );

										if ( ! empty( $show_excerpt_grid ) ) {
											?>
											<div class="entry-content"><?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?></div>
											<?php
										}
									} elseif ( '1' === $crafto_show_content_sticky ) {
										?>
										<div class="entry-content blog-full-content"><?php echo \Crafto_Addons_Extra_Functions::crafto_get_the_post_content(); // phpcs:ignore ?></div>
										<?php
									}

									if ( '1' === $crafto_show_button_sticky ) {
										?>
										<div class="crafto-button-wrapper default-button-wrapper">
											<a href="<?php the_permalink(); ?>" class="btn crafto-button-link blog-post-button" role="button">
												<span class="screen-reader-text"><?php echo esc_html__( 'Details', 'crafto-addons' ); ?></span>
												<span class="button-text alt-font"><?php echo esc_html( $crafto_button_text_sticky ); ?></span>
											</a>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}

							if ( '1' === $crafto_show_post_author_sticky || '1' === $crafto_show_like_sticky || '1' === $crafto_show_comment_sticky ) {
								?>
								<div class="post-meta-wrapper alt-font">
									<?php
									if ( '1' === $crafto_show_post_author_sticky && get_the_author() ) {
										?>
										<span class="post-author-meta">
											<?php
											if ( '1' === $crafto_show_post_author_image_sticky ) {
												echo get_avatar( get_the_author_meta( 'ID' ), '30' );
											}
											?>
											<span class="author-name"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
												<i class="fa-regular fa-user blog-icon"></i><?php echo esc_html__( 'By&nbsp;', 'crafto-addons' ) . esc_html( get_the_author() ); ?></a>
											</span>
										</span>
										<?php
									}

									if ( '1' === $crafto_show_like_sticky && class_exists( 'Crafto_Blog_Post_Likes' ) ) {
										?>
										<span class="post-meta-like">
											<?php echo \Crafto_Blog_Post_Likes::crafto_get_simple_likes_button( get_the_ID() ); // phpcs:ignore ?>
										</span>
										<?php
									}

									if ( '1' === $crafto_show_comment_sticky && ( comments_open() || get_comments_number() ) ) {
										?>
										<span class="post-meta-comments">
											<?php crafto_post_comments(); ?>
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
				<?php
			}
		endwhile;
	}
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
