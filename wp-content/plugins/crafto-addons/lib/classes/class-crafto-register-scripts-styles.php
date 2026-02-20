<?php
/**
 * Register Styles and Scripts for Widgets
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crafto_Register_Scripts_Styles' ) ) {
	/**
	 * Define enqueue scripts and styles
	 */
	class Crafto_Register_Scripts_Styles {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$crafto_load_css_footer = get_theme_mod( 'crafto_load_css_footer', '0' );
			$crafto_load_css_footer = ( '1' === $crafto_load_css_footer ) ? 'wp_footer' : 'wp_enqueue_scripts';

			add_action( $crafto_load_css_footer, array( $this, 'crafto_widgets_style_register' ) );
			add_action( $crafto_load_css_footer, array( $this, 'crafto_google_map_api_script' ) );

			$crafto_load_jquery_footer = get_theme_mod( 'crafto_load_jquery_footer', '0' );
			$crafto_load_jquery_footer = ( '1' === $crafto_load_jquery_footer ) ? 'wp_footer' : 'wp_enqueue_scripts';
			add_action( $crafto_load_jquery_footer, array( $this, 'crafto_widgets_script_register' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'crafto_deregister_scripts' ) );
			add_action( 'wp_footer', array( $this, 'crafto_low_priority_scripts_register' ) );
		}

		/**
		 * Add hooks to register CSS libraries.
		 */
		public function crafto_widgets_style_register() {
			$flag     = false;
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-addons-vendors.min.css' ) ) {
				$flag = true;
			}

			$widget_flag     = false;
			$widget_rtl_flag = false;
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_WIDGETS_DIR . '/assets/crafto-widgets.min.css' ) ) {
				$widget_flag = true;
			}

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_WIDGETS_DIR . '/assets/crafto-widgets-rtl.min.css' ) && is_rtl() ) {
				$widget_rtl_flag = true;
			}

			if ( crafto_disable_module_by_key( 'swiper' ) ) {
				wp_register_style(
					'swiper',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/swiper-bundle.min.css',
					[],
					'11.2.6',
				);
			}

			if ( ! $flag ) {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					wp_register_style(
						'nav-pagination',
						CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/nav-pagination.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
					);
				}

				if ( crafto_disable_module_by_key( 'anime' ) ) {
					wp_register_style(
						'splitting',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/splitting.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
					);
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					wp_register_style(
						'atropos',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/atropos.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
				}

				if ( crafto_disable_module_by_key( 'justified-gallery' ) ) {
					wp_register_style(
						'justified-gallery',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/justified-gallery.min.css',
						[],
						'3.8.1'
					);
				}

				if ( crafto_disable_module_by_key( 'image-compare-viewer' ) ) {
					wp_register_style(
						'image-compare-viewer',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/image-compare-viewer.min.css',
						[],
						'1.7.0',
					);
				}
			}

			if ( crafto_disable_module_by_key( 'swiper' ) ) {
				wp_register_style(
					'nav-pagination-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/nav-pagination-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
			}

			if ( ! $widget_flag ) {
				wp_register_style(
					'crafto-accordion-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/accordion.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-ai-assistant-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/ai-assistant.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Author Widget.
				wp_register_style(
					'crafto-author-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/author.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Back to Top Widget.
				wp_register_style(
					'crafto-back-to-top-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/back-to-top.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Blog List Widget.
				wp_register_style(
					'crafto-blog-list-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/blog-list.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Blog Slider Widget.
				wp_register_style(
					'crafto-blog-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/blog-slider.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Contact Form Widget.
				wp_register_style(
					'crafto-contact-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/contact-form.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Content Block Widget.
				wp_register_style(
					'crafto-content-box',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/content-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Client Image Carousel Widget.
				wp_register_style(
					'client-image-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/client-image-carousel.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Content Carousel Widget.
				wp_register_style(
					'crafto-content-slider',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/content-carousel.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-countdown-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/countdown-timer.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-counter-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/counter.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				// Brand Logos Widget.
				wp_register_style(
					'crafto-brand-logo',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/brand-logo.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				// Breadcrumb Logos Widget.
				wp_register_style(
					'crafto-breadcrumb-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/breadcrumb.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				// Dynamic Slider Widget.
				wp_register_style(
					'crafto-dynamic-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/dynamic-slider.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-fancy-text-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/fancy-text-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Feature Box Carousel Widget.
				wp_register_style(
					'crafto-feature-box-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/feature-box-carousel.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Feature Widget.
				wp_register_style(
					'crafto-feature-box',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/feature-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Flip Box Widget.
				wp_register_style(
					'crafto-flip-box',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/flip-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-heading-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/heading.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-horizontal-portfolio-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/horizontal-portfolio.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Icon Box Widget.
				wp_register_style(
					'crafto-icon-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/icon-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				// Image Carousel Widget.
				wp_register_style(
					'crafto-image-carousel-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/image-carousel.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-image-gallery-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/image-gallery.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_register_style(
					'crafto-image-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/image.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-instagram-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/instagram.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-interactive-banner',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/interactive-banner.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-interactive-portfolio',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/interactive-portfolio.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// List Widget.
				wp_register_style(
					'crafto-lists',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/lists.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-looping-animation',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/looping-animation.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-lottie-animation',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/lottie.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-marquee-slider',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/marquee-slider.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-media-gallery-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/media-gallery.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-minimal-portfolio',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/minimal-portfolio.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-newsletter',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/newsletter.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-page-title-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/page-title.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-particle-effect-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/particle-effect.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-pie-chart-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/pie-chart.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-popup-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/popup.css',
					[
						'magnific-popup',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-portfolio-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/portfolio-list.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Post Taxonomy Widget.
				wp_register_style(
					'crafto-post-taxonomy-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/post-taxonomy.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Price Table Widget.
				wp_register_style(
					'crafto-price-table',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/price-table.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Process Step Widget.
				wp_register_style(
					'crafto-process-step-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/process-step.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-product-taxonomy-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/product-taxonomy.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_register_style(
					'crafto-product-list-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/product-list.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-progress-bar-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/progress-bar.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Product Slider Widget.
				wp_register_style(
					'crafto-product-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/product-slider.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_register_style(
					'crafto-property-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/property-list.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Property Gallery Carousel Widget.
				wp_register_style(
					'crafto-property-gallery-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/property-gallery-carousel.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Propert Meta Widget.
				wp_register_style(
					'crafto-property-meta-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/property-meta.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/slider.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-sliding-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/sliding-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Social Icons Widget.
				wp_register_style(
					'crafto-social-icons',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/social-icons.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Social Share Widget.
				wp_register_style(
					'crafto-social-share',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/social-share.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-stack-section',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/stack-section.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Star Rating Widget.
				wp_register_style(
					'crafto-star-rating',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/star-rating.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Table Widget.
				wp_register_style(
					'crafto-table-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/table.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Tabs Widget.
				wp_register_style(
					'crafto-tabs-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/tabs.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Team Member Widget.
				wp_register_style(
					'crafto-team-member-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/team-member.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Testimonial Carousel Widget.
				wp_register_style(
					'crafto-testimonial-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/testimonial-carousel.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Testimonial Widget.
				wp_register_style(
					'crafto-testimonial-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/testimonial.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Text Slider Widget.
				wp_register_style(
					'crafto-text-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/text-slider.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				// Three D Parallax Hover Widget.
				wp_register_style(
					'crafto-3d-parallax-hover-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/three-d-parallax-hover.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-tilt-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/tilt-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Timeline Widget.
				wp_register_style(
					'crafto-timeline-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/timeline.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-tours-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/tour.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Tour Header Bar Widget.
				wp_register_style(
					'crafto-tour-header',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/tour-header.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				// Tour Meta Details Widget.
				wp_register_style(
					'crafto-tour-meta',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/tour-meta.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-vertical-portfolio-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/vertical-portfolio.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_register_style(
					'crafto-video-button',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/video-button.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-video-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/video.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_register_style(
					'crafto-images-comparison',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/images-comparison.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
			}

			if ( ! $widget_rtl_flag ) {
				wp_register_style(
					'crafto-accordion-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/accordion-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-ai-assistant-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/ai-assistant-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-blog-list-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/blog-list-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-blog-slider-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/blog-slider-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-contact-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/contact-form-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-content-box-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/content-box-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-content-slider-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/content-carousel-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-countdown-widget-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/countdown-timer-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-counter-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/counter-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-brand-logo-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/brand-logo-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-dynamic-slider-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/dynamic-slider-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-fancy-text-box-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/fancy-text-box-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-feature-box-carousel-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/feature-box-carousel-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-feature-box-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/feature-box-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-heading-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/heading-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-horizontal-portfolio-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/horizontal-portfolio-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-icon-box-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/icon-box-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-image-carousel-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/image-carousel-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-interactive-banner-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/interactive-banner-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-lists-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/lists-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-marquee-slider-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/marquee-slider-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-minimal-portfolio-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/minimal-portfolio-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-newsletter-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/newsletter-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-page-title-widget-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/page-title-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-portfolio-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/portfolio-list-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-post-taxonomy-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/post-taxonomy-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-process-step-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/process-step-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-product-taxonomy-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/product-taxonomy-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-product-list-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/product-list-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-progress-bar-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/progress-bar-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-product-slider-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/product-slider-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-property-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/property-list-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-slider-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/slider-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-sliding-box-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/sliding-box-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-social-icons-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/social-icons-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-social-share-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/social-share-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-star-rating-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/star-rating-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-table-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/table-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-tabs-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/tabs-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-team-member-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/team-member-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-testimonial-carousel-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/testimonial-carousel-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-testimonial-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/testimonial-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-text-slider-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/text-slider-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-tour-rtl-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/tour-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-tour-header-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/tour-header-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-tour-meta-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/tour-meta-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-vertical-portfolio-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/vertical-portfolio-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_style(
					'crafto-video-button-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/video-button-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-images-comparison-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/rtl-css/images-comparison-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
			}

			// All combined css of widgets which is load in editor.
			if ( $widget_flag ) {
				wp_register_style(
					'crafto-widgets',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/crafto-widgets.min.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
			}

			// All combined rtl css of widgets which is load in editor.
			if ( $widget_rtl_flag ) {
				wp_register_style(
					'crafto-widgets-rtl',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/crafto-widgets-rtl.min.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
			}
		}

		/**
		 * Add hooks to register Javascripts libraries.
		 */
		public function crafto_widgets_script_register() {
			if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
				wp_register_script(
					'imagesloaded',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/imagesloaded.pkgd.min.js',
					[],
					'4.1.4',
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/imagesloaded.pkgd.min.js' ),
				);
			}

			$flag = false;
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_JS_DIR . '/vendors/crafto-addons-vendors.min.js' ) ) {
				$flag = true;
			}

			$widget_flag = false;
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_WIDGETS_DIR . '/assets/crafto-widgets.min.js' ) ) {
				$widget_flag = true;
			}

			if ( ! $flag ) {
				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					wp_register_script(
						'isotope',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/isotope.pkgd.min.js',
						[],
						'3.0.6',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/isotope.pkgd.min.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'appear' ) ) {
					wp_register_script(
						'appear',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.appear.js',
						[],
						'0.6.2',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.appear.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
					wp_register_script(
						'infinite-scroll',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/infinite-scroll.pkgd.min.js',
						[],
						'4.0.1',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/infinite-scroll.pkgd.min.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'fitvids' ) ) {
					wp_register_script(
						'jquery.fitvids',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.fitvids.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.fitvids.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'custom-parallax' ) ) {
					wp_register_script(
						'custom-parallax',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/custom-parallax.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/custom-parallax.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'jquery-countdown' ) ) {
					wp_register_script(
						'jquery-countdown',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.countdown.min.js',
						[],
						'2.2.0',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.countdown.min.js' ),
					);
				}

				$crafto_optimize_bootstrap = get_theme_mod( 'crafto_optimize_bootstrap', '0' );
				if ( '1' === $crafto_optimize_bootstrap ) {
					wp_register_script(
						'bootstrap-tab',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/bootstrap-tab.bundle.min.js',
						[],
						'5.3.3',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/bootstrap-tab.bundle.min.js' )
					);
				}

				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					wp_register_script(
						'swiper',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/swiper-bundle.min.js',
						[],
						'11.2.6',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/swiper-bundle.min.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					wp_register_script(
						'atropos',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/atropos.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/atropos.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'justified-gallery' ) ) {
					wp_register_script(
						'justified-gallery',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/justified-gallery.min.js',
						[],
						'3.8.1',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/justified-gallery.min.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'image-compare-viewer' ) ) {
					wp_register_script(
						'image-compare-viewer',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/image-compare-viewer.min.js',
						[],
						'1.7.0',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/image-compare-viewer.min.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'lottie' ) ) {
					wp_register_script(
						'lottie',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/lottie.min.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/lottie.min.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'particles' ) ) {
					wp_register_script(
						'particles',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/particles.js',
						[],
						'2.0.0',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/particles.js' ),
					);
				}

				if ( crafto_disable_module_by_key( 'sticky-kit' ) ) {
					wp_register_script(
						'sticky-kit',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.sticky-kit.min.js',
						[],
						'1.1.3',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.sticky-kit.min.js' ),
					);
				}

				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					wp_register_script(
						'anime',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/anime.min.js',
						[],
						'3.2.2',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/anime.min.js' ),
					);

					wp_register_script(
						'splitting',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/splitting.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/splitting.js' ),
					);

					if ( ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
						wp_register_script(
							'animation',
							CRAFTO_ADDONS_VENDORS_JS_URI . '/animation.js',
							[
								'anime',
							],
							CRAFTO_ADDONS_PLUGIN_VERSION,
							crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/animation.js' )
						);

					} elseif ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
						wp_register_script(
							'animation',
							CRAFTO_ADDONS_VENDORS_JS_URI . '/editor-animation.js',
							[
								'anime',
							],
							CRAFTO_ADDONS_PLUGIN_VERSION,
							crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/editor-animation.js' ),
						);
					}

					wp_register_script(
						'crafto-fancy-text-effect',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/fancy-text-effect.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/fancy-text-effect.js' ),
					);

					if ( crafto_disable_module_by_key( 'parallax-liquid' ) ) {
						wp_register_script(
							'parallax-liquid',
							CRAFTO_ADDONS_VENDORS_JS_URI . '/parallaxLiquid.js',
							[],
							CRAFTO_ADDONS_PLUGIN_VERSION,
							crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/parallaxLiquid.js' ),
						);
					}
				}
			}

			// All combined js of vendors which is load in only editor.
			if ( $flag ) {
				wp_register_script(
					'crafto-addons-vendors',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/crafto-addons-vendors.min.js',
					[ 'elementor-frontend' ],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/crafto-addons-vendors.min.js' ),
				);
				wp_enqueue_script( 'crafto-addons-vendors' );

				$localized_data = [
					'i18n' => [
						'templatesEmptyTitle'       => esc_html__( 'No Templates Found', 'crafto-addons' ),
						'templatesEmptyMessage'     => esc_html__( 'Try different category or sync for new templates.', 'crafto-addons' ),
						'templatesNoResultsTitle'   => esc_html__( 'No Results Found', 'crafto-addons' ),
						'templatesNoResultsMessage' => esc_html__( 'Please make sure your search is spelled correctly or try a different word.', 'crafto-addons' ),
					],
					'icon' => CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/crafto-addons.svg',
				];

				wp_localize_script(
					'crafto-addons-vendors',
					'ExclusiveAddonsEditor',
					$localized_data
				);

				wp_localize_script(
					'crafto-addons-vendors',
					'craftoMagicCursor',
					[
						'enableImage'      => get_theme_mod( 'crafto_enable_image', '0' ),
						'magicCursorImage' => get_theme_mod( 'crafto_magic_cursor_image', '' ),
						'cursorStyle'      => get_theme_mod( 'crafto_magic_cursor_style', '' ),
					]
				);
			}

			if ( ! $widget_flag ) {
				wp_register_script(
					'crafto-default-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/default-carousel.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/default-carousel.js' ),
				);

				// Accordion Widget.
				wp_register_script(
					'crafto-accordion-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/accordion.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/accordion.js' ),
				);

				// AI Assistant.
				wp_register_script(
					'crafto-ai-assistant-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/ai-assistant.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/ai-assistant.js' ),
				);

				// Back to Top Widget.
				wp_register_script(
					'crafto-back-to-top-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/back-to-top.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/back-to-top.js' ),
				);

				// Blog List / Blog Archive Widget.
				wp_register_script(
					'crafto-blog-list-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/blog-list.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/blog-list.js' ),
				);

				// Countdown Timer Widget.
				wp_register_script(
					'crafto-countdown-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/countdown-timer.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/countdown-timer.js' ),
				);

				// Counter Widget.
				wp_register_script(
					'crafto-counter-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/counter.js',
					[ 'wp-util' ],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/counter.js' ),
				);

				// Fancy Text Box Widget.
				wp_register_script(
					'crafto-fancy-text-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/fancy-text-box.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/fancy-text-box.js' ),
				);

				// Hamburger Menu Widget.
				wp_register_script(
					'crafto-hamburger-menu-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/hamburger-menu.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/hamburger-menu.js' ),
				);

				// Heading Widget.
				wp_register_script(
					'crafto-heading-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/heading.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/heading.js' ),
				);

				// Horizontal Portfolio Widget.
				wp_register_script(
					'crafto-horizontal-portfolio-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/horizontal-portfolio.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/horizontal-portfolio.js' ),
				);

				// Image Gallery Widget.
				wp_register_script(
					'crafto-image-gallery-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/image-gallery.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/image-gallery.js' ),
				);

				// Instagram Widget.
				wp_register_script(
					'crafto-instagram-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/instagram.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/instagram.js' ),
				);

				// Interactive Banner Widget.
				wp_register_script(
					'crafto-interactive-banner',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/interactive-banner.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/interactive-banner.js' ),
				);

				// Interactive Portfolio Widget.
				wp_register_script(
					'crafto-interactive-portfolio',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/interactive-portfolio.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/interactive-portfolio.js' ),
				);

				// Left Menu Widget.
				wp_register_script(
					'crafto-left-menu',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/left-menu.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/left-menu.js' ),
				);

				// Looping Animation.
				if ( crafto_disable_module_by_key( 'anime' ) ) {
					wp_register_script(
						'crafto-looping-animation',
						CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/looping-animation.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/looping-animation.js' ),
					);
				}

				wp_register_script(
					'crafto-lottie-animation',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/lottie.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/lottie.js' ),
				);

				// Map Location Widget.
				wp_register_script(
					'crafto-map-location',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/map-location.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/map-location.js' ),
				);

				// Marquee Slider Widget.
				wp_register_script(
					'crafto-marquee-slider',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/marquee-slider.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/marquee-slider.js' ),
				);

				// Media Gallery Widget.
				wp_register_script(
					'crafto-media-gallery-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/media-gallery.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/media-gallery.js' ),
				);

				// Minimal Portfolio Widget.
				wp_register_script(
					'crafto-minimal-portfolio',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/minimal-portfolio.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/minimal-portfolio.js' ),
				);

				// Newsletter Widget.
				wp_register_script(
					'crafto-newsletter',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/newsletter.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/newsletter.js' ),
				);

				// Page Title Widget.
				wp_register_script(
					'crafto-page-title-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/page-title.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/page-title.js' ),
				);

				wp_register_script(
					'crafto-particle-effect-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/particle-effect.js',
					[
						'particles',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/particle-effect.js' ),
				);

				// Pie Chart Widget.
				wp_register_script(
					'crafto-pie-chart-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/pie-chart.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/pie-chart.js' ),
				);
				// Popup Widget.
				wp_register_script(
					'crafto-popup-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/popup.js',
					[
						'magnific-popup',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/popup.js' ),
				);

				wp_register_script(
					'crafto-lightbox-gallery',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/lightbox-gallery.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/lightbox-gallery.js' ),
				);

				// Portfolio List / Archive Widget.
				wp_register_script(
					'crafto-portfolio-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/portfolio-list.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/portfolio-list.js' ),
				);

				// Portfolio Slider Widget.
				wp_register_script(
					'crafto-portfolio-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/portfolio-slider.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/portfolio-slider.js' ),
				);

				// Primary Menu Widget.
				wp_register_script(
					'crafto-mega-menu-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/primary-menu.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/primary-menu.js' ),
				);

				// Product Categories Widget.
				wp_register_script(
					'crafto-product-taxonomy-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/product-taxonomy.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/product-taxonomy.js' ),
				);

				// Product List Widget.
				wp_register_script(
					'crafto-product-list-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/product-list.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/product-list.js' ),
				);

				// Progress Bar Widget.
				wp_register_script(
					'crafto-progress-bar-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/progress-bar.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/progress-bar.js' ),
				);

				// Property List / Archive Widget.
				wp_register_script(
					'crafto-property-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/property-list.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/property-list.js' ),
				);

				// Search Form Widget.
				wp_register_script(
					'crafto-search-form-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/search-form.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/search-form.js' ),
				);
			
				// Simple Menu / Custom Menu Wiget.
				wp_register_script(
					'crafto-simple-menu-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/simple-menu.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/simple-menu.js' ),
				);
			

				// Single Post layout widget.
				wp_register_script(
					'crafto-single-post-layout',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/post-layout.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/post-layout.js' ),
				);

				// Slider Widget.
				wp_register_script(
					'crafto-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/slider.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/slider.js' ),
				);

				// Sliding Box Widget.
				wp_register_script(
					'crafto-sliding-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/sliding-box.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/sliding-box.js' ),
				);

				// Stack Section Widget.
				wp_register_script(
					'crafto-stack-section',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/stack-section.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/stack-section.js' ),
				);
				// Tab Widget.
				wp_register_script(
					'crafto-tabs-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/tabs.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/tabs.js' ),
				);

				// Team Member Widget.
				wp_register_script(
					'crafto-team-member-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/team-member.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/team-member.js' ),
				);

				// Testimonial Carousel Widget.
				wp_register_script(
					'crafto-testimonial-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/testimonial-carousel.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/testimonial-carousel.js' ),
				);

				// Text Editor Widget.
				wp_register_script(
					'crafto-text-editor',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/text-editor.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/text-editor.js' ),
				);

				// Text Rotator Widget.
				wp_register_script(
					'crafto-text-rotator',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/text-rotator.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/text-rotator.js' ),
				);

				// Text Slider Widget.
				wp_register_script(
					'crafto-text-slider-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/text-slider.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/text-slider.js' ),
				);

				// Tilt Box Widget.
				wp_register_script(
					'crafto-tilt-box-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/tilt-box.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/tilt-box.js' ),
				);

				// Image Widget.
				wp_register_script(
					'crafto-image-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/image.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/image.js' ),
				);

				// Tour List / Archive Widget.
				wp_register_script(
					'crafto-tour-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/tour.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/tour.js' ),
				);

				// Vertical Portfolio Widget.
				wp_register_script(
					'crafto-vertical-portfolio-carousel',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/vertical-portfolio-carousel.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/vertical-portfolio-carousel.js' ),
				);

				// Video Button Widget.
				wp_register_script(
					'crafto-video-button-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/video-button.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/video-button.js' ),
				);

				// Video Widget.
				wp_register_script(
					'crafto-video-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/video.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/video.js' ),
				);

				// Images Comparison Widget.
				wp_register_script(
					'crafto-images-comparison',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/images-comparison.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/images-comparison.js' ),
				);
			}

			// All combined JS of widgets which is load only in editor.
			if ( $widget_flag ) {
				wp_register_script(
					'crafto-widgets',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/crafto-widgets.min.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/crafto-widgets.min.js' )
				);

				wp_localize_script(
					'crafto-widgets',
					'localizedData',
					array(
						'geocodeError'      => esc_html__( 'Geocode was not successful for the following reason:', 'crafto-addons' ),
						'google_maps_error' => esc_html__( 'Google Maps failed to load. Please check your connection.', 'crafto-addons' ),
					)
				);
			}
		}

		/**
		 * Add hooks to register style & scripts.
		 */
		public function crafto_google_map_api_script() {
			$prefix = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_JS_DIR . '/vendors/mapstyles.min.js' ) ? '.min' : '';

			if ( crafto_disable_module_by_key( 'google-map' ) ) {
				// Google Map Widget.
				wp_register_script(
					'crafto-mapstyles',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/mapstyles' . $prefix . '.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/mapstyles' . $prefix . '.js' ),
				);

				wp_register_script(
					'crafto-google-maps-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/google-maps.js',
					[
						'crafto-mapstyles',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_WIDGETS_URI . '/assets/js/google-maps.js' ),
				);

				wp_localize_script(
					'crafto-google-maps-widget',
					'localizedData',
					array(
						'geocodeError'      => esc_html__( 'Geocode was not successful for the following reason:', 'crafto-addons' ),
						'google_maps_error' => esc_html__( 'Google Maps failed to load. Please check your connection.', 'crafto-addons' ),
					)
				);

				wp_register_style(
					'crafto-google-maps-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/google-maps.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				$api_key = esc_html( get_option( 'elementor_google_maps_api_key' ) );
				$api_key = ! empty( $api_key ) ? $api_key : '1234567890';

				if ( ! empty( $api_key ) ) {
					// phpcs:ignore
					wp_register_script(
						'crafto-googleapis',
						'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=marker',
						[
							'crafto-google-maps-widget',
						],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
				}
			}
		}

		/**
		 * Add hooks to deregister and dequeue style.
		 */
		public function crafto_deregister_scripts() {
			// Remove Give Style.
			if ( class_exists( 'Give' ) ) {
				wp_dequeue_style( 'give-styles' );
			}
		}

		/**
		 * Add hooks to give style.
		 */
		public function crafto_low_priority_scripts_register() {
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
			
			if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) && crafto_disable_module_by_key( 'magic-cursor' ) ) {
				wp_register_style(
					'crafto-magic-cursor',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/magic-cursor.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);

				wp_register_script(
					'crafto-magic-cursor',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/magic-cursor.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/magic-cursor.js' ),
				);

				$enable_image       = get_theme_mod( 'crafto_enable_image', '0' );
				$magic_cursor_image = get_theme_mod( 'crafto_magic_cursor_image', '' );
				$cursor_style       = get_theme_mod( 'crafto_magic_cursor_style', '' );

				/**
				 * Only localize if image toggle is on.
				 */
				wp_localize_script(
					'crafto-magic-cursor',
					'craftoMagicCursor',
					[
						'enableImage'      => $enable_image,
						'magicCursorImage' => esc_url( $magic_cursor_image ),
						'cursorStyle'      => esc_html( $cursor_style ),
					]
				);
			}

			if ( class_exists( 'Give' ) ) {
				wp_enqueue_style( 'give-styles' );
			}
		}
	}

	new Crafto_Register_Scripts_Styles();
}
