<?php
/**
 * Popup Compare Details
 *
 * This template can be overridden by copying it to yourtheme/crafto/compare-popup/compare-details.php
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( $enable_heading || $enable_filter ) {
	?>
	<div class="compare-popup-heading">
		<?php
		if ( $enable_heading ) {
			?>
			<h3><?php echo esc_html( $heading_text ); ?></h3>
			<?php
		}

		if ( $enable_filter ) {
			?>
			<div class="actions">
				<span class="compare-error-msg d-none"><i class="fa-solid fa-exclamation-triangle"></i>
					<?php echo apply_filters( 'crafto_compare_product_error_message', esc_html__( 'PLEASE SELECT AT LEAST TWO PRODUCTS', 'crafto-addons' ) ); // phpcs:ignore ?>
				</span>
				<a href="javascript:void(0);" class="crafto-compare-reset">
					<?php echo esc_html__( 'RESET', 'crafto-addons' ); ?>
				</a>
				<a href="javascript:void(0);" class="crafto-compare-filter">
					<?php echo esc_html__( 'FILTER', 'crafto-addons' ); ?>
				</a>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
?>
<div class="compare-popup-main-content">
	<div class="content-left">
		<ul class="compare-table">
			<li></li>
			<li><?php echo esc_html__( 'Rating', 'crafto-addons' ); ?></li>
			<li><?php echo esc_html__( 'Description', 'crafto-addons' ); ?></li>
			<li><?php echo esc_html__( 'SKU', 'crafto-addons' ); ?></li>
			<li><?php echo esc_html__( 'Availability', 'crafto-addons' ); ?></li>
			<li><?php echo esc_html__( 'Weight', 'crafto-addons' ); ?></li>
			<li><?php echo esc_html__( 'Dimensions', 'crafto-addons' ); ?></li>
			<?php
			$attributes = wc_get_attribute_taxonomies();
			if ( ! empty( $attributes ) ) {
				foreach ( $attributes as $attributes_details ) {
					?>
					<li><?php echo esc_html( $attributes_details->attribute_label ); ?></li>
					<?php
				}
			} ?>
			<li><?php echo esc_html__( 'Additional Information', 'crafto-addons' ); ?></li>
			<li><?php echo esc_html__( 'Price', 'crafto-addons' ); ?></li>
			<li class="d-none"></li>
			<?php do_action( 'crafto_compare_list_heading' ); ?>
		</ul>
	</div>
	<div class="content-right">
		<?php
		if ( ! empty( $productids ) ) {
			?>
			<ul class="compare-lists-wrap">
				<?php
				$original_post = $GLOBALS['post'];

				foreach ( $productids as $productid ) {
					$GLOBALS['post'] = get_post( $productid ); // phpcs:ignore.
					setup_postdata( $GLOBALS['post'] );

					global $product;
					if ( ! $product || 'publish' !== $product->get_status() ) {
						continue;
					}

					$image         = $product->get_image();
					$product_title = $product->get_title();
					$description   = ! empty( $product->get_short_description() ) ? $product->get_short_description() : '-';
					$sku           = ! empty( $product->get_sku() ) ? $product->get_sku() : '-';
					$rating        = ! empty( wc_get_rating_html( $product->get_average_rating() ) ) ? wc_get_rating_html( $product->get_average_rating() ) : '-';
					$availability  = ! empty( $product->get_stock_status() ) ? ucfirst( $product->get_stock_status() ) : '-';
					$weight        = ! empty( $product->get_weight() ) ? $product->get_weight() : '-';
					$dimentions    = ( $product->has_dimensions() ) ? wc_format_dimensions( $product->get_dimensions( false ) ) : '-';
					$price_html    = ! empty( $product->get_price_html() ) ? $product->get_price_html() : '';
					?>
					<li class="list-details">
						<ul class="compare-table">
							<li>
								<div class="crafto-compare-product-remove-wrap">
									<?php
									if ( $enable_filter ) {
										?>
										<a class="crafto-compare-product-filter-opt" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>'" href="javascript:void(0);">
											<span class="crafto-compare-product-cb crafto-cb"></span>
										</a>
										<?php
									}
									?>									
									<a href="javascript:void(0);" class="crafto-compare-product-remove" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
										<?php echo esc_html__( 'REMOVE', 'crafto-addons' ); ?>
									</a>
								</div>

								<?php echo sprintf( '%s', $image ); // phpcs:ignore ?>
								<h2 class="compare-title">
									<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html( $product_title ); ?></a>
								</h2>
								<span class="price"><?php echo sprintf( '%s', $price_html ); // phpcs:ignore ?></span>
								<?php do_action( 'crafto_addons_compare_list_add_to_cart', $product, '' ); ?>
							</li>
							<li><?php echo sprintf( '%s', $rating ); // phpcs:ignore ?></li> 
							<li><?php echo sprintf( '%s', $description ); // phpcs:ignore ?></li>
							<li><?php echo esc_html( $sku ); ?></li>
							<li><?php echo esc_html( $availability ); ?></li>
							<li><?php echo esc_html( $weight ); ?></li>
							<li><?php echo esc_html( $dimentions ); ?></li>

							<?php
							$attributes_details = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );
							// Variation.
							if ( $product->is_type( 'variable' ) ) {
								$attributes = wc_get_attribute_taxonomies();
								foreach ( $attributes as $attribute ) {
									$name = 'pa_' . $attribute->attribute_name;
									if ( isset( $attributes_details[ $name ] ) ) {
										$terms = wc_get_product_terms( $productid, $name, array( 'fields' => 'names' ) ); ?>
										<li>
											<?php
											if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
												$terms_data = ( ! empty( $terms ) ) ? implode( ', ', $terms ) : '';
												echo esc_html( $terms_data );
											} else {
												echo '-';
											}
											?>
										</li>
										<?php
									} else {
										?>
										<li>-</li>
										<?php
									}
								}
							} else {
								$attributes       = wc_get_attribute_taxonomies();
								$attributes_count = count( $attributes );
								for ( $i = 0; $i < $attributes_count; $i++ ) {
									echo '<li>-</li>';
								}
							}

							// Additional Information.
							if ( ! empty( $attributes_details ) ) {
								?>
								<li>
									<table>
									<?php
									foreach ( $attributes_details as $attribute_detail ) {
										if ( ! $attribute_detail->is_taxonomy() ) {
											$label  = wc_attribute_label( $attribute_detail->get_name() );
											$values = $attribute_detail->get_options();
											?>
											<tr>
												<th><?php echo esc_html( $label ); ?></th>
												<td>
												<?php
												foreach ( $values as &$value ) {
													$value = make_clickable( esc_html( $value ) );
													echo $value; // phpcs:ignore
												}
												?>
												</td>
											</tr>
											<?php
										}
									}
									?>
									</table>
								</li>
								<?php
							} else {
								?>
								<li>-</li>
								<?php
							}
							?>
							<li><?php echo sprintf( '%s', $price_html ); // phpcs:ignore ?></li>
							<li class="d-none"></li>
							<?php do_action( 'crafto_compare_list_content', $product ); ?>
						</ul>
					</li>
					<?php
				}
				$GLOBALS['post'] = $original_post; // phpcs:ignore
				?>
			</ul>
			<?php
		}
		?>
	</div>
</div>
