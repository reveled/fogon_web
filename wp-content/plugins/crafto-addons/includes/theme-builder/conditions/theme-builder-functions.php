<?php
/**
 * Theme Builder Functions
 *
 * @package Crafto
 */

use CraftoAddons\Theme_builder\Theme_Builder_Init as Theme_Builder;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_render_mini_header' ) ) {
	/**
	 * Render mini header template in theme header section.
	 */
	function crafto_render_mini_header() {
		$crafto_enable_mini_header = crafto_builder_option( 'crafto_enable_mini_header', '0' );
		if ( '1' === $crafto_enable_mini_header ) {
			$specific_mini_header      = crafto_builder_option( 'crafto_mini_header_section', '' );
			$basic_page                = crafto_get_render_display_mini_header( 'basic-page' );
			$basic_single              = crafto_get_render_display_mini_header( 'basic-single' );
			$basic_archives            = crafto_get_render_display_mini_header( 'basic-archives' );
			$special_search            = crafto_get_render_display_mini_header( 'special-search' );
			$special_blog              = crafto_get_render_display_mini_header( 'special-blog' );
			$special_front             = crafto_get_render_display_mini_header( 'special-front' );
			$special_product_single    = crafto_get_render_display_mini_header( 'special-product-single' );
			$special_product_archive   = crafto_get_render_display_mini_header( 'special-product-archive' );
			$special_property_single   = crafto_get_render_display_mini_header( 'special-property-single' );
			$special_property_archive  = crafto_get_render_display_mini_header( 'special-property-archive' );
			$special_portfolio_single  = crafto_get_render_display_mini_header( 'special-portfolio-single' );
			$special_portfolio_archive = crafto_get_render_display_mini_header( 'special-portfolio-archive' );
			$special_tours_single      = crafto_get_render_display_mini_header( 'special-tours-single' );
			$special_tours_archive     = crafto_get_render_display_mini_header( 'special-tours-archive' );
			$special_woo_shop          = crafto_get_render_display_mini_header( 'special-woo-shop' );
			$basic_global              = crafto_get_render_display_mini_header( 'basic-global' );

			if ( $specific_mini_header ) {
				Theme_Builder::get_content_frontend( $specific_mini_header );
			} elseif ( $basic_page && is_page() ) {
					Theme_Builder::get_content_frontend( $basic_page );

			} elseif ( $special_search && is_search() ) {
					Theme_Builder::get_content_frontend( $special_search );

			} elseif ( $special_blog && is_home() ) {
					Theme_Builder::get_content_frontend( $special_blog );

			} elseif ( $special_front && is_front_page() ) {
					Theme_Builder::get_content_frontend( $special_front );

			} elseif ( $special_product_single && is_singular( 'product' ) ) {
					Theme_Builder::get_content_frontend( $special_product_single );

			} elseif ( $special_product_archive && is_post_type_archive( 'product' ) ) {
					Theme_Builder::get_content_frontend( $special_product_archive );

			} elseif ( $special_property_single && is_singular( 'property' ) ) {
					Theme_Builder::get_content_frontend( $special_property_single );

			} elseif ( $special_property_archive && is_post_type_archive( 'property' ) ) {
					Theme_Builder::get_content_frontend( $special_property_archive );

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {
					Theme_Builder::get_content_frontend( $special_portfolio_single );

			} elseif ( $special_portfolio_archive && is_post_type_archive( 'portfolio' ) ) {
					Theme_Builder::get_content_frontend( $special_portfolio_archive );

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {
					Theme_Builder::get_content_frontend( $special_tours_single );

			} elseif ( $special_tours_archive && is_post_type_archive( 'tours' ) ) {
					Theme_Builder::get_content_frontend( $special_tours_archive );

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {
					Theme_Builder::get_content_frontend( $special_woo_shop );

			} elseif ( $basic_single && is_single() ) {
					Theme_Builder::get_content_frontend( $basic_single );

			} elseif ( $basic_archives && is_archive() ) {
					Theme_Builder::get_content_frontend( $basic_archives );

			} else {
					Theme_Builder::get_content_frontend( $basic_global );
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=mini-header' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage mini header in the theme builder.', 'crafto-addons' )
			);
		} else {
			return;
		}
	}
}

if ( ! function_exists( 'crafto_mini_header_section_id' ) ) {
	/**
	 * Render header template in theme header section
	 */
	function crafto_mini_header_section_id() {
		$specific_mini_header      = crafto_builder_option( 'crafto_mini_header_section', '' );
		$basic_page                = crafto_get_render_display_mini_header( 'basic-page' );
		$basic_single              = crafto_get_render_display_mini_header( 'basic-single' );
		$basic_archives            = crafto_get_render_display_mini_header( 'basic-archives' );
		$special_search            = crafto_get_render_display_mini_header( 'special-search' );
		$special_blog              = crafto_get_render_display_mini_header( 'special-blog' );
		$special_front             = crafto_get_render_display_mini_header( 'special-front' );
		$special_product_single    = crafto_get_render_display_mini_header( 'special-product-single' );
		$special_product_archive   = crafto_get_render_display_mini_header( 'special-product-archive' );
		$special_property_single   = crafto_get_render_display_mini_header( 'special-property-single' );
		$special_property_archive  = crafto_get_render_display_mini_header( 'special-property-archive' );
		$special_portfolio_single  = crafto_get_render_display_mini_header( 'special-portfolio-single' );
		$special_portfolio_archive = crafto_get_render_display_mini_header( 'special-portfolio-archive' );
		$special_tours_single      = crafto_get_render_display_mini_header( 'special-tours-single' );
		$special_tours_archive     = crafto_get_render_display_mini_header( 'special-tours-archive' );
		$special_woo_shop          = crafto_get_render_display_mini_header( 'special-woo-shop' );
		$basic_global              = crafto_get_render_display_mini_header( 'basic-global' );

		if ( 'default' === $specific_mini_header || '' === $specific_mini_header ) {

			if ( $basic_page && is_page() ) {

				return $basic_page;

			} elseif ( $special_search && is_search() ) {

				return $special_search;

			} elseif ( $special_blog && is_home() ) {

				return $special_blog;

			} elseif ( $special_front && is_front_page() ) {

				return $special_front;

			} elseif ( $special_product_single && is_singular( 'product' ) ) {

				return $special_product_single;

			} elseif ( $special_product_archive && is_post_type_archive( 'product' ) ) {

				return $special_product_archive;

			} elseif ( $special_property_single && is_singular( 'property' ) ) {

				return $special_property_single;

			} elseif ( $special_property_archive && is_post_type_archive( 'property' ) ) {

				return $special_property_archive;

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {

				return $special_portfolio_single;

			} elseif ( $special_portfolio_archive && is_post_type_archive( 'portfolio' ) ) {

				return $special_portfolio_archive;

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {

				return $special_tours_single;

			} elseif ( $special_tours_archive && is_post_type_archive( 'tours' ) ) {

				return $special_tours_archive;

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {

				return $special_woo_shop;

			} elseif ( $basic_single && is_single() ) {

				return $basic_single;

			} elseif ( $basic_archives && is_archive() ) {

				return $basic_archives;

			} else {
				return $basic_global;
			}
		} else {
			return $specific_mini_header;
		}
	}
}

if ( ! function_exists( 'crafto_get_render_display_mini_header' ) ) {
	/**
	 * Return Header ID
	 *
	 * @param string $render_display_key Mini Header.
	 */
	function crafto_get_render_display_mini_header( $render_display_key ) {
		// Prepare the query arguments to search for the template.
		$query_args = [
			'post_type'        => 'themebuilder',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'no_found_rows'    => true,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'fields'           => 'ids',
			'suppress_filters' => false,
			// phpcs:ignore
			'meta_query'       => [
				'relation' => 'AND',
				[
					'key'   => '_crafto_theme_builder_template',
					'value' => 'mini-header',
				],
				[
					'key'     => '_crafto_mini_header_display_type',
					'value'   => sprintf( ':"%s";', $render_display_key ),
					'compare' => 'LIKE',
				],
			],
		];

		$post_ids = get_posts( $query_args );

		return ! empty( $post_ids ) ? $post_ids[0] : false;
	}
}

if ( ! function_exists( 'crafto_render_header' ) ) {
	/**
	 * Render header template in theme header section
	 */
	function crafto_render_header() {
		$crafto_enable_header = crafto_builder_option( 'crafto_enable_header', '1' );
		if ( '1' === $crafto_enable_header ) {
			$specific_header           = crafto_builder_option( 'crafto_header_section', '' );
			$basic_page                = crafto_get_render_display_header( 'basic-page' );
			$basic_single              = crafto_get_render_display_header( 'basic-single' );
			$basic_archives            = crafto_get_render_display_header( 'basic-archives' );
			$special_search            = crafto_get_render_display_header( 'special-search' );
			$special_404               = crafto_get_render_display_header( 'special-not-found' );
			$special_blog              = crafto_get_render_display_header( 'special-blog' );
			$special_front             = crafto_get_render_display_header( 'special-front' );
			$special_product_single    = crafto_get_render_display_header( 'special-product-single' );
			$special_product_archive   = crafto_get_render_display_header( 'special-product-archive' );
			$special_property_single   = crafto_get_render_display_header( 'special-property-single' );
			$special_property_archive  = crafto_get_render_display_header( 'special-property-archive' );
			$special_portfolio_single  = crafto_get_render_display_header( 'special-portfolio-single' );
			$special_portfolio_archive = crafto_get_render_display_header( 'special-portfolio-archive' );
			$special_tours_single      = crafto_get_render_display_header( 'special-tours-single' );
			$special_tours_archive     = crafto_get_render_display_header( 'special-tours-archive' );
			$special_woo_shop          = crafto_get_render_display_header( 'special-woo-shop' );
			$basic_global              = crafto_get_render_display_header( 'basic-global' );

			if ( $specific_header ) {
				Theme_Builder::get_content_frontend( $specific_header );
			} elseif ( $basic_page && is_page() ) {
					Theme_Builder::get_content_frontend( $basic_page );

			} elseif ( $basic_single && is_single() ) {
					Theme_Builder::get_content_frontend( $basic_single );

			} elseif ( $basic_archives && is_archive() ) {
					Theme_Builder::get_content_frontend( $basic_archives );

			} elseif ( $special_search && is_search() ) {
					Theme_Builder::get_content_frontend( $special_search );

			} elseif ( $special_404 && is_404() ) {
					Theme_Builder::get_content_frontend( $special_404 );

			} elseif ( $special_blog && is_home() ) {
					Theme_Builder::get_content_frontend( $special_blog );

			} elseif ( $special_front && is_front_page() ) {
					Theme_Builder::get_content_frontend( $special_front );

			} elseif ( $special_product_single && is_singular( 'product' ) ) {
					Theme_Builder::get_content_frontend( $special_product_single );

			} elseif ( $special_product_archive && is_post_type_archive( 'product' ) ) {
					Theme_Builder::get_content_frontend( $special_product_archive );

			} elseif ( $special_property_single && is_singular( 'property' ) ) {
					Theme_Builder::get_content_frontend( $special_property_single );

			} elseif ( $special_property_archive && is_post_type_archive( 'property' ) ) {
					Theme_Builder::get_content_frontend( $special_property_archive );

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {
					Theme_Builder::get_content_frontend( $special_portfolio_single );

			} elseif ( $special_portfolio_archive && is_post_type_archive( 'portfolio' ) ) {
					Theme_Builder::get_content_frontend( $special_portfolio_archive );

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {
					Theme_Builder::get_content_frontend( $special_tours_single );

			} elseif ( $special_tours_archive && is_post_type_archive( 'tours' ) ) {
					Theme_Builder::get_content_frontend( $special_tours_archive );

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {
					Theme_Builder::get_content_frontend( $special_woo_shop );

			} else {
					Theme_Builder::get_content_frontend( $basic_global );
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=header' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage header in the theme builder.', 'crafto-addons' )
			);
		} else {
			return;
		}
	}
}

if ( ! function_exists( 'crafto_header_section_id' ) ) {
	/**
	 * Render header template in theme header section
	 */
	function crafto_header_section_id() {
		$specific_header           = crafto_builder_option( 'crafto_header_section', '' );
		$basic_page                = crafto_get_render_display_header( 'basic-page' );
		$basic_single              = crafto_get_render_display_header( 'basic-single' );
		$basic_archives            = crafto_get_render_display_header( 'basic-archives' );
		$special_search            = crafto_get_render_display_header( 'special-search' );
		$special_404               = crafto_get_render_display_header( 'special-not-found' );
		$special_blog              = crafto_get_render_display_header( 'special-blog' );
		$special_front             = crafto_get_render_display_header( 'special-front' );
		$special_product_single    = crafto_get_render_display_header( 'special-product-single' );
		$special_product_archive   = crafto_get_render_display_header( 'special-product-archive' );
		$special_property_single   = crafto_get_render_display_header( 'special-property-single' );
		$special_property_archive  = crafto_get_render_display_header( 'special-property-archive' );
		$special_portfolio_single  = crafto_get_render_display_header( 'special-portfolio-single' );
		$special_portfolio_archive = crafto_get_render_display_header( 'special-portfolio-archive' );
		$special_tours_single      = crafto_get_render_display_header( 'special-tours-single' );
		$special_tours_archive     = crafto_get_render_display_header( 'special-tours-archive' );
		$special_woo_shop          = crafto_get_render_display_header( 'special-woo-shop' );
		$basic_global              = crafto_get_render_display_header( 'basic-global' );

		if ( 'default' === $specific_header || '' === $specific_header ) {

			if ( $basic_page && is_page() ) {

				return $basic_page;

			} elseif ( $special_search && is_search() ) {

				return $special_search;

			} elseif ( $special_404 && is_404() ) {

				return $special_404;

			} elseif ( $special_blog && is_home() ) {

				return $special_blog;

			} elseif ( $special_front && is_front_page() ) {

				return $special_front;

			} elseif ( $special_product_single && is_singular( 'product' ) ) {

				return $special_product_single;

			} elseif ( $special_product_archive && is_post_type_archive( 'product' ) ) {

				return $special_product_archive;

			} elseif ( $special_property_single && is_singular( 'property' ) ) {

				return $special_property_single;

			} elseif ( $special_property_archive && is_post_type_archive( 'property' ) ) {

				return $special_property_archive;

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {

				return $special_portfolio_single;

			} elseif ( $special_portfolio_archive && is_post_type_archive( 'portfolio' ) ) {

				return $special_portfolio_archive;

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {

				return $special_tours_single;

			} elseif ( $special_tours_archive && is_post_type_archive( 'tours' ) ) {

				return $special_tours_archive;

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {

				return $special_woo_shop;

			} elseif ( $basic_single && is_single() ) {

				return $basic_single;

			} elseif ( $basic_archives && is_archive() ) {

				return $basic_archives;

			} else {
				return $basic_global;
			}
		} else {
			return $specific_header;
		}
	}
}

if ( ! function_exists( 'crafto_check_header_template_exist' ) ) {
	/**
	 * Render header template in theme header section
	 */
	function crafto_check_header_template_exist() {
		$specific_header           = crafto_builder_option( 'crafto_header_section', '' );
		$basic_page                = crafto_get_render_display_header( 'basic-page' );
		$basic_single              = crafto_get_render_display_header( 'basic-single' );
		$basic_archives            = crafto_get_render_display_header( 'basic-archives' );
		$special_search            = crafto_get_render_display_header( 'special-search' );
		$special_404               = crafto_get_render_display_header( 'special-not-found' );
		$special_blog              = crafto_get_render_display_header( 'special-blog' );
		$special_front             = crafto_get_render_display_header( 'special-front' );
		$special_product_single    = crafto_get_render_display_header( 'special-product-single' );
		$special_product_archive   = crafto_get_render_display_header( 'special-product-archive' );
		$special_property_single   = crafto_get_render_display_header( 'special-property-single' );
		$special_property_archive  = crafto_get_render_display_header( 'special-property-archive' );
		$special_portfolio_single  = crafto_get_render_display_header( 'special-portfolio-single' );
		$special_portfolio_archive = crafto_get_render_display_header( 'special-portfolio-archive' );
		$special_tours_single      = crafto_get_render_display_header( 'special-tours-single' );
		$special_tours_archive     = crafto_get_render_display_header( 'special-tours-archive' );
		$special_woo_shop          = crafto_get_render_display_header( 'special-woo-shop' );
		$basic_global              = crafto_get_render_display_header( 'basic-global' );

		if ( 'default' === $specific_header || '' === $specific_header ) {

			if ( $basic_page ) {

				return $basic_page;

			} elseif ( $special_search ) {

				return $special_search;

			} elseif ( $special_404 ) {

				return $special_404;

			} elseif ( $special_blog ) {

				return $special_blog;

			} elseif ( $special_front ) {

				return $special_front;

			} elseif ( $special_product_single ) {

				return $special_product_single;

			} elseif ( $special_product_archive ) {

				return $special_product_archive;

			} elseif ( $special_property_single ) {

				return $special_property_single;

			} elseif ( $special_property_archive ) {

				return $special_property_archive;

			} elseif ( $special_portfolio_single ) {

				return $special_portfolio_single;

			} elseif ( $special_portfolio_archive ) {

				return $special_portfolio_archive;

			} elseif ( $special_tours_single ) {

				return $special_tours_single;

			} elseif ( $special_tours_archive ) {

				return $special_tours_archive;

			} elseif ( $special_woo_shop ) {

				return $special_woo_shop;

			} elseif ( $basic_single ) {

				return $basic_single;

			} elseif ( $basic_archives ) {

				return $basic_archives;

			} else {
				return $basic_global;
			}
		} else {
			return $specific_header;
		}
	}
}

if ( ! function_exists( 'crafto_get_render_display_header' ) ) {
	/**
	 * Return Header ID
	 *
	 * @param string $render_display_key Header.
	 */
	function crafto_get_render_display_header( $render_display_key ) {
		// Prepare the query arguments to search for the template.
		$query_args = [
			'post_type'        => 'themebuilder',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'no_found_rows'    => true,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'fields'           => 'ids',
			'suppress_filters' => false,
			// phpcs:ignore
			'meta_query'       => [
				'relation' => 'AND',
				[
					'key'   => '_crafto_theme_builder_template',
					'value' => 'header',
				],
				[
					'key'     => '_crafto_header_display_type',
					'value'   => sprintf( ':"%s";', $render_display_key ),
					'compare' => 'LIKE',
				],
			],
		];

		$post_ids = get_posts( $query_args );

		return ! empty( $post_ids ) ? $post_ids[0] : false;
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_footer' ) ) {
	/**
	 * Render footer template in theme footer section
	 */
	function crafto_render_footer() {
		$crafto_enable_footer = crafto_builder_option( 'crafto_enable_footer', '1' );
		if ( '1' === $crafto_enable_footer ) {
			$specific_footer           = crafto_builder_option( 'crafto_footer_section', '' );
			$basic_page                = crafto_get_render_display_footer( 'basic-page' );
			$basic_single              = crafto_get_render_display_footer( 'basic-single' );
			$basic_archives            = crafto_get_render_display_footer( 'basic-archives' );
			$special_search            = crafto_get_render_display_footer( 'special-search' );
			$special_404               = crafto_get_render_display_footer( 'special-not-found' );
			$special_blog              = crafto_get_render_display_footer( 'special-blog' );
			$special_front             = crafto_get_render_display_footer( 'special-front' );
			$special_product_single    = crafto_get_render_display_footer( 'special-product-single' );
			$special_product_archive   = crafto_get_render_display_footer( 'special-product-archive' );
			$special_property_single   = crafto_get_render_display_footer( 'special-property-single' );
			$special_property_archive  = crafto_get_render_display_footer( 'special-property-archive' );
			$special_portfolio_single  = crafto_get_render_display_footer( 'special-portfolio-single' );
			$special_portfolio_archive = crafto_get_render_display_footer( 'special-portfolio-archive' );
			$special_tours_single      = crafto_get_render_display_footer( 'special-tours-single' );
			$special_tours_archive     = crafto_get_render_display_footer( 'special-tours-archive' );
			$special_woo_shop          = crafto_get_render_display_footer( 'special-woo-shop' );
			$basic_global              = crafto_get_render_display_footer( 'basic-global' );

			if ( $specific_footer ) {
				Theme_Builder::get_content_frontend( $specific_footer );
			} elseif ( $basic_page && is_page() ) {
				Theme_Builder::get_content_frontend( $basic_page );

			} elseif ( $special_search && is_search() ) {
				Theme_Builder::get_content_frontend( $special_search );

			} elseif ( $special_404 && is_404() ) {
				Theme_Builder::get_content_frontend( $special_404 );

			} elseif ( $special_blog && is_home() ) {
				Theme_Builder::get_content_frontend( $special_blog );

			} elseif ( $special_front && is_front_page() ) {
				Theme_Builder::get_content_frontend( $special_front );

			} elseif ( $special_product_single && is_singular( 'product' ) ) {
				Theme_Builder::get_content_frontend( $special_product_single );

			} elseif ( $special_product_archive && is_post_type_archive( 'product' ) ) {
				Theme_Builder::get_content_frontend( $special_product_archive );

			} elseif ( $special_property_single && is_singular( 'property' ) ) {
				Theme_Builder::get_content_frontend( $special_property_single );

			} elseif ( $special_property_archive && is_post_type_archive( 'property' ) ) {
				Theme_Builder::get_content_frontend( $special_property_archive );

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {
				Theme_Builder::get_content_frontend( $special_portfolio_single );

			} elseif ( $special_portfolio_archive && is_post_type_archive( 'portfolio' ) ) {
				Theme_Builder::get_content_frontend( $special_portfolio_archive );

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {
				Theme_Builder::get_content_frontend( $special_tours_single );

			} elseif ( $special_tours_archive && is_post_type_archive( 'tours' ) ) {
				Theme_Builder::get_content_frontend( $special_tours_archive );

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {
				Theme_Builder::get_content_frontend( $special_woo_shop );

			} elseif ( $basic_single && is_single() ) {
				Theme_Builder::get_content_frontend( $basic_single );

			} elseif ( $basic_archives && is_archive() ) {
				Theme_Builder::get_content_frontend( $basic_archives );

			} else {
				Theme_Builder::get_content_frontend( $basic_global );
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=footer' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage footer in the theme builder.', 'crafto-addons' )
			);
		} else {
			return;
		}
	}
}

if ( ! function_exists( 'crafto_footer_section_id' ) ) {
	/**
	 * Render footer template in theme footer section
	 */
	function crafto_footer_section_id() {
		$specific_footer           = crafto_builder_option( 'crafto_footer_section', '' );
		$basic_page                = crafto_get_render_display_footer( 'basic-page' );
		$basic_single              = crafto_get_render_display_footer( 'basic-single' );
		$basic_archives            = crafto_get_render_display_footer( 'basic-archives' );
		$special_search            = crafto_get_render_display_footer( 'special-search' );
		$special_404               = crafto_get_render_display_footer( 'special-not-found' );
		$special_blog              = crafto_get_render_display_footer( 'special-blog' );
		$special_front             = crafto_get_render_display_footer( 'special-front' );
		$special_product_single    = crafto_get_render_display_footer( 'special-product-single' );
		$special_product_archive   = crafto_get_render_display_footer( 'special-product-archive' );
		$special_property_single   = crafto_get_render_display_footer( 'special-property-single' );
		$special_property_archive  = crafto_get_render_display_footer( 'special-property-archive' );
		$special_portfolio_single  = crafto_get_render_display_footer( 'special-portfolio-single' );
		$special_portfolio_archive = crafto_get_render_display_footer( 'special-portfolio-archive' );
		$special_tours_single      = crafto_get_render_display_footer( 'special-tours-single' );
		$special_tours_archive     = crafto_get_render_display_footer( 'special-tours-archive' );
		$special_woo_shop          = crafto_get_render_display_footer( 'special-woo-shop' );
		$basic_global              = crafto_get_render_display_footer( 'basic-global' );

		if ( 'default' === $specific_footer || '' === $specific_footer ) {

			if ( $basic_page && is_page() ) {

				return $basic_page;

			} elseif ( $special_search && is_search() ) {

				return $special_search;

			} elseif ( $special_404 && is_404() ) {

				return $special_404;

			} elseif ( $special_blog && is_home() ) {

				return $special_blog;

			} elseif ( $special_front && is_front_page() ) {

				return $special_front;

			} elseif ( $special_product_single && is_singular( 'product' ) ) {

				return $special_product_single;

			} elseif ( $special_product_archive && is_post_type_archive( 'product' ) ) {

				return $special_product_archive;

			} elseif ( $special_property_single && is_singular( 'property' ) ) {

				return $special_property_single;

			} elseif ( $special_property_archive && is_post_type_archive( 'property' ) ) {

				return $special_property_archive;

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {

				return $special_portfolio_single;

			} elseif ( $special_portfolio_archive && is_post_type_archive( 'portfolio' ) ) {

				return $special_portfolio_archive;

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {

				return $special_tours_single;

			} elseif ( $special_tours_archive && is_post_type_archive( 'tours' ) ) {

				return $special_tours_archive;

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {

				return $special_woo_shop;

			} elseif ( $basic_single && is_single() ) {

				return $basic_single;

			} elseif ( $basic_archives && is_archive() ) {

				return $basic_archives;

			} else {
				return $basic_global;
			}
		} else {
			return $specific_footer;
		}
	}
}

if ( ! function_exists( 'crafto_get_render_display_footer' ) ) {
	/**
	 * Return footer ID
	 *
	 * @param string $render_display_key Footer.
	 */
	function crafto_get_render_display_footer( $render_display_key ) {
		// Prepare the query arguments to search for the template.
		$query_args = [
			'post_type'        => 'themebuilder',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'no_found_rows'    => true,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'fields'           => 'ids',
			'suppress_filters' => false,
			// phpcs:ignore
			'meta_query'       => [
				'relation' => 'AND',
				[
					'key'   => '_crafto_theme_builder_template',
					'value' => 'footer',
				],
				[
					'key'     => '_crafto_footer_display_type',
					'value'   => sprintf( ':"%s";', $render_display_key ),
					'compare' => 'LIKE',
				],
			],
		];

		$post_ids = get_posts( $query_args );

		return ! empty( $post_ids ) ? $post_ids[0] : false;
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_custom_title' ) ) {
	/**
	 * Render custom title template in theme page title section
	 */
	function crafto_render_custom_title() {
		$crafto_enable_custom_title = crafto_builder_option( 'crafto_enable_custom_title', '1' );
		if ( '1' === $crafto_enable_custom_title ) {
			$specific_custom_title     = crafto_builder_option( 'crafto_custom_title_section', '' );
			$basic_page                = crafto_get_render_display_custom_title( 'basic-page' );
			$basic_single              = crafto_get_render_display_custom_title( 'basic-single' );
			$basic_archives            = crafto_get_render_display_custom_title( 'basic-archives' );
			$special_search            = crafto_get_render_display_custom_title( 'special-search' );
			$special_blog              = crafto_get_render_display_custom_title( 'special-blog' );
			$special_front             = crafto_get_render_display_custom_title( 'special-front' );
			$special_product_single    = crafto_get_render_display_custom_title( 'special-product-single' );
			$special_product_archive   = crafto_get_render_display_custom_title( 'special-product-archive' );
			$special_property_single   = crafto_get_render_display_custom_title( 'special-property-single' );
			$special_property_archive  = crafto_get_render_display_custom_title( 'special-property-archive' );
			$special_portfolio_single  = crafto_get_render_display_custom_title( 'special-portfolio-single' );
			$special_portfolio_archive = crafto_get_render_display_custom_title( 'special-portfolio-archive' );
			$special_tours_single      = crafto_get_render_display_custom_title( 'special-tours-single' );
			$special_tours_archive     = crafto_get_render_display_custom_title( 'special-tours-archive' );
			$special_woo_shop          = crafto_get_render_display_custom_title( 'special-woo-shop' );
			$basic_global              = crafto_get_render_display_custom_title( 'basic-global' );

			$courses_archive = '';
			if ( class_exists( 'LearnPress' ) ) {
				$courses_page_id = learn_press_get_page_id( 'courses' );
				if ( $courses_page_id ) {
					$courses_page_slug = get_post_field( 'post_name', $courses_page_id );
					$courses_archive   = crafto_get_render_display_custom_title( $courses_page_slug );
				}
			}
			if ( $specific_custom_title ) {
				Theme_Builder::get_content_frontend( $specific_custom_title );
			} elseif ( $basic_page && is_page() ) {
				Theme_Builder::get_content_frontend( $basic_page );

			} elseif ( $special_search && is_search() ) {
				Theme_Builder::get_content_frontend( $special_search );

			} elseif ( $special_blog && is_home() ) {
				Theme_Builder::get_content_frontend( $special_blog );

			} elseif ( $special_front && is_front_page() ) {
				Theme_Builder::get_content_frontend( $special_front );

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {
				Theme_Builder::get_content_frontend( $special_woo_shop );

			} elseif ( $special_product_single && is_singular( 'product' ) ) {
				Theme_Builder::get_content_frontend( $special_product_single );

			} elseif ( $special_product_archive && is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( 'product' ) ) {
				Theme_Builder::get_content_frontend( $special_product_archive );

			} elseif ( $special_property_single && is_singular( 'properties' ) ) {
				Theme_Builder::get_content_frontend( $special_property_single );

			} elseif ( $special_property_archive && is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) ) {
				Theme_Builder::get_content_frontend( $special_property_archive );

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {
				Theme_Builder::get_content_frontend( $special_portfolio_single );

			} elseif ( $special_portfolio_archive && is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) {
				Theme_Builder::get_content_frontend( $special_portfolio_archive );

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {
				Theme_Builder::get_content_frontend( $special_tours_single );

			} elseif ( $special_tours_archive && is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) {
				Theme_Builder::get_content_frontend( $special_tours_archive );

			} elseif ( $courses_archive && is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) ) {
				Theme_Builder::get_content_frontend( $courses_archive );

			} elseif ( $basic_single && is_single() ) {
				Theme_Builder::get_content_frontend( $basic_single );

			} elseif ( $basic_archives && is_archive() ) {
				Theme_Builder::get_content_frontend( $basic_archives );
			} else {
				Theme_Builder::get_content_frontend( $basic_global );
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=custom-title' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage custom title in the theme builder.', 'crafto-addons' )
			);
		} else {
			return;
		}
	}
}

if ( ! function_exists( 'crafto_custom_title_section_id' ) ) {
	/**
	 * Render custom title template in theme Page title section
	 */
	function crafto_custom_title_section_id() {
		$specific_custom_title     = crafto_builder_option( 'crafto_custom_title_section', '' );
		$basic_page                = crafto_get_render_display_custom_title( 'basic-page' );
		$basic_single              = crafto_get_render_display_custom_title( 'basic-single' );
		$basic_archives            = crafto_get_render_display_custom_title( 'basic-archives' );
		$special_search            = crafto_get_render_display_custom_title( 'special-search' );
		$special_blog              = crafto_get_render_display_custom_title( 'special-blog' );
		$special_front             = crafto_get_render_display_custom_title( 'special-front' );
		$special_product_single    = crafto_get_render_display_custom_title( 'special-product-single' );
		$special_product_archive   = crafto_get_render_display_custom_title( 'special-product-archive' );
		$special_property_single   = crafto_get_render_display_custom_title( 'special-property-single' );
		$special_property_archive  = crafto_get_render_display_custom_title( 'special-property-archive' );
		$special_portfolio_single  = crafto_get_render_display_custom_title( 'special-portfolio-single' );
		$special_portfolio_archive = crafto_get_render_display_custom_title( 'special-portfolio-archive' );
		$special_tours_single      = crafto_get_render_display_custom_title( 'special-tours-single' );
		$special_tours_archive     = crafto_get_render_display_custom_title( 'special-tours-archive' );
		$special_woo_shop          = crafto_get_render_display_custom_title( 'special-woo-shop' );
		$basic_global              = crafto_get_render_display_custom_title( 'basic-global' );
		$courses_archive           = '';

		if ( class_exists( 'LearnPress' ) ) {
			$courses_page_id = learn_press_get_page_id( 'courses' );
			if ( $courses_page_id ) {
				$courses_page_slug = get_post_field( 'post_name', $courses_page_id );
				$courses_archive   = crafto_get_render_display_custom_title( $courses_page_slug );
			}
		}
		if ( 'default' === $specific_custom_title || '' === $specific_custom_title ) {

			if ( $basic_page && is_page() && ! is_home() && ! is_front_page() ) {

				return $basic_page;

			} elseif ( $special_search && is_search() ) {

				return $special_search;

			} elseif ( $special_blog && is_home() ) {

				return $special_blog;

			} elseif ( $special_front && is_front_page() ) {

				return $special_front;

			} elseif ( $special_product_single && is_singular( 'product' ) ) {

				return $special_product_single;

			} elseif ( is_woocommerce_activated() && $special_woo_shop && is_shop() ) {

				return $special_woo_shop;

			} elseif ( $special_product_archive && is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( 'product' ) ) {

				return $special_product_archive;

			} elseif ( $special_property_single && is_singular( 'properties' ) ) {

				return $special_property_single;

			} elseif ( $special_property_archive && is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) ) {

				return $special_property_archive;

			} elseif ( $special_portfolio_single && is_singular( 'portfolio' ) ) {

				return $special_portfolio_single;

			} elseif ( $special_portfolio_archive && is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) {

				return $special_portfolio_archive;

			} elseif ( $special_tours_single && is_singular( 'tours' ) ) {

				return $special_tours_single;

			} elseif ( $special_tours_archive && is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) {

				return $special_tours_archive;

			} elseif ( $courses_archive && is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) ) {

				return $courses_archive;

			} elseif ( $basic_single && is_single() ) {

				return $basic_single;

			} elseif ( $basic_archives && is_archive() ) {

				return $basic_archives;

			} else {
				return $basic_global;
			}
		} else {
			return $specific_custom_title;
		}
	}
}

if ( ! function_exists( 'crafto_get_render_display_custom_title' ) ) {
	/**
	 * Return custom title ID
	 *
	 * @param string $render_display_key page title.
	 */
	function crafto_get_render_display_custom_title( $render_display_key ) {
		// Prepare the query arguments to search for the template.
		$query_args = [
			'post_type'        => 'themebuilder',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'no_found_rows'    => true,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'fields'           => 'ids',
			'suppress_filters' => false,
			// phpcs:ignore
			'meta_query'       => [
				'relation' => 'AND',
				[
					'key'   => '_crafto_theme_builder_template',
					'value' => 'custom-title',
				],
				[
					'key'     => '_crafto_custom_title_display_type',
					'value'   => sprintf( ':"%s";', $render_display_key ),
					'compare' => 'LIKE',
				],
			],
		];

		$post_ids = get_posts( $query_args );

		return ! empty( $post_ids ) ? $post_ids[0] : false;
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_promo_popup' ) ) {
	/**
	 * Render popup template
	 */
	function crafto_render_promo_popup() {
		// Retrieve theme customizer options.
		$crafto_enable_promo_popup  = get_theme_mod( 'crafto_enable_promo_popup', '0' );
		$crafto_default_template_id = get_theme_mod( 'crafto_promo_popup_section', '' );

		if ( ! empty( $crafto_default_template_id ) ) {
			if ( '1' === $crafto_enable_promo_popup ) {
				Theme_Builder::get_content_frontend( $crafto_default_template_id );

			} elseif ( is_admin() ) {
				echo sprintf( // phpcs:ignore
					'<a target="_blank" href="%s">%s </a> %s',
					esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=promo_popup' ),
					esc_html__( 'Click here', 'crafto-addons' ),
					esc_html__( 'to create / manage popup template in the theme builder.', 'crafto-addons' )
				);
			} else {
				return;
			}
		}
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_side_icon' ) ) {
	/**
	 * Render Side Icon template
	 */
	function crafto_render_side_icon() {
		// Retrieve theme customizer options.
		$crafto_enable_side_icon    = get_theme_mod( 'crafto_enable_side_icon', '0' );
		$crafto_default_template_id = get_theme_mod( 'crafto_side_icon_section', '' );

		// If a side icon template is set and it's not empty.
		if ( ! empty( $crafto_default_template_id ) ) {
			// Check if side icon is enabled.
			if ( '1' === $crafto_enable_side_icon ) {
				// Render side icon content if enabled.
				Theme_Builder::get_content_frontend( $crafto_default_template_id );

			} elseif ( is_admin() ) {
				// If in the admin area, provide a link to manage the side icon.
				echo sprintf( // phpcs:ignore
					'<a target="_blank" href="%s">%s </a> %s',
					esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=side_icon' ),
					esc_html__( 'Click here', 'crafto-addons' ),
					esc_html__( 'to create / manage side icon template in the theme builder.', 'crafto-addons' )
				);
			} else {
				// If not in the admin area and side icon is not enabled, do nothing.
				return;
			}
		}
	}
}

/*============================ SINGLE Portfolio ===================================*/

if ( ! function_exists( 'crafto_render_single_portfolio' ) ) {
	/**
	 * Render single portfolio template in theme single portfolio content area
	 */
	function crafto_render_single_portfolio() {
		$single_template = \Crafto_Builder_Helper::crafto_get_specific_item_template( 'single-portfolio' );

		if ( '0' !== $single_template ) {
			crafto_edit_single_section_link( $single_template );
			Theme_Builder::get_content_frontend( $single_template );
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=single-portfolio' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage single portfolio in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

/*============================ SINGLE Property ===================================*/

if ( ! function_exists( 'crafto_render_single_property' ) ) {
	/**
	 * Render single property template in theme single property content area
	 */
	function crafto_render_single_property() {
		$single_template = \Crafto_Builder_Helper::crafto_get_specific_item_template( 'single-properties' );

		if ( '0' !== $single_template ) {
			crafto_edit_single_section_link( $single_template );
			Theme_Builder::get_content_frontend( $single_template );
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=single-properties' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage single property in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

/*============================ SINGLE tours ===================================*/

if ( ! function_exists( 'crafto_render_single_tours' ) ) {
	/**
	 * Render single tours template in theme single tours content area
	 */
	function crafto_render_single_tours() {
		$single_template = \Crafto_Builder_Helper::crafto_get_specific_item_template( 'single-tours' );

		if ( '0' !== $single_template ) {
			crafto_edit_single_section_link( $single_template );
			Theme_Builder::get_content_frontend( $single_template );
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=single-tours' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage single tours in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

/*============================ SINGLE post ===================================*/

if ( ! function_exists( 'crafto_render_single_post' ) ) {
	/**
	 * Render single post template in theme single post content area
	 */
	function crafto_render_single_post() {
		$current_post_id   = get_the_ID();
		$current_post_type = get_post_type( $current_post_id );

		if ( 'post' === $current_post_type ) {
			$single_template = \Crafto_Builder_Helper::crafto_get_specific_item_template();
		} else {
			$default = 'single-' . $current_post_type . '-all';

			$single_template = \Crafto_Builder_Helper::crafto_get_specific_item_template( 'single', $default );
		}

		if ( '0' !== $single_template ) {
			crafto_edit_single_section_link( $single_template );
			Theme_Builder::get_content_frontend( $single_template );
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=single' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage single post in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_archive' ) ) {
	/**
	 * Render archive template in theme archive page content area
	 */
	function crafto_render_archive() {
		$blog_archive_id      = crafto_get_archive_template( 'archive', 'blog-home-archive' );
		$category_template_id = crafto_get_archive_template( 'archive', 'category-archives' );
		$tag_template_id      = crafto_get_archive_template( 'archive', 'tag-archives' );
		$author_template_id   = crafto_get_archive_template( 'archive', 'author-archives' );
		$author_template_id   = crafto_get_archive_template( 'archive', 'date-archives' );
		$search_template_id   = crafto_get_archive_template( 'archive', 'search-archives-template' );
		$archive_template_id  = crafto_get_archive_template( 'archive', 'general' );
		$post_type_name       = get_post_type();
		$all_custom_post_id   = crafto_get_archive_template( 'archive', $post_type_name );

		if ( is_tax() ) {
			$tax      = get_queried_object();
			$tax_name = $tax->taxonomy;

			$crafto_category_template_id = crafto_get_archive_template( 'archive', $tax_name );
			if ( $crafto_category_template_id ) {
				crafto_edit_section_link( $crafto_category_template_id );
				Theme_Builder::get_content_frontend( $crafto_category_template_id );
			} elseif ( $all_custom_post_id ) {
				crafto_edit_section_link( $all_custom_post_id );
				Theme_Builder::get_content_frontend( $all_custom_post_id );
			} elseif ( $archive_template_id ) {
				crafto_edit_section_link( $archive_template_id );
				Theme_Builder::get_content_frontend( $archive_template_id );
			} else {
				if ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/archive/layout-default.php' ) ) {
					include CRAFTO_ADDONS_ROOT . '/templates/archive/layout-default.php';
				}
			}
		} else {
			if ( is_category() && $category_template_id ) {
				crafto_edit_section_link( $category_template_id );

				Theme_Builder::get_content_frontend( $category_template_id );

			} elseif ( is_tag() && $tag_template_id ) {

				crafto_edit_section_link( $tag_template_id );

				Theme_Builder::get_content_frontend( $tag_template_id );

			} elseif ( is_author() && $author_template_id ) {

				crafto_edit_section_link( $author_template_id );

				Theme_Builder::get_content_frontend( $author_template_id );

			} elseif ( is_search() && $search_template_id ) {

				crafto_edit_section_link( $search_template_id );

				Theme_Builder::get_content_frontend( $search_template_id );

			} elseif ( is_home() && $blog_archive_id ) {

				crafto_edit_section_link( $blog_archive_id );

				Theme_Builder::get_content_frontend( $blog_archive_id );

			} elseif ( $archive_template_id ) {

				crafto_edit_section_link( $archive_template_id );

				Theme_Builder::get_content_frontend( $archive_template_id );

			} elseif ( is_search() || is_category() || is_tag() || is_archive() ) {
				if ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/archive/layout-default.php' ) ) {
					include CRAFTO_ADDONS_ROOT . '/templates/archive/layout-default.php';
				}
			} elseif ( is_home() ) {
				if ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/index/layout-default.php' ) ) {
					include CRAFTO_ADDONS_ROOT . '/templates/index/layout-default.php';
				}
			} elseif ( is_admin() ) {
				echo sprintf( // phpcs:ignore
					'<a target="_blank" href="%s">%s </a> %s',
					esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=archive' ),
					esc_html__( 'Click here', 'crafto-addons' ),
					esc_html__( 'to create / manage archive in the theme builder.', 'crafto-addons' )
				);

			} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
				include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
			}
		}
	}
}

if ( ! function_exists( 'crafto_render_archive_portfolio' ) ) {
	/**
	 * Render portfolio archive template in theme archive page content area
	 */
	function crafto_render_archive_portfolio() {

		$portfolio_category_template_id = crafto_get_archive_template( 'archive-portfolio', 'portfolio-cat-archives' );
		$portfolio_tags_template_id     = crafto_get_archive_template( 'archive-portfolio', 'portfolio-tags-archives' );
		$archive_template_id            = crafto_get_archive_template( 'archive-portfolio', 'general' );

		if ( is_tax( 'portfolio-category' ) && $portfolio_category_template_id ) {

			crafto_edit_section_link( $portfolio_category_template_id );

			Theme_Builder::get_content_frontend( $portfolio_category_template_id );

		} elseif ( is_tax( 'portfolio-tags' ) && $portfolio_tags_template_id ) {

			crafto_edit_section_link( $portfolio_tags_template_id );

			Theme_Builder::get_content_frontend( $portfolio_tags_template_id );

		} elseif ( $archive_template_id ) {

			crafto_edit_section_link( $archive_template_id );

			Theme_Builder::get_content_frontend( $archive_template_id );

		} elseif ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) {
			if ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/portfolio-archive/layout-default.php' ) ) {
				include CRAFTO_ADDONS_ROOT . '/templates/portfolio-archive/layout-default.php';
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=archive-portfolio' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage archive in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

if ( ! function_exists( 'crafto_render_archive_property' ) ) {
	/**
	 * Render property archive template in theme archive page content area
	 */
	function crafto_render_archive_property() {
		$property_types_template_id  = crafto_get_archive_template( 'archive-property', 'property-types' );
		$property_agents_template_id = crafto_get_archive_template( 'archive-property', 'property-agents' );
		$archive_template_id         = crafto_get_archive_template( 'archive-property', 'general' );

		if ( is_tax( 'property-types' ) && $property_types_template_id ) {

			crafto_edit_section_link( $property_types_template_id );

			Theme_Builder::get_content_frontend( $property_types_template_id );

		} elseif ( is_tax( 'property-agents' ) && $property_agents_template_id ) {

			crafto_edit_section_link( $property_agents_template_id );

			Theme_Builder::get_content_frontend( $archive_template_id );

		} elseif ( $archive_template_id ) {

			crafto_edit_section_link( $archive_template_id );

			Theme_Builder::get_content_frontend( $archive_template_id );

		} elseif ( is_tax( 'property-types' ) || is_tax( 'property-agents' ) || is_post_type_archive( 'properties' ) ) {
			if ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/property-archive/layout-default.php' ) ) {
				include CRAFTO_ADDONS_ROOT . '/templates/property-archive/layout-default.php';
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=archive-property' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage archive in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

if ( ! function_exists( 'crafto_render_archive_tours' ) ) {
	/**
	 * Render tours archive template in theme archive page content area
	 */
	function crafto_render_archive_tours() {

		$tours_destination_template_id = crafto_get_archive_template( 'archive-tours', 'tours-destination' );
		$tours_activity_template_id    = crafto_get_archive_template( 'archive-tours', 'tours-activity' );
		$archive_template_id           = crafto_get_archive_template( 'archive-tours', 'general' );

		if ( is_tax( 'tours-destination' ) && $tours_destination_template_id ) {

			crafto_edit_section_link( $tours_destination_template_id );

			Theme_Builder::get_content_frontend( $tours_destination_template_id );

		} elseif ( is_tax( 'tours-activity' ) && $tours_activity_template_id ) {

			crafto_edit_section_link( $tours_activity_template_id );

			Theme_Builder::get_content_frontend( $tours_activity_template_id );

		} elseif ( $archive_template_id ) {

			crafto_edit_section_link( $archive_template_id );

			Theme_Builder::get_content_frontend( $archive_template_id );

		} elseif ( is_tax( 'tours-destination' ) || is_tax( 'tours-activity' ) || is_post_type_archive( 'properties' ) ) {
			if ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/tours-archive/layout-default.php' ) ) {
				include CRAFTO_ADDONS_ROOT . '/templates/tours-archive/layout-default.php';
			}
		} elseif ( is_admin() ) {
			echo sprintf( // phpcs:ignore
				'<a target="_blank" href="%s">%s </a> %s',
				esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=archive-tours' ),
				esc_html__( 'Click here', 'crafto-addons' ),
				esc_html__( 'to create / manage archive in the theme builder.', 'crafto-addons' )
			);
		} elseif ( file_exists( CRAFTO_ADDONS_ROOT . '/templates/content-none.php' ) ) {
			include CRAFTO_ADDONS_ROOT . '/templates/content-none.php';
		}
	}
}

if ( ! function_exists( 'crafto_get_archive_template' ) ) {
	/**
	 * Return archive template ID
	 *
	 * @param string $template_type Template type.
	 *
	 * @param string $archive_key Archive key ( like categories, tags, author etc.. ).
	 */
	function crafto_get_archive_template( $template_type, $archive_key ) {
		// Prepare the query arguments to search for the template.
		$query_args = [
			'post_type'      => 'themebuilder',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
			// phpcs:ignore
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'   => '_crafto_theme_builder_template',
					'value' => $template_type,
				],
				[
					'key'     => 'crafto_global_meta',
					'value'   => sprintf( ':"%s";', $archive_key ),
					'compare' => 'LIKE',
				],
			],
		];

		$post_ids = get_posts( $query_args );

		return ! empty( $post_ids ) ? $post_ids[0] : false;
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_404_page' ) ) {
	/**
	 * Render 404 page template in theme 404 area
	 */
	function crafto_render_404_page() {
		$crafto_default_template_id = get_theme_mod( 'crafto_page_not_found', '' );
		if ( ! empty( $crafto_default_template_id ) ) {
			Theme_Builder::get_content_frontend( $crafto_default_template_id );
			if ( is_admin() ) {
				echo sprintf( // phpcs:ignore
					'<a target="_blank" href="%s">%s </a> %s',
					esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=404_page' ),
					esc_html__( 'Click here', 'crafto-addons' ),
					esc_html__( 'to create / manage 404 in the theme builder.', 'crafto-addons' )
				);
			} else {
				return;
			}
		}
	}
}


/*===============================================================*/

if ( ! function_exists( 'crafto_render_promo_popup' ) ) {
	/**
	 * Render popup template
	 */
	function crafto_render_promo_popup() {
		// Retrieve theme customizer options.
		$crafto_enable_promo_popup  = get_theme_mod( 'crafto_enable_promo_popup', '0' );
		$crafto_default_template_id = get_theme_mod( 'crafto_promo_popup_section', '' );

		if ( ! empty( $crafto_default_template_id ) ) {
			if ( '1' === $crafto_enable_promo_popup ) {
				Theme_Builder::get_content_frontend( $crafto_default_template_id );
			} elseif ( is_admin() ) {
				echo sprintf( // phpcs:ignore
					'<a target="_blank" href="%s">%s </a> %s',
					esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=promo_popup' ),
					esc_html__( 'Click here', 'crafto-addons' ),
					esc_html__( 'to create / manage popup template in the theme builder.', 'crafto-addons' )
				);
			} else {
				return;
			}
		}
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_render_side_icon' ) ) {
	/**
	 * Render Side Icon template
	 */
	function crafto_render_side_icon() {
		// Retrieve theme customizer options.
		$crafto_enable_side_icon    = get_theme_mod( 'crafto_enable_side_icon', '0' );
		$crafto_default_template_id = get_theme_mod( 'crafto_side_icon_section', '' );

		// If a side icon template is set and it's not empty.
		if ( ! empty( $crafto_default_template_id ) ) {
			// Check if side icon is enabled.
			if ( '1' === $crafto_enable_side_icon ) {
				// Render side icon content if enabled.
				Theme_Builder::get_content_frontend( $crafto_default_template_id );

			} elseif ( is_admin() ) {
				// If in the admin area, provide a link to manage the side icon.
				echo sprintf( // phpcs:ignore
					'<a target="_blank" href="%s">%s </a> %s',
					esc_url( get_admin_url() . 'edit.php?post_type=themebuilder&template_type=side_icon' ),
					esc_html__( 'Click here', 'crafto-addons' ),
					esc_html__( 'to create / manage side icon template in the theme builder.', 'crafto-addons' )
				);
			} else {
				// If not in the admin area and side icon is not enabled, do nothing.
				return;
			}
		}
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_edit_section_link' ) ) {
	/**
	 * @param string $template_id Edit archive section link.
	 */
	function crafto_edit_section_link( $template_id ) {
		if ( current_user_can( 'edit_posts' ) && ! is_customize_preview() && $template_id ) {
			$edit_link = add_query_arg(
				array(
					'post'   => $template_id,
					'action' => 'elementor',
				),
				admin_url( 'post.php' )
			);
			?>
			<a href="<?php echo esc_url( $edit_link ); ?>" target="_blank" data-bs-placement="right" title="<?php echo esc_attr__( 'Edit Archive Template', 'crafto-addons' ); ?>" class="edit-crafto-section edit-archive crafto-tooltip"><span class="screen-reader-text"><?php echo esc_html__( 'Edit Archive Template', 'crafto-addons' ); ?></span></a>
			<?php
		}
	}
}

if ( ! function_exists( 'crafto_edit_single_section_link' ) ) {
	/**
	 * @param string $template_id Edit single post section link.
	 */
	function crafto_edit_single_section_link( $template_id ) {
		if ( current_user_can( 'edit_posts' ) && ! is_customize_preview() && $template_id ) {
			$edit_link = add_query_arg(
				array(
					'post'   => $template_id,
					'action' => 'elementor',
				),
				admin_url( 'post.php' )
			);
			?>
			<a href="<?php echo esc_url( $edit_link ); ?>" target="_blank" data-bs-placement="right" title="<?php echo esc_attr__( 'Edit Single Template', 'crafto-addons' ); ?>" class="edit-crafto-section edit-single crafto-tooltip"><span class="screen-reader-text"><?php echo esc_html__( 'Edit Single Template', 'crafto-addons' ); ?></span></a>
			<?php
		}
	}
}

/*===============================================================*/

if ( ! function_exists( 'crafto_builder_template_exist' ) ) {
	/**
	 * Return the template ID for a specific template type.
	 *
	 * @param string $template_type Template Type.
	 *
	 * @return int|false Template ID if found, false if not found.
	 */
	function crafto_builder_template_exist( $template_type ) {
		// Return early if the template type is empty.
		if ( empty( $template_type ) ) {
			return false;
		}

		// Prepare the query arguments to search for the template.
		$query_args = [
			'post_type'        => 'themebuilder',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'no_found_rows'    => true,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'fields'           => 'ids',
			'suppress_filters' => false,
			// phpcs:ignore
			'meta_query'       => [
				'relation' => 'AND',
				[
					'key'   => '_crafto_theme_builder_template',
					'value' => $template_type,
				],
			],
		];

		$post_ids = get_posts( $query_args );

		return ! empty( $post_ids ) ? $post_ids[0] : false;
	}
}
