<?php
/**
 * Quick View Product Meta
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/meta.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$crafto_quick_view_product_enable_category = get_theme_mod( 'crafto_quick_view_product_enable_category', '1' );
$crafto_quick_view_product_enable_tag      = get_theme_mod( 'crafto_quick_view_product_enable_tag', '1' );

if ( $crafto_quick_view_product_enable_category || $crafto_quick_view_product_enable_tag ) {
	?>
	<div class="product_meta alt-font">

		<?php do_action( 'crafto_quick_view_product_meta_start' ); ?>

		<?php
		if ( '1' === $crafto_quick_view_product_enable_category ) {
			echo wc_get_product_category_list( $product->get_id(), '', '<span class="posted_in">' . sprintf( _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'crafto-addons' ) ) . ' ', '</span>' ); // phpcs:ignore
		}

		if ( '1' === $crafto_quick_view_product_enable_tag ) {
			echo wc_get_product_tag_list( $product->get_id(), '', '<span class="tagged_as">' . sprintf( _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'crafto-addons' ) ) . ' ', '</span>' ); // phpcs:ignore
		}
		?>

		<?php do_action( 'crafto_quick_view_product_meta_end' ); ?>

	</div>
	<?php
}
