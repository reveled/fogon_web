<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/crafto/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post, $product;

$crafto_new_product_shop                   = crafto_option( 'crafto_new_product_shop', '0' );
$crafto_quick_view_product_enable_sale_box = get_theme_mod( 'crafto_quick_view_product_enable_sale_box', '1' );
$crafto_quick_view_product_enable_new_box  = get_theme_mod( 'crafto_quick_view_product_enable_new_box', '1' );
?>
<?php if ( $product->is_on_sale() || $crafto_new_product_shop || ! $product->is_in_stock() ) : ?>

	<div class="sale-new-wrap">

		<?php if ( '1' === $crafto_quick_view_product_enable_sale_box ) : ?>
			<?php if ( $product->is_on_sale() ) : ?>

				<?php
					$regular_price = $product->get_regular_price();
					$sale_price    = $product->get_sale_price();
					$sale_label    = ( $regular_price > $sale_price ) ? '-' . ( ( 1 - number_format( $sale_price / $regular_price, 2 ) ) * 100 ) . '%' : esc_html__( 'Sale!', 'crafto-addons' );
				?>
				<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale alt-font">' . $sale_label . '</span>', $post, $product ); // phpcs:ignore ?>

			<?php elseif ( ! $product->is_in_stock() ) : ?>

				<?php echo apply_filters( 'woocommerce_sold_flash', '<span class="soldout alt-font">' . esc_html__( 'Sold', 'crafto-addons' ) . '</span>', $post, $product ); // phpcs:ignore  ?>

			<?php endif; ?>

		<?php endif; ?>

		<?php if ( '1' === $crafto_quick_view_product_enable_new_box ) : ?>

			<?php if ( $crafto_new_product_shop ) : ?>

				<?php echo apply_filters( 'crafto_new_product_flash', '<span class="new alt-font">' . esc_html__( 'New', 'crafto-addons' ) . '</span>', $post, $product ); // phpcs:ignore  ?>

			<?php endif; ?>

		<?php endif; ?>


	</div>

<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
