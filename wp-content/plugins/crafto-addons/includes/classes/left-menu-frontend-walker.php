<?php
namespace craftoAddons\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Left_Menu_Frontend_Walker` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Left_Menu_Frontend_Walker' ) ) {

	/**
	 * Define Left_Menu_Frontend_Walker class
	 */
	class Left_Menu_Frontend_Walker extends \Walker_Nav_Menu {

		/**
		 * Holds a copy of itself, so it can be referenced by the class name.
		 *
		 * @since 1.0.0
		 *
		 * @var TGM_Plugin_Activation
		 */
		public static $instance;
		private $currentitem_id;
		public $crafto_left_menu_id;
		/**
		 * Initialize constructor.
		 */
		public function __construct() {

			global $crafto_left_menu_unique_id;
			$this->crafto_left_menu_id = $crafto_left_menu_unique_id + 0;
			++$crafto_left_menu_unique_id;
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @param string           $output Used to append additional content (passed by reference).
		 * @param array|object|int $depth   An array of arguments.
		 * @param array|object     $args   An array of arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			/**
			 * Default class.
			 */
			$classes   = array( 'sub-menu-item' );
			$classes[] = 'collapse';
			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id          = ( $this->currentitem_id->ID ) ? ' id="sub-menu-' . esc_attr( $this->currentitem_id->ID ) . '-' . esc_attr( $this->crafto_left_menu_id ) . '"' : '';

			$output .= "{$n}{$indent}<ul$id $class_names>{$n}";
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @param string           $output Used to append additional content (passed by reference).
		 * @param array|object|int $depth   An array of arguments.
		 * @param array|object     $args   An array of arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent  = str_repeat( $t, $depth );
			$output .= "$indent</ul>{$n}";
		}

		/**
		 *
		 * Starts the element output.
		 *
		 * @param string           $output Used to append additional content (passed by reference).
		 * @param object           $item   Depth of category. Used for tab indentation.
		 * @param array|object|int $depth   An array of arguments.
		 * @param array|object     $args   An array of arguments.
		 * @param array|object     $id   An array of arguments.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$link_class = array();
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent                          = ( $depth ) ? str_repeat( $t, $depth ) : '';
			$classes                         = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[]                       = 'menu-item-' . $item->ID;
			$classes[]                       = 'item-depth-' . $depth;
			$crafto_menu_item_icon           = get_post_meta( $item->ID, '_menu_item_icon', true );
			$menu_item_image_id              = get_post_meta( $item->ID, '_menu_item_svg_icon_image', true );
			$crafto_menu_item_svg_icon_image = wp_get_attachment_url( $menu_item_image_id );
			$this->currentitem_id            = $item;

			switch ( $depth ) {
				case '0':
					if ( $args->walker->has_children ) {
						$classes[] = 'dropdown';
					}
					break;
				default:
					if ( $args->walker->has_children ) {
						$classes[] = 'dropdown';
					}
					break;
			}

			/**
			 * Filters the arguments for a single nav menu item.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @param int          $item  Depth of category. Used for tab indentation.
			 * @param array|object $depth   An array of arguments.
			 * @param array|object $args   An array of arguments.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $class_names . '>';

			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : 'javascript:void(0);';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );

			$item_output = $args->before;

			$link_class      = join( ' ', apply_filters( 'crafto_left_menu_main_link_css_class', array_filter( $link_class ), $depth ) );
			$link_class_name = $link_class ? ' class="' . esc_attr( $link_class ) . '"' : '';

			$item_output .= '<a' . $attributes . ' itemprop="url" ' . $link_class_name . '>';

			if ( ! empty( $crafto_menu_item_icon ) && '' !== $crafto_menu_item_icon ) {
				if ( ! empty( $crafto_menu_item_icon ) && '' !== $crafto_menu_item_icon ) {
					$item_output .= '<i class="menu-item-icon ' . esc_attr( $crafto_menu_item_icon ) . '"></i>'; // phpcs:ignore
				} elseif ( ! empty( $crafto_menu_item_svg_icon_image ) && '' !== $crafto_menu_item_svg_icon_image ) {

					if ( ini_get( 'allow_url_fopen' ) ) {
						$file_extension = pathinfo( $crafto_menu_item_svg_icon_image, PATHINFO_EXTENSION );

						if ( 'svg' === strtolower( $file_extension ) ) {
							// phpcs:ignore
							$svg_content = file_get_contents( $crafto_menu_item_svg_icon_image );

							if ( $svg_content && strpos( $svg_content, '<svg' ) !== false ) {
								$item_output .= $svg_content;
							} else {
								$item_output .= '<img src="' . esc_url( $crafto_menu_item_svg_icon_image ) . '" alt="' . esc_attr__( 'Icon Image', 'crafto-addons' ) . '" data-no-retina="">';
							}
						} else {
							$item_output .= '<img src="' . esc_url( $crafto_menu_item_svg_icon_image ) . '" alt="' . esc_attr__( 'Icon Image', 'crafto-addons' ) . '" data-no-retina="">';
						}
					} else {
						$item_output .= '<img src="' . esc_url( $crafto_menu_item_svg_icon_image ) . '" alt="' . esc_attr__( 'Icon Image', 'crafto-addons' ) . '" data-no-retina="">';
					}
				}
			}

			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';

			// Icon Right Side.
			if ( ( 0 === $depth || 1 === $depth || 2 === $depth ) && $args->walker->has_children ) {
				$item_output .= '<span class="menu-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#sub-menu-' . esc_attr( $item->ID ) . '-' . esc_attr( $this->crafto_left_menu_id ) . '" aria-expanded="false" role="menuitem" aria-label="' . esc_attr( $title ) . '"></span>';
			}

			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 */
			$output .= apply_filters( 'crafto_left_menu_walker_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @param string       $output Used to append additional content (passed by reference).
		 * @param int          $item  Depth of category. Used for tab indentation.
		 * @param array|object $depth   An array of arguments.
		 * @param array|object $args   An array of arguments.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$output .= "</li>{$n}";
		}
		/**
		 * Returns the singleton instance of the class.
		 *
		 * @since 2.4.0
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}
