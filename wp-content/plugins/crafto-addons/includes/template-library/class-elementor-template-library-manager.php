<?php
/**
 * Template Library Manager
 *
 * @package Crafto
 */

namespace CraftoAddons\Template_Library;

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Template_Library_Manager {

	protected static $source = null;
	/**
	 * Initializes the class or component.
	 */
	public static function init() {
		add_action( 'elementor/editor/footer', [ __CLASS__, 'print_template_views' ] );
		add_action( 'elementor/ajax/register_actions', [ __CLASS__, 'register_ajax_actions' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'editor_scripts' ] );
		add_action( 'elementor/preview/enqueue_styles', [ __CLASS__, 'enqueue_preview_styles' ] );
	}
	/**
	 * Prints or outputs the template views.
	 */
	public static function print_template_views() {
		if ( file_exists( CRAFTO_ADDONS_TEMPLATE_LIBRARY_PATH . '/templates.php' ) ) {
			include_once CRAFTO_ADDONS_TEMPLATE_LIBRARY_PATH . '/templates.php';
		}
	}
	/**
	 * Register editor script.
	 */
	public static function editor_scripts() {
		$prefix = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_TEMPLATE_LIBRARY_PATH . '/assets/css/template-library.min.css' ) ? '.min' : '';

		wp_enqueue_style(
			'crafto-template-library-style',
			CRAFTO_ADDONS_TEMPLATE_LIBRARY_URI . '/assets/css/template-library' . $prefix . '.css',
			[
				'elementor-editor',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION
		);

		wp_enqueue_script(
			'crafto-template-library-script',
			CRAFTO_ADDONS_TEMPLATE_LIBRARY_URI . '/assets/js/template-library.min.js',
			[
				'elementor-editor',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			true
		);

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
			'crafto-template-library-script',
			'ExclusiveAddonsEditor',
			$localized_data
		);
	}
	/**
	 * Preview style.
	 */
	public static function enqueue_preview_styles() {
		wp_enqueue_style(
			'crafto-template-preview-style',
			CRAFTO_ADDONS_TEMPLATE_LIBRARY_URI . '/assets/css/template-preview.css',
			[],
			CRAFTO_ADDONS_PLUGIN_VERSION
		);
	}

	/**
	 * Load Template library source
	 *
	 * @return Template_Library_Source
	 */
	public static function get_source() {
		if ( is_null( self::$source ) ) {
			self::$source = new Template_Library_Source();
		}

		return self::$source;
	}
	/**
	 * Register actions.
	 *
	 *  @param Ajax $ajax An instance of the `Ajax` class that manages AJAX requests and actions.
	 */
	public static function register_ajax_actions( Ajax $ajax ) {
		$ajax->register_ajax_action(
			'crafto_get_template_library_data',
			function ( $data ) {
				if ( ! current_user_can( 'edit_posts' ) ) {
					throw new \Exception( esc_html__( 'Access Denied', 'crafto-addons' ) );
				}

				if ( ! empty( $data['editor_post_id'] ) ) {
					$editor_post_id = absint( $data['editor_post_id'] );

					if ( ! get_post( $editor_post_id ) ) {
						throw new \Exception( esc_html__( 'Post not found.', 'crafto-addons' ) );
					}

					\Elementor\Plugin::instance()->db->switch_to_post( $editor_post_id );
				}

				$result = self::get_library_data( $data );

				return $result;
			},
		);

		$ajax->register_ajax_action(
			'crafto_get_template_item_data',
			function ( $data ) {
				if ( ! current_user_can( 'edit_posts' ) ) {
					throw new \Exception( 'Access Denied' );
				}

				if ( ! empty( $data['editor_post_id'] ) ) {
					$editor_post_id = absint( $data['editor_post_id'] );

					if ( ! get_post( $editor_post_id ) ) {
						throw new \Exception( esc_html__( 'Post not found', 'crafto-addons' ) );
					}

					\Elementor\Plugin::instance()->db->switch_to_post( $editor_post_id );
				}

				if ( empty( $data['template_id'] ) ) {
					throw new \Exception( esc_html__( 'Template id missing', 'crafto-addons' ) );
				}

				$result = self::get_template_data( $data );

				return $result;
			},
		);
	}
	/**
	 * Retrieves template data based on the provided arguments.
	 *
	 * @param array $args An associative array of arguments used to filter or specify the data retrieval for the template.
	 */
	public static function get_template_data( array $args ) {
		$source = self::get_source();
		$data   = $source->get_data( $args );
		return $data;
	}
	/**
	 * Retrieves library data based on the provided arguments.
	 *
	 * @param array $args An associative array of arguments used to filter or specify the data retrieval for the library.
	 */
	public static function get_library_data( array $args ) {
		$source = self::get_source();

		if ( ! empty( $args['sync'] ) ) {
			Template_Library_Source::get_library_data( true );
		}

		return [
			'templates'     => $source->get_items(),
			'category'      => $source->get_categories(),
			'type_category' => $source->get_type_category(),
		];
	}
}

Template_Library_Manager::init();
