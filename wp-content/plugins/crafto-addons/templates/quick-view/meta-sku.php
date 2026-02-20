<?php
/**
 * Quick View Product Meta SKU
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/meta-sku.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$crafto_quick_view_product_enable_sku = get_theme_mod( 'crafto_quick_view_product_enable_sku', '1' );

if ( '1' === $crafto_quick_view_product_enable_sku && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
	?>
	<span class="sku_wrapper product_meta alt-font"><?php echo esc_html__( 'SKU: ', 'crafto-addons' ); ?>
		<span class="sku"><?php echo esc_attr( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'crafto-addons' ); // phpcs:ignore ?></span>
	</span>
	<?php
}
