<?php
/**
 * Loop Quick View Product Image
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/product-image.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$columns        = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
// Remove the comment syntax // if you need to use it.

$post_thumbnail_id = $product->get_image_id();
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . $placeholder,
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

echo '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ) . '" data-columns = "' . esc_attr( $columns ) . '" style="opacity: 0; transition: opacity .25s ease-in-out;">';

do_action( 'crafto_product_gallery_before' );
$attachment_ids = $product->get_gallery_image_ids();
if ( has_post_thumbnail() && $attachment_ids ) {
	echo '<figure class="woocommerce-product-gallery__wrapper quick-view-images swiper">';
	echo '<div class="swiper-wrapper">';

	$attachment_id = $product->get_image_id();
	if ( has_post_thumbnail() ) {

		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
		$image_size        = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
		$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
		$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
		$full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
		$image             = wp_get_attachment_image(
			$attachment_id,
			$image_size,
			false,
			array(
				'title'                   => get_post_field( 'post_title', $attachment_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
				'data-src'                => $full_src[0],
				'data-large_image'        => $full_src[0],
				'data-large_image_width'  => $full_src[1],
				'data-large_image_height' => $full_src[2],
				'class'                   => 'wp-post-image',
			)
		);

		$html = '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="swiper-slide woocommerce-product-gallery__image">' . $image . '</div>';

	} else {
		$html  = '<div class="swiper-slide woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'crafto-addons' ) );
		$html .= '</div>';
	}

	// Main Image.
	echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id ); // phpcs:ignore

	if ( $attachment_ids && $product->get_image_id() ) { // phpcs:ignore
		foreach ( $attachment_ids as $attachment_id ) {

			$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
			$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
			$image_size        = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
			$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
			$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
			$full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
			$image             = wp_get_attachment_image(
				$attachment_id,
				$image_size,
				false,
				array(
					'title'                   => get_post_field( 'post_title', $attachment_id ),
					'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
					'data-src'                => $full_src[0],
					'data-large_image'        => $full_src[0],
					'data-large_image_width'  => $full_src[1],
					'data-large_image_height' => $full_src[2],
					'class'                   => '',
				)
			);

			$html = '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="swiper-slide woocommerce-product-gallery__image">' . $image . '</div>';
			// Gallery Image.
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id ); // phpcs:ignore
		}
	}

		echo '</div>';

		echo '<div class="swiper-button-next"><i class="fa-solid fa-chevron-right"></i></div>';
		echo '<div class="swiper-button-prev"><i class="fa-solid fa-chevron-left"></i></div>';
		echo '</figure>';
} else {
	echo '<figure class="woocommerce-product-gallery__wrapper">';
	$attributes = array(
		'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
		'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
		'data-src'                => $full_size_image[0],
		'data-large_image'        => $full_size_image[0],
		'data-large_image_width'  => $full_size_image[1],
		'data-large_image_height' => $full_size_image[2],
	);

	if ( has_post_thumbnail() ) {
		$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image">';
		$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
		$html .= '</div>';
	} else {
		$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'crafto-addons' ) );
		$html .= '</div>';
	}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) ); // phpcs:ignore
	echo '</figure>';
}

	do_action( 'crafto_product_gallery_after' );

echo '</div>';
