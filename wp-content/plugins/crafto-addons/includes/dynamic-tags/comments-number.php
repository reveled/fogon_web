<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post comments number.
 *
 * @package Crafto
 */

// If class `Comments_Number` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Comments_Number' ) ) {
	/**
	 * Define `Comments_Number` class.
	 */
	class Comments_Number extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'comments-number';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Comments Number', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'comment';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::NUMBER_CATEGORY,
			];
		}

		/**
		 * Register comments number controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'format_no_comments',
				[
					'label'   => esc_html__( 'No Comments Format', 'crafto-addons' ),
					'default' => esc_html__( 'No Comments', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'format_one_comments',
				[
					'label'   => esc_html__( 'One Comment Format', 'crafto-addons' ),
					'default' => esc_html__( 'One Response', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'format_many_comments',
				[
					'label'   => esc_html__( 'Many Comment Format', 'crafto-addons' ),
					'default' => esc_html__( '{number} Comments', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'link_to',
				[
					'label'   => esc_html__( 'Link', 'crafto-addons' ),
					'type'    => 'select',
					'default' => '',
					'options' => [
						''              => esc_html__( 'None', 'crafto-addons' ),
						'comments_link' => esc_html__( 'Comments Link', 'crafto-addons' ),
					],
				]
			);
		}

		/**
		 * Render comments number.
		 *
		 * @access public
		 */
		public function render() {
			$settings        = $this->get_settings();
			$comments_number = intval( get_comments_number() );

			if ( ! $comments_number ) {
				$count = $settings['format_no_comments'];
			} elseif ( 1 === $comments_number ) {
				$count = $settings['format_one_comments'];
			} else {
				$count = strtr(
					$settings['format_many_comments'],
					[
						'{number}' => number_format_i18n( $comments_number ),
					]
				);
			}

			if ( 'comments_link' === $this->get_settings( 'link_to' ) ) {
				/* translators: %1$s: comments link, %2$s: comments number */
				$count = sprintf( '<a href="%1$s">%2$s</a>', get_comments_link(), $count );
			}

			echo wp_kses_post( $count );
		}
	}
}
