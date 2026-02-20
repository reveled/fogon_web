<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class User_Info extends Tag {

	/**
	 * Retrieve the name.
	 *
	 * @access public
	 * @return string name.
	 */
	public function get_name() {
		return 'user-info';
	}

	/**
	 * Retrieve the title.
	 *
	 * @access public
	 *
	 * @return string title.
	 */
	public function get_title() {
		return esc_html__( 'User Info', 'crafto-addons' );
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
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	/**
	 * Retrieve the panel template settings.
	 *
	 * @access public
	 *
	 * @return string template key.
	 */
	public function get_panel_template_setting_key() {
		return 'type';
	}

	/**
	 * Register user info controls.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->add_control(
			'type',
			[
				'label'   => esc_html__( 'Field', 'crafto-addons' ),
				'type'    => 'select',
				'options' => [
					''             => esc_html__( 'Choose', 'crafto-addons' ),
					'id'           => esc_html__( 'ID', 'crafto-addons' ),
					'display_name' => esc_html__( 'Display Name', 'crafto-addons' ),
					'login'        => esc_html__( 'Username', 'crafto-addons' ),
					'first_name'   => esc_html__( 'First Name', 'crafto-addons' ),
					'last_name'    => esc_html__( 'Last Name', 'crafto-addons' ),
					'description'  => esc_html__( 'Bio', 'crafto-addons' ),
					'email'        => esc_html__( 'Email', 'crafto-addons' ),
					'url'          => esc_html__( 'Website', 'crafto-addons' ),
					'meta'         => esc_html__( 'User Meta', 'crafto-addons' ),
				],
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label'     => esc_html__( 'Meta Key', 'crafto-addons' ),
				'condition' => [
					'type' => 'meta',
				],
			]
		);
	}

	/**
	 * Render user info.
	 *
	 * @access public
	 */
	public function render() {
		$type = $this->get_settings( 'type' );
		$user = wp_get_current_user();

		if ( empty( $type ) || 0 === $user->ID ) {
			return;
		}

		if ( in_array( $type, [ 'login', 'email', 'url', 'nicename' ], true ) ) {
			$field = 'user_' . $type;
			echo wp_kses_post( isset( $user->$field ) ? $user->$field : '' );
			return;
		}

		if ( 'id' === $type ) {
			echo wp_kses_post( $user->ID );
			return;
		}

		if ( in_array( $type, [ 'description', 'first_name', 'last_name', 'display_name' ], true ) ) {
			echo wp_kses_post( isset( $user->$type ) ? $user->$type : '' );
			return;
		}

		if ( 'meta' === $type ) {
			$key = $this->get_settings( 'meta_key' );
			if ( ! empty( $key ) ) {
				echo wp_kses_post( get_user_meta( $user->ID, $key, true ) );
				return;
			}
		}

		echo '';
	}
}
