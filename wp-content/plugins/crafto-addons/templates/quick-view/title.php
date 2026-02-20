<?php
/**
 * Quick View Product title
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/title.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$crafto_quick_view_product_enable_title_link = get_theme_mod( 'crafto_quick_view_product_enable_title_link', '1' );
?>
<h1 class="product_title entry-title alt-font">
	<?php
	if ( '1' === $crafto_quick_view_product_enable_title_link ) {
		?>
		<a href="<?php the_permalink(); ?>">
		<?php
	}
	the_title();

	if ( '1' === $crafto_quick_view_product_enable_title_link ) {
		?>
		</a>
		<?php
	}
	?>
</h1>
