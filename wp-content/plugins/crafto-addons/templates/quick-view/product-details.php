<?php
/**
 * Loop Quick View Product Details
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/product-details.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove our custom class for quick view product.
do_action( 'crafto_remove_post_class' );
?>
<div id="product-quick-view-<?php the_ID(); ?>" <?php post_class( 'quick-view-product ' ); ?>>

	<div class="quick-view-gallery">
	<?php
		/**
		 * Crafto_before_quick_view_product_summary hook.
		 *
		 * @hooked crafto_show_quick_view_product_sale_flash - 10
		 * @hooked crafto_show_quick_view_product_image - 20
		 */
		do_action( 'crafto_before_quick_view_product_summary' );
	?>
	</div>

	<div class="summary entry-summary">

		<?php
			/**
			 * Crafto_quick_view_product_summary hook.
			 *
			 * @hooked crafto_template_quick_view_product_top_content_wrap_start - 2
			 * @hooked crafto_template_quick_view_product_title - 5
			 * @hooked crafto_template_quick_view_product_price - 9
			 * @hooked crafto_template_quick_view_product_top_content_wrap_middle - 9
			 * @hooked crafto_template_quick_view_product_rating - 10
			 * @hooked crafto_template_quick_view_product_sku - 11
			 * @hooked crafto_template_quick_view_product_top_content_wrap_end - 12
			 * @hooked crafto_template_quick_view_product_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked crafto_template_quick_view_product_wishlist - 31
			 * @hooked crafto_template_quick_view_product_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'crafto_quick_view_product_summary' );
		?>

	</div><!-- .summary -->

	<?php
	/**
	 * Crafto_after_quick_view_product_summary hook.
	 */
	do_action( 'crafto_after_quick_view_product_summary' );
	?>
</div>
