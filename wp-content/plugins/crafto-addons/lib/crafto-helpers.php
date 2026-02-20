<?php
/**
 * Crafto Helper
 *
 * Contains all the helping functions
 *
 * @package Crafto
 */

if ( ! function_exists( 'is_crafto_theme_activated' ) ) {
	/**
	 * Check crafto theme activated or not.
	 */
	function is_crafto_theme_activated() {
		$theme = wp_get_theme(); // gets the current theme.
		if ( 'Crafto' === $theme->name || 'Crafto' === $theme->parent_theme ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'is_crafto_addons_activated' ) ) {
	/**
	 * Check Crafto Addons activated or not.
	 */
	function is_crafto_addons_activated() {
		return class_exists( 'Crafto_Addons' ) ? true : false;
	}
}

if ( ! function_exists( 'is_elementor_activated' ) ) {
	/**
	 * Check Elementor activated or not.
	 */
	function is_elementor_activated() {
		return defined( 'ELEMENTOR_VERSION' ) ? true : false;
	}
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	/**
	 * Check WooCommerce activated or not.
	 */
	function is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

if ( ! function_exists( 'is_contact_form_7_activated' ) ) {
	/**
	 * Check Contact Form 7 activated or not.
	 */
	function is_contact_form_7_activated() {
		return class_exists( 'WPCF7' ) ? true : false;
	}
}

if ( ! function_exists( 'is_revolution_slider_activated' ) ) {
	/**
	 * Check revolution slider activated or not.
	 */
	function is_revolution_slider_activated() {
		return class_exists( 'UniteFunctionsRev' ) ? true : false;
	}
}

if ( ! function_exists( 'crafto_remove_wpautop' ) ) {
	/**
	 * Remove <p> tags and apply wpautop if needed.
	 *
	 * @param string $content The content to process.
	 * @param bool   $force_br Whether to force <br> tags instead of <p> tags.
	 * @return string Processed content.
	 */
	function crafto_remove_wpautop( $content, $force_br = true ) {
		// If forcing <br> tags, replace <p> tags with new lines and reapply wpautop.
		if ( $force_br ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}

		// Return content with shortcodes processed and <p> tags removed.
		return do_shortcode( shortcode_unautop( $content ) );
	}
}

if ( ! function_exists( 'crafto_get_attachment_html' ) ) {
	/**
	 * Generate HTML for an attachment image.
	 *
	 * @param mixed $attachment_id Attachment ID.
	 * @param mixed $attachment_url Attachment URL.
	 * @param mixed $attachment_size Attachment size.
	 * @param mixed $fetch_priority Fetch Priority.
	 * @param mixed $lazy_loading Lazy loading.
	 */
	function crafto_get_attachment_html( $attachment_id, $attachment_url, $attachment_size, $fetch_priority = '', $lazy_loading = '' ) {
		$crafto_image = '';
		// If attachment ID and URL are provided.
		if ( ! empty( $attachment_id ) && '' !== $attachment_url ) {
			$thumbnail_id = $attachment_id;

			// Get image data (alt, title, and sizes).
			$crafto_img_alt     = crafto_option_image_alt( $thumbnail_id );
			$crafto_img_title   = crafto_option_image_title( $thumbnail_id );
			$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
			$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

			$default_attr     = array(
				'class' => 'swiper-slide-image',
				'alt'   => esc_attr( $crafto_image_alt ),
				'title' => esc_attr( $crafto_image_title ),
			);

			if ( 'none' !== $fetch_priority ) {
				$default_attr['fetchpriority'] = $fetch_priority;
			}

			if ( 'yes' === $lazy_loading ) {
				$default_attr['loading'] = 'lazy';
			}

			$crafto_image = wp_get_attachment_image( $thumbnail_id, $attachment_size, false, $default_attr );
		} elseif ( ! empty( $attachment_url ) ) {
			// Placeholder image if URL is available but no attachment ID.
			$crafto_image = sprintf(
				'<img src="%1$s" alt="%2$s" />',
				esc_url( $attachment_url ),
				esc_attr__( 'Placeholder Image', 'crafto-addons' )
			);
		}

		// Output the image HTML.
		echo sprintf( '%s', $crafto_image ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_single_product_share_shortcode' ) ) {
	/**
	 * Product Share Shortcode.
	 */
	function crafto_single_product_share_shortcode() {
		global $post;

		if ( ! is_woocommerce_activated() ) {
			return false;
		}

		if ( ! $post ) {
			return false;
		}

		$default_social_sharing = array(
			'facebook',
			'1',
			'Facebook',
			'twitter',
			'1',
			'Twitter',
			'linkedin',
			'1',
			'Linkedin',
			'pinterest',
			'1',
			'Pinterest',
		);

		$crafto_enable_social_share = crafto_option( 'crafto_single_product_enable_social_share', '1' );
		$crafto_social_share        = crafto_option( 'crafto_single_product_social_sharing', $default_social_sharing );

		$permalink      = (string) get_permalink( $post->ID );
		$permalink      = is_string( $permalink ) ? $permalink : '';
		$featuredimage  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$featured_image = ( ! empty( $featuredimage[0] ) ) ? $featuredimage[0] : '';
		$product_title  = rawurlencode( get_the_title( $post->ID ) );

		ob_start();
		if ( '1' === $crafto_enable_social_share && ! empty( $crafto_social_share ) ) {
			?>
			<div class="product-social-icon">
				<div class="shop-icon-wrap" data-tooltip-position='top'>
						<?php
						$crafto_copy_title     = apply_filters( 'crafto_sharebox_copy_title', esc_html__( 'Copy link', 'crafto-addons' ) );
						$crafto_clipboard_text = apply_filters( 'crafto_sharebox_copy_clipboard_text', esc_html__( 'Copy to clipboard', 'crafto-addons' ) );
						?>
						<label class="screen-reader-text" for="copyinput">Copy link</label>
						<span class="crafto-product-share-box-title alt-font"><?php echo esc_html( $crafto_copy_title ); ?></span>
						<input id="copyinput" type="text" value="<?php echo esc_url( $permalink ); ?>">
						<span class="copy-code">
							<i class="bi bi-files" data-bs-original-title="<?php echo esc_attr( $crafto_clipboard_text ); ?>"></i>
						</span>
					</div>
				<div class="social-icons-wrapper">
					<ul>
						<?php
						$i     = 0;
						$count = count( $crafto_social_share );
						foreach ( $crafto_social_share as $key => $value ) {
							if ( $i < $count ) {
								if ( '1' === $crafto_social_share[ $i + 1 ] ) {
									switch ( $crafto_social_share[ $i ] ) {
										case 'facebook':
											?>
											<li><a class="social-sharing-icon facebook-f" href="//www.facebook.com/sharer.php?u=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $product_title ); ?>"><i class="fa-brands fa-facebook-f"></i><span></span></a></li>
											<?php
											break;
										case 'twitter':
											?>
											<li><a class="social-sharing-icon x-twitter" href="//twitter.com/share?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $product_title ); ?>"><i class="fa-brands fa-x-twitter"></i><span></span></a></li>
											<?php
											break;
										case 'linkedin':
											?>
											<li><a class="social-sharing-icon linkedin-in" href="//linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $product_title ); ?>" target="_blank" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" rel="nofollow" title="<?php echo esc_attr( $product_title ); ?>"><i class="fa-brands fa-linkedin-in"></i><span></span></a></li>
											<?php
											break;
										case 'pinterest':
											?>
											<li><a class="social-sharing-icon pinterest-p" href="//pinterest.com/pin/create/button/?url=<?php echo esc_url( $permalink ); ?>&amp;media=<?php echo esc_url( $featured_image ); ?>&amp;description=<?php echo esc_attr( $product_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $product_title ); ?>"><i class="fa-brands fa-pinterest-p"></i><span></span></a></li>
											<?php
											break;
										case 'reddit':
											?>
											<li><a class="social-sharing-icon reddit" href="//reddit.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $product_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-reddit"></i><span></span></a></li>
											<?php
											break;
										case 'stumbleupon':
											?>
											<li><a class="social-sharing-icon stumbleupon" href="http://www.stumbleupon.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $product_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-stumbleupon"></i><span></span></a></li>
											<?php
											break;
										case 'digg':
											?>
											<li><a class="social-sharing-icon digg" href="//www.digg.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $product_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-digg"></i><span></span></a></li>
											<?php
											break;
										case 'vk':
											?>
											<li><a class="social-sharing-icon vk" href="//vk.com/share.php?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-vk"></i><span></span></a></li>
											<?php
											break;
										case 'xing':
											?>
											<li><a class="social-sharing-icon xing" href="//www.xing.com/app/user?op=share&url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-xing"></i><span></span></a></li>
											<?php
											break;
										case 'telegram':
											?>
											<li><a class="social-sharing-icon telegram" href="//t.me/share/url?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-telegram-plane"></i><span></span></a></li>
											<?php
											break;
										case 'oksocial':
											?>
											<li><a class="social-sharing-icon odnoklassniki" href="//connect.ok.ru/offer?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-odnoklassniki"></i><span></span></a></li>
											<?php
											break;
										case 'viber':
											?>
											<li><a class="social-sharing-icon viber" href="//viber://forward?text=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-viber"></i><span></span></a></li>
											<?php
											break;
										case 'whatsapp':
											?>
											<li><a class="social-sharing-icon whatsapp" href="//api.whatsapp.com/send?text=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-whatsapp"></i><span></span></a></li>
											<?php
											break;
									}
								}
								$i = $i + 3;
							}
						}
						?>
					</ul>
				</div>
			</div>
			<?php
		}

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

if ( ! function_exists( 'crafto_wishlist_shortcode' ) ) {
	/**
	 * [crafto-wishlist] Crafto Wishlist Shortcode Start.
	 *
	 * @param mixed $atts atts.
	 * @param mixed $content content.
	 */
	function crafto_wishlist_shortcode( $atts, $content = '' ) {
		// Initialize wishlist data.
		$data = [];

		// Check if user is logged in.
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$data    = get_user_meta( $user_id, '_crafto_wishlist', true );
		} else {
			$siteid      = ( is_multisite() ) ? '-' . get_current_blog_id() : '';
			$cookie_name = 'crafto-wishlist' . $siteid;
			$data        = ! empty( $_COOKIE[ $cookie_name ] ) ? $_COOKIE[ $cookie_name ] : ''; // phpcs:ignore
		}

		// Process wishlist data if available.
		$data = ! empty( $data ) ? explode( ',', $data ) : [];

		ob_start();
		do_action( 'crafto_addons_wishlist_data', $data );
		$content .= ob_get_contents(); // Get the contents and clean the buffer.
		ob_clean();

		return $content;
	}
}
add_shortcode( 'crafto-wishlist', 'crafto_wishlist_shortcode' );

// Disable Crawling and indexing for mega menu items & themebuilder.
add_filter(
	'wp_robots',
	function ( $robots ) {
		if ( is_singular( [ 'crafto-mega-menu', 'themebuilder' ] ) ) {
			// Return noindex and nofollow for these pages.
			return array(
				'noindex'  => true,
				'nofollow' => true,
			);
		}

		// Return the original $robots if the condition is not met.
		return $robots;
	}
);

if ( ! function_exists( 'crafto_option' ) ) {

	/**
	 * Get custom meta option value
	 *
	 * @param mixed $option Meta Key.
	 *
	 * @param mixed $default_value Default Value.
	 */
	function crafto_option( $option, $default_value ) {
		global $post;
		$crafto_option_value = '';

		if ( is_404() ) {

			$crafto_option_value = get_theme_mod( $option, $default_value );

		} elseif ( ( ! ( is_category() || is_archive() || is_author() || is_tag() || is_search() || is_home() || is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) || is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) || is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) || ( is_woocommerce_activated() && is_shop() ) ) && isset( $post->ID ) ) {

			// Meta Prefix.
			$value       = array();
			$meta_prefix = '_';
			if ( is_woocommerce_activated() && is_shop() ) {
				$page_id            = wc_get_page_id( 'shop' );
				$shop_option        = str_replace( '_product_archive_', '_page_', $option );
				$crafto_global_meta = get_post_meta( $page_id, 'crafto_global_meta', true );

				if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
					foreach ( $crafto_global_meta as $metavalue ) {
						if ( isset( $metavalue[ $shop_option . '_single' ] ) ) {
							$crafto_option_value = $metavalue[ $shop_option . '_single' ];
						}
					}

					if ( is_string( $crafto_option_value ) && ( strlen( $crafto_option_value ) > 0 || is_array( $crafto_option_value ) ) && ( 'default' !== $crafto_option_value ) ) {

						if ( strtolower( $crafto_option_value ) === '.' ) {
								$crafto_option_value = '';
						} else {
								$crafto_option_value = $crafto_option_value;
						}
					} else {
						$crafto_option_value = get_theme_mod( $option, $default_value );
					}
				} else {
					$crafto_option_value = get_theme_mod( $option, $default_value );
				}
				return $crafto_option_value;
			} else {
				$crafto_global_meta = get_post_meta( $post->ID, 'crafto_global_meta', true );

				if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
					foreach ( $crafto_global_meta as $metavalue ) {
						if ( isset( $metavalue[ $option . '_single' ] ) ) {
							$crafto_option_value = $metavalue[ $option . '_single' ];
						}
					}

					if ( is_string( $crafto_option_value ) && ( strlen( $crafto_option_value ) > 0 || is_array( $crafto_option_value ) ) && ( 'default' !== $crafto_option_value ) ) {

						if ( strtolower( $crafto_option_value ) === '.' ) {
							$crafto_option_value = '';
						} else {
							$crafto_option_value = $crafto_option_value;
						}
					} else {
						$crafto_option_value = get_theme_mod( $option, $default_value );
					}
				} else {
					$crafto_option_value = get_theme_mod( $option, $default_value );
				}
				return $crafto_option_value;
			}
		} else {
			$crafto_option_value = get_theme_mod( $option, $default_value );
		}

		return $crafto_option_value;
	}
}

if ( ! function_exists( 'crafto_global_meta_options' ) ) {

	/**
	 * Crafto Global Meta Options.
	 *
	 * @param mixed $option Meta Key.
	 *
	 * @param mixed $default_value Default Value.
	 */
	function crafto_global_meta_options( $option, $default_value ) {
		$crafto_option_value = '';
		$crafto_option_data  = crafto_option( $option, $default_value );
		$crafto_option_data  = crafto_builder_option( $option, $default_value );
		$crafto_option_data  = crafto_post_meta( $option );

		if ( is_array( $crafto_option_data ) && ! empty( $crafto_option_data ) ) {
			foreach ( $crafto_option_data as $key => $meta_value ) {
				if ( ( strlen( $meta_value ) > 0 && is_string( $meta_value ) ) && ( 'default' !== $meta_value ) ) {
					$crafto_option_value = $meta_value;
				}
			}
		}

		if ( '' === $crafto_option_value ) {
			$crafto_option_value = get_theme_mod( $option, $default_value );
		}
		return $crafto_option_value;
	}
}

if ( ! function_exists( 'crafto_builder_customize_option' ) ) {
	/**
	 * Get custom customize option value.
	 *
	 * @param mixed $option Meta Key.
	 * @param mixed $default_value Default Value.
	 * @return mixed The option value or default.
	 */
	function crafto_builder_customize_option( $option, $default_value ) {
		// Initialize the suffix variable to append to the option key.
		$suffix = '';
		// Get the theme mod with the appropriate suffix.
		$crafto_option_value = get_theme_mod( $option . $suffix, $default_value );

		// If the value is empty, return the default option value.
		return ( '' === $crafto_option_value ) ? get_theme_mod( $option, $default_value ) : $crafto_option_value;
	}
}

if ( ! function_exists( 'crafto_builder_option' ) ) {

	/**
	 * Get custom meta option value for Theme builder
	 *
	 * @param mixed $option Meta Key.
	 * @param mixed $default_value Default Value.
	 */
	function crafto_builder_option( $option, $default_value ) {
		global $post;

		$crafto_option_value = '';
		if ( is_404() ) {
			$crafto_option_value = get_theme_mod( $option, $default_value );

		} elseif ( ( ! ( is_category() || is_archive() || is_author() || is_tag() || is_search() || is_home() || is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) || is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) || is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) || ( is_woocommerce_activated() && is_shop() ) ) && isset( $post->ID ) ) {

			if ( is_woocommerce_activated() && is_shop() ) {

				$page_id            = wc_get_page_id( 'shop' );
				$crafto_global_meta = get_post_meta( $page_id, 'crafto_global_meta', true );
				$option             = str_replace( '_product_archive_', '_page_', $option );

				if ( is_array( $crafto_global_meta ) && ! empty( $globaldata ) ) {
					foreach ( $crafto_global_meta as $metavalue ) {
						if ( isset( $metavalue[ $option . '_single' ] ) ) {
							$crafto_option_value = $metavalue[ $option . '_single' ];
						}
					}

					if ( is_string( $crafto_option_value ) && ( strlen( $crafto_option_value ) > 0 || is_array( $crafto_option_value ) ) && ( 'default' !== $crafto_option_value ) ) {
						if ( strtolower( $crafto_option_value ) === '.' ) {
							$crafto_option_value = '';
						} else {
							$crafto_option_value = $crafto_option_value;
						}
					} else {
						$crafto_option_value = crafto_builder_customize_option( $option, $default_value );
					}
				} else {
					$crafto_option_value = crafto_builder_customize_option( $option, $default_value );
				}
				return $crafto_option_value;
			} else {
				$crafto_global_meta = get_post_meta( $post->ID, 'crafto_global_meta', true );

				if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
					foreach ( $crafto_global_meta as $metavalue ) {
						if ( isset( $metavalue[ $option . '_single' ] ) ) {
							$crafto_option_value = $metavalue[ $option . '_single' ];
						}
					}

					if ( is_string( $crafto_option_value ) && ( strlen( $crafto_option_value ) > 0 || is_array( $crafto_option_value ) ) && ( 'default' !== $crafto_option_value ) ) {
						if ( strtolower( $crafto_option_value ) === '.' ) {
							$crafto_option_value = '';
						} else {
							$crafto_option_value = $crafto_option_value;
						}
					} else {
						$crafto_option_value = crafto_builder_customize_option( $option, $default_value );
					}
				} else {
					$crafto_option_value = crafto_builder_customize_option( $option, $default_value );
				}
				return $crafto_option_value;
			}
		} else {
			$crafto_option_value = crafto_builder_customize_option( $option, $default_value );
		}

		return $crafto_option_value;
	}
}

if ( ! function_exists( 'crafto_theme_builder_meta_data' ) ) {

	/**
	 * Return Post Meta.
	 *
	 * @param mixed $crafto_section_id Post ID.
	 *
	 * @param mixed $option Post Meta Key.
	 */
	function crafto_theme_builder_meta_data( $crafto_section_id, $option ) {

		$crafto_option_value = '';
		$crafto_global_meta  = get_post_meta( $crafto_section_id, 'crafto_global_meta', true );

		if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
			foreach ( $crafto_global_meta as $metavalue ) {
				if ( isset( $metavalue[ $option ] ) ) {
					$crafto_option_value = $metavalue[ $option ];
				}
			}

			if ( is_string( $crafto_option_value ) && ( strlen( $crafto_option_value ) > 0 || is_array( $crafto_option_value ) ) && ( 'default' !== $crafto_option_value ) ) {
				if ( strtolower( $crafto_option_value ) === '.' ) {
					$crafto_option_value = '';
				} else {
					$crafto_option_value = $crafto_option_value;
				}
			}
			return $crafto_option_value;
		}
	}
}

if ( ! function_exists( 'crafto_post_meta' ) ) {

	/**
	 * Return Post Meta.
	 *
	 * @param mixed $option Post Meta Key.
	 */
	function crafto_post_meta( $option ) {
		global $post;

		if ( empty( $post->ID ) ) {
			return;
		}

		$crafto_option_value = '';
		$crafto_global_meta  = get_post_meta( $post->ID, 'crafto_global_meta', true );

		if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
			foreach ( $crafto_global_meta as $metavalue ) {
				if ( isset( $metavalue[ $option . '_single' ] ) ) {
					$crafto_option_value = $metavalue[ $option . '_single' ];
				}
			}
			return $crafto_option_value;
		}
	}
}

if ( ! function_exists( 'crafto_post_meta_by_id' ) ) {

	/**
	 * Return Post meta value by id.
	 *
	 * @param mixed $id Post ID.
	 *
	 * @param mixed $option Post meta key.
	 */
	function crafto_post_meta_by_id( $id, $option ) {
		// If ID empty.
		if ( ! $id ) {
			return;
		}

		$crafto_option_value = '';
		$crafto_global_meta  = get_post_meta( $id, 'crafto_global_meta', true );

		if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
			foreach ( $crafto_global_meta as $metavalue ) {
				if ( isset( $metavalue[ $option ] ) ) {
					$crafto_option_value = $metavalue[ $option ];
				}
			}
			return $crafto_option_value;
		}
	}
}

if ( ! function_exists( 'crafto_meta_box_values' ) ) {

	/**
	 * Return Meta Box Value.
	 *
	 * @param array $crafto_id meta key.
	 * @since 1.0
	 */
	function crafto_meta_box_values( $crafto_id ) {
		global $post;

		if ( empty( $post->ID ) ) {
			return;
		}

		$crafto_global_meta = get_post_meta( $post->ID, 'crafto_global_meta', true );
		if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
			foreach ( $crafto_global_meta as $global_meta_keys => $global_meta_val ) {
				if ( is_array( $global_meta_val ) && ! empty( $global_meta_val ) ) {
					foreach ( $global_meta_val as $meta_key => $meta_vals ) {
						if ( $meta_key === $crafto_id ) {
							return $meta_vals;
						}
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'crafto_get_post_types' ) ) {
	/**
	 * Get public post types for Crafto, excluding certain types.
	 *
	 * @param array $args Additional arguments to customize the post type query.
	 * @return array The post types with their labels.
	 */
	function crafto_get_post_types( $args = [] ) {
		// Default arguments to filter post types that show in navigation menus.
		$post_type_args = [
			// Default is the value $public.
			'show_in_nav_menus' => true,
		];

		// Keep for backwards compatibility.
		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['name'] = $args['post_type'];
			unset( $args['post_type'] );
		}

		// Merge passed arguments with the default ones.
		$post_type_args = wp_parse_args( $post_type_args, $args );

		// Get all post types based on the query arguments.
		$crafto_post_types = get_post_types( $post_type_args, 'objects' );

		$post_types = [];
		foreach ( $crafto_post_types as $post_type => $object ) {
			if ( 'e-landing-page' !== $post_type ) {
				$post_types[ $post_type ] = $object->label;
			}
		}

		/**
		 * Allow modification of the returned post types.
		 *
		 * @since 1.0
		 * @param array $post_types The post types list.
		 */
		return apply_filters( 'crafto_get_public_post_types', $post_types );
	}
}

if ( ! function_exists( 'crafto_get_intermediate_image_sizes' ) ) {

	/**
	 * Return a list of available image sizes including additional sizes.
	 *
	 * This function retrieves the default image sizes (full, thumbnail, medium, etc.)
	 * as well as any additional sizes registered via `add_image_size()`.
	 *
	 * @return array List of image sizes.
	 */
	function crafto_get_intermediate_image_sizes() {
		// Default image sizes provided by WordPress.
		$image_sizes = array(
			'full',
			'thumbnail',
			'medium',
			'medium_large',
			'large',
		);

		if ( version_compare( $GLOBALS['wp_version'], '4.7.0', '>=' ) ) {

			$_wp_additional_image_sizes = wp_get_additional_image_sizes();

			// Merge the additional sizes with the default ones.
			if ( ! empty( $_wp_additional_image_sizes ) ) {
				$image_sizes = array_merge( $image_sizes, array_keys( $_wp_additional_image_sizes ) );
			}
		}

		/**
		 * Filter hook to allow modification of the image sizes.
		 *
		 * @since 1.0
		 * @param array $image_sizes List of image sizes.
		 */
		return apply_filters( 'intermediate_image_sizes', $image_sizes );
	}
}

if ( ! function_exists( 'crafto_get_thumbnail_image_sizes' ) ) {

	/**
	 * Return thumbnail image size.
	 */
	function crafto_get_thumbnail_image_sizes() {

		$thumbnail_image_sizes = [];

		// Hackily add in the data link parameter.
		$crafto_srcset = crafto_get_intermediate_image_sizes();

		if ( empty( $crafto_srcset ) ) {
			return $thumbnail_image_sizes; // Early return if no image sizes.
		}

		foreach ( $crafto_srcset as $value => $label ) {

			$key               = esc_attr( $label );
			$crafto_image_data = crafto_get_image_sizes( $label );

			// Get width and height.
			if ( 'full' !== $label ) {
				$width  = isset( $crafto_image_data['width'] ) && '0' !== (string) $crafto_image_data['width'] ? $crafto_image_data['width'] . 'px' : esc_html__( 'Auto', 'crafto-addons' );
				$height = isset( $crafto_image_data['height'] ) && '0' !== (string) $crafto_image_data['height'] ? $crafto_image_data['height'] . 'px' : esc_html__( 'Auto', 'crafto-addons' );
			}

			if ( 'full' === $label ) {
				$data = esc_html__( 'Original Full Size', 'crafto-addons' );
			} else {
				$data = ucwords( str_replace( '_', ' ', str_replace( '-', ' ', esc_attr( $label ) ) ) ) . ' ( ' . esc_attr( $width ) . ' X ' . esc_attr( $height ) . ')';
			}

			$thumbnail_image_sizes[ $key ] = $data;
		}

		return $thumbnail_image_sizes;
	}
}

if ( ! function_exists( 'crafto_get_image_sizes' ) ) {

	/**
	 * Return thumbnail image size.
	 *
	 * @param mixed $size Image Size.
	 */
	function crafto_get_image_sizes( $size ) {
		global $_wp_additional_image_sizes;

		// Default sizes provided by WordPress.
		if ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
			return array(
				'width'  => $_wp_additional_image_sizes[ $size ]['width'],
				'height' => $_wp_additional_image_sizes[ $size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $size ]['crop'],
			);
		} elseif ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
			return array(
				'width'  => get_option( "{$size}_size_w" ),
				'height' => get_option( "{$size}_size_h" ),
				'crop'   => (bool) get_option( "{$size}_crop" ),
			);
		}
		// If no size is found, return empty.
		return false;
	}
}

if ( ! function_exists( 'crafto_post_category' ) ) {

	/**
	 * Return post category.
	 *
	 * @param mixed   $id Post ID.
	 * @param boolean $separator Post Separator.
	 * @param mixed   $count Post count.
	 * @return string|null The post categories as a formatted string or null.
	 */
	function crafto_post_category( $id, $separator = true, $count = '10' ) {

		if ( empty( $id ) ) {
			return null;
		}

		if ( get_post_type( $id ) !== 'post' ) {
			return null;
		}

		// Get categories for the post.
		$categories = get_the_category( $id );
		if ( empty( $categories ) ) {
			return '';
		}

		$post_cat = [];
		foreach ( array_slice( $categories, 0, intval( $count ) ) as $cat ) {
			$cat_link   = get_category_link( $cat->cat_ID );
			$post_cat[] = '<a rel="category tag" href="' . esc_url( $cat_link ) . '">' . esc_html( $cat->name ) . '</a>';
		}

		return implode( $separator ? ', ' : '', $post_cat );
	}
}

if ( ! function_exists( 'crafto_single_post_meta_category' ) ) {
	/**
	 * Return post category list with optional icon.
	 *
	 * @param mixed   $id Post ID.
	 * @param boolean $icon Whether to display an icon.
	 */
	function crafto_single_post_meta_category( $id, $icon = false ) {
		// Return early if ID is empty or post type is not 'post'.
		if ( empty( $id ) || 'post' !== get_post_type( $id ) ) {
			return;
		}

		/**
		 * Filter for post category limit
		 *
		 * @since 1.0
		 */
		$crafto_term_limit = apply_filters( 'crafto_single_post_category_limit', '40' );
		$category_list     = crafto_post_category( $id, true, $crafto_term_limit );

		$icon_html = '';
		if ( $icon ) {

			/**
			 * Filter for remove or modify post category default icon.
			 *
			 * @since 1.0
			 */
			$icon_html = apply_filters(
				'crafto_single_post_meta_category_icon',
				'<i class="feather icon-feather-folder"></i>'
			);
		}

		if ( $category_list ) {
			printf( '<li>%1$s%2$s</li>', $icon_html, $category_list ); // phpcs:ignore
		}
	}
}

if ( ! function_exists( 'crafto_post_exists' ) ) {
	/**
	 * Check post exists.
	 *
	 * @param mixed $id Post ID.
	 * @return boolean True if the post exists, false otherwise.
	 */
	function crafto_post_exists( $id ) {

		if ( empty( $id ) ) {
			return false;
		}

		$post_status = get_post_status( $id );

		return 'trash' !== $post_status && $post_status;
	}
}

if ( ! function_exists( 'crafto_breadcrumb_display' ) ) {
	/**
	 * Display breadcrumbs for Crafto.
	 */
	function crafto_breadcrumb_display() {

		if ( is_woocommerce_activated() && ( is_product() || is_product_category() || is_product_tag() || is_tax( 'product_brand' ) || is_shop() ) ) {

			ob_start();
				/**
				 * Fires to load breadcrumb for WooCommerce
				 *
				 * @since 1.0
				 */
				do_action( 'crafto_woocommerce_breadcrumb' );

			return ob_get_clean();

		} elseif ( class_exists( 'Crafto_Breadcrumb_Navigation' ) ) {

			$titles = [
				'blog'   => esc_html__( 'Home', 'crafto-addons' ),
				'home'   => esc_html__( 'Home', 'crafto-addons' ),
				'search' => esc_html__( 'Search', 'crafto-addons' ),
				'404'    => esc_html__( '404', 'crafto-addons' ),
			];

			$crafto_breadcrumb = new Crafto_Breadcrumb_Navigation();

			$crafto_breadcrumb->opt['static_frontpage'] = false;
			$crafto_breadcrumb->opt['url_blog']         = '';

			// Apply filters for breadcrumb titles.
			foreach ( $titles as $key => $title ) {
				$crafto_breadcrumb->opt[ "title_$key" ] = apply_filters( "crafto_breadcrumb_title_$key", $title );
			}

			// Additional breadcrumb options.
			$crafto_breadcrumb->opt['separator']                       = '';
			$crafto_breadcrumb->opt['tag_page_prefix']                 = '';
			$crafto_breadcrumb->opt['singleblogpost_category_display'] = false;

			return $crafto_breadcrumb->crafto_display_breadcrumb();
		}
	}
}

if ( ! function_exists( 'crafto_extract_shortcode_contents' ) ) {

	/**
	 * Crafto extract shortcode
	 *
	 * @param mixed $m Post content.
	 */
	function crafto_extract_shortcode_contents( $m ) {
		global $shortcode_tags;

		// Setup the array of all registered shortcodes.
		$shortcodes          = array_keys( $shortcode_tags );
		$no_space_shortcodes = array( 'dropcap' );
		$omitted_shortcodes  = array( 'slide' );

		// Extract contents from all shortcodes recursively.
		if ( in_array( $m[2], $shortcodes, true ) && ! in_array( $m[2], $omitted_shortcodes, true ) ) {
			$pattern = get_shortcode_regex();
			// Add space the excerpt by shortcode, except for those who should stick together, like dropcap.
			$space = ' ';
			if ( in_array( $m[2], $no_space_shortcodes, true ) ) {
				$space = '';
			}
			$content = preg_replace_callback( "/$pattern/s", 'crafto_extract_shortcode_contents', rtrim( $m[5] ) . $space );
			return $content;
		}
		// allow [[foo]] syntax for escaping a tag.
		if ( '[' === $m[1] && ']' === $m[6] ) {
			return substr( $m[0], 1, -1 );
		}
		return $m[1] . $m[6];
	}
}

if ( ! function_exists( 'crafto_get_the_excerpt_theme' ) ) {
	/**
	 * Return post excerpt length.
	 *
	 * @param array $length Excerpt Length.
	 */
	function crafto_get_the_excerpt_theme( $length ) {
		$crato_excerpt = ( class_exists( 'Crafto_Excerpt' ) ) ? Crafto_Excerpt::crafto_get_by_length( $length ) : '';
		return $crato_excerpt;
	}
}

if ( ! function_exists( 'crafto_get_builder_section_data' ) ) {
	/**
	 * Get Theme builder data.
	 *
	 * @param array   $template_type Template type.
	 *
	 * @param boolean $meta Default value.
	 *
	 * @param boolean $general Global value exist or not.
	 */
	function crafto_get_builder_section_data( $template_type = '', $meta = false, $general = false ) {
		// Return early if the template type is empty.
		if ( empty( $template_type ) ) {
			return [];
		}

		// Base options depending on context.
		if ( $meta ) {
			$builder_section_data['default'] = esc_html__( 'Default', 'crafto-addons' );
		} elseif ( $general ) {
			$builder_section_data[''] = esc_html__( 'General', 'crafto-addons' );
		} else {
			$builder_section_data[''] = esc_html__( 'Select', 'crafto-addons' );
		}

		// Prepare the meta query based on the template type.
		$crafto_filter_section = [
			'key'     => '_crafto_theme_builder_template',
			'value'   => $template_type, // phpcs:ignore
			'compare' => '=',
		];

		// Set up the arguments for get_posts.
		$args = [
			'post_type'      => 'themebuilder',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'no_found_rows'  => true,
			'fields'         => 'ids',
			// phpcs:ignore
			'meta_query'     => [
				$crafto_filter_section,
			],
		];

		// Fetch posts based on the defined arguments.
		$post_ids = get_posts( $args );

		// Populate builder section data with post titles.
		if ( ! empty( $post_ids ) ) {
			$posts = get_posts(
				[
					'post_type'      => 'themebuilder',
					'post_status'    => 'publish',
					'post__in'       => $post_ids,
					'orderby'        => 'post__in',
					'posts_per_page' => -1,
					'no_found_rows'  => true,
				]
			);

			foreach ( $posts as $post ) {
				$builder_section_data[ $post->ID ] = esc_html( $post->post_title );
			}
		}

		return $builder_section_data;
	}
}

if ( ! function_exists( 'crafto_get_mini_header_sticky_type_by_key' ) ) {
	/**
	 * Return mini header sticky style.
	 *
	 * @param mixed $mini_header_sticky_type Add mini header style.
	 */
	function crafto_get_mini_header_sticky_type_by_key( $mini_header_sticky_type = '' ) {

		// Define mini header sticky types.
		$mini_header_sticky_types = array(
			'always-fixed'  => esc_html__( 'Always Fixed', 'crafto-addons' ),
			'disable-fixed' => esc_html__( 'Disable Fixed', 'crafto-addons' ),
		);

		// Return specific type or all types.
		return ! empty( $mini_header_sticky_type ) && isset( $mini_header_sticky_types[ $mini_header_sticky_type ] )
			? $mini_header_sticky_types[ $mini_header_sticky_type ]
			: $mini_header_sticky_types;
	}
}

if ( ! function_exists( 'crafto_register_sidebar_array' ) ) {

	/**
	 * Return register sidebar list.
	 *
	 * @return array Sidebar array.
	 */
	function crafto_register_sidebar_array() {
		global $wp_registered_sidebars;

		$sidebar_array = [];
		if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) {
			$sidebar_array = [
				'default' => esc_html__( 'Default', 'crafto-addons' ),
				'none'    => esc_html__( 'No Sidebar', 'crafto-addons' ),
			];

			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebar_array[ $sidebar['id'] ] = $sidebar['name'];
			}
		}
		return $sidebar_array;
	}
}

if ( ! function_exists( 'crafto_sanitize_multiple_checkbox' ) ) {
	/**
	 * Custom sanitize function for Validate the multiple checkbox field.
	 *
	 * @param mixed $values Optional | Default value.
	 */
	function crafto_sanitize_multiple_checkbox( $values ) {

		// Convert to an array if $values is not already one.
		$multi_values = is_array( $values ) ? $values : explode( ',', $values );

		return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	}
}

if ( ! function_exists( 'crafto_blog_post_like_button' ) ) {
	/**
	 * Crafto blog post like button
	 *
	 * @param mixed $post_id Post ID.
	 * @return string HTML output for the like button.
	 */
	function crafto_blog_post_like_button( $post_id ) {
		if ( ! class_exists( 'Crafto_Blog_Post_Likes' ) ) {
			return ''; // Return early if the class doesn't exist.
		}

		$crafto_blog_post_likes = new Crafto_Blog_Post_Likes();
		return $crafto_blog_post_likes->crafto_get_simple_likes_button( $post_id );
	}
}

if ( ! function_exists( 'crafto_load_async_javascript' ) ) {
	/**
	 * Check loaded async JavaScript library.
	 *
	 * @param string $url The URL of the JavaScript file.
	 * @return mixed Sync array or filter result..
	 */
	function crafto_load_async_javascript( $url ) {

		$crafto_js_async      = get_theme_mod( 'crafto_js_async', '0' );
		$crafto_load_strategy = get_theme_mod( 'crafto_load_strategy', 'defer' );

		// Default return value.
		$sync_array = true;

		// Check if async loading is enabled.
		if ( '1' === $crafto_js_async && 'delay' !== $crafto_load_strategy ) {
			$exclude       = [];
			$js_files_name = get_theme_mod( 'crafto_js_exclude_defer', '' );

			// Process excluded JavaScript files.
			if ( '' !== $js_files_name ) {
				$exclude = explode( ',', $js_files_name );
				foreach ( $exclude as $jsname ) {
					if ( strpos( $url, $jsname ) ) {
						return $sync_array;
					}
				}
			}

			// Set sync array if async loading is enabled.
			$sync_array = array(
				'in_footer' => true,
				'strategy'  => $crafto_load_strategy,
			);
		}

		/**
		 * Filter to check if JavaScript library exists or not.
		 *
		 * @since 1.0
		 */
		return apply_filters( 'crafto_load_async_javascript', $sync_array );
	}
}

if ( ! function_exists( 'crafto_disable_module_by_key' ) ) {
	/**
	 * Check if a CSS library is enabled or disabled based on user settings.
	 *
	 * @param string $value The handle of the CSS library to check.
	 * @return bool True if the style is enabled, false if it is disabled
	 */
	function crafto_disable_module_by_key( $value ) {
		global $post;

		$crafto_customizer = get_theme_mod( 'crafto_disable_module_lists', '' );
		$crafto_customizer = ( ! empty( $crafto_customizer ) ) ? explode( ',', $crafto_customizer ) : [];

		// Gather disabled styles from global meta.
		$crafto_option_value = [];
		if ( ! empty( $post->ID ) ) {
			$crafto_global_meta = get_post_meta( $post->ID, 'crafto_global_meta', true );
			if ( is_array( $crafto_global_meta ) && ! empty( $crafto_global_meta ) ) {
				foreach ( $crafto_global_meta as $metavalue ) {
					if ( isset( $metavalue['crafto_disable_module_lists_single'] ) ) {
						$crafto_option_value = $metavalue['crafto_disable_module_lists_single'];
					}
				}
			}
		}

		// Merge disabled styles from both customizer and post meta.
		$style_details = array_merge( $crafto_option_value, $crafto_customizer );
		$style_details = array_filter( $style_details ); // Remove empty values.

		// Check if the specified stylesheet is disabled.
		$flag = ! in_array( $value, $style_details, true );

		/**
		 * Filter to check if CSS library exist or not
		 *
		 * @since 1.0
		 */
		return apply_filters( 'crafto_disable_module_by_key', $flag, $value );
	}
}

if ( ! function_exists( 'crafto_post_comments' ) ) {
	/**
	 * Add post comments count
	 */
	function crafto_post_comments() {
		$icon_html         = '<i class="fa-regular fa-comment"></i>';
		$no_comments       = '<span class="comment-count">0</span><span class="comment-text">' . esc_html__( 'Comment', 'crafto-addons' ) . '</span>';
		$one_comment       = '<span class="comment-count">1</span><span class="comment-text">' . esc_html__( 'Comment', 'crafto-addons' ) . '</span>';
		$multiple_comments = '<span class="comment-count">%</span><span class="comment-text">' . esc_html__( 'Comments', 'crafto-addons' ) . '</span>';

		comments_popup_link(
			$icon_html . $no_comments,
			$icon_html . $one_comment,
			$icon_html . $multiple_comments,
			'comment-link'
		);
	}
}

if ( ! function_exists( 'crafto_option_image_alt' ) ) {
	/**
	 * Retrieve alt text for an image.
	 *
	 * @param mixed $attachment_id Attachment ID.
	 */
	function crafto_option_image_alt( $attachment_id ) {
		// Return null for non-image attachments.
		if ( ! wp_attachment_is_image( $attachment_id ) ) {
			return null;
		}

		// Check if image alt text feature is enabled.
		$crafto_image_alt = get_theme_mod( 'crafto_image_alt', '1' );

		if ( '1' === $crafto_image_alt ) {
			// Get alt text from attachment metadata.
			$image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

			// Fallback to the attachment title if alt text is empty.
			if ( empty( $image_alt ) ) {
				$image_alt = esc_attr( get_the_title( $attachment_id ) );
			}

			return [
				'alt' => $image_alt,
			];
		}

		return null; // Return null if alt text feature is off.
	}
}

if ( ! function_exists( 'crafto_option_image_title' ) ) {
	/**
	 * For Image Alt Text.
	 *
	 * @param mixed $attachment_id Attachment ID.
	 */
	function crafto_option_image_title( $attachment_id ) {

		if ( ! wp_attachment_is_image( $attachment_id ) ) {
			return null; // Return null for non-image attachments.
		}

		// Check if image title feature is enabled.
		$crafto_image_title = get_theme_mod( 'crafto_image_title', '0' );

		if ( '1' === $crafto_image_title ) {
			// Get title text from attachment metadata.
			return [
				'title' => esc_attr( get_the_title( $attachment_id ) ),
			];
		}

		return null; // Return null if alt text feature is off.
	}
}


if ( ! function_exists( 'crafto_get_magic_cursor_data' ) ) {
	/**
	 * Get Magic cursor settings.
	 *
	 * @return string Cursor class name.
	 */
	function crafto_get_magic_cursor_data() {
		$crafto_magic_cursor_style = get_theme_mod( 'crafto_magic_cursor_style', 'cursor-label' );

		// Return early if in edit mode.
		if ( is_elementor_activated() && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return '';
		}

		// Define cursor class based on the selected style.
		$cursor_classes = [
			'cursor-icon'  => 'magic-cursor cursor-icon',
			'cursor-label' => 'magic-cursor cursor-label',
		];

		// Return the appropriate cursor class if it exists.
		return isset( $cursor_classes[ $crafto_magic_cursor_style ] ) ? $cursor_classes[ $crafto_magic_cursor_style ] : '';
	}
}

if ( ! function_exists( 'crafto_get_pagination' ) ) {
	/**
	 * Generates pagination.
	 */
	function crafto_get_pagination() {
		global $wp_query;

		$total_pages = $wp_query->max_num_pages;

		if ( $total_pages <= 1 ) {
			return; // No pagination needed.
		}

		$current_page = max( 1, get_query_var( 'paged' ) );

		$prev_text = apply_filters(
			'crafto_pagination_prev_text',
			sprintf(
				'<i aria-hidden="true" class="feather icon-feather-arrow-left"></i><span class="screen-reader-text">%s</span>',
				esc_html__( 'Previous page', 'crafto-addons' )
			)
		);

		$next_text = apply_filters(
			'crafto_pagination_next_text',
			sprintf(
				'<span class="screen-reader-text">%s</span><i aria-hidden="true" class="feather icon-feather-arrow-right"></i>',
				esc_html__( 'Next page', 'crafto-addons' )
			)
		);

		$pagination_links = paginate_links(
			[
				'base'      => str_replace( 999999999, '%#%', esc_url_raw( get_pagenum_link( 999999999 ) ) ),
				'format'    => '',
				'current'   => $current_page,
				'total'     => $total_pages,
				'prev_text' => $prev_text,
				'next_text' => $next_text,
				'type'      => 'list',
				'end_size'  => 2,
				'mid_size'  => 2,
			]
		);

		if ( $pagination_links ) {
			echo '<div class="col-12 crafto-pagination"><div class="text-center">' . $pagination_links . '</div></div>'; // phpcs:ignore
		}
	}
}

if ( ! function_exists( 'crafto_post_pagination' ) ) {
	/**
	 * Custom Post Pagination Function
	 *
	 * Generates pagination links for a WordPress query.
	 *
	 * @param WP_Query $wpquery  The custom WordPress query object for pagination.
	 * @param array    $settings An array of settings for customization (optional).
	 */
	function crafto_post_pagination( $wpquery, $settings ) {
		$crafto_pagination_prev_icon              = '';
		$crafto_pagination_next_icon              = '';
		$crafto_pagination                        = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';
		$crafto_pagination_next_label             = ( isset( $settings['crafto_pagination_next_label'] ) && $settings['crafto_pagination_next_label'] ) ? $settings['crafto_pagination_next_label'] : '';
		$crafto_pagination_prev_label             = ( isset( $settings['crafto_pagination_prev_label'] ) && $settings['crafto_pagination_prev_label'] ) ? $settings['crafto_pagination_prev_label'] : '';
		$crafto_pagination_load_more_button_label = ( isset( $settings['crafto_pagination_load_more_button_label'] ) && $settings['crafto_pagination_load_more_button_label'] ) ? $settings['crafto_pagination_load_more_button_label'] : esc_html__( 'Load more', 'crafto-addons' );

		if ( $crafto_pagination ) {

			// Previous Page.
			ob_start();
			\Elementor\Icons_Manager::render_icon(
				$settings['crafto_pagination_prev_icon'],
				[
					'aria-hidden' => 'true',
				]
			);
			$crafto_pagination_prev_icon .= ob_get_contents();
			ob_end_clean();
			$crafto_pagination_prev_icon .= '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'crafto-addons' ) . '</span>';

			/**
			 * Apply filters to change or modify previous page text.
			 */
			$crafto_pagination_prev_icon_attr  = apply_filters( 'crafto_pagination_prev_text', $crafto_pagination_prev_icon );
			$crafto_pagination_prev_icon_attr .= $crafto_pagination_prev_label;

			// Next Page.
			$crafto_pagination_next_icon_attr = $crafto_pagination_next_label;
			ob_start();
				$crafto_pagination_next_icon .= '<span class="screen-reader-text">' . esc_html__( 'Next page', 'crafto-addons' ) . '</span>';
				\Elementor\Icons_Manager::render_icon(
					$settings['crafto_pagination_next_icon'],
					[
						'aria-hidden' => 'true',
					]
				);
				$crafto_pagination_next_icon .= ob_get_contents();
			ob_end_clean();

			/**
			 * Apply filters to change or modify next page text.
			 */
			$crafto_pagination_next_icon_attr .= apply_filters( 'crafto_pagination_next_text', $crafto_pagination_next_icon );
		}

		switch ( $crafto_pagination ) {
			case 'number-pagination':
				$current = ( $wpquery->query_vars['paged'] > 1 ) ? $wpquery->query_vars['paged'] : 1;
				add_action( 'number_format_i18n', 'crafto_pagination_zero_prefix' );
				if ( $wpquery->max_num_pages > 1 ) {
					?>
					<div class="col-12 crafto-pagination">
						<div class="pagination d-flex align-items-center" aria-label="<?php echo esc_attr__( 'Pagination', 'crafto-addons' ); ?>" >
							<?php
							// phpcs:ignore
							echo paginate_links(
								array(
									'base'      => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
									'format'    => '',
									'add_args'  => '',
									'current'   => $current,
									'total'     => $wpquery->max_num_pages,
									'prev_text' => $crafto_pagination_prev_icon_attr,
									'next_text' => $crafto_pagination_next_icon_attr,
									'type'      => 'list',
									'end_size'  => 2,
									'mid_size'  => 2,
								),
							);
							?>
						</div>
					</div>
					<?php
				}
				remove_action( 'number_format_i18n', 'crafto_pagination_zero_prefix' );
				break;
			case 'next-prev-pagination':
				if ( $wpquery->max_num_pages > 1 ) {
					?>
					<div class="post-pagination col-12">
						<div class="new-post">
							<?php
							if ( is_elementor_activated() && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
								?>
								<a href="#">
									<i aria-hidden="true" class="feather icon-feather-arrow-left"></i>
									<?php echo esc_html__( 'PREV', 'crafto-addons' ); ?></a>
								<?php
							} else {
								echo get_previous_posts_link( $crafto_pagination_prev_icon_attr ); // phpcs:ignore
							}
							?>
						</div>
						<div class="old-post">
							<?php
							if ( is_elementor_activated() && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
								?>
								<a href="#">
									<?php echo esc_html__( 'NEXT', 'crafto-addons' ); ?>
									<i aria-hidden="true" class="feather icon-feather-arrow-right"></i></a>
								<?php
							} else {
								echo get_next_posts_link( $crafto_pagination_next_icon_attr, $wpquery->max_num_pages ); // phpcs:ignore
							}
							?>
						</div>
					</div>
					<?php
				}
				break;
			case 'infinite-scroll-pagination':
				$current = ( $wpquery->query_vars['paged'] > 1 ) ? $wpquery->query_vars['paged'] : 1;
				if ( $wpquery->max_num_pages !== $current ) {
					?>
					<div class="col-12 post-pagination post-infinite-scroll-pagination" data-pagination="<?php echo esc_attr( $wpquery->max_num_pages ); ?>">
						<div class="page-load-status text-center">
							<p class="infinite-scroll-request">
								<?php
								/**
								 * Apply filters to modify loading GIF
								 */
								$crafto_pagination_loading_gif = apply_filters( 'crafto_pagination_loading_gif', esc_url( CRAFTO_THEME_IMAGES_URI . '/loading-infinite-scroll.svg' ) );
								?>
								<img src="<?php echo $crafto_pagination_loading_gif; // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'loading', 'crafto-addons' ); ?>">
							</p>
						</div>
						<div class="old-post d-none">
							<?php
							if ( get_next_posts_link( '', $wpquery->max_num_pages ) ) {
								next_posts_link( esc_html__( 'Next', 'crafto-addons' ) . '<i aria-hidden="true" class="feather icon-feather-arrow-right"></i>', $wpquery->max_num_pages );
							}
							?>
						</div>
					</div>
					<?php
				}
				break;
			case 'load-more-pagination':
				$current = ( $wpquery->query_vars['paged'] > 1 ) ? $wpquery->query_vars['paged'] : 1;
				if ( $wpquery->max_num_pages !== $current ) {
					?>
					<div class="post-pagination post-infinite-scroll-pagination crafto-post-load-more" data-pagination="<?php echo $wpquery->max_num_pages; // phpcs:ignore ?>">
						<div class="old-post d-none">
							<?php
							if ( get_next_posts_link( '', $wpquery->max_num_pages ) ) {
								next_posts_link( esc_html__( 'Next', 'crafto-addons' ) . '<i aria-hidden="true" class="feather icon-feather-arrow-right"></i>', $wpquery->max_num_pages );
							}
							?>
						</div>
						<div class="load-more-btn text-center">
							<button class="btn view-more-button">
								<span><?php echo esc_html( $crafto_pagination_load_more_button_label ); ?></span>
								<div class="page-load-status text-center">
									<p class="infinite-scroll-request">
										<?php
										/**
										 * Apply filters to modify loading GIF
										 */
										$crafto_pagination_loading_gif = apply_filters( 'crafto_pagination_loading_gif', esc_url( CRAFTO_THEME_IMAGES_URI . '/load-more-icon.svg' ) );
										?>
										<img src="<?php echo $crafto_pagination_loading_gif; // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'loading', 'crafto-addons' ); ?>">
									</p>
								</div>
							</button>
						</div>
					</div>
					<?php
				}
				break;
		}
	}
}

if ( ! function_exists( 'crafto_pagination_zero_prefix' ) ) {
	/**
	 * Post for Pagination.
	 *
	 * @param array $format add format string.
	 */
	function crafto_pagination_zero_prefix( $format ) {
		$number = intval( $format );
		if ( intval( $number / 10 ) > 0 ) {
			return $format;
		}

		return '0' . $format;
	}
}

if ( ! function_exists( 'crafto_upload_custom_font_action_data' ) ) {
	/**
	 * Upload Custom Font.
	 */
	function crafto_upload_custom_font_action_data() {
		/* Verify nonce */
		check_ajax_referer( 'crafto_font_nonce', '_ajax_nonce' );

		/* Check current user permission */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( esc_html__( 'Unauthorized request.', 'crafto-addons' ) );
		}

		if ( ! isset( $_FILES['file'] ) ) { // phpcs:ignore
			wp_send_json_error( esc_html__( 'Missing file.', 'crafto-addons' ) );
		}

		if ( empty( $_FILES['file'] ) ) { // phpcs:ignore
			wp_send_json_error( esc_html__( 'Missing file.', 'crafto-addons' ) );
		}

		$file      = $_FILES['file']; // phpcs:ignore
		$filename  = $_FILES['file']['name']; // phpcs:ignore
		$ext       = pathinfo( $filename, PATHINFO_EXTENSION );
		$font_type = ( isset( $_POST['font_type'] ) && ! empty( $_POST['font_type'] ) ) ? $_POST['font_type'] : esc_html__( 'Current', 'crafto-addons' ); // phpcs:ignore

		// Check if the file extension matches the font type.
		if ( $ext === $font_type ) {
			add_filter( 'upload_dir', 'crafto_custom_font_upload_dir' );
			$upload_result = wp_handle_upload( $file, [ 'test_form' => false ] );
			remove_filter( 'upload_dir', 'crafto_custom_font_upload_dir' );

			wp_send_json_success(
				[
					'message' => sprintf(
						'%1$s %2$s %3$s',
						esc_html__( 'Your', 'crafto-addons' ),
						esc_html( $font_type ),
						esc_html__( 'file was uploaded.', 'crafto-addons' )
					),
					'url'     => ( isset( $upload_result['url'] ) && ! empty( $upload_result['url'] ) ) ? esc_url_raw( $upload_result['url'] ) : '',
				]
			);

		} else {
			wp_send_json_error(
				sprintf(
					'%1$s %2$s %3$s',
					esc_html__( 'The file you are trying to upload is not a', 'crafto-addons' ),
					esc_html( $font_type ),
					esc_html__( 'file. Please try again.', 'crafto-addons' )
				)
			);
		}
	}
}
add_action( 'wp_ajax_crafto_upload_custom_font_action_data', 'crafto_upload_custom_font_action_data' );

if ( ! function_exists( 'crafto_custom_font_upload_dir' ) ) {
	/**
	 * @param $path $path Get path url.
	 * Return path array.
	 */
	function crafto_custom_font_upload_dir( $path ) {
		if ( ! empty( $path['error'] ) ) {
			return $path;
		}

		if ( isset( $_POST['fontFamily'] ) && ! empty( $_POST['fontFamily'] ) ) { // phpcs:ignore
			// Retrieve font family from POST data.
			$font_family = str_replace( ' ', '-', $_POST['fontFamily'] ); // phpcs:ignore
			$customdir   = '/crafto-fonts/' . $font_family; // phpcs:ignore

			// Update path and URL without the original subdir.
			$path['path'] = str_replace( $path['subdir'], '', $path['path'] );
			$path['url']  = str_replace( $path['subdir'], '', $path['url'] );

			// Set new subdir and update path and URL.
			$path['subdir'] = $customdir;
			$path['path']  .= $customdir;
			$path['url']   .= $customdir;
		}

		return $path;
	}
}
if ( ! function_exists( 'crafto_get_tags_list' ) ) {
	/**
	 * @param mixed $taxonomy Get type of term.
	 *
	 * Return post tags array.
	 */
	function crafto_get_tags_list( $taxonomy ) {
		$tags_array = [];

		$args = [
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		];

		$terms = get_terms( $args );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$tags_array[ $term->slug ] = $term->name;
			}
		}

		return $tags_array;
	}
}

if ( ! function_exists( 'crafto_get_categories_list' ) ) {
	/**
	 * @param mixed $taxonomy Get type of taxonomy.
	 *
	 * Return terms array.
	 */
	function crafto_get_categories_list( $taxonomy ) {
		$categories_array = [];

		$terms = get_terms(
			[
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'fields'     => 'all',
			]
		);

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$categories_array[ $term->slug ] = $term->name;
			}
		}

		return $categories_array;
	}
}

if ( ! function_exists( 'crafto_get_portfolio_array' ) ) {
	/**
	 * Return post array
	 */
	function crafto_get_portfolio_array() {
		global $wpdb;
		// phpcs:ignore
		$results = $wpdb->get_results( "
			SELECT ID, post_title
			FROM {$wpdb->posts}
			WHERE post_type = 'portfolio'
			AND post_status = 'publish'
			ORDER BY post_title ASC
		", OBJECT_K ); // phpcs:ignore

		$post_array = [];
		foreach ( $results as $id => $row ) {
			$post_array[ $id ] = $row->post_title ? $row->post_title : esc_html__( '(no title)', 'crafto-addons' );
		}

		return $post_array;
	}
}

if ( ! function_exists( 'no_template_content_message' ) ) {
	/**
	 * Function to show message if no template available.
	 */
	function no_template_content_message() {
		$message = esc_html__( 'Template is not defined. ', 'crafto-addons' );

		$link = add_query_arg(
			array(
				'post_type'     => 'elementor_library',
				'action'        => 'elementor_new_post',
				'_wpnonce'      => wp_create_nonce( 'elementor_action_new_post' ),
				'template_type' => 'section',
			),
			esc_url( admin_url( '/edit.php' ) )
		);

		$new_link = esc_html__( 'Select an existing template or create a ', 'crafto-addons' ) . '<a class="elementor-custom-new-template-link elementor-clickable" href="' . $link . '">' . esc_html__( 'new one', 'crafto-addons' ) . '</a>';

		return sprintf(
			'<div class="elementor-no-template-message alert alert-warning"><div class="message">%1$s%2$s</div></div>',
			$message,
			( \Elementor\Plugin::instance()->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) ? $new_link : ''
		);
	}
}
if ( ! function_exists( 'crafto_is_editor_mode' ) ) {
	/**
	 * Render crafto editor mode output on the frontend.
	 *
	 * @access public
	 */
	function crafto_is_editor_mode() {
		if ( ( \Elementor\Plugin::instance()->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) || is_singular( 'themebuilder' ) ) {
			return true;
		} else {
			return false;
		}
	}
}
if ( ! function_exists( 'get_menus_list' ) ) {
	/**
	 * Return available menus list
	 */
	function get_menus_list() {

		$menus      = wp_get_nav_menus();
		$menus_list = wp_list_pluck( $menus, 'name', 'slug' );
		$parent     = isset( $_GET['parent_menu'] ) ? absint( $_GET['parent_menu'] ) : 0; // phpcs:ignore

		if ( 0 < $parent && isset( $menus_list[ $parent ] ) ) {
			unset( $menus_list[ $parent ] );
		}

		return $menus_list;
	}
}
if ( ! function_exists( 'get_swiper_pagination' ) ) {
	/**
	 * Return swiper pagination.
	 *
	 * @param array $settings The settings array.
	 */
	function get_swiper_pagination( $settings ) { // phpcs:ignore

		if ( empty( $settings ) ) {
			return;
		}

		$previous_arrow_icon            = '';
		$next_arrow_icon                = '';
		$is_new                         = empty( $settings['icon'] ) && \Elementor\Icons_Manager::is_migration_allowed();
		$previous_icon_migrated         = isset( $settings['__fa4_migrated']['crafto_previous_arrow_icon'] );
		$next_icon_migrated             = isset( $settings['__fa4_migrated']['crafto_next_arrow_icon'] );
		$crafto_navigation              = isset( $settings['crafto_navigation'] ) ? $settings['crafto_navigation'] : '';
		$crafto_pagination              = isset( $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';
		$crafto_pagination_style        = isset( $settings['crafto_pagination_style'] ) ? $settings['crafto_pagination_style'] : '';
		$crafto_pagination_number_style = isset( $settings['crafto_pagination_number_style'] ) ? $settings['crafto_pagination_number_style'] : '';

		if ( isset( $settings['crafto_previous_arrow_icon'] ) && ! empty( $settings['crafto_previous_arrow_icon'] ) ) {
			if ( $is_new || $previous_icon_migrated ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['crafto_previous_arrow_icon'], [ 'aria-hidden' => 'true' ] );
				$previous_arrow_icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_previous_arrow_icon']['value'] ) && ! empty( $settings['crafto_previous_arrow_icon']['value'] ) ) {
				$previous_arrow_icon .= '<i class="' . esc_attr( $settings['crafto_previous_arrow_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
		}

		if ( isset( $settings['crafto_next_arrow_icon'] ) && ! empty( $settings['crafto_next_arrow_icon'] ) ) {
			if ( $is_new || $next_icon_migrated ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['crafto_next_arrow_icon'], [ 'aria-hidden' => 'true' ] );
				$next_arrow_icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_next_arrow_icon']['value'] ) && ! empty( $settings['crafto_next_arrow_icon']['value'] ) ) {
				$next_arrow_icon .= '<i class="' . esc_attr( $settings['crafto_next_arrow_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
		}

		if ( 'yes' === $crafto_navigation ) {
			?>
			<div class="elementor-swiper-button elementor-swiper-button-prev">
				<?php echo $previous_arrow_icon; // phpcs:ignore ?>
				<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
			</div>
			<div class="elementor-swiper-button elementor-swiper-button-next">
				<?php echo $next_arrow_icon; // phpcs:ignore ?>
				<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'crafto-addons' ); ?></span>
			</div>
			<?php
		}

		if ( 'yes' === $crafto_pagination && 'dots' === $crafto_pagination_style ) {
			?>
			<div class="swiper-pagination"></div>
			<?php
		}

		if ( 'yes' === $crafto_pagination && 'number' === $crafto_pagination_style && 'number-style-3' !== $crafto_pagination_number_style ) {
			?>
			<div class="swiper-pagination swiper-pagination-clickable swiper-numbers"></div>
			<?php
		}

		if ( 'yes' === $crafto_pagination && 'number' === $crafto_pagination_style && 'number-style-3' === $crafto_pagination_number_style ) {
			?>
			<div class="swiper-pagination-wrapper">
				<div class="number-prev"></div>
				<div class="swiper-pagination"></div>
				<div class="number-next"></div>
			</div>
			<?php
		}
	}
}
if ( ! function_exists( 'crafto_get_post_formats_icon' ) ) {
	/**
	 * Get post formats icon.
	 *
	 * @return void
	 */
	function crafto_get_post_formats_icon() {

		$post_format           = get_post_format( get_the_ID() );
		$blog_lightbox_gallery = crafto_post_meta( 'crafto_lightbox_image' );
		$video_type_single     = crafto_post_meta( 'crafto_video_type' );

		if ( 'gallery' === $post_format && '1' === $blog_lightbox_gallery ) {
			?>
			<span class="post-icon post-type-<?php echo esc_attr( $post_format ); ?>"></span>
			<?php
		} elseif ( 'gallery' === $post_format ) {
			?>
			<span class="post-icon post-type-<?php echo esc_attr( $post_format ); ?>-slider"></span>
			<?php
		} elseif ( 'video' === $post_format && 'self' === $video_type_single ) {
			?>
			<span class="post-icon post-type-<?php echo esc_attr( $post_format ); ?>-html5"></span>
			<?php
		} elseif ( 'video' === $post_format ) {
			?>
			<span class="post-icon post-type-<?php echo esc_attr( $post_format ); ?>"></span>
			<?php
		} elseif ( 'audio' === $post_format ) {
			?>
			<span class="post-icon post-type-<?php echo esc_attr( $post_format ); ?>"></span>
			<?php
		} elseif ( 'quote' === $post_format ) {
			?>
			<span class="post-icon post-type-<?php echo esc_attr( $post_format ); ?>"></span>
			<?php
		}
	}
}
if ( ! function_exists( 'crafto_post_read_more_button' ) ) {
	/**
	 * Renders a customizable "Read More" button for posts.
	 *
	 * @param object $element Elementor widget object, used for rendering attributes and settings.
	 * @param int    $index   Index of the button, useful for differentiating multiple buttons in the same context.
	 *
	 * @return void Outputs the HTML for the "Read More" button directly.
	 */
	function crafto_post_read_more_button( $element, $index ) {
		$settings                = $element->get_settings_for_display();
		$button_style            = $settings['crafto_button_style'];
		$button_icon_align       = $settings['crafto_button_icon_align'];
		$crafto_icon_shape_style = $settings['crafto_icon_shape_style'];
		$crafto_button           = 'button_' . $index;
		$button_hover_animation  = $element->get_settings( 'crafto_button_hover_animation' );
		$crafto_read_more_text   = ( isset( $settings['crafto_read_more_text'] ) && $settings['crafto_read_more_text'] ) ? $settings['crafto_read_more_text'] : '';

		$button_link_key = 'button_link_' . $index;
		$post_format     = get_post_format( get_the_ID() );
		if ( 'link' === $post_format || has_post_format( 'link', get_the_ID() ) ) {
			if ( ! empty( $settings['crafto_portfolio_style'] ) && 'portfolio-parallax' === $settings['crafto_portfolio_style'] ) {
				$button_external_link = crafto_post_meta( 'crafto_portfolio_external_link' );
				$button_link_target   = crafto_post_meta( 'crafto_portfolio_link_target' );
			} else {
				$button_external_link = crafto_post_meta( 'crafto_post_external_link' );
				$button_link_target   = crafto_post_meta( 'crafto_post_link_target' );
			}
			$button_external_link = ( ! empty( $button_external_link ) ) ? $button_external_link : '#';
			$button_link_target   = ( ! empty( $button_link_target ) ) ? $button_link_target : '_self';
		} else {
			$button_external_link = get_permalink();
			$button_link_target   = '_self';
		}

		$element->add_render_attribute(
			$button_link_key,
			[
				'href'   => $button_external_link,
				'target' => $button_link_target,
			],
		);

		/* Button hover animation */
		$custom_animation_class       = '';
		$custom_animation_div         = '';
		$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

		if ( ! empty( $hover_animation_effect_array ) || ! empty( $settings['crafto_button_hover_animation'] ) ) {
			if ( '' === $button_style || 'border' === $button_style ) {
				$element->add_render_attribute( $crafto_button, 'class', 'elementor-animation-' . $button_hover_animation );
				$element->add_render_attribute( $crafto_button, 'class', $crafto_icon_shape_style );
			}
			if ( in_array( $button_hover_animation, $hover_animation_effect_array, true ) ) {
				$custom_animation_class = 'btn-custom-effect';
				if ( ! in_array( $button_hover_animation, array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
					$custom_animation_div = '<span class="btn-hover-animation"></span>';
				}
			}
		}
		$element->add_render_attribute( $crafto_button, 'class', $custom_animation_class );
		$element->add_render_attribute( $crafto_button, 'class', 'elementor-button-link' );

		if ( 'btn-reveal-icon' === $button_hover_animation && 'left' === $button_icon_align ) {
			$element->add_render_attribute( $crafto_button, 'class', 'btn-reveal-icon-left' );
		}

		if ( 'border' === $button_style ) {
			$element->add_render_attribute( $crafto_button, 'class', 'btn-border' );
		}

		if ( 'double-border' === $button_style ) {
			$element->add_render_attribute( $crafto_button, 'class', 'btn-double-border' );
		}

		if ( 'underline' === $button_style ) {
			$element->add_render_attribute( $crafto_button, 'class', 'btn-underline' );
		}

		if ( 'expand-border' === $button_style ) {
			$element->add_render_attribute( $crafto_button, 'class', 'elementor-animation-btn-expand-ltr' );
		}

		if ( ! empty( $settings['crafto_button_size'] ) ) {
			$element->add_render_attribute( $crafto_button, 'class', 'elementor-size-' . $settings['crafto_button_size'] );
		}

		if ( ! empty( $settings['crafto_button_icon_align'] ) ) {
			$element->add_render_attribute( $crafto_button, 'class', [ 'elementor-button', 'btn-icon-' . $settings['crafto_button_icon_align'] ] );
		}

		$element->add_render_attribute( $crafto_button, 'class', [ 'elementor-button', $crafto_button ] );
		$element->add_render_attribute( $crafto_button, 'role', 'button' );

		if ( 'expand-border' === $button_style ) {
			$custom_animation_div = '<span class="btn-hover-animation"></span>';
		}

		if ( ! empty( $crafto_read_more_text ) ) {
			?>
			<div class="elementor-button-wrapper crafto-button-wrapper">
				<a <?php $element->print_render_attribute_string( $button_link_key ); ?> <?php $element->print_render_attribute_string( $crafto_button ); ?>>
					<?php
					post_button_render_text( $element, $index );
					echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore ?>
				</a>
			</div>
			<?php
		}
	}
}
if ( ! function_exists( 'post_button_render_text' ) ) {
	/**
	 * Renders the "Read More" text for a post button.
	 *
	 * @param object $element Elementor widget object, used to fetch settings or attributes for rendering.
	 * @param int    $index   Index of the button, useful for handling multiple buttons or unique identifiers.
	 *
	 * @return void Outputs the "Read More" text directly.
	 */
	function post_button_render_text( $element, $index ) {

		$settings    = $element->get_settings_for_display();
		$widget_type = $element->get_name();

		if ( 'crafto-portfolio' === $widget_type || 'crafto-archive-portfolio' === $widget_type ) {
			if ( ! empty( $settings['crafto_portfolio_style'] ) && 'portfolio-parallax' === $settings['crafto_portfolio_style'] ) {
				$button_icon = 'crafto_portfolio_read_more_button_icon';
			}
		} else {
			$button_icon = 'crafto_post_read_more_button_icon';
		}

		$migrated       = isset( $settings['fa4_migrated'][ $button_icon ] );
		$is_new         = empty( $settings['icon'] ) && Elementor\Icons_Manager::is_migration_allowed();
		$crafto_text    = 'crafto_text' . $index;
		$crafto_icon    = 'crafto_icon' . $index;
		$crafto_content = 'crafto_content' . $index;

		if ( ! $is_new && empty( $settings['crafto_selected_icon_align'] ) ) {
			$settings['crafto_button_icon_align'] = $element->get_settings( 'crafto_button_icon_align' );
		}

		$button_hover_animation = $element->get_settings( 'crafto_button_hover_animation' );

		$element->add_render_attribute(
			[
				$crafto_content => [
					'class' => 'elementor-button-content-wrapper',
				],
				$crafto_icon    => [
					'class' => [
						'elementor-button-icon',
					],
				],
				$crafto_text    => [
					'class' => 'elementor-button-text',
				],
			]
		);
		if ( 'btn-switch-icon' !== $button_hover_animation ) {
			$element->add_render_attribute(
				[
					$crafto_icon => [
						'class' => [
							'elementor-align-icon-' . $settings['crafto_button_icon_align'],
						],
					],
				],
			);
		}
		if ( 'btn-switch-text' === $button_hover_animation ) {
			$element->add_render_attribute(
				[
					$crafto_text => [
						'data-btn-text' => wp_strip_all_tags( $settings['crafto_read_more_text'] ),
					],
				],
			);
		}
		?>
		<span <?php $element->print_render_attribute_string( $crafto_content ); ?>>
			<?php
			if ( ! empty( $settings['crafto_read_more_text'] ) ) {
				?>
				<span <?php $element->print_render_attribute_string( $crafto_text ); ?>>
					<?php
					echo sprintf( '%s', esc_html( $settings[ 'crafto_read_more_text' ] ) ); // phpcs:ignore
					?>
				</span>
				<?php
			}

			if ( ! empty( $settings['icon'] ) || ! empty( $settings[ $button_icon ]['value'] ) ) {
				?>
				<span <?php $element->print_render_attribute_string( $crafto_icon ); ?>>
					<?php
					if ( $is_new || $migrated ) {
						Elementor\Icons_Manager::render_icon( $settings[ $button_icon ], [ 'aria-hidden' => 'true' ] );
					} elseif ( isset( $settings[ $button_icon ]['value'] ) && ! empty( $settings[ $button_icon ]['value'] ) ) {
						?>
						<i class="<?php echo esc_attr( $settings[ $button_icon ]['value'] ); ?>" aria-hidden="true"></i>
						<?php
					}
					?>
				</span>
				<?php
			}

			if ( 'btn-switch-icon' === $button_hover_animation ) {
				if ( ! empty( $settings[ $button_icon ] ) || ! empty( $settings[ $button_icon ]['value'] ) ) {
					?>
					<span <?php $element->print_render_attribute_string( $crafto_icon ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Elementor\Icons_Manager::render_icon( $settings[ $button_icon ], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings[ $button_icon ]['value'] ) && ! empty( $settings[ $button_icon ]['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings[ $button_icon ]['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}
			}
			?>
		</span>
		<?php
	}
}

if ( ! function_exists( 'crafto_start_wrapper' ) ) {
	/**
	 * Starting wrapper for portfolio archive.
	 *
	 * This function initializes the wrapper for a portfolio.
	 * It is used to output the necessary opening HTML or structure
	 * for the portfolio display.
	 *
	 * @param object $element The current element or widget being rendered.
	 */
	function crafto_start_wrapper( $element ) {
		$settings                = $element->get_settings_for_display();
		$portfolio_style         = $element->get_settings( 'crafto_portfolio_style' );
		$crafto_enable_masonry   = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
		$portfolio_enable_filter = ( isset( $settings['crafto_enable_filter'] ) && $settings['crafto_enable_filter'] ) ? $settings['crafto_enable_filter'] : '';
		$style_exclude_arr       = [
			'portfolio-justified-gallery',
			'portfolio-parallax',
		];
		if ( in_array( $portfolio_style, $style_exclude_arr, true ) ) {
			?>
			<div <?php $element->print_render_attribute_string( 'wrapper' ); ?>>
			<?php
		} else {
			?>
			<ul <?php $element->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( 'yes' === $crafto_enable_masonry || 'yes' === $portfolio_enable_filter ) {

					if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
						?>
						<li class="grid-sizer p-0 m-0"></li>
						<?php
					}
				}
				?>
			<?php
		}
	}
}
if ( ! function_exists( 'crafto_end_wrapper' ) ) {
	/**
	 * Ends the portfolio archive wrapper.
	 *
	 * This function is executed to finalize the wrapper for a portfolio.
	 * It is conditionally declared to avoid redeclaring if it already exists.
	 *
	 * @param object $element The current element or widget being rendered.
	 */
	function crafto_end_wrapper( $element ) {
		$portfolio_style   = $element->get_settings( 'crafto_portfolio_style' );
		$style_exclude_arr = [
			'portfolio-justified-gallery',
			'portfolio-parallax',
		];

		if ( in_array( $portfolio_style, $style_exclude_arr, true ) ) {
			?>
			</div>
			<?php
		} else {
			?>
			</ul>
			<?php
		}
	}
}
if ( ! function_exists( 'crafto_get_portfolio_thumbnail' ) ) {
	/**
	 * Display portfolio archive thumbnail.
	 *
	 * @param array $settings An array of thumbnail settings.
	 */
	function crafto_get_portfolio_thumbnail( $settings ) {

		$post_thumbanail  = '';
		$crafto_thumbnail = $settings['crafto_thumbnail'];

		if ( has_post_thumbnail() ) {
			$post_thumbanail = get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail );
		} else {
			$alt = sprintf( '%1$s %2$s', esc_html__( 'Portfolio Image', 'crafto-addons' ), get_the_ID() );

			$post_thumbanail = sprintf(
				'<img src="%1$s" alt="%2$s" />',
				Elementor\Utils::get_placeholder_image_src(),
				$alt // phpcs:ignore
			);
		}
		echo sprintf( '%s', $post_thumbanail ); // phpcs:ignore
	}
}
if ( ! function_exists( 'portfolio_filter' ) ) {
	/**
	 * Generates and outputs the portfolio filter widget HTML on the frontend.
	 *
	 * @param array  $settings An array of widget settings.
	 * @param object $element  The Elementor element object or similar.
	 *
	 * @return void This function directly outputs the HTML content and does not return a value.
	 */
	function portfolio_filter( $settings, $element ) {

		$portfolio_filter_type_selection = ( isset( $settings['crafto_portfolio_filter_type_selection'] ) && $settings['crafto_portfolio_filter_type_selection'] ) ? $settings['crafto_portfolio_filter_type_selection'] : 'portfolio-category';
		$categories_list                 = ( isset( $settings['crafto_categories_list'] ) && $settings['crafto_categories_list'] ) ? $settings['crafto_categories_list'] : [];
		$tags_list                       = ( isset( $settings['crafto_tags_list'] ) && $settings['crafto_tags_list'] ) ? $settings['crafto_tags_list'] : [];
		$show_all_text_filter            = ( isset( $settings['crafto_show_all_text_filter'] ) && $settings['crafto_show_all_text_filter'] ) ? $settings['crafto_show_all_text_filter'] : '';
		$default_category_selected       = ( isset( $settings['crafto_default_category_selected'] ) && $settings['crafto_default_category_selected'] ) ? $settings['crafto_default_category_selected'] : '';
		$default_tags_selected           = ( isset( $settings['crafto_default_tags_selected'] ) && $settings['crafto_default_tags_selected'] ) ? $settings['crafto_default_tags_selected'] : '';
		$show_all_label                  = ( isset( $settings['crafto_show_all_label'] ) && $settings['crafto_show_all_label'] ) ? $settings['crafto_show_all_label'] : '';
		$portfolio_categories_orderby    = ( isset( $settings['crafto_portfolio_categories_orderby'] ) && $settings['crafto_portfolio_categories_orderby'] ) ? $settings['crafto_portfolio_categories_orderby'] : '';
		$portfolio_categories_order      = ( isset( $settings['crafto_portfolio_categories_order'] ) && $settings['crafto_portfolio_categories_order'] ) ? $settings['crafto_portfolio_categories_order'] : '';
		$portfolio_heading               = ( isset( $settings['crafto_portfolio_heading'] ) && $settings['crafto_portfolio_heading'] ) ? $settings['crafto_portfolio_heading'] : '';

		$query_args = [];

		if ( 'portfolio-tags' === $portfolio_filter_type_selection ) {
			$categories_to_display_ids = ( ! empty( $tags_list ) ) ? $tags_list : [];
		} else {
			$categories_to_display_ids = ( ! empty( $categories_list ) ) ? $categories_list : [];
		}

		// If no categories are chosen or "All categories", we need to load all available categories.
		if ( ! is_array( $categories_to_display_ids ) || 0 === count( $categories_to_display_ids ) ) {
			$terms = get_terms( $portfolio_filter_type_selection );
			if ( ! is_array( $categories_to_display_ids ) ) {
				$categories_to_display_ids = [];
			}

			foreach ( $terms as $term ) {
				$categories_to_display_ids[] = $term->slug;
			}
		} else {
			$categories_to_display_ids = array_values( $categories_to_display_ids );
		}

		if ( ! empty( $categories_to_display_ids ) ) {
			$query_args['slug'] = $categories_to_display_ids;
		}
		if ( ! empty( $portfolio_categories_orderby ) ) {
			$query_args['orderby'] = $portfolio_categories_orderby;
		}
		if ( ! empty( $portfolio_categories_order ) ) {
			$query_args['order'] = $portfolio_categories_order;
		}

		if ( ! empty( $portfolio_filter_type_selection ) ) {
			$query_args['taxonomy'] = $portfolio_filter_type_selection;
		}

		$tax_terms = get_terms( $query_args );

		if ( is_array( $tax_terms ) && count( $tax_terms ) === 0 ) {
			return;
		}

		$element->add_render_attribute(
			'filter_wrapper',
			[
				'class' => [
					'grid-filter',
					'nav',
					'nav-tabs',
				],
			]
		);
		?>
		<div class="filter-wrap">
			<?php
			if ( ! empty( $portfolio_heading ) ) {
				?>
				<<?php echo $element->get_settings( 'crafto_portfolio_heading_size' ); // phpcs:ignore ?>  class="portfolio-heading">
					<?php echo esc_html( $portfolio_heading ); ?>
				</<?php echo $element->get_settings( 'crafto_portfolio_heading_size' ); // phpcs:ignore ?>>
				<?php
			}
			?>
			<ul <?php $element->print_render_attribute_string( 'filter_wrapper' ); ?>>
				<?php
				$active_class = '';
				if ( 'portfolio-tags' === $portfolio_filter_type_selection ) {
					if ( 'yes' === $show_all_text_filter ) {
						$active_class = empty( $default_tags_selected ) ? 'active' : '';
					}
				} else {
					if ( 'yes' === $show_all_text_filter ) {
						$active_class = empty( $default_category_selected ) ? 'active' : '';
					}
				}

				$element->add_render_attribute(
					'filter_li',
					[
						'class' => [
							'nav',
							$active_class,
						],
					]
				);
				$element->add_render_attribute(
					'filter_a',
					[
						'data-filter' => '*',
					]
				);

				if ( 'yes' === $show_all_text_filter ) {
					?>
					<li <?php $element->print_render_attribute_string( 'filter_li' ); ?>>
						<span <?php $element->print_render_attribute_string( 'filter_a' ); ?>>
							<?php echo esc_html( $show_all_label ); ?>
						</span>
					</li>
					<?php
				}

				foreach ( $tax_terms as $index => $tax_term ) {
					$active_class  = '';
					$filter_li_key = 'filter_li' . $index;
					$filter_a_key  = 'filter_a' . $index;

					if ( 'portfolio-tags' === $portfolio_filter_type_selection ) {
						$active_class = ( $default_tags_selected === $tax_term->slug ) ? 'active' : '';
					} else {
						$active_class = ( $default_category_selected === $tax_term->slug ) ? 'active' : '';
					}
					$element->add_render_attribute(
						$filter_li_key,
						[
							'class' => [
								'nav',
								$active_class,
							],
						]
					);
					$element->add_render_attribute(
						$filter_a_key,
						[
							'data-filter' => '.portfolio-filter-' . $tax_term->term_id,
						]
					);

					?>
					<li <?php $element->print_render_attribute_string( $filter_li_key ); ?>>
						<span <?php $element->print_render_attribute_string( $filter_a_key ); ?>>
							<?php echo esc_html( $tax_term->name ); ?>
						</span>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
			CraftoAddons\Controls\Groups\Button_Group_Control::render_button_content( $element, 'primary' );
			?>
		</div>
		<?php
	}
}
if ( ! function_exists( 'crafto_property_view_details_button' ) ) {
	/**
	 * Property button.
	 *
	 * @param object $element add current value.
	 * @param array  $index   add format string.
	 *
	 * @return void
	 */
	function crafto_property_view_details_button( $element, $index ) {
		$settings                 = $element->get_settings_for_display();
		$button_key               = 'button_' . $index;
		$button_link_key          = 'button_link_' . $index;
		$button_content_key       = 'button_content_wrapper_' . $index;
		$button_text_key          = 'button_text_' . $index;
		$crafto_view_details_text = ( isset( $settings['crafto_view_details_text'] ) && $settings['crafto_view_details_text'] ) ? $settings['crafto_view_details_text'] : '';
		?>
		<div <?php $element->print_render_attribute_string( $button_key ); ?>>
			<a <?php $element->print_render_attribute_string( $button_link_key ); ?>>
				<span <?php $element->print_render_attribute_string( $button_content_key ); ?>>
					<span <?php $element->print_render_attribute_string( $button_text_key ); ?>>
						<?php echo esc_html( $crafto_view_details_text ); ?>
					</span>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'crafto_get_delay_js' ) ) {
	/**
	 * Get JS for delay settings.
	 *
	 * @return array JS list name.
	 */
	function crafto_get_delay_js() {
		$delayed_scripts = array(
			'bootstrap-tab'                      => esc_html__( 'Bootstrap Tab', 'crafto-addons' ),
			'swiper'                             => esc_html__( 'Swiper', 'crafto-addons' ),
			'magnific-popup'                     => esc_html__( 'Magnific Popup', 'crafto-addons' ),
			'atropos'                            => esc_html__( 'Atropos', 'crafto-addons' ),
			'parallax-liquid'                    => esc_html__( 'Parallax Liquid', 'crafto-addons' ),
			'mCustomScrollbar'                   => esc_html__( 'mCustomScrollbar', 'crafto-addons' ),
			'custom-parallax'                    => esc_html__( 'Custom Parallax', 'crafto-addons' ),
			'smooth-scroll'                      => esc_html__( 'Smooth Scroll', 'crafto-addons' ),
			'sticky-kit'                         => esc_html__( 'Sticky Kit', 'crafto-addons' ),
			'justified-gallery'                  => esc_html__( 'Justified Gallery', 'crafto-addons' ),
			'jquery.fitvids'                     => esc_html__( 'Fitvids', 'crafto-addons' ),
			'particles'                          => esc_html__( 'Particles', 'crafto-addons' ),
			'jquery-countdown'                   => esc_html__( 'Jquery Countdown', 'crafto-addons' ),
			'image-compare-viewer'               => esc_html__( 'Image Compare Viewer', 'crafto-addons' ),
			'lottie'                             => esc_html__( 'Lottie', 'crafto-addons' ),
			'infinite-scroll'                    => esc_html__( 'Infinite Scroll', 'crafto-addons' ),
			'comment-reply'                      => esc_html__( 'Comment Reply', 'crafto-addons' ),
			'crafto-gutenberg-block'             => esc_html__( 'Crafto Gutenberg Block', 'crafto-addons' ),
			'crafto-theme-custom-cursor'         => esc_html__( 'Theme Custom Cursor', 'crafto-addons' ),
			'crafto-magic-cursor'                => esc_html__( 'Crafto Magic Cursor', 'crafto-addons' ),
			'crafto-lightbox-gallery'            => esc_html__( 'Crafto Lightbox Gallery', 'crafto-addons' ),
			'crafto-heading-widget'              => esc_html__( 'Crafto Heading', 'crafto-addons' ),
			'crafto-search-form-widget'          => esc_html__( 'Crafto Search Form', 'crafto-addons' ),
			'crafto-accordion-widget'            => esc_html__( 'Crafto Accordion', 'crafto-addons' ),
			'crafto-progress-bar-widget'         => esc_html__( 'Crafto Progress Bar', 'crafto-addons' ),
			'crafto-video-button-widget'         => esc_html__( 'Crafto Video Button', 'crafto-addons' ),
			'crafto-hamburger-menu-widget'       => esc_html__( 'Crafto Hamburger Menu', 'crafto-addons' ),
			'crafto-popup-widget'                => esc_html__( 'Crafto Popup', 'crafto-addons' ),
			'crafto-tilt-box-widget'             => esc_html__( 'Crafto Tilt Box', 'crafto-addons' ),
			'crafto-image-widget'                => esc_html__( 'Crafto Image', 'crafto-addons' ),
			'crafto-simple-menu-widget'          => esc_html__( 'Crafto Simple Menu', 'crafto-addons' ),
			'crafto-text-editor'                 => esc_html__( 'Crafto Text Editor', 'crafto-addons' ),
			'crafto-mega-menu-widget'            => esc_html__( 'Crafto Mega Menu', 'crafto-addons' ),
			'crafto-media-gallery-widget'        => esc_html__( 'Crafto Media Gallery', 'crafto-addons' ),
			'crafto-image-gallery-widget'        => esc_html__( 'Crafto Image Gallery', 'crafto-addons' ),
			'crafto-team-member-widget'          => esc_html__( 'Crafto Team Member', 'crafto-addons' ),
			'crafto-countdown-widget'            => esc_html__( 'Crafto Countdown', 'crafto-addons' ),
			'crafto-counter-widget'              => esc_html__( 'Crafto Counter', 'crafto-addons' ),
			'crafto-tabs-widget'                 => esc_html__( 'Crafto Tabs', 'crafto-addons' ),
			'crafto-fancy-text-box-widget'       => esc_html__( 'Crafto Fancy Text Box', 'crafto-addons' ),
			'crafto-sliding-box-widget'          => esc_html__( 'Crafto Sliding Box', 'crafto-addons' ),
			'crafto-text-rotator'                => esc_html__( 'Crafto Text Rotator', 'crafto-addons' ),
			'crafto-default-carousel'            => esc_html__( 'Crafto Default Carousel', 'crafto-addons' ),
			'crafto-marquee-slider'              => esc_html__( 'Crafto Marquee Slider', 'crafto-addons' ),
			'crafto-portfolio-slider-widget'     => esc_html__( 'Crafto Portfolio Slider', 'crafto-addons' ),
			'crafto-portfolio-widget'            => esc_html__( 'Crafto Portfolio', 'crafto-addons' ),
			'crafto-horizontal-portfolio-widget' => esc_html__( 'Crafto Horizontal Portfolio', 'crafto-addons' ),
			'crafto-pie-chart-widget'            => esc_html__( 'Crafto Pie Chart', 'crafto-addons' ),
			'crafto-product-taxonomy-widget'     => esc_html__( 'Crafto Product Taxonomy', 'crafto-addons' ),
			'crafto-product-list-widget'         => esc_html__( 'Crafto Product List', 'crafto-addons' ),
			'crafto-video-widget'                => esc_html__( 'Crafto Video', 'crafto-addons' ),
			'crafto-instagram-widget'            => esc_html__( 'Crafto Instagram', 'crafto-addons' ),
			'crafto-testimonial-carousel'        => esc_html__( 'Crafto Testimonial Carousel', 'crafto-addons' ),
			'crafto-property-widget'             => esc_html__( 'Crafto Property Widget', 'crafto-addons' ),
			'crafto-blog-list-widget'            => esc_html__( 'Crafto Blog List', 'crafto-addons' ),
			'crafto-theme-gdpr'                  => esc_html__( 'Crafto Theme GDPR', 'crafto-addons' ),
			'crafto-newsletter'                  => esc_html__( 'Crafto Newsletter', 'crafto-addons' ),
			'crafto-interactive-banner'          => esc_html__( 'Crafto Interactive Banner', 'crafto-addons' ),
			'crafto-stack-section'               => esc_html__( 'Crafto Stack Section', 'crafto-addons' ),
			'crafto-particle-effect-widget'      => esc_html__( 'Crafto Particle Effect', 'crafto-addons' ),
			'crafto-text-slider-widget'          => esc_html__( 'Crafto Text Slider', 'crafto-addons' ),
			'crafto-tour-widget'                 => esc_html__( 'Crafto Tour', 'crafto-addons' ),
			'crafto-images-comparison'           => esc_html__( 'Crafto Images Comparison', 'crafto-addons' ),
			'crafto-looping-animation'           => esc_html__( 'Crafto Looping Animation', 'crafto-addons' ),
			'crafto-lottie-animation'            => esc_html__( 'Crafto Lottie Animation', 'crafto-addons' ),
			'crafto-promo-popup'                 => esc_html__( 'Crafto Promo Popup', 'crafto-addons' ),
			'crafto-theme-back-to-top'           => esc_html__( 'Crafto Theme Back To Top', 'crafto-addons' ),
			'crafto-wishlist'                    => esc_html__( 'Crafto Wishlist', 'crafto-addons' ),
			'crafto-quick-view'                  => esc_html__( 'Crafto Quick View', 'crafto-addons' ),
			'crafto-product-compare'             => esc_html__( 'Crafto Product Compare', 'crafto-addons' ),
			'crafto-woocommerce'                 => esc_html__( 'Crafto Woocommerce', 'crafto-addons' ),
			'crafto-theme-learnpress'            => esc_html__( 'Crafto Theme Learnpress', 'crafto-addons' ),
			'crafto-theme'                       => esc_html__( 'Crafto Theme', 'crafto-addons' ),
			'crafto-theme-single-portfolio'      => esc_html__( 'Crafto Theme Single Portfolio', 'crafto-addons' ),
			'crafto-addons-frontend-lite'        => esc_html__( 'Crafto Addons Frontend Lite', 'crafto-addons' ),
			'crafto-theme-comment-form'          => esc_html__( 'Crafto Theme Comment Form', 'crafto-addons' ),
			'crafto-theme-single-post'           => esc_html__( 'Crafto Theme Single Post', 'crafto-addons' ),
		);

		/**
		 * Apply filters for delay javascript so user can modify it.
		 *
		 * @since 1.0
		 */
		$crafto_additional_delayed_scripts = apply_filters( 'crafto_delay_scripts', [] );

		return array_merge( $crafto_additional_delayed_scripts, $delayed_scripts );
	}
}

/**
 * Retrieve attachment Id from file name.
 *
 * @param array $settings Settings.
 * @param array $image_size_key Image size.
 * @param array $image_key Image option.
 * @param array $default_attr add attributes.
 *
 * @access protected
 */
function crafto_get_attachment_image_html( $settings, $image_size_key = 'image', $image_key = null, $default_attr = [] ) {

	if ( ! $image_key ) {
		$image_key = $image_size_key;
	}

	$image = $image_key;

	// Old version of image settings.
	if ( ! isset( $image_size_key ) ) {
		$image_size_key = '';
	}

	$size = $image_size_key;

	$html = '';

	// If is the new version - with image size.
	$image_sizes = get_intermediate_image_sizes();

	$image_sizes[] = 'full';

	if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
		$image['id'] = '';
	}

	$is_static_render_mode = is_elementor_activated() && \Elementor\Plugin::$instance->frontend->is_static_render_mode();

	// On static mode don't use WP responsive images.
	if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) { // phpcs:ignore
		$image_attr = $default_attr;

		$html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
	} else {
		$image_src = '';

		if ( is_array( $image ) && ! empty( $image['id'] ) ) {
			$image_src = Elementor\Group_Control_Image_Size::get_attachment_image_src( $image['id'], $image_size_key, $settings );
		}

		if ( empty( $image_src ) && isset( $image['url'] ) ) {
			$image_src = $image['url'];
		}

		if ( ! empty( $image_src ) ) {
			$image_attr_html = '';
			if ( is_array( $default_attr ) ) {
				foreach ( $default_attr as $key => $value ) {
					$image_attr_html .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
				}
			}

			$image_alt          = Elementor\Control_Media::get_image_alt( $image );
			$image_title        = Elementor\Control_Media::get_image_title( $image );
			$crafto_image_alt   = $image_alt ? $image_alt : esc_attr__( 'Placeholder Image', 'crafto-addons' );
			$crafto_image_title = $image_title ? $image_title : esc_attr__( 'Placeholder Image', 'crafto-addons' );

			$html .= sprintf(
				'<img src="%1$s" title="%2$s" alt="%3$s"%4$s />',
				esc_url( $image_src ),
				$crafto_image_title,
				$crafto_image_alt,
				$image_attr_html
			);
		}
	}

	return $html;
}

add_filter(
	'wpml_pb_elementor_register_string_name_crafto-slider',
	function( $name, $args ) {
		$widget_type = $args['element']['widgetType'];
		return $widget_type . '-' . $args['key'] . '-' . $args['field'] . '-' . $args['nodeId'] . '-' . $args['item']['_id'];
	},
	10,
	2
);

add_filter(
	'wpml_pb_elementor_register_string_name_crafto-media-gallery',
	function( $name, $args ) {
		$widget_type = $args['element']['widgetType'];
		return $widget_type . '-' . $args['key'] . '-' . $args['field'] . '-' . $args['nodeId'] . '-' . $args['item']['_id'];
	},
	10,
	2
);

add_filter(
	'wpml_pb_elementor_register_string_name_crafto-content-slider',
	function( $name, $args ) {
		$widget_type = $args['element']['widgetType'];
		return $widget_type . '-' . $args['key'] . '-' . $args['field'] . '-' . $args['nodeId'] . '-' . $args['item']['_id'];
	},
	10,
	2
);

add_filter(
	'wpml_pb_elementor_register_string_name_crafto-feature-box-carousel',
	function( $name, $args ) {
		$widget_type = $args['element']['widgetType'];
		return $widget_type . '-' . $args['key'] . '-' . $args['field'] . '-' . $args['nodeId'] . '-' . $args['item']['_id'];
	},
	0,
	2
);
