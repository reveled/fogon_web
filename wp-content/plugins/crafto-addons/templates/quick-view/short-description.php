<?php
/**
 * Quick view product short description
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/short-description.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}
?>
<div class="woocommerce-product-details__short-description">
	<?php printf( '%s', $short_description ); // phpcs:ignore ?>
</div>
