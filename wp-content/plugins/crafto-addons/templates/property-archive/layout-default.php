<?php
/**
 * The template for displaying the default property archive
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
	<div class="property-wrapper">
		<ul class="grid grid-3col lg-grid-2col sm-grid-1col default-property-grid">
			<?php
			if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
				?>
				<li class="grid-sizer p-0 m-0"></li>
				<?php
			}

			while ( have_posts() ) :
				the_post();
				$crafto_property_address         = crafto_post_meta( 'crafto_property_address' );
				$crafto_property_price           = crafto_post_meta( 'crafto_property_price' );
				$crafto_property_status          = crafto_post_meta( 'crafto_property_status' );
				$crafto_property_no_of_bedrooms  = crafto_post_meta( 'crafto_property_no_of_bedrooms' );
				$crafto_property_no_of_bathrooms = crafto_post_meta( 'crafto_property_no_of_bathrooms' );
				$crafto_property_size            = crafto_post_meta( 'crafto_property_size' );

				$crafto_property_address_arry = array();

				if ( ! empty( $crafto_property_address ) ) {
					$crafto_property_address_arry[] = $crafto_property_address;
				}

				$crafto_property_address_str = ! empty( $crafto_property_address_arry ) ? implode( ' ', $crafto_property_address_arry ) : '';
				?>
				<li id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class( 'grid-item grid-gutter' ); ?>>
					<div class="property-details-content-wrap">
						<div class="property-images">
							<div class="property-status">
								<?php echo esc_html( $crafto_property_status ); ?>
							</div>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'full' ); ?>
							</a>
						</div>
						<div class="properties-details">
							<div class="content-wrapper">
								<a href="<?php the_permalink(); ?>" class="property-title alt-font"><?php the_title(); ?></a>
								<?php
								$show_excerpt_grid = ! empty( $crafto_property_excerpt_length ) ? crafto_get_the_excerpt_theme( $crafto_property_excerpt_length ) : crafto_get_the_excerpt_theme( 15 );
								if ( ! empty( $show_excerpt_grid ) ) {
									?>
									<p class="property-content">
										<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
									</p>
									<?php
								}
								?>
								<p class="property-content">
									<?php echo esc_html( $crafto_property_address_str ); ?>
								</p>
								<div class="row">
									<?php
									if ( ! empty( $crafto_property_no_of_bedrooms ) ) {
										/**
										 * Filter to modify bedroom icon
										 *
										 * @since 1.0
										 */
										$crafto_property_bedroom_icon = apply_filters( 'crafto_property_bedroom_icon', CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/bedroom-small-icon.svg' );

										/**
										 * Filter to modify bedroom label
										 *
										 * @since 1.0
										 */
										$crafto_property_bedroom_label = apply_filters( 'crafto_property_bedroom_label', esc_html__( 'Bedrooms', 'crafto-addons' ) );
										?>
										<div class="col property-icon-box">
											<div class="icon-text">
												<img src="<?php echo esc_url( $crafto_property_bedroom_icon ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Bedroom', 'crafto-addons' ); ?>">
												<span><?php echo esc_html( $crafto_property_no_of_bedrooms ); ?></span>
											</div>
											<span class="icon-label"><?php echo esc_html( $crafto_property_bedroom_label ); ?></span>
										</div>
										<?php
									}

									if ( ! empty( $crafto_property_no_of_bathrooms ) ) {
										/**
										 * Filter to modify bathroom icon
										 *
										 * @since 1.0
										 */
										$crafto_property_bathroom_icon = apply_filters( 'crafto_property_bathroom_icon', CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/bathroom-small-icon.svg' );

										/**
										 * Filter to modify bathroom label
										 *
										 * @since 1.0
										 */
										$crafto_property_bathroom_label = apply_filters( 'crafto_property_bathroom_label', esc_html__( 'Bathroom', 'crafto-addons' ) );
										?>
										<div class="col property-icon-box">
											<div class="icon-text">
												<img src="<?php echo esc_url( $crafto_property_bathroom_icon ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Bathroom', 'crafto-addons' ); ?>">
												<span><?php echo sprintf( '%s', $crafto_property_no_of_bathrooms ); // phpcs:ignore ?></span>
											</div>
											<span class="icon-label"><?php echo esc_html( $crafto_property_bathroom_label ); ?></span>
										</div>
										<?php
									}

									if ( ! empty( $crafto_property_size ) ) {
										/**
										 * Filter to modify property size icon
										 *
										 * @since 1.0
										 */
										$crafto_property_size_icon = apply_filters( 'crafto_property_size_icon', CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/size-small-icon.svg' );

										/**
										 * Filter to modify property size label
										 *
										 * @since 1.0
										 */
										$crafto_property_size_label = apply_filters( 'crafto_property_size_label', esc_html__( 'Living area', 'crafto-addons' ) );
										?>
										<div class="col property-icon-box">
											<div class="icon-text">
												<img src="<?php echo esc_url( $crafto_property_size_icon ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Living area', 'crafto-addons' ); ?>">
												<span><?php echo sprintf( '%s', $crafto_property_size ); // phpcs:ignore ?></span>
											</div>
											<span class="icon-label"><?php echo esc_html( $crafto_property_size_label ); ?></span>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<div class="property-action-wrap">
								<div class="elementor-button-wrapper">
									<a href="<?php the_permalink(); ?>" class="elementor-button-link elementor-button blog-post-button" role="button">
										<span class="elementor-button-content-wrapper">
											<span class="elementor-button-text"><?php echo esc_html__( 'View Details', 'crafto-addons' ); ?></span>
										</span>
									</a>
								</div>
								<?php
								if ( ! empty( $crafto_property_price ) ) {
									?>
									<div class="property-price">
										<?php echo esc_html( $crafto_property_price ); ?>
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
