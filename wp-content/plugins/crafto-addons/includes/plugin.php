<?php
/**
 * Main Elementor `Plugin` Class
 *
 * The main class that initiates and runs the elementor plugin.
 *
 * @package Crafto
 */

namespace CraftoAddons;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin class.
 *
 * The main class that initiates and runs the addon.
 *
 * @since 1.0.0
 */
final class Plugin {

	public $modules = [];

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0
	 * @var string Minimum Elementor version required to run the addon.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.16.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0
	 * @var string Minimum PHP version required to run the addon.
	 */

	const MINIMUM_PHP_VERSION = '8.0';

	/**
	 * Theme Builder Menu slug
	 *
	 * @since 1.0
	 * @var string Theme Builder Menu slug for custom post type.
	 */

	const THEME_BUILDER_MENU_SLUG = 'edit.php?post_type=themebuilder';

	/**
	 * Instance
	 *
	 * @since 1.0
	 * @access private
	 * @static
	 * @var \Crafto_Addons\Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @access public
	 * @static
	 * @return \Crafto_Addons\Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

	/**
	 * Compatibility Checks
	 *
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function is_compatible() {
		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'crafto_check_missing_elementor' ] );
			return false;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'crafto_check_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'crafto_check_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function crafto_check_missing_elementor() {

		$plugin = 'elementor/elementor.php';

		if ( $this->crafto_is_elementor_installed() ) {

			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

			$message  = '<h3>' . esc_html__( 'Elementor Plugin Not Installed!', 'crafto-addons' ) . '</h3>';
			$message .= '<p>' . esc_html__( 'Please install and activate the Elementor plugin to unlock all the features of the Crafto Addons plugin.', 'crafto-addons' ) . '</p>';
			$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Now', 'crafto-addons' ) ) . '</p>';

		} else {

			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}

			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

			$message  = '<h3>' . esc_html__( 'Crafto Addons plugin requires installing the Elementor plugin', 'crafto-addons' ) . '</h3>';
			$message .= '<p>' . esc_html__( 'Install and activate the Elementor plugin to unlock all the features of the Crafto Addons plugin.', 'crafto-addons' ) . '</p>';
			$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Now', 'crafto-addons' ) ) . '</p>';
		}

		printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );// phpcs:ignore
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function crafto_check_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
			unset( $_GET['activate'] ); // phpcs:ignore
		}

		$message = sprintf(
			/* translators: %1$s is the Plugin name */

			/* translators: %2$s is the Elementor */

			/* translators: %3$s is the Required version */
			__( '"%1$s" requires "%2$s" version %3$s or greater.', 'crafto-addons' ),
			'<strong>' . esc_html__( 'Crafto Addons', 'crafto-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'crafto-addons' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );// phpcs:ignore
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function crafto_check_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
			unset( $_GET['activate'] ); // phpcs:ignore
		}

		$message = sprintf(
			/* translators: %1$s is the Plugin name */

			/* translators: %2$s is the PHP */

			/* translators: %3$s is the Required version */
			__( '"%1$s" requires "%2$s" version %3$s or greater.', 'crafto-addons' ),
			'<strong>' . esc_html__( 'Crafto Addons', 'crafto-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'crafto-addons' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );// phpcs:ignore
	}

	/**
	 * Initialize
	 *
	 * Load the addons functionality only after Elementor is initialized.
	 *
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function init() {

		spl_autoload_register( [ $this, 'autoload' ] );

		$this->crafto_register_modules();

		$this->add_hooks();
	}

	/**
	 * Autoload classes based on namesapce.
	 *
	 * @param string $class Class.
	 *
	 * @access public
	 */
	public function autoload( $class ) {
		// Return if Crafto name space is not set.
		if ( false === strpos( $class, __NAMESPACE__ ) ) {
			return;
		}
		/**
		 * Prepare filename.
		 *
		 * @todo Refactor to use preg_replace.
		 */
		$filename = str_replace( __NAMESPACE__ . '\\', '', $class );
		$filename = str_replace( '\\', DIRECTORY_SEPARATOR, $filename );
		$filename = str_replace( '_', '-', $filename );
		$filename = dirname( __FILE__ ) . '/' . strtolower( $filename ) . '.php';

		// Return if file is not found.
		if ( ! is_readable( $filename ) ) {
			return;
		}
		include $filename;
	}

	/**
	 * Adds required hooks
	 *
	 * @access private
	 */
	private function add_hooks() {
		/* Load templates. */
		add_action( 'wp_footer', [ $this, 'crafto_html_templates' ] );
		/* Register controls. */
		add_action( 'elementor/controls/controls_registered', [ $this, 'crafto_register_controls' ] );
		/* Register widgets. */
		add_action( 'elementor/widgets/register', [ $this, 'crafto_register_widgets' ], 15 );
		/* Unregister widgets. */
		add_action( 'elementor/widgets/register', [ $this, 'crafto_unregister_widgets' ], 15 );
		/* Register dynamic tags. */
		add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'crafto_register_dynamictags' ], 15 );
		/* Register categories. */
		add_action( 'elementor/elements/categories_registered', [ $this, 'crafto_register_categories' ], 15 );
		/* Theme Builder - Reorder admin menu order with #add_new. */
		add_action( 'admin_menu', [ $this, 'crafto_admin_menu_reorder' ], 800 );
		/* Register editor scripts. */
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'crafto_register_editor_scripts' ] );
		/* Register editor styles. */
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'crafto_register_editor_styles' ] );
		/* Register editor styles for mega menu. */
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'crafto_register_menu_editor_styles' ] );
		/* Register frontend scripts. */
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'crafto_register_front_scripts' ] );
		/* Localized settings for editor. */
		add_filter( 'elementor/editor/localize_settings', [ $this, 'crafto_localized_settings' ] );
		/* Add [crafto_highlight] shortcode. */
		add_shortcode( 'crafto_highlight', [ $this, 'crafto_highlight_shortcode' ] );
		/* Add menu in admin bar. */
		add_filter( 'elementor/frontend/admin_bar/settings', [ $this, 'crafto_add_menu_in_admin_bar' ] );
	}

	/**
	 * Add menu item in Admin bar
	 *
	 * @param array $admin_bar_config List of templates to print.
	 */
	public function crafto_add_menu_in_admin_bar( $admin_bar_config ) {
		if ( isset( $admin_bar_config['elementor_edit_page']['children'] ) && ! empty( $admin_bar_config['elementor_edit_page']['children'] ) && is_array( $admin_bar_config['elementor_edit_page']['children'] ) ) {
			foreach ( $admin_bar_config['elementor_edit_page']['children'] as $key => $value ) {
				if ( 'crafto-mega-menu' === get_post_type( $key ) ) {
					unset( $admin_bar_config['elementor_edit_page']['children'][ $key ] );
				}
			}
		}

		$admin_bar_config['elementor_edit_page']['children'][] = [
			'id'        => 'elementor_app_site_editor',
			'title'     => esc_html__( 'Crafto Theme Builder', 'crafto-addons' ),
			'sub_title' => esc_html__( 'Builder', 'crafto-addons' ),
			'href'      => admin_url( self::THEME_BUILDER_MENU_SLUG ),
			'class'     => 'crafto-app-link',
		];
		return $admin_bar_config;
	}

	/**
	 * Get array of custom html templates
	 */
	public function crafto_html_templates() {
		$templates = [
			'vertical-counter' => 'vertical-counter.html',
			'count-down'       => 'count-down.html',
			'element-section'  => 'element-section.html',
		];
		$this->crafto_print_templates_array( $templates );
	}

	/**
	 * Print templates array
	 *
	 * @param array $templates List of templates to print.
	 * @return [type][description]
	 */
	public function crafto_print_templates_array( $templates = [] ) {
		if ( empty( $templates ) ) {
			return;
		}

		foreach ( $templates as $id => $file ) {
			$file = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'template/' . $file;
			if ( ! file_exists( $file ) ) {
				continue;
			}

			ob_start();
			include $file;
			$content = ob_get_clean();
			printf( '<script type="text/html" id="tmpl-%1$s">%2$s</script>', esc_attr( $id ), $content ); // phpcs:ignore
		}
	}

	/**
	 * Register widgets with Elementor.
	 *
	 * @access public
	 *
	 * @param object $widgets_manager The controls manager.
	 */
	public function crafto_register_widgets( $widgets_manager ) {
		$widgets = preg_grep( '/^((?!index.php).)*$/', glob( CRAFTO_ADDONS_ROOT . '/includes/widgets/*.php' ) );

		// Register widgets.
		foreach ( $widgets as $widget ) {
			// Prepare widget name.
			$widget_name = basename( $widget, '.php' );
			$widget_name = str_replace( '-', '_', $widget_name );

			// Prepare class name.
			$class_name = str_replace( '-', '_', $widget_name );
			$class_name = __NAMESPACE__ . '\Widgets\\' . $class_name;

			if ( ! class_exists( $class_name ) ) {
				continue;
			}

			// Register now.
			$widgets_manager->register( new $class_name() );
		}
	}

	/**
	 * Unregister widgets with Elementor.
	 *
	 * @access public
	 *
	 * @param object $widgets_manager The controls manager.
	 */
	public function crafto_unregister_widgets( $widgets_manager ) {
		global $post;

		if ( is_admin() && ( \Elementor\Plugin::instance()->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) && 'page' === $post->post_type ) {
			$widgets = [
				'crafto-mega-menu',
				'crafto-hamburger-menu',
				'crafto-left-menu',
				'crafto-prevent-opt-popup',
				'crafto-post-navigation',
				'crafto-site-logo',
				'crafto-post-meta',
				'crafto-post-likes',
				'crafto-post-feature-image',
				'crafto-post-excerpt',
				'crafto-post-comments',
				'crafto-post-author-box',
				'crafto-post-layout',
				'crafto-left-menu-toggle',
			];

			foreach ( $widgets as $widget ) {
				$widgets_manager->unregister( $widget );
			}
		}
	}

	/**
	 * Retrieves an array of tag groups and their associated classes.
	 *
	 * @return array An array of tag groups, each containing a title and a list of class names.
	 */
	public function get_groups() {
		$tag_classes = [
			'action'  => [
				'title'   => esc_html__( 'Action', 'crafto-addons' ),
				'classes' => [
					'Popup',
					'Contact_URL',
					'Lightbox',
				],
			],
			'archive' => [
				'title'   => esc_html__( 'Archive', 'crafto-addons' ),
				'classes' => [
					'Archive_Description',
					'Archive_Meta',
					'Archive_Title',
					'Archive_URL',
				],
			],
			'author'  => [
				'title'   => esc_html__( 'Author', 'crafto-addons' ),
				'classes' => [
					'Author_Info',
					'Author_Meta',
					'Author_Name',
					'Author_URL',
					'Author_Profile_Picture',
				],
			],
			'comment' => [
				'title'   => esc_html__( 'Comment', 'crafto-addons' ),
				'classes' => [
					'Comments_Number',
					'Comments_URL',
				],
			],
			'media'   => [
				'title'   => esc_html__( 'Media', 'crafto-addons' ),
				'classes' => [
					'Featured_Image_Data',
				],
			],
			'post'    => [
				'title'   => esc_html__( 'Post', 'crafto-addons' ),
				'classes' => [
					'Post_Custom_Field',
					'Post_Date',
					'Post_Excerpt',
					'Post_ID',
					'Post_Terms',
					'Post_Time',
					'Post_Title',
					'Post_Featured_Image',
					'Post_URL',
					'Post_Gallery',
				],
			],
			'site'    => [
				'title'   => esc_html__( 'Site', 'crafto-addons' ),
				'classes' => [
					'Shortcode',
					'Request_Parameter',
					'Site_Logo',
					'Site_Tagline',
					'Site_Title',
					'Site_URL',
					'Current_Date_Time',
					'Page_Title',
					'User_Info',
					'User_Profile_Picture',
					'Internal_URL',
				],
			],
			'meta'    => [
				'title'   => esc_html__( 'Crafto Custom Meta', 'crafto-addons' ),
				'classes' => [
					'Custom_Post_Meta',
					'Custom_Post_Meta_Image',
				],
			],
		];

		if ( class_exists( 'woocommerce' ) ) {
			$tag_classes['woocommerce'] = [
				'title'   => esc_html__( 'WooCommerce', 'crafto-addons' ),
				'classes' => [
					'Category_Image',
					'Product_Gallery',
					'Product_Image',
					'Product_Price',
					'Product_Rating',
					'Product_Sale',
					'Product_Short_Description',
					'Product_SKU',
					'Product_Stock',
					'Product_Terms',
					'Product_Title',
				],
			];
		}

		if ( class_exists( '\acf' ) ) {
			$tag_classes['acf'] = [
				'title'   => esc_html__( 'ACF', 'crafto-addons' ),
				'classes' => [
					'ACF_Text',
					'ACF_Image',
					'ACF_URL',
					'ACF_Gallery',
					'ACF_File',
					'ACF_Number',
					'ACF_Color',
				],
			];
		}

		return $tag_classes;
	}

	/**
	 * Register Dynamic Tags with Elementor.
	 *
	 * @access public
	 *
	 * @param object $dynamic_tags The controls manager.
	 */
	public function crafto_register_dynamictags( $dynamic_tags ) {
		// Early return if Elementor Pro is active.
		if ( class_exists( 'ElementorPro/Plugin' ) ) {
			return;
		}

		foreach ( $this->get_groups() as $group_name => $group_title ) {
			$dynamic_tags->register_group(
				$group_name,
				[
					'title' => $group_title['title'],
				]
			);
		}

		$dynamictags = preg_grep( '/^((?!index.php).)*$/', glob( CRAFTO_ADDONS_ROOT . '/includes/dynamic-tags/*.php' ) );

		// Register dynamic tags.
		foreach ( $dynamictags as $dynamictag ) {
			// Prepare tag name.
			$tag_name = basename( $dynamictag, '.php' );
			$tag_name = str_replace( '-', '_', $tag_name );

			// Prepare class name.
			$class_name = str_replace( '-', '_', $tag_name );
			$class_name = __NAMESPACE__ . '\Dynamic_Tags\\' . $class_name;

			if ( ! class_exists( $class_name ) ) {
				continue;
			}

			// Register now.
			$dynamic_tags->register( new $class_name() );
		}
	}

	/**
	 * Get page title based on a current query.
	 *
	 * @param bool $include_context whether to prefix result with the context.
	 * @return string the page title.
	 * @since 2.5.0
	 * @access public
	 * @static
	 *
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 */
	public static function get_page_title( $include_context = true ) {
		$title = '';
		if ( is_singular() ) {
			$singular_name = get_post_type_object( get_post_type() )->labels->singular_name;
			$title         = $include_context ? $singular_name . ': ' . get_the_title() : get_the_title();

			return $title;
		}

		if ( is_search() ) {
			$title  = esc_html__( 'Search Results for: ', 'crafto-addons' ) . get_search_query();
			$title .= get_query_var( 'paged' ) ? esc_html__( '&nbsp;&ndash; Page ', 'crafto-addons' ) . get_query_var( 'paged' ) : '';

			return $title;
		}

		if ( is_category() ) {
			$title  = $include_context ? esc_html__( 'Category: ', 'crafto-addons' ) : '';
			$title .= single_cat_title( '', false );

			return $title;
		}

		if ( is_tag() ) {
			$title  = $include_context ? esc_html__( 'Tag: ', 'crafto-addons' ) : '';
			$title .= single_tag_title( '', false );

			return $title;
		}

		if ( is_author() ) {
			$title  = $include_context ? esc_html__( 'Author: ', 'crafto-addons' ) : '';
			$title .= '<span class="vcard">' . get_the_author() . '</span>';

			return $title;
		}

		if ( is_year() ) {
			$title  = $include_context ? esc_html__( 'Year: ', 'crafto-addons' ) : '';
			$title .= get_the_date( _x( 'Y', 'yearly archives date format', 'crafto-addons' ) );

			return $title;
		}

		if ( is_month() ) {
			$title  = $include_context ? esc_html__( 'Month: ', 'crafto-addons' ) : '';
			$title .= get_the_date( _x( 'F Y', 'monthly archives date format', 'crafto-addons' ) );

			return $title;
		}

		if ( is_day() ) {
			$title  = $include_context ? esc_html__( 'Day: ', 'crafto-addons' ) : '';
			$title .= get_the_date( _x( 'F j, Y', 'daily archives date format', 'crafto-addons' ) );

			return $title;
		}

		if ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				return _x( 'Asides', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				return _x( 'Galleries', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-image' ) ) {
				return _x( 'Images', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-video' ) ) {
				return _x( 'Videos', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-quote' ) ) {
				return _x( 'Quotes', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-link' ) ) {
				return _x( 'Links', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-status' ) ) {
				return _x( 'Statuses', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-audio' ) ) {
				return _x( 'Audio', 'post format archive title', 'crafto-addons' );
			}

			if ( is_tax( 'post_format', 'post-format-chat' ) ) {
				return _x( 'Chats', 'post format archive title', 'crafto-addons' );
			}
		}

		if ( is_post_type_archive() ) {
			$title  = $include_context ? esc_html__( 'Archives: ', 'crafto-addons' ) : '';
			$title .= post_type_archive_title( '', false );

			return $title;
		}

		if ( is_tax() ) {
			$tax_singular_name = get_taxonomy( get_queried_object()->taxonomy )->labels->singular_name;

			$title  = $include_context ? $tax_singular_name . ': ' : '';
			$title .= single_term_title( '', false );

			return $title;
		}

		if ( is_archive() ) {
			return esc_html__( 'Archives', 'crafto-addons' );
		}

		if ( is_404() ) {
			return esc_html__( 'Page Not Found', 'crafto-addons' );
		}

		return $title;
	}

	/**
	 * Register modules.
	 *
	 * @access public
	 */
	public function crafto_register_modules() {
		$modules = [
			'custom-icons\custom-icons',
			'custom-fonts\custom-theme-fonts',
			'mega-menu\menu',
			'classes\custom-cursor-settings',
			'classes\elementor-templates',
			'classes\mobile-full-screen-menu-options',
			'classes\mobile-modern-menu-options',
			'classes\section-extended',
			'classes\sticky-header-options',
			'classes\sticky-footer-options',
			'classes\widget-extended',
			'theme-builder\theme-builder-init',
			'theme-builder\classes\theme-builder-admin',
			'theme-builder\classes\theme-builder-elementor-canvas',
			'template-library\class-elementor-template-library-source',
			'template-library\class-elementor-template-library-manager',
		];

		foreach ( $modules as $module_name ) {
			// Prepare class name.
			$class_name = str_replace( '-', ' ', $module_name );
			$class_name = str_replace( ' ', '_', ucwords( $class_name ) );
			$class_name = __NAMESPACE__ . '\\' . $class_name;

			if ( ! class_exists( $class_name ) ) {
				continue;
			}

			// Register.
			$this->modules[ $module_name ] = new $class_name();
		}
	}

	/**
	 * Register categories with Elementor.
	 *
	 * @access public
	 *
	 * @param object $category_manager The categories manager.
	 */
	public function crafto_register_categories( $category_manager ) {
		global $post;

		$crafto_categories    = [];
		$crafto_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

		if ( isset( $post->post_type ) && ! empty( $post->post_type ) && 'themebuilder' === $post->post_type ) {
			$crafto_categories['crafto-page-title'] = [
				'title'  => esc_html__( 'Crafto Page Title', 'crafto-addons' ),
				'active' => true,
			];

			$crafto_categories['crafto-archive'] = [
				'title'  => esc_html__( 'Crafto Archive', 'crafto-addons' ),
				'active' => true,
			];

			if ( class_exists( 'Crafto_Builder_Helper' ) && ( \Crafto_Builder_Helper::is_theme_builder_all_single_template() ) ) {
				$crafto_categories['crafto-single'] = [
					'title'  => esc_html__( 'Crafto Single', 'crafto-addons' ),
					'active' => true,
				];
			}

			if ( 'header' === $crafto_template_type ) {
				$crafto_categories['crafto-header'] = [
					'title'  => esc_html__( 'Crafto Header', 'crafto-addons' ),
					'active' => true,
				];
			}
		}

		$crafto_categories['crafto'] = [
			'title'  => esc_html__( 'Crafto', 'crafto-addons' ),
			'active' => true,
		];

		$crafto_old_categories = $category_manager->get_categories();
		$crafto_categories     = array_merge( $crafto_categories, $crafto_old_categories );

		$crafto_set_categories = function ( $crafto_categories ) {
			$this->categories = $crafto_categories;
		};

		$crafto_set_categories->call( $category_manager, $crafto_categories );
	}

	/**
	 * Register submenu with Elementor.
	 *
	 * @access public
	 */
	public function crafto_admin_menu_reorder() {
		global $submenu;

		if ( ! isset( $submenu[ self::THEME_BUILDER_MENU_SLUG ] ) ) {
			return;
		}

		$library_submenu = &$submenu[ self::THEME_BUILDER_MENU_SLUG ];

		// If current use can 'Add New' - move the menu to end, and add the '#add_new' anchor.
		if ( isset( $library_submenu[10][2] ) ) {
			$library_submenu[700] = $library_submenu[10];
			unset( $library_submenu[10] );
			$library_submenu[700][2] = admin_url( self::THEME_BUILDER_MENU_SLUG . '#add_new' );
		}

		// Move the 'Categories' menu to end.
		if ( isset( $library_submenu[15] ) ) {
			$library_submenu[800] = $library_submenu[15];
			unset( $library_submenu[15] );
		}
	}

	/**
	 * Register scripts for editor
	 *
	 * @access public
	 */
	public function crafto_register_editor_scripts() {	
		$prefix = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/assets/js/editor.min.js' ) ? '.min' : '';

		wp_register_script(
			'crafto-addons-editor-script',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/editor' . $prefix . '.js',
			[
				'jquery',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			true
		);
		wp_enqueue_script( 'crafto-addons-editor-script' );

		wp_localize_script(
			'crafto-addons-editor-script',
			'CraftoEditorScript',
			[
				'ajaxurl'                         => admin_url( 'admin-ajax.php' ),
				'nonce'                           => wp_create_nonce( 'ai_image_upload_nonce' ),
				'ai_image_generation_heading'     => esc_html__( 'Generate Image With AI', 'crafto-addons' ),
				'ai_image_textarea_placeholder'   => esc_html__( 'Enter image prompt...', 'crafto-addons' ),
				'ai_image_size_label'             => esc_html__( 'Select Image Size:', 'crafto-addons' ),
				'ai_image_button_text'            => esc_html__( 'Generate', 'crafto-addons' ),
				'ai_image_prompt_empty_alert'     => esc_html__( 'Please enter the prompt name', 'crafto-addons' ),
				'ai_image_upload_failed_alert'    => esc_html__( 'Failed to upload image.', 'crafto-addons' ),
				'ai_image_generating_error_alert' => esc_html__( 'Error generating image.', 'crafto-addons' ),
				'ai_text_generating_error_alert'  => esc_html__( 'Error processing request.', 'crafto-addons' ),
				'ai_text_textarea_placeholder'    => esc_html__( 'Describe what you want.', 'crafto-addons' ),
				'ai_text_generating_button_text'  => esc_html__( 'Generate', 'crafto-addons' ),
				'ai_text_insert_button_text'      => esc_html__( 'Insert', 'crafto-addons' ),
				'ai_text_generation_heading'      => esc_html__( 'Generate Text With AI', 'crafto-addons' ),
				'ai_text_prompt_empty_alert'      => esc_html__( 'Please enter the prompt name', 'crafto-addons' ),
				'ai_button_logo_url'              => esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-ai-image-creator-logo.svg' ),
			]
		);
	}

	/**
	 * Register styles for editor
	 *
	 * @access public
	 */
	public function crafto_register_editor_styles() {
		$prefix     = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/assets/css/editor.min.css' ) ? '.min' : '';
		$rtl_prefix = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/assets/css/editor-rtl.min.css' ) ? '.min' : '';

		wp_register_style(
			'crafto-addons-editor',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/css/editor' . $prefix . '.css',
			[
				'elementor-editor',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION
		);
		wp_enqueue_style( 'crafto-addons-editor' );

		if ( is_rtl() ) {
			wp_register_style(
				'crafto-addons-editor-rtl',
				CRAFTO_ADDONS_INCLUDES_URI . '/assets/css/editor-rtl' . $rtl_prefix . '.css',
				[
					'elementor-editor',
				],
				CRAFTO_ADDONS_PLUGIN_VERSION
			);
			wp_enqueue_style( 'crafto-addons-editor-rtl' );
		}

		wp_register_style(
			'crafto-elementor-editor-style-dark',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/css/editor-drak.css',
			[
				'elementor-editor',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			'(prefers-color-scheme: dark)'
		);
		wp_enqueue_style( 'crafto-elementor-editor-style-dark' );

		wp_enqueue_script(
			'crafto-editor-ui-mode',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/crafto-editor-ui-mode.js',
			[
				'elementor-editor',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			true
		);
	}

	/**
	 * Register menu editor styles
	 *
	 * @access public
	 */
	public function crafto_register_menu_editor_styles() {
		if ( ! isset( $_REQUEST['context'] ) || 'crafto-addons' !== $_REQUEST['context'] ) { // phpcs:ignore
			return;
		}

		wp_register_style(
			'crafto-menu-editor',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/css/menu-editor.css',
			[],
			CRAFTO_ADDONS_PLUGIN_VERSION
		);
		wp_enqueue_style( 'crafto-menu-editor' );
	}

	/**
	 * Register styles for frontend
	 *
	 * @access public
	 */
	public function crafto_register_front_scripts() {
		wp_enqueue_script( 'wp-util' );
		$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

		$flag = false;
		if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_JS_DIR . '/vendors/crafto-addons-vendors.min.js' ) ) {
			$flag = true;
		}

		if ( ! $flag ) {
			if ( '0' === $crafto_disable_all_animation ) {
				if ( crafto_disable_module_by_key( 'skrollr' ) ) {
					wp_register_script(
						'skrollr',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/skrollr.js',
						[],
						'0.6.30',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/skrollr.js' ),
					);
					wp_enqueue_script( 'skrollr' );
				}

				if ( crafto_disable_module_by_key( 'anime' ) ) {
					wp_register_script(
						'anime',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/anime.min.js',					
						[],
						'3.2.2',
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/anime.min.js' ),
					);
					wp_enqueue_script( 'anime' );

					wp_register_script(
						'splitting',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/splitting.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/splitting.js' ),
					);
					wp_enqueue_script( 'splitting' );

					if ( crafto_disable_module_by_key( 'magic-cursor' ) ) {
						wp_register_script(
							'crafto-magic-cursor',
							CRAFTO_ADDONS_VENDORS_JS_URI . '/magic-cursor.js',
							[],
							CRAFTO_ADDONS_PLUGIN_VERSION,
							crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/magic-cursor.js' ),
						);
						wp_enqueue_script( 'crafto-magic-cursor' );
					}

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
						wp_enqueue_script( 'animation' );
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
						wp_enqueue_script( 'animation' );
					}

					wp_register_script(
						'floating-animation',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/floating-animation.js',
						[
							'elementor-frontend',
						],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/floating-animation.js' ),
					);
					wp_enqueue_script( 'floating-animation' );

					wp_register_script(
						'crafto-fancy-text-effect',
						CRAFTO_ADDONS_VENDORS_JS_URI . '/fancy-text-effect.js',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/fancy-text-effect.js' ),
					);
					wp_enqueue_script( 'crafto-fancy-text-effect' );
				}
			}

			if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
				wp_register_script(
					'magnific-popup',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.magnific-popup.min.js',
					[],
					'1.2.0',
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.magnific-popup.min.js' ),
				);
				wp_enqueue_script( 'magnific-popup' );
			}

			if ( crafto_disable_module_by_key( 'custom-parallax' ) ) {
				wp_register_script(
					'custom-parallax',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/custom-parallax.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/custom-parallax.js' ),
				);
				wp_enqueue_script( 'custom-parallax' );
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

			if ( crafto_disable_module_by_key( 'mCustomScrollbar' ) ) {
				wp_register_script(
					'mCustomScrollbar',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.mCustomScrollbar.concat.min.js',
					[],
					'3.1.13',
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.mCustomScrollbar.concat.min.js' ),
				);
				wp_enqueue_script( 'mCustomScrollbar' );
			}
		}

		

		$prefix_frontend = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/assets/js/frontend.min.js' ) ? '.min' : '';

		wp_register_script(
			'crafto-addons-frontend-script',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/frontend' . $prefix_frontend . '.js',
			[
				'jquery',
				'elementor-frontend',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			crafto_load_async_javascript( CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/frontend' . $prefix_frontend . '.js' ),
		);
		wp_enqueue_script( 'crafto-addons-frontend-script' );

		$prefix_frontend_lite = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/assets/js/frontend-lite.min.js' ) ? '.min' : '';

		wp_register_script(
			'crafto-addons-frontend-lite',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/frontend-lite' . $prefix_frontend_lite . '.js',
			[
				'jquery',
				'elementor-frontend',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			crafto_load_async_javascript( CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/frontend-lite' . $prefix_frontend_lite . '.js' ),
		);
		wp_enqueue_script( 'crafto-addons-frontend-lite' );

		$crafto_localize_arr = [
			'ajaxurl'                        => admin_url( 'admin-ajax.php' ),
			'site_id'                        => is_multisite() ? '-' . get_current_blog_id() : '',
			'editor_entrance_disable'        => get_theme_mod( 'crafto_disable_editor_entrance_animation', '0' ),
			'editor_scrollable_disable'      => get_theme_mod( 'crafto_disable_scrolling_animation', '0' ),
			'mobile_animation_disable'       => get_theme_mod( 'crafto_crafto_mobile_animation_disable', '0' ),
			'all_animations_disable'         => $crafto_disable_all_animation, // phpcs:ignore
			'postType'                       => get_post_type(),
			'magnific_popup_video_disableOn' => apply_filters( 'crafto_magnific_popup_video_disable', 0 ), // e.g., 400 - Popup will be disabled on screens smaller than 400px.
			'i18n'                           => [
				'likeText'   => esc_html__( 'Like', 'crafto-addons' ),
				'unlikeText' => esc_html__( 'Unlike', 'crafto-addons' ),
				'viewMore'   => esc_html__( 'View All', 'crafto-addons' ),
			],
		];

		if ( is_elementor_activated() && wp_script_is( 'elementor-frontend', 'registered' ) ) {
			wp_localize_script(
				'elementor-frontend',
				'CraftoFrontend',
				$crafto_localize_arr
			);
		} else {
			wp_localize_script(
				'crafto-addons-frontend-script',
				'CraftoFrontend',
				$crafto_localize_arr
			);
		}
	}

	/**
	 * Localize text
	 *
	 * @param array $settings Array of localize settings.
	 *
	 * @return $settings localize confing.
	 */
	public function crafto_localized_settings( $settings ) {
		$settings = array_replace_recursive(
			$settings,
			[
				'i18n' => [
					'crafto_panel_menu_item_customizer' => esc_html__( 'Theme Settings (Customizer)', 'crafto-addons' ),
				],
			]
		);

		return $settings;
	}

	/**
	 * Register controls with Elementor.
	 *
	 * @access public
	 *
	 * @param object $controls_manager The controls manager.
	 */
	public function crafto_register_controls( $controls_manager ) {
		$group_controls = preg_grep( '/^((?!index.php).)*$/', glob( CRAFTO_ADDONS_ROOT . '/includes/controls/groups/*.php' ) );
		// Register controls.
		foreach ( $group_controls as $control ) {
			// Prepare control name.
			$control_basename = basename( $control, '.php' );
			$control_name     = str_replace( '-', '_', $control_basename );

			// Prepare class name.
			$class_name = str_replace( '-', '_', $control_name );
			$class_name = __NAMESPACE__ . '\Controls\Groups\\' . $class_name;

			if ( ! class_exists( $class_name ) ) {
				continue;
			}
			// Register now.
			$controls_manager->add_group_control( $control_basename, new $class_name() );
		}

		$controls = preg_grep( '/^((?!index.php).)*$/', glob( CRAFTO_ADDONS_ROOT . '/includes/controls/*.php' ) );

		// Register controls.
		foreach ( $controls as $control ) {
			// Prepare control name.
			$control_basename = basename( $control, '.php' );
			$control_name     = str_replace( '-', '_', $control_basename );

			// Prepare class name.
			$class_name = str_replace( '-', '_', $control_name );
			$class_name = __NAMESPACE__ . '\Controls\\' . $class_name;

			if ( ! class_exists( $class_name ) ) {
				continue;
			}
			// Register now.
			$controls_manager->register( new $class_name() );
		}
	}

	/**
	 * Add shortcode here [crafto_highlight]Text[/crafto_highlight]
	 *
	 * @param array $atts the array to get the attributes from.
	 *
	 * @param null  $content content.
	 *
	 * @return string return content
	 */
	public function crafto_highlight_shortcode( $atts, $content = null ) {
		// phpcs:ignore
		extract(
			shortcode_atts(
				array(
					'color'          => '',
					'font_size'      => '',
					'letter_spacing' => '',
					'margin'         => '',
					'padding'        => '',
				),
				$atts,
			),
		);

		$inline_style = '';
		$style_atts   = [];

		if ( ! empty( $color ) || ! empty( $font_size ) || ! empty( $letter_spacing ) || ! empty( $margin ) || ! empty( $padding ) ) {
			$style_atts[] = ! empty( $color ) ? 'color:' . $color . ';' : '';
			$style_atts[] = ! empty( $font_size ) ? 'font-size:' . $font_size . ';' : '';
			$style_atts[] = ! empty( $letter_spacing ) ? 'letter-spacing:' . $letter_spacing . ';' : '';
			$style_atts[] = ! empty( $margin ) ? 'margin:' . $margin . ';' : '';
			$style_atts[] = ! empty( $padding ) ? 'padding:' . $padding . ';' : '';
			$inline_style = ! empty( $style_atts ) ? ' style="' . implode( ' ', $style_atts ) . '"' : '';

			/**
			 * Filter to change `Highlight Separator` inline CSS
			 *
			 * @since 1.0
			 */
			$crafto_style_highlight = apply_filters( 'crafto_highlight_separator_inline_style', $style_atts );

			$inline_style = ( ! empty( $style_atts ) ) ? ' style="' . implode( ' ', $crafto_style_highlight ) . '"' : '';
		}

		$output = '<span class="highlight-txt separator"' . $inline_style . '>' . esc_html( $content ) . '<span class="separator-animation horizontal-separator"></span></span>';

		return $output;
	}

	/**
	 * Crafto is elementor installed
	 */
	public function crafto_is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

Plugin::instance();
