<?php
/**
 * Post Like/Unlike
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Crafto_Blog_Post_Likes' ) ) {

	/**
	 * Define class
	 */
	class Crafto_Blog_Post_Likes {

		/**
		 * Construct
		 */
		public function __construct() {
			add_action( 'wp_ajax_nopriv_process_simple_like', array( $this, 'crafto_process_simple_like' ) );
			add_action( 'wp_ajax_process_simple_like', array( $this, 'crafto_process_simple_like' ) );
			add_shortcode( 'jmliker', array( $this, 'crafto_sl_shortcode' ) );
			add_action( 'show_user_profile', array( $this, 'crafto_show_user_likes' ) );
			add_action( 'edit_user_profile', array( $this, 'crafto_show_user_likes' ) );
		}

		/**
		 * Like/Unlike ajax callback function.
		 *
		 * @return void
		 */
		public function crafto_process_simple_like() {
			// Security.
			$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0; // phpcs:ignore
			if ( ! wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
				exit( esc_html__( 'Not permitted', 'crafto-addons' ) );
			}
			// Test if javascript is disabled.
			$disabled = ( true === isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] ) ? true : false; // phpcs:ignore
			// Test if this is a comment.
			$is_comment = ( 1 === isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] ) ? 1 : 0; // phpcs:ignore
			// Base variables.
			$post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : ''; // phpcs:ignore
			$result     = array();
			$post_users = null;
			$like_count = 0;
			// Get plugin options.
			if ( '' !== $post_id ) {
				$count = ( 1 === $is_comment ) ? get_comment_meta( $post_id, '_comment_like_count', true ) : get_post_meta( $post_id, '_post_like_count', true ); // like count.
				$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
				if ( ! self::crafto_already_liked( $post_id, $is_comment ) ) { // Like the post.
					if ( is_user_logged_in() ) { // user is logged in.
						$user_id    = get_current_user_id();
						$post_users = self::crafto_post_user_likes( $user_id, $post_id, $is_comment );
						if ( 1 === $is_comment ) {
							// Update User & Comment.
							$user_like_count = get_user_option( '_comment_like_count', $user_id );
							$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
							update_user_option( $user_id, '_comment_like_count', ++$user_like_count );
							if ( $post_users ) {
								update_comment_meta( $post_id, '_user_comment_liked', $post_users );
							}
						} else {
							// Update User & Post.
							$user_like_count = get_user_option( '_user_like_count', $user_id );
							$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
							update_user_option( $user_id, '_user_like_count', ++$user_like_count );
							if ( $post_users ) {
								update_post_meta( $post_id, '_user_liked', $post_users );
							}
						}
					} else { // user is anonymous.
						$user_ip    = self::crafto_sl_get_ip();
						$post_users = self::crafto_post_ip_likes( $user_ip, $post_id, $is_comment );
						// Update Post.
						if ( $post_users ) {
							if ( 1 === $is_comment ) {
								update_comment_meta( $post_id, '_user_comment_IP', $post_users );
							} else {
								update_post_meta( $post_id, '_user_IP', $post_users );
							}
						}
					}
					$like_count         = ++$count;
					$response['status'] = 'liked';
					$response['icon']   = self::crafto_get_liked_icon();
				} else { // Unlike the post.
					if ( is_user_logged_in() ) { // user is logged in.
						$user_id    = get_current_user_id();
						$post_users = self::crafto_post_user_likes( $user_id, $post_id, $is_comment );
						// Update User.
						if ( 1 === $is_comment ) {
							$user_like_count = get_user_option( '_comment_like_count', $user_id );
							$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
							if ( $user_like_count > 0 ) {
								update_user_option( $user_id, '_comment_like_count', --$user_like_count );
							}
						} else {
							$user_like_count = get_user_option( '_user_like_count', $user_id );
							$user_like_count = ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
							if ( $user_like_count > 0 ) {
								update_user_option( $user_id, '_user_like_count', --$user_like_count );
							}
						}
						// Update Post.
						if ( $post_users ) {
							$uid_key = array_search( $user_id, $post_users, true );
							unset( $post_users[ $uid_key ] );
							if ( 1 === $is_comment ) {
								update_comment_meta( $post_id, '_user_comment_liked', $post_users );
							} else {
								update_post_meta( $post_id, '_user_liked', $post_users );
							}
						}
					} else { // user is anonymous.
						$user_ip    = self::crafto_sl_get_ip();
						$post_users = self::crafto_post_ip_likes( $user_ip, $post_id, $is_comment );
						// Update Post.
						if ( $post_users ) {
							$uip_key = array_search( $user_ip, $post_users, true );
							unset( $post_users[ $uip_key ] );
							if ( 1 === $is_comment ) {
								update_comment_meta( $post_id, '_user_comment_IP', $post_users );
							} else {
								update_post_meta( $post_id, '_user_IP', $post_users );
							}
						}
					}
					$like_count         = ( $count > 0 ) ? --$count : 0; // Prevent negative number.
					$response['status'] = 'unliked';
					$response['icon']   = self::crafto_get_unliked_icon();
				}
				if ( 1 === $is_comment ) {
					update_comment_meta( $post_id, '_comment_like_count', $like_count );
					update_comment_meta( $post_id, '_comment_like_modified', date( 'Y-m-d H:i:s' ) ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
				} else {
					update_post_meta( $post_id, '_post_like_count', $like_count );
					update_post_meta( $post_id, '_post_like_modified', date( 'Y-m-d H:i:s' ) ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
				}
				$response['count']   = self::crafto_get_like_count( $like_count );
				$response['testing'] = $is_comment;
				if ( true === $disabled ) {
					if ( 1 === $is_comment ) {
						wp_safe_redirect( get_permalink( get_the_ID() ) );
						exit();
					} else {
						wp_safe_redirect( get_permalink( $post_id ) );
						exit();
					}
				} else {
					wp_send_json( $response );
				}
			}
		}

		/**
		 * Utility retrieves post meta user likes (user id array),
		 * then adds new user id to retrieved array
		 *
		 * @param mixed $user_id Widget data.
		 *
		 * @param mixed $post_id Widget data.
		 *
		 * @param mixed $is_comment Widget data.
		 *
		 * Return crafto post user likes.
		 */
		public function crafto_post_user_likes( $user_id, $post_id, $is_comment ) {
			$post_users      = '';
			$post_meta_users = ( 1 === $is_comment ) ? get_comment_meta( $post_id, '_user_comment_liked' ) : get_post_meta( $post_id, '_user_liked' );
			if ( is_array( $post_meta_users ) && count( $post_meta_users ) !== 0 ) {
				$post_users = $post_meta_users[0];
			}

			if ( ! is_array( $post_users ) ) {
				$post_users = array();
			}

			if ( ! in_array( $user_id, $post_users, true ) ) {
				$post_users[ 'user-' . $user_id ] = $user_id;
			}
			return $post_users;
		}

		/**
		 * Utility to test if the post is already liked
		 *
		 * @param mixed $post_id Widget data.
		 *
		 * @param mixed $is_comment Widget data.
		 *
		 * Return crafto already likes.
		 */
		public static function crafto_already_liked( $post_id, $is_comment ) {

			$post_users = null;
			$user_id    = null;

			if ( is_user_logged_in() ) { // user is logged in.
				$user_id         = get_current_user_id();
				$post_meta_users = ( 1 === $is_comment ) ? get_comment_meta( $post_id, '_user_comment_liked' ) : get_post_meta( $post_id, '_user_liked' );
				if ( is_array( $post_meta_users ) && count( $post_meta_users ) !== 0 ) {
					$post_users = $post_meta_users[0];
				}
			} else { // user is anonymous.
				$user_id         = self::crafto_sl_get_ip();
				$post_meta_users = ( 1 === $is_comment ) ? get_comment_meta( $post_id, '_user_comment_IP' ) : get_post_meta( $post_id, '_user_IP' );

				if ( is_array( $post_meta_users ) && count( $post_meta_users ) !== 0 ) { // meta exists, set up values.
					$post_users = $post_meta_users[0];
				}
			}

			if ( is_array( $post_users ) && in_array( $user_id, $post_users, true ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Return crafto simple likes button.
		 *
		 * @param mixed $post_id Widget data.
		 *
		 * @param mixed $is_comment Widget data.
		 *
		 * @param mixed $font_class Widget data.
		 */
		public static function crafto_get_simple_likes_button( $post_id, $is_comment = null, $font_class = null ) {

			$output     = '';
			$is_comment = ( null === $is_comment ) ? 0 : 1;
			$nonce      = wp_create_nonce( 'simple-likes-nonce' ); // Security.

			if ( 1 === $is_comment ) {
				$comment_class = esc_attr( ' sl-comment' );
				$post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
				$like_count    = get_comment_meta( $post_id, '_comment_like_count', true );
				$like_count    = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
			} else {
				$comment_class = '';
				$post_id_class = esc_attr( ' sl-button-' . $post_id );
				$like_count    = get_post_meta( $post_id, '_post_like_count', true );
				$like_count    = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
			}
			$count      = self::crafto_get_like_count( $like_count );
			$icon_empty = self::crafto_get_unliked_icon();
			$icon_full  = self::crafto_get_liked_icon();
			// Loader.
			$loader = '<span id="sl-loader"></span>';
			// Liked/Unliked Variables.
			if ( self::crafto_already_liked( $post_id, $is_comment ) ) {
				$class = ' liked' . $font_class;
				$title = esc_html__( 'Unlike', 'crafto-addons' );
				$icon  = $icon_full;
			} else {
				$class = $font_class;
				$title = esc_html__( 'Like', 'crafto-addons' );
				$icon  = $icon_empty;
			}
			$output = '<a href="' . admin_url( 'admin-ajax.php?action=process_simple_like&nonce=' . $nonce . '&post_id=' . $post_id . '&disabled=true&is_comment=' . $is_comment ) . '" class="sl-button blog-like' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . esc_attr( $title ) . '">' . $icon . $count . '</a>';

			/**
			 * Apply filters for get post liked/unliked button.
			 *
			 * @since 1.0
			 */
			return apply_filters( 'crafto_post_simple_like_button', $output );
		}

		/**
		 * Return crafto simple likes button.
		 */
		public function crafto_sl_shortcode() {
			return self::crafto_get_simple_likes_button( get_the_ID(), 0, '' );
		}

		/**
		 * Utility retrieves post meta ip likes (ip array),
		 * then adds new ip to retrieved array
		 *
		 * @param mixed $user_ip Widget data.
		 *
		 * @param mixed $post_id Widget data.
		 *
		 * @param mixed $is_comment Widget data.
		 *
		 * Return crafto post ip likes.
		 */
		public static function crafto_post_ip_likes( $user_ip, $post_id, $is_comment ) {

			$post_users      = '';
			$post_meta_users = ( 1 === $is_comment ) ? get_comment_meta( $post_id, '_user_comment_IP' ) : get_post_meta( $post_id, '_user_IP' );

			// Retrieve post information.
			if ( is_array( $post_meta_users ) && 0 !== count( $post_meta_users ) ) {
				$post_users = $post_meta_users[0];
			}
			if ( ! is_array( $post_users ) ) {
				$post_users = array();
			}
			if ( ! in_array( $user_ip, $post_users, true ) ) {
				$post_users[ 'ip-' . $user_ip ] = $user_ip;
			}
			return $post_users;
		}

		/**
		 * Utility to retrieve IP address
		 *
		 * @var string $ip Widget data.
		 *
		 * Return crafto sl get ip.
		 */
		public static function crafto_sl_get_ip() {
			if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				$ip = $_SERVER['HTTP_CLIENT_IP']; // phpcs:ignore
			} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // phpcs:ignore
			} else {
				$ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0'; // phpcs:ignore
			}
			$ip = filter_var( $ip, FILTER_VALIDATE_IP );
			$ip = ( false === $ip ) ? '0.0.0.0' : $ip;
			return $ip;
		}

		/**
		 * Utility returns the button icon for "like" action
		 *
		 * @var string $icon Widget data.
		 *
		 * Return crafto liked icon.
		 */
		public static function crafto_get_liked_icon() {
			/* If already using Font Awesome with your theme, replace svg with: <i class="icon-feather-heart-on"></i> */
			$icon = '<i class="icon-feather-heart-on"></i>';

			/**
			 * Apply filters for get post liked icon.
			 *
			 * @since 1.0
			 */
			return apply_filters( 'crafto_post_simple_liked_icon', $icon );
		}

		/**
		 * Utility returns the button icon for "unlike" action
		 *
		 * @var string $icon Widget data.
		 *
		 * Return crafto unliked icon.
		 */
		public static function crafto_get_unliked_icon() {
			/* If already using Font Awesome with your theme, replace svg with: <i class="icon-feather-heart"></i> */
			$icon = '<i class="icon-feather-heart"></i>';

			/**
			 * Apply filters for get post unliked icon.
			 *
			 * @since 1.0
			 */
			return apply_filters( 'crafto_post_simple_unliked_icon', $icon );
		}

		/**
		 * Utility function to format the button count,
		 * appending "K" if one thousand or greater,
		 * "M" if one million or greater,
		 * and "B" if one billion or greater (unlikely).
		 * $precision = how many decimal points to display (1.25K)
		 *
		 * @param mixed $number Widget data.
		 *
		 * Return crafto like count.
		 */
		public static function crafto_sl_format_count( $number ) {
			$precision = 2;
			if ( $number >= 1000 && $number < 1000000 ) {
				$formatted = number_format( $number / 1000, $precision ) . 'K';
			} elseif ( $number >= 1000000 && $number < 1000000000 ) {
				$formatted = number_format( $number / 1000000, $precision ) . 'M';
			} elseif ( $number >= 1000000000 ) {
				$formatted = number_format( $number / 1000000000, $precision ) . 'B';
			} else {
				$formatted = $number; // Number is less than 1000.
			}
			$formatted = str_replace( '.00', '', $formatted );

			if ( $number > 0 && $number < 10 ) {
				return '0' . $formatted;
			}
			return $formatted;
		}

		/**
		 * Utility retrieves count plus count options,
		 * returns appropriate format based on options
		 *
		 * @param array $like_count Widget data.
		 *
		 * Return crafto like count.
		 */
		public static function crafto_get_like_count( $like_count ) {

			$like_text = ( $like_count > 1 ) ? esc_html__( 'Likes', 'crafto-addons' ) : esc_html__( 'Like', 'crafto-addons' );

			// Check if like_count is numeric.
			if ( is_numeric( $like_count ) ) {
				$formatted_count = self::crafto_sl_format_count( $like_count );
				$number          = sprintf(
					'<span class="posts-like-count">%s</span><span class="posts-like">%s</span>',
					esc_html( $formatted_count ),
					esc_html( $like_text )
				); // phpcs:ignore
			} else {
				$number = $like_text;
			}

			return $number;
		}

		/**
		 * User Profile List.
		 *
		 * @param object $user Widget data.
		 *
		 * Return crafto show user likes.
		 */
		public function crafto_show_user_likes( $user ) {
			if ( ! isset( $user->ID ) ) {
				return; // Exit if user ID is not set.
			}
			?>
			<table class="form-table">
				<tr>
					<th>
						<label for="user_likes"><?php echo esc_html__( 'You Like:', 'crafto-addons' ); ?></label>
					</th>
					<td>
					<?php
					$types = get_post_types(
						array(
							'public' => true,
						)
					);

					$args = array(
						'numberposts'   => -1,
						'post_type'     => $types,
						'no_found_rows' => true,
						'meta_query'    => array( // phpcs:ignore
							array(
								'key'     => '_user_liked',
								'value'   => $user->ID,
								'compare' => 'LIKE',
							),
						),
					);

					$sep        = '';
					$like_query = new WP_Query( $args );
					if ( $like_query->have_posts() ) :
						?>
						<p>
							<?php
							while ( $like_query->have_posts() ) :
								$like_query->the_post();
								echo sprintf( '%s', $sep ); // phpcs:ignore ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								<?php
								$sep = ' &middot; ';
							endwhile;
							?>
						</p>
						<?php
					else :
						?>
						<p><?php echo esc_html__( 'You do not like anything yet.', 'crafto-addons' ); ?></p>
						<?php
					endif;
					wp_reset_postdata();
					?>
					</td>
				</tr>
			</table>
			<?php
		}
	}

	$crafto_blog_post_likes = new Crafto_Blog_Post_Likes();
}
