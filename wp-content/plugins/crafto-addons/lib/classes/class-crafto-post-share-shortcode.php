<?php
/**
 * Post and Custom Post Type Post Share Shortcodes.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crafto_Post_Share_Shortcode' ) ) {
	/**
	 * Define `Crafto_Post_Share_Shortcode` class
	 */
	class Crafto_Post_Share_Shortcode {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_shortcode( 'crafto_single_post_share', array( $this, 'crafto_single_post_share_shortcode' ) );
			add_shortcode( 'crafto_single_portfolio_share', array( $this, 'crafto_single_portfolio_share_shortcode' ) );
		}

		/**
		 * [crafto_single_post_share] Shortcode.
		 */
		public function crafto_single_post_share_shortcode() {
			global $post;

			if ( ! $post ) {
				return false;
			}

			$permalink  = (string) get_permalink( $post->ID );
			$post_title = rawurlencode( get_the_title( $post->ID ) );

			ob_start();
			?>
			<div class="blog-details-social-sharing">
				<ul>
					<li><a class="social-sharing-icon facebook-f" href="//www.facebook.com/sharer.php?u=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><i class="fa-brands fa-facebook-f"></i><span></span></a></li>	
					<li><a class="social-sharing-icon twitter" href="//twitter.com/share?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;"  rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><i class="fa-brands fa-x-twitter"></i><span></span></a></li>
					<li><a class="social-sharing-icon linkedin-in" href="//linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" target="_blank" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;"  rel="nofollow" title="<?php echo esc_attr( $post_title ); ?>"><i class="fa-brands fa-linkedin-in"></i><span></span></a></li>
					<li><a class="social-sharing-icon pinterest-p" href="//pinterest.com/pin/create/button/?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-pinterest-p"></i><span></span></a></li>
				</ul>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * [crafto_single_portfolio_share] Shortcode.
		 */
		public static function crafto_single_portfolio_share_shortcode() {
			global $post;

			if ( ! $post ) {
				return false;
			}
			$permalink  = (string) get_permalink( $post->ID );
			$post_title = rawurlencode( get_the_title( $post->ID ) );
			ob_start();
			?>
			<div class="post-social-sharing">
				<ul>
					<li><a class="social-sharing-icon facebook-f" href="//www.facebook.com/sharer.php?u=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><i class="fa-brands fa-facebook-f"></i><span></span></a></li>	
					<li><a class="social-sharing-icon twitter" href="//twitter.com/share?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;"  rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><i class="fa-brands fa-x-twitter"></i><span></span></a></li>
					<li><a class="social-sharing-icon linkedin-in" href="//linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" target="_blank" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;"  rel="nofollow" title="<?php echo esc_attr( $post_title ); ?>"><i class="fa-brands fa-linkedin-in"></i><span></span></a></li>
					<li><a class="social-sharing-icon behance" href="//www.behance.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><i class="fa-brands fa-behance"></i><span></span></a></li>
				</ul>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * Default social media.
		 */
		public function default_social_media() {
			return [
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
			];
		}
	}

	new Crafto_Post_Share_Shortcode();
}
