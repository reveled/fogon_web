<?php
/**
 * Crafto Register Gutenberg Blocks
 *
 * @package Crafto
 */

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If class `Crafto_Gutenberg_Blocks` doesn't exists yet.
if ( ! class_exists( 'Crafto_Gutenberg_Blocks' ) ) {

	/**
	 * Define `Crafto_Gutenberg_Blocks` class
	 */
	class Crafto_Gutenberg_Blocks {

		/**
		 * Constructor
		 */
		public function __construct() {
			if ( is_woocommerce_activated() ) {
				add_action( 'enqueue_block_editor_assets', array( $this, 'crafto_enqueue_gutenberg_script' ) );
				add_action( 'init', array( $this, 'crafto_register_product_filter_block' ), 20 );
				add_action( 'pre_get_posts', array( $this, 'crafto_active_filter_woocommerce_query' ) );
				add_action( 'rest_api_init', array( $this, 'crafto_rest_api_filter_woocommerce' ) );
			}
		}

		/**
		 *  Rest API for woocommerce attribute
		 */
		public function crafto_rest_api_filter_woocommerce () {
			register_rest_route( 'crafto/v1', '/product-attributes', [
				'methods'  => 'GET',
				'callback' => function () {
					$attributes = wc_get_attribute_taxonomies();
					$result     = [];
					foreach ( $attributes as $attribute ) {
						$result[] = [
							'id'   => $attribute->attribute_id,
							'name' => $attribute->attribute_label,
							'slug' => $attribute->attribute_name,
						];
					}
					return $result;
				},
				'permission_callback' => '__return_true',
			] );
		}

		/**
		 *  Enqueue crafto gutenberg script
		 */
		public function crafto_enqueue_gutenberg_script() {
			$file_path = CRAFTO_ADDONS_ROOT . '/gutenberg/build/index.js';
			wp_enqueue_script(
				'crafto-product-tag-widget-block',
				CRAFTO_ADDONS_ROOT_URI . '/gutenberg/build/index.js',
				[
					'wp-blocks',
					'wp-editor',
					'wp-data',
					'wp-i18n',
				],
				filemtime( $file_path ),
				true
			);

			wp_localize_script(
				'crafto-product-tag-widget-block',
				'craftoPriceFilterData',
				[ 'maxPrice' => $this->crafto_get_max_product_price() ]
			);
		}

		/**
		 *  Maximum price get in product.
		 */
		public function crafto_get_max_product_price() {
			global $wpdb;
			$max_price = $wpdb->get_var("
				SELECT MAX(CAST(meta_value AS UNSIGNED)) 
				FROM {$wpdb->postmeta} 
				WHERE meta_key = '_price'
			");

			return $max_price ? (float) $max_price : 10000; // Default to 10000 if no products found.
		}

		/**
		 *  Render crafto product filter blocks
		 */
		public function crafto_register_product_filter_block() {
			register_block_type(
				'crafto/product-tag-widget',
				[
					'render_callback' => function ( $attributes ) { // phpcs:ignore
						$selected_option   = isset( $attributes['selected_option'] ) ? $attributes['selected_option'] : 'product_cat';
						$number_of_posts   = isset( $attributes['numberof_posts'] ) ? $attributes['numberof_posts'] : 0;
						$selected_order_by = isset( $attributes['selected_orderby'] ) ? $attributes['selected_orderby'] : 'name';
						$selected_order    = isset( $attributes['selected_order'] ) ? $attributes['selected_order'] : 'ASC';
						$include           = isset( $attributes['include'] ) ? $attributes['include'] : [];
						$exclude           = isset( $attributes['exclude'] ) ? $attributes['exclude'] : [];
						$title             = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : esc_html__( 'Filter by Category', 'crafto-addons' );
						$args = [
							'taxonomy'   => $selected_option,
							'number'     => $number_of_posts,
							'orderby'    => $selected_order_by,
							'order'      => $selected_order,
							'hide_empty' => true,
						];
						if ( ! empty( $include ) ) {
							$args['include'] = $include;
						}
						if ( ! empty( $exclude ) ) {
							$args['exclude'] = $exclude;
						}
						$terms = get_terms( $args );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
							$output = '';
							if ( ! empty( $title ) ) {
								$output .= '<h3>' . $title . '</h3>';
							}
							if ( 'product_cat' === $selected_option ) {
								$filter_class = 'product-filter';
							} else {
								$filter_class = 'product-tag-filter';
							}
							$output .= '<ul class="' . esc_attr( $filter_class ) . '">';
							foreach ( $terms as $term ) {
								if ( 'product_cat' === $selected_option ) {
									$is_selected  = ( isset( $_GET['filter_' . $selected_option] ) && in_array( $term->slug, explode( ',', $_GET['filter_' . $selected_option] ) ) ); // phpcs:ignore

									$output .= '<li>';
									$output .= '<label>';
									$output .= '<input type="checkbox" class="filter-checkbox" data-term-slug="' . esc_attr( $term->slug ) . '" data-taxonomy="' . esc_attr( $selected_option ) . '"' . ( $is_selected ? ' checked' : '' ) . '><span class="crafto-cb"></span>';
									$output .= esc_html( $term->name );
									$output .= '<span class="count">' . esc_html( sprintf( '%02d', $term->count ) ) . '</span>';
									$output .= '</label>';
									$output .= '</li>';
								} else {
									$output .= '<li class="filter-tag"><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
								}
							}
							$output .= '</ul>';
							return $output;
						}
					},
				]
			);

			register_block_type(
				'crafto/recent-product-slider',
				[
					'render_callback' => function ( $attributes ) {
						$number_of_products = isset( $attributes['number_of_products'] ) ? intval( $attributes['number_of_products'] ) : 5;
						$orderby            = isset( $attributes['orderby'] ) ? sanitize_text_field( $attributes['orderby'] ) : 'date';
						$title              = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : esc_html__( 'New arrivals', 'crafto-addons' );

						$args = [
							'post_type'      => 'product',
							'posts_per_page' => $number_of_products,
							'orderby'        => $orderby,
							'order'          => 'DESC',
							'post_status'    => 'publish',
							'no_found_rows'  => true,
							'meta_query'     => [
								[
									'key'     => '_thumbnail_id',
									'compare' => 'EXISTS',
								],
							],
						];

						$products = new WP_Query( $args );
						if ( $products->have_posts() ) {
							$output = '';
							if ( ! empty( $title ) ) {
								$output .= '<h3>' . $title . '</h3>';
							}

							$output      .= '<div class="swiper recent-product-widget">';
							$output      .= '<div class="swiper-wrapper">';
							$counter      = 0;
							$opened_slide = false;

							while ( $products->have_posts() ) {
								$products->the_post();
								if ( 0 === $counter % 3 ) {
									if ( $opened_slide ) {
										$output .= '</div>';
									}
									$output      .= '<div class="swiper-slide">';
									$opened_slide = true;
								}

								$product = wc_get_product( get_the_ID() );

								if ( $product ) {
									$price_html     = $product->get_price_html();
									$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
									$output        .= '<div class="product-item">';
									$output        .= '<div class="product-details">';
									$output        .= '<h4><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h4>';

									$output .= '<p class="price">' . ( $price_html ? wp_kses_post( $price_html ) : esc_html__( 'No price available', 'crafto-addons' ) ) . '</p>';
									$output .= '</div>';
									$output .= '<div class="product-image">';
									if ( $featured_image ) {
										$output .= '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '"><img src="' . esc_url( $featured_image ) . '" alt="' . esc_attr( get_the_title() ) . '" /></a>';
									} else {
										$output .= '<p>' . esc_html__( 'No image available', 'crafto-addons' ) . '</p>';
									}
									$output .= '</div>';
									$output .= '</div>';
								}
								++$counter;
							}

							if ( $opened_slide ) {
								$output .= '</div>';
							}

							$output .= '</div>';
							$output .= '<div class="swiper-button-next"><i class="fa-solid fa-arrow-right"></i></div>';
							$output .= '<div class="swiper-button-prev"><i class="fa-solid fa-arrow-left"></i></div>';
							$output .= '</div>';
							wp_reset_postdata();
							return $output;
						} else {
							return '<p>' . esc_html__( 'No products found.', 'crafto-addons' ) . '</p>';
						}
					},
				]
			);

			register_block_type(
				'crafto/product-attribute-filter',
				[
					'render_callback' => function ( $attributes ) { // phpcs:ignore
						$title           = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : esc_html__( 'Filter by Attribute', 'crafto-addons' );
						$selected_option = isset( $attributes['selected_option'] ) ? $attributes['selected_option'] : 'pa_color';
						$args            = [
							'taxonomy'   => $selected_option,
							'hide_empty' => true,
							'orderby'    => 'name',
							'order'      => 'ASC',
							'number'     => 0,
						];

						$terms = get_terms( $args );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
							$output = '';
							if ( ! empty( $title ) ) {
								$output .= '<h3>' . $title . '</h3>';
							}
							if ( 'pa_color' === $selected_option ) {
								$filter_class = 'product-color-filter';
							} elseif ( 'pa_size' === $selected_option ) {
								$filter_class = 'product-size-filter';
							} else {
								$filter_class = 'product-attribute-filter';
							}
							$output .= '<ul class="' . esc_attr( $filter_class ) . '">';
							foreach ( $terms as $term ) {
								if ( 'pa_color' === $selected_option ) {
									$class            = '';
									$is_selected      = ( isset( $_GET['filter_color'] ) && in_array( $term->slug, explode( ',', $_GET['filter_color'] ) ) ); // phpcs:ignore
									$output          .= '<li><label>';
									$output          .= '<input type="checkbox" class="color-filter-checkbox" data-taxonomy="color" data-term-slug="' . esc_attr( $term->slug ) . '"' . ( $is_selected ? ' checked' : '' ) . '>';
									$color_value      = get_term_meta( $term->term_id, 'crafto_color', true );
									$background_color = ! empty( $color_value ) ? $color_value : '#232323';
									if ( 'white' === $term->slug ) {
										$class = 'crafto-white';
									}
									$output .= '<span class="crafto-cb ' . $class . '" style="background-color:' . esc_attr( $background_color ) . ';"></span>';
									$output .= esc_html( $term->name );
									$output .= '<span class="count">' . esc_html( sprintf( '%02d', $term->count ) ) . '</span>';
									$output .= '</label>';
									$output .= '</li>';
								} elseif ( 'pa_size' === $selected_option ) {
									$is_selected = (isset( $_GET['filter_size'] ) && in_array( $term->slug, explode( ',', $_GET['filter_size'] ) ) ); // phpcs:ignore
									$output     .= '<li>';
									$output     .= '<label>';
									$output     .= '<input type="checkbox" class="size-filter-checkbox" data-taxonomy="size" data-term-slug="' . esc_attr( $term->slug ) . '"' . ( $is_selected ? ' checked' : '' ) . '><span class="crafto-cb"></span>';
									$output     .= esc_html( $term->name );
									$output     .= '<span class="count">' . esc_html( sprintf( '%02d', $term->count ) ) . '</span>';
									$output     .= '</label>';
									$output     .= '</li>';
								} else {
									$attr        = explode( '_', $selected_option );
									$is_selected = ( isset( $_GET['filter_' . $attr[1] ] ) && in_array( $term->slug, explode( ',', $_GET['filter_' . $attr[1] ] ) ) ); // phpcs:ignore

									$output     .= '<li><label>';
									$output     .= '<input type="checkbox" class="attribute-filter-checkbox" data-taxonomy="' . $attr[1] . '" data-term-slug="' . esc_attr( $term->slug ) . '"' . ( $is_selected ? ' checked' : '' ) . '>';
									$image_value = get_term_meta( $term->term_id, 'crafto_image', true );
									if ( $image_value && wp_attachment_is_image( $image_value ) ) {
										$post_thumbanail = wp_get_attachment_image( $image_value, 'full' );
									} else {
										$alt = sprintf( '%1$s %2$s', esc_html__( 'Image', 'crafto-addons' ), get_the_ID() );

										$post_thumbanail = sprintf(
											'<img src="%1$s" alt="%2$s" />',
											Utils::get_placeholder_image_src(),
											$alt // phpcs:ignore
										);
									}
									$output .= '<span class="crafto-cb">' . $post_thumbanail . '</span>';
									$output .= esc_html( $term->name );
									$output .= '<span class="count">' . esc_html( sprintf( '%02d', $term->count ) ) . '</span>';
									$output .= '</label>';
									$output .= '</li>';
								}
							}
							$output .= '</ul>';
							return $output;
						}
					},
				]
			);

			register_block_type(
				'crafto/crafto-active-filter',
				[
					'render_callback' => function ( $attributes ) { // phpcs:ignore

						$title             = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : esc_html__( 'Active Filter', 'crafto-addons' );
						$active_categories = isset( $_GET['filter_product_cat'] ) ? explode( ',', sanitize_text_field( $_GET['filter_product_cat'] ) ) : array(); // phpcs:ignore
						$active_color      = isset( $_GET['filter_color'] ) ? explode( ',', sanitize_text_field( $_GET['filter_color'] ) ) : array(); // phpcs:ignore
						$active_fabric     = isset( $_GET['filter_fabric'] ) ? explode( ',', sanitize_text_field( $_GET['filter_fabric'] ) ) : array(); // phpcs:ignore
						$active_material   = isset( $_GET['filter_material'] ) ? explode( ',', sanitize_text_field( $_GET['filter_material'] ) ) : array(); // phpcs:ignore
						$active_size       = isset( $_GET['filter_size'] ) ? explode( ',', sanitize_text_field( $_GET['filter_size'] ) ) : array(); // phpcs:ignore
						$min_price         = isset( $_GET['min_price'] ) ? sanitize_text_field( $_GET['min_price'] ) : ''; // phpcs:ignore
						$max_price         = isset( $_GET['max_price'] ) ? sanitize_text_field( $_GET['max_price'] ) : ''; // phpcs:ignore
						$rating_filter     = isset( $_GET['rating_filter'] ) ? explode( ',', sanitize_text_field( $_GET['rating_filter'] ) ) : array(); // phpcs:ignore
						$currency_symbol   = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';

						if ( ! empty( $active_categories ) || ! empty( $active_color ) || ! empty( $active_fabric ) || ! empty( $active_size ) || ! empty( $min_price ) || ! empty( $max_price ) || ! empty( $rating_filter ) || ! empty( $active_material ) ) {
							echo '<div class="crafto-active-filters">';
							if ( ! empty( $title ) ) {
								echo '<h3>' . esc_html( $title );

								if ( ! empty( $active_categories ) || ! empty( $active_color ) || ! empty( $active_fabric ) || ! empty( $active_material ) || ! empty( $active_size ) || ! empty( $min_price ) || ! empty( $max_price ) || ! empty( $rating_filter ) ) {
									echo '<a href="' . esc_url( remove_query_arg( array( 'filter_product_cat', 'filter_color', 'filter_fabric', 'filter_material', 'filter_size', 'min_price', 'max_price', 'rating_filter' ) ) ) . '" class="clear-all-filters">' . esc_html__( 'Clear All', 'crafto-addons' ) . '</a>';
								}
								echo '</h3>';
							}
							echo '<ul>';
							if ( ! empty( $active_categories ) ) {
								foreach ( $active_categories as $category ) {
									$remaining_categories = array_diff( $active_categories, array( $category ) );
									$new_url              = empty( $remaining_categories )
										? remove_query_arg( 'filter_product_cat' ) : add_query_arg( 'filter_product_cat', implode( ',', $remaining_categories ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( ucfirst( $category ) ) . '</a></li>';
								}
							}
							if ( ! empty( $active_color ) ) {
								foreach ( $active_color as $color ) {
									$remaining_color = array_diff( $active_color, array( $color ) );
									$new_url         = empty( $remaining_color )
										? remove_query_arg( 'filter_color' ) : add_query_arg( 'filter_color', implode( ',', $remaining_color ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( ucfirst( $color ) ) . '</a></li>';
								}
							}
							if ( ! empty( $active_fabric ) ) {
								foreach ( $active_fabric as $fabric ) {
									$remaining_fabric = array_diff( $active_fabric, array( $fabric ) );
									$new_url          = empty( $remaining_fabric )
										? remove_query_arg( 'filter_fabric' ) : add_query_arg( 'filter_fabric', implode( ',', $remaining_fabric ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( ucfirst( $fabric ) ) . '</a></li>';
								}
							}
							if ( ! empty( $active_material ) ) {
								foreach ( $active_material as $material ) {
									$remaining_material = array_diff( $active_material, array( $material ) );
									$new_url            = empty( $remaining_material )
										? remove_query_arg( 'filter_material' ) : add_query_arg( 'filter_material', implode( ',', $remaining_material ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( ucfirst( $material ) ) . '</a></li>';
								}
							}
							if ( ! empty( $active_size ) ) {
								foreach ( $active_size as $size ) {
									$remaining_sizes = array_diff( $active_size, array( $size ) );
									$new_url         = empty( $remaining_sizes )
										? remove_query_arg( 'filter_size' ) : add_query_arg( 'filter_size', implode( ',', $remaining_sizes ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( ucfirst( $size ) ) . '</a></li>';
								}
							}
							if ( ! empty( $rating_filter ) ) {
								foreach ( $rating_filter as $size ) {
									$remaining_rating = array_diff( $rating_filter, array( $size ) );
									$new_url         = empty( $remaining_rating )
										? remove_query_arg( 'rating_filter' ) : add_query_arg( 'rating_filter', implode( ',', $remaining_rating ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( 'Rated ' . $size . ' out of 5 ' ) . '</a></li>';
								}
							}
							if ( ! empty( $min_price ) || ! empty( $max_price ) ) {
								if ( ! empty( $min_price ) && ! empty( $max_price ) ) {
									$new_url = remove_query_arg( array( 'min_price', 'max_price' ) );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( 'Between ' . $currency_symbol . $min_price . ' and ' . $currency_symbol . $max_price ) . '</a></li>';
								} elseif ( ! empty( $max_price ) ) {
									$new_url = remove_query_arg( 'max_price' );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( 'Up to ' . $currency_symbol . $max_price ) . '</a></li>';
								} elseif ( ! empty( $min_price ) ) {
									$new_url = remove_query_arg( 'min_price' );
									echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html( 'From ' . $currency_symbol . $min_price ) . '</a></li>';
								}
							}
							echo '</ul>';
							echo '</div>';
						}
					},
				]
			);

			register_block_type(
				'crafto/crafto-price-filter',
				[
					'attributes'      => [
						'title'    => [
							'type'    => 'string',
							'default' => esc_html__( 'Filter by price', 'crafto-addons' ),
						],
						'minPrice' => [
							'type'    => 'number',
							'default' => 0,
						],
						'maxPrice' => [
							'type'    => 'number',
							'default' => $this->crafto_get_max_product_price(),
						],
					],

					'render_callback' => function ( $attributes ) {
						$title            = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : esc_html__( 'Filter by price', 'crafto-addons' );
						$originalMaxPrice = $attributes[ 'maxPrice' ];
						$originalMinPrice = $attributes[ 'minPrice' ];

						$maxPrice = isset( $_GET[ 'max_price' ] ) ? intval( $_GET[ 'max_price' ] ) : $originalMaxPrice;
						$minPrice = isset( $_GET[ 'min_price' ] ) ? intval( $_GET[ 'min_price' ] ) : $originalMinPrice;

						ob_start();
						?>
						<div class="crafto-price-filter">
							<?php
							if ( ! empty( $title ) ) {
								?>
								<h3><?php echo esc_html( $title ); ?></h3>
								<?php
							}
							?>
							<form class="crafto-price-range" method="get" action="<?php echo esc_url( home_url( '/shop/' ) ); ?>">
								<div class="price-range-slider">
									<div class="price-range-wrapper" 
										style="--low-value: <?php echo ( $minPrice / $originalMaxPrice ) * 100; // phpcs:ignore ?>%; --high-value: 100%;">
										<div class="price-calculate-width"></div>
										<input type="range" id="minPrice" min="<?php echo esc_html( $originalMinPrice ); ?>" max="<?php echo esc_html( $originalMaxPrice ); ?>" value="<?php echo esc_html( $minPrice ); ?>">
										<input type="range" id="maxPrice" min="<?php echo esc_html( $originalMinPrice ); ?>" max="<?php echo esc_html( $originalMaxPrice ); ?>" value="<?php echo esc_html( $maxPrice ); ?>" data-max="<?php echo esc_html( $originalMaxPrice ); ?>">
									</div>
									<div class="price-values">
										<?php echo esc_html__( 'Price:', 'crafto-addons'); ?>
										<span id="minPriceValue"><?php echo esc_html( '$' . $minPrice ); // phpcs:ignore ?></span>
										<span id="maxPriceValue"><?php echo esc_html( '$' . $maxPrice ); // phpcs:ignore ?></span>
										<button type="submit"><?php echo esc_html__( 'Filter', 'crafto-addons' ); ?></button>
									</div>
								</div>
							</form>
						</div>
						<?php
						return ob_get_clean();
					},
				]
			);
		}

		/**
		 *  Taxonomy filter woocommerce query
		 */
		public function crafto_active_filter_woocommerce_query( $query ) {
			if ( ! is_admin() && $query->is_main_query() && is_woocommerce_activated() && is_shop() ) {
				$tax_query  = [ 'relation' => 'AND' ];
				$meta_query = [ 'relation' => 'AND' ];
				// Category filter.
				if ( isset( $_GET['filter_product_cat'] ) && ! empty( $_GET['filter_product_cat'] ) ) { // phpcs:ignore
					$categories  = explode( ',', sanitize_text_field( $_GET['filter_product_cat'] ) ); // phpcs:ignore
					$tax_query[] = [
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $categories,
						'operator' => 'IN',
					];
				}
				// Color filter.
				if ( isset( $_GET['filter_color'] ) && ! empty( $_GET['filter_color'] ) ) { // phpcs:ignore
					$tags = explode( ',', sanitize_text_field( $_GET['filter_color'] ) ); // phpcs:ignore
					$tax_query[] = [
						'taxonomy' => 'pa_color',
						'field'    => 'slug',
						'terms'    => $tags,
						'operator' => 'IN',
					];
				}
				// Fabric filter.
				if ( isset( $_GET['filter_fabric'] ) && ! empty( $_GET['filter_fabric'] ) ) { // phpcs:ignore
					$tags = explode( ',', sanitize_text_field( $_GET['filter_fabric'] ) ); // phpcs:ignore
					$tax_query[] = [
						'taxonomy' => 'pa_fabric',
						'field'    => 'slug',
						'terms'    => $tags,
						'operator' => 'IN',
					];
				}
				// Material filter.
				if ( isset( $_GET['filter_material'] ) && ! empty( $_GET['filter_material'] ) ) { // phpcs:ignore
					$tags = explode( ',', sanitize_text_field( $_GET['filter_material'] ) ); // phpcs:ignore
					$tax_query[] = [
						'taxonomy' => 'pa_material',
						'field'    => 'slug',
						'terms'    => $tags,
						'operator' => 'IN',
					];
				}

				// Size filter.
				if ( isset( $_GET['filter_size'] ) && ! empty( $_GET['filter_size'] ) ) { // phpcs:ignore
					$tags = explode( ',', sanitize_text_field( $_GET['filter_size'] ) ); // phpcs:ignore
					$tax_query[] = [
						'taxonomy' => 'pa_size',
						'field'    => 'slug',
						'terms'    => $tags,
						'operator' => 'IN',
					];
				}
				// Price filter.
				if ( isset( $_GET['min_price'] ) && ! empty( $_GET['min_price'] ) ) { // phpcs:ignore
					$min_price = (float) sanitize_text_field( $_GET['min_price'] ); // phpcs:ignore
					$meta_query[] = [
						'key'     => '_price',
						'value'   => $min_price,
						'compare' => '>=',
						'type'    => 'NUMERIC',
					];
				}
				if ( isset( $_GET['max_price'] ) && ! empty( $_GET['max_price'] ) ) { // phpcs:ignore
					$max_price = (float) sanitize_text_field( $_GET['max_price'] ); // phpcs:ignore
					$meta_query[] = [
						'key'     => '_price',
						'value'   => $max_price,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					];
				}
				// Rating filter.
				if ( isset( $_GET['rating_filter'] ) && ! empty( $_GET['rating_filter'] ) ) { // phpcs:ignore
					$rating = (float) sanitize_text_field( $_GET['rating_filter'] ); // phpcs:ignore
					$meta_query[] = [
						'key'     => '_wc_average_rating',
						'value'   => $rating,
						'compare' => '>=',
						'type'    => 'NUMERIC',
					];
				}
				if ( count( $tax_query ) > 1 ) {
					$query->set( 'tax_query', $tax_query );
				}
				if ( count( $meta_query ) > 1 ) {
					$query->set( 'meta_query', $meta_query );
				}
			}
		}

	}

	new Crafto_Gutenberg_Blocks();
}
