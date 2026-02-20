<?php
/**
 * List of Wishlist data
 *
 * This template can be overridden by copying it to yourtheme/crafto/wishlist/product-wishlist.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="crafto-wishlist-page woocommerce">
	<?php
	if ( ! empty( $data ) ) {
		?>
		<div class="wishlistlink" link="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<div class="woocommerce-error crafto-wishlist-error-message d-none">
				<span><?php echo esc_html__( 'Please select at least one product', 'crafto-addons' ); ?></span>
			</div>
			<table class="table">
				<tr>
					<th class="product-check">
						<a class="crafto-all-wishlist-opt" href="javascript:void(0);">
							<span class="crafto-wishlist-cb crafto-cb"></span>
						</a>
					</th>
					<th class="product-thumbnail"></th>
					<th class="product-name alt-font"><?php echo esc_html__( 'Product Name', 'crafto-addons' ); ?></th>
					<th class="product-price alt-font"><?php echo esc_html__( 'Unit Price', 'crafto-addons' ); ?></th>
					<th class="product-stock-status alt-font"><?php echo esc_html__( 'Stock Status', 'crafto-addons' ); ?></th>
					<th class="product-add-to-cart"></th>
					<th class="product-remove"></th>
				</tr>
				<?php
				$original_post = $GLOBALS['post'];

				foreach ( $data as $productid ) {

					if ( ! empty( $productid ) ) {

						$GLOBALS['post'] = get_post( $productid ); // phpcs:ignore
						setup_postdata( $GLOBALS['post'] );

						global $product;

						if ( ! $product || 'publish' !== $product->get_status() ) {

							crafto_addons_remove_product_wishlist( array( $productid ) );
							continue;
						}

						$image         = $product->get_image();
						$product_title = $product->get_title();
						$price_html    = $product->get_price_html();

						ob_start();
							wc_get_template(
								'single-product/stock.php',
								array(
									'product'      => $product,
									'class'        => 'in-stock',
									'availability' => esc_html__( 'In stock', 'crafto-addons' ),
								)
							);
							$in_stock_html = ob_get_contents();
						ob_end_clean();

						$stock_html = wc_get_stock_html( $product );
						$stock_html = ! empty( $stock_html ) ? $stock_html : $in_stock_html;
						?>
					<tr>
						<td class="product-check-single">
							<a class="crafto-wishlist-opt" data-product_id="<?php echo esc_html( $productid ); ?>" href="javascript:void(0);">
								<span class="crafto-wishlist-cb crafto-cb"></span>
							</a>
						</td>
						<td class="product-thumbnail">
							<a href="<?php echo get_permalink( $productid ); ?>"><?php printf( '%s', $image ); // phpcs:ignore ?></a>
						</td>
						<td>
							<a class="wishlist-product-title" href="<?php echo get_permalink( $productid ); ?>"><?php printf( '%s', $product_title ); // phpcs:ignore ?></a>
						</td>
						<td><?php printf( '%s', $price_html ); // phpcs:ignore ?></td>
						<td class="product-stock-status"><?php printf( '%s', $stock_html ); // phpcs:ignore ?></td>
						<td><?php do_action( 'crafto_wishlist_page_add_to_cart', $product, 'single-add-to-cart' ); // Add To Cart Button. ?></td>
						<td>
							<a href="javascript:void(0);" data-product_id="<?php echo esc_html( $productid ); ?>" class="crafto-page-remove-wish">×</a>
						</td>
					</tr>
						<?php
					}
				}
				$GLOBALS['post'] = $original_post; // phpcs:ignore
				?>
				<tr>
					<td colspan="3">
						<a class="crafto-remove-wishlist-selected alt-font" href="javascript:void(0);"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></a>
					</td>
					<td colspan="4">
						<a class="crafto-empty-wishlist alt-font" href="javascript:void(0);"><?php echo esc_html__( 'Empty Wishlist', 'crafto-addons' ); ?></a>
					</td>
				</tr>
			</table>
		</div>
		<?php
	} else {
		?>
		<p class="no-product-wishlist alt-font">
			<i class="icon-feather-heart"></i><?php echo esc_html__( 'Your wishlist is currently empty.', 'crafto-addons' ); ?>
		</p>
		<p class="return-to-shop">
			<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php echo esc_html__( 'Return to shop', 'crafto-addons' ); ?></a>
		</p>
		<?php
	}
	?>
</div>
