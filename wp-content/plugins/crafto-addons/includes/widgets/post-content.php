<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Crafto widget for post content.
 *
 * @package Crafto
 */

// If class `Post_Content` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Content' ) ) {
	/**
	 * Define `Post_Content` class.
	 */
	class Post_Content extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-content';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Content', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-content crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-content/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return array Widget categories.
		 */
		public function get_categories() {
			return [
				'crafto-single',
			];
		}
		/**
		 * Get widget keywords.
		 *
		 * Retrieve the list of keywords the widget belongs to.
		 *
		 * @access public
		 *
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'post content',
				'content',
				'dynamic content',
				'post body',
				'article content',
			];
		}

		/**
		 * Register post content widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_content_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'These are dummy content, the original post content are pulled from relevant post.', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post content widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			static $did_posts   = [];
			$elementor_instance = \Elementor\Plugin::instance();
			$post               = get_post();

			if ( post_password_required( $post->ID ) ) {
				return get_the_password_form( $post->ID );
			}

			// Avoid recursion.
			if ( isset( $did_posts[ $post->ID ] ) ) {
				return;
			}

			$did_posts[ $post->ID ] = true;
			// End avoid recursion.

			$editor       = $elementor_instance->editor;
			$is_edit_mode = $editor->is_edit_mode();

			if ( ! $is_edit_mode && ! is_singular( 'themebuilder' ) ) {

				$crafto_post_format = get_post_format( get_the_ID() );
				// Include Post Format Data.
				if ( ! post_password_required() ) {
					switch ( $crafto_post_format ) {
						case 'gallery':
							include CRAFTO_ADDONS_ROOT . '/templates/single/format/loop-gallery.php';
							break;
						case 'video':
							include CRAFTO_ADDONS_ROOT . '/templates/single/format/loop-video.php';
							break;
						case 'quote':
							include CRAFTO_ADDONS_ROOT . '/templates/single/format/loop-quote.php';
							break;
						case 'audio':
							include CRAFTO_ADDONS_ROOT . '/templates/single/format/loop-audio.php';
							break;
						case 'image':
						default:
							include CRAFTO_ADDONS_ROOT . '/templates/single/format/loop-image.php';
							break;
					}
				}

				the_content();

			} else {
				echo 'This is a dummy text to demonstration purposes. It will be replaced with the post content/excerpt. <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi scelerisque luctus velit. Etiam quis quam. Duis viverra diam non justo. Suspendisse sagittis ultrices augue. Duis sapien nunc, commodo et, interdum suscipit, sollicitudin et, dolor. Donec ipsum massa, ullamcorper in, auctor et. Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Aenean placerat. Pellentesque sapien. Mauris metus. Maecenas libero. Mauris dolor felis, sagittis at, luctus sed, aliquam non, tellus. In rutrum. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Praesent in mauris eu tortor porttitor accumsan. Nunc tincidunt ante vitae massa. Curabitur bibendum justo non orci. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Curabitur vitae diam non enim vestibulum interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Et harum quidem rerum facilis est et expedita distinctio. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus.</p><p>Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Aenean placerat. Pellentesque sapien. Mauris metus. Maecenas libero. Mauris dolor felis, sagittis at, luctus sed, aliquam non, tellus. In rutrum. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Praesent in mauris eu tortor porttitor accumsan. Nunc tincidunt ante vitae massa. Curabitur bibendum justo non orci. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Curabitur vitae diam non enim vestibulum interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Et harum quidem rerum facilis est et expedita distinctio. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus.</p> End of the dummy content.';
			}

			// Restore edit mode state.
			$elementor_instance->editor->set_edit_mode( $is_edit_mode );
		}
	}
}
