<?php
/**
 * Quick View Product Price
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/price.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

$price_html = $product->get_price_html();

?>
<p class="price alt-font"><?php printf( '%s', $price_html ); // phpcs:ignore ?></p>
