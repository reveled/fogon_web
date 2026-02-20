<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for request parameter.
 *
 * @package Crafto
 */

// If class `Request_Parameter` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Request_Parameter' ) ) {
	/**
	 * Define `Request_Parameter` class.
	 */
	class Request_Parameter extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'request-arg';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Request Parameter', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'site';
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
				\Elementor\Modules\DynamicTags\Module::POST_META_CATEGORY,
			];
		}

		/**
		 * Register request parameter controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'request_type',
				[
					'label'   => esc_html__( 'Type', 'crafto-addons' ),
					'type'    => 'select',
					'default' => 'get',
					'options' => [
						'get'       => esc_html__( 'Get', 'crafto-addons' ),
						'post'      => esc_html__( 'Post', 'crafto-addons' ),
						'query_var' => esc_html__( 'Query Var', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'param_name',
				[
					'label' => esc_html__( 'Parameter Name', 'crafto-addons' ),
					'type'  => 'text',
				]
			);
		}

		/**
		 * Render request parameter.
		 *
		 * @access public
		 */
		public function render() {
			$settings     = $this->get_settings();
			$request_type = $settings['request_type'];
			$param_name   = $settings['param_name'];
			$value        = '';

			if ( empty( $request_type ) || empty( $param_name ) ) {
				return;
			}

			switch ( $request_type ) {
				case 'get':
					$value = filter_input( INPUT_GET, $param_name );
					break;
				case 'post':
					$value = filter_input( INPUT_POST, $param_name );
					break;
				case 'query_var':
					$value = get_query_var( $param_name );
					break;
			}

			echo htmlentities( wp_kses_post( $value ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
