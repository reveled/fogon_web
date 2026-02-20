<?php
/**
 * Custom Theme Fonts
 *
 * @package Crafto
 */

namespace craftoAddons\Custom_fonts;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

// If class `Custom_Theme_Fonts` doesn't exists yet.
if ( ! class_exists( 'Custom_Theme_Fonts' ) ) {

	/**
	 * Define 'Custom_Theme_Fonts' class
	 */
	class Custom_Theme_Fonts {

		const ADOBE_TYPEKIT_EMBED = 'https://use.typekit.net/%s.css';

		/**
		 * Constructor
		 */
		public function __construct() {
			// Add custom font group.
			add_filter( 'elementor/fonts/groups', [ $this, 'crafto_add_fonts_groups' ] );
			add_filter( 'elementor/fonts/additional_fonts', [ $this, 'crafto_add_additional_fonts' ] );

			// Enqueue adobe fonts.
			add_action( 'wp_enqueue_scripts', [ $this, 'crafto_adobe_font_css' ] );

			// Render custom font CSS.
			add_action( 'wp_head', [ $this, 'crafto_custom_enqueue_fonts_css' ] );

			// Render custom font Preview with Editor.
			add_action( 'elementor/ajax/register_actions', [ $this, 'crafto_register_ajax_actions' ] );
		}

		/**
		 * Adds font groups to the provided collection.
		 *
		 * @param array $font_groups An associative array of font groups to be added.
		 */
		public function crafto_add_fonts_groups( $font_groups ) {

			$crafto_custom_fonts   = '';
			$crafto_get_fonts_list = $this->crafto_get_custom_fonts();
			$crafto_adobe_font     = apply_filters( 'crafto_adobe_font', array() );

			if ( ! empty( $crafto_get_fonts_list ) ) {
				$crafto_custom_fonts = array(
					'custom' => esc_html__( 'Crafto Theme Fonts', 'crafto-addons' ),
				);

				$font_groups = array_merge( $crafto_custom_fonts, $font_groups );
			}

			if ( ! empty( $crafto_adobe_font ) ) {
				$crafto_adobe_fonts = array(
					'adobe' => esc_html__( 'Crafto Adobe Fonts', 'crafto-addons' ),
				);

				$font_groups = array_merge( $crafto_adobe_fonts, $font_groups );
			}

			return $font_groups;
		}

		/**
		 * Adds additional fonts to the existing collection.
		 *
		 * @param array $additional_fonts An associative array of additional fonts to be added.
		 */
		public function crafto_add_additional_fonts( $additional_fonts ) {

			$crafto_get_fonts_list = $this->crafto_get_custom_fonts();

			if ( is_array( $crafto_get_fonts_list ) && ! empty( $crafto_get_fonts_list ) ) {
				foreach ( $crafto_get_fonts_list as $key => $val ) {
					if ( ! empty( $val[0] ) ) {
						$additional_fonts[ $val[0] ] = 'custom';
					}
				}
			}

			$crafto_adobe_font = apply_filters( 'crafto_adobe_font', array() );

			if ( ! empty( $crafto_adobe_font ) ) {
				foreach ( $crafto_adobe_font as $adobe_font_family => $adobe_fonts_url ) {
					$font_slug = ( isset( $adobe_fonts_url['slug'] ) ) ? $adobe_fonts_url['slug'] : '';
					$font_css  = ( isset( $adobe_fonts_url['css_names'][0] ) ) ? $adobe_fonts_url['css_names'][0] : $font_slug;

					$additional_fonts[ $font_css ] = 'adobe';
				}
			}

			// Load Latest Google Fonts if not exist in elementor lists.
			$additional_fonts['Schibsted Grotesk'] = 'googlefonts';

			return $additional_fonts;
		}

		/**
		 * Enqueues fonts for use in the specified post or context.
		 */
		public function crafto_custom_enqueue_fonts_css() {
			$crafto_custom_css     = '';
			$crafto_get_fonts_list = $this->crafto_get_custom_fonts();
			if ( is_array( $crafto_get_fonts_list ) && ! empty( $crafto_get_fonts_list ) ) {
				foreach ( $crafto_get_fonts_list as $key => $fonts ) {
					ob_start();
					if ( ! empty( $fonts[0] ) ) {
						$fonts_count = count( $fonts );
						for ( $i = 1; $i <= $fonts_count; $i += 5 ) {
							$sources = [];
							if ( ! empty( $fonts[ $i ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i ] ) . "' ) format('woff2')";
							}
							if ( ! empty( $fonts[ $i + 1 ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i + 1 ] ) . "' ) format('woff')";
							}
							if ( ! empty( $fonts[ $i + 2 ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i + 2 ] ) . "' ) format('truetype')";
							}
							if ( ! empty( $fonts[ $i + 3 ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i + 3 ] ) . "' ) format('embedded-opentype')";
							}
							if ( ! empty( $sources ) ) {
								echo '@font-face {';
								echo 'font-family: "' . esc_attr( $fonts[0] ) . '";';
								echo 'src: ' . implode( ', ', $sources ) . ';'; // phpcs:ignore
								if ( ! empty( $fonts[ $i + 4 ] ) ) {
									echo 'font-weight: ' . esc_attr( $fonts[ $i + 4 ] ) . '; ';
								}
								echo 'font-style: normal;';
								echo 'font-display: swap;';
								echo '}';
							}
						}
					}

					$crafto_custom_css .= ob_get_contents();
					ob_end_clean();
				}
			}

			if ( ! empty( $crafto_custom_css ) ) {
				echo '<style type="text/css" id="crafto-theme-custom-fonts-css">' . sprintf( '%s', $crafto_custom_css ) . '</style>'; // phpcs:ignore
			}
		}

		/**
		 * Generates CSS for Adobe fonts.
		 */
		public function crafto_adobe_font_css() {

			$crafto_adobe_id = get_option( 'crafto_adobe_font_id' );

			if ( empty( $crafto_adobe_id ) ) {
				return false;
			}

			$adobe_url = sprintf( self::ADOBE_TYPEKIT_EMBED, $crafto_adobe_id );

			wp_enqueue_style(
				'crafto-adobe-font',
				$adobe_url,
				[],
				CRAFTO_ADDONS_PLUGIN_VERSION
			);
		}

		/**
		 * Custom fonts.
		 */
		public function crafto_get_custom_fonts() {
			$crafto_theme_custom_fonts = get_theme_mod( 'crafto_custom_fonts', '' );
			$crafto_theme_custom_fonts = ! empty( $crafto_theme_custom_fonts ) ? json_decode( $crafto_theme_custom_fonts ) : [];
			return $crafto_theme_custom_fonts;
		}

		/**
		 * Registers AJAX actions using the provided AJAX handler.
		 *
		 * @param Ajax $ajax An instance of the `Ajax` class used to manage and register AJAX actions.
		 */
		public function crafto_register_ajax_actions( Ajax $ajax ) {

			$ajax->register_ajax_action( 'crafto_custom_fonts_action_data', [ $this, 'crafto_fonts_preview' ] );
		}

		/**
		 * Fonts Preview.
		 */
		public function crafto_fonts_preview() {
			$crafto_custom_css     = '';
			$crafto_get_fonts_list = $this->crafto_get_custom_fonts();
			if ( is_array( $crafto_get_fonts_list ) && ! empty( $crafto_get_fonts_list ) ) {
				ob_start();
				foreach ( $crafto_get_fonts_list as $key => $fonts ) {
					if ( ! empty( $fonts[0] ) ) {
						$fonts_count = count( $fonts );
						for ( $i = 1; $i <= $fonts_count; $i += 5 ) {
							$sources = [];
							if ( ! empty( $fonts[ $i ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i ] ) . "' ) format('woff2')";
							}
							if ( ! empty( $fonts[ $i + 1 ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i + 1 ] ) . "' ) format('woff')";
							}
							if ( ! empty( $fonts[ $i + 2 ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i + 2 ] ) . "' ) format('truetype')";
							}
							if ( ! empty( $fonts[ $i + 3 ] ) ) {
								$sources[] = "url( '" . esc_url( $fonts[ $i + 3 ] ) . "' ) format('embedded-opentype')";
							}
							if ( ! empty( $sources ) ) {
								echo '@font-face {';
								echo 'font-family: "' . esc_attr( $fonts[0] ) . '";';
								echo 'src: ' . implode( ', ', $sources ) . ';'; // phpcs:ignore
								if ( ! empty( $fonts[ $i + 4 ] ) ) {
									echo 'font-weight: ' . esc_attr( $fonts[ $i + 4 ] ) . '; ';
								}
								echo 'font-style: normal;';
								echo 'font-display: swap;';
								echo '}';
							}
						}
					}
				}

				$crafto_custom_css .= ob_get_contents();
				ob_end_clean();
				return [
					'font_face' => $crafto_custom_css,
				];
			}
		}
	}
}
