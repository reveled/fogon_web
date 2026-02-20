<?php
namespace CraftoAddons\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Mega_Menu_Frontend_Walker` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Mega_Menu_Frontend_Walker' ) ) {

	/**
	 * Define Mega_Menu_Frontend_Walker class
	 */
	class Mega_Menu_Frontend_Walker extends \Walker_Nav_Menu {

		public $mega_menu_sub_status = '';

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @param string           $output Used to append additional content (passed by reference).
		 * @param array|object     $item   An array of arguments.
		 * @param array|object|int $depth   An array of arguments.
		 * @param array|object     $args   An array of arguments.
		 * @param array|object     $id   An array of arguments.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$link_class = array();

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
			} else {
				$t = "\t";
			}
			$indent    = ( $depth ) ? str_repeat( $t, $depth ) : '';
			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . esc_attr( $item->ID );
			$classes[] = 'item-depth-' . $depth;

			if ( $args->walker->has_children ) {
				$classes[] = 'dropdown';
			}

			$crafto_mega_item                = get_post_meta( $item->ID, '_crafto_menu_item', true ); // Get from "crafto-mega-menu" Post type.
			$crafto_mega_submenu_status      = get_post_meta( $item->ID, '_enable_mega_submenu', true );
			$crafto_menu_item_icon           = get_post_meta( $item->ID, '_menu_item_icon', true );
			$menu_item_image_id              = get_post_meta( $item->ID, '_menu_item_svg_icon_image', true );
			$crafto_menu_item_svg_icon_image = wp_get_attachment_url( $menu_item_image_id );
			$crafto_menu_item_icon_position  = get_post_meta( $item->ID, '_menu_item_icon_position', true );
			$crafto_menu_item_label          = get_post_meta( $item->ID, '_menu_item_label', true );
			$crafto_menu_item_label_color    = get_post_meta( $item->ID, '_menu_item_label_color', true );
			$crafto_menu_item_label_bg_color = get_post_meta( $item->ID, '_menu_item_label_bg_color', true );
			$mega_menu_parent_status         = get_post_meta( $item->menu_item_parent, '_enable_mega_submenu', true );
			$mega_menu_style_meta            = get_post_meta( $item->ID, '_mega_menu_style', true );
			$megamenu_hover_color            = get_post_meta( $item->ID, '_megamenu_hover_color', true );
			$disable_megamenu_link           = get_post_meta( $item->ID, '_disable_megamenu_link', true );
			$this->mega_menu_sub_status      = $crafto_mega_submenu_status;

			$crafto_icon_color_css     = ( ! empty( $crafto_menu_item_icon_color ) ) ? ' style="color:' . $crafto_menu_item_icon_color . '"' : '';
			$crafto_label_color_css    = ( $crafto_menu_item_label_color ) ? $label_style_array[]    = 'color:' . $crafto_menu_item_label_color . ';' : '';
			$crafto_label_bg_color_css = ( $crafto_menu_item_label_bg_color ) ? $label_style_array[] = 'background-color:' . $crafto_menu_item_label_bg_color . ';' : '';
			$label_style_attr          = ! empty( $label_style_array ) ? ' style="' . implode( '', $label_style_array ) . '"' : '';

			switch ( $depth ) {
				case '0':
					$classes[] = 'nav-item';
					if ( 'yes' === $crafto_mega_submenu_status ) {
						if ( 'full-width' === $mega_menu_style_meta ) {
							$classes[] = 'dropdown megamenu full-width-megamenu';
						} else {
							$classes[] = 'dropdown megamenu default-megamenu';
						}
					} else {
						$classes[] = 'simple-dropdown';
					}
					if ( 'yes' === $crafto_mega_submenu_status ) {
						$this->get_first_level_menu_id = $item->ID;
					}
					$link_class[] = 'nav-link';
					break;
				case '1':
					if ( $args->walker->has_children && $mega_menu_parent_status ) {
						$classes[] = 'mega-menu-li';
					}
					break;
				default:
					if ( $args->walker->has_children ) {
						$classes[] = 'dropdown';
					}
					break;
			}

			switch ( $crafto_menu_item_icon_position ) {
				case 'before':
				default:
					$link_class[] = 'before';
					break;
				case 'after':
					$link_class[] = 'after';
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
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			if ( $megamenu_hover_color && 'full-width' === $mega_menu_style_meta ) {
				$style = ' data-bs-color="' . esc_attr( $megamenu_hover_color ) . '"';
			} else {
				$style = '';
			}

			$output .= $indent . '<li' . $id . $class_names . $style . '>';

			$atts = array();

			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
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

			if ( 'yes' === $disable_megamenu_link ) {
				$link_class[] = 'disable-megamenu-yes';
			}

			$link_class      = join( ' ', apply_filters( 'crafto_mega_menu_main_link_css_class', array_filter( $link_class ), $depth ) );
			$link_class_name = $link_class ? ' class="' . esc_attr( $link_class ) . '"' : '';

			if ( 'yes' === $disable_megamenu_link ) {
				$item_output .= '<span' . $link_class_name . '>';
			} else {
				$item_output .= '<a' . $attributes . ' itemprop="url" ' . $link_class_name . '>';
			}

			if ( 'before' === $crafto_menu_item_icon_position ) {
				if ( ! empty( $crafto_menu_item_icon ) && '' !== $crafto_menu_item_icon ) {
					$item_output .= '<i class="menu-item-icon ' . esc_attr( $crafto_menu_item_icon ) . '"' . $crafto_icon_color_css . '></i>'; // phpcs:ignore
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

			if ( 'after' === $crafto_menu_item_icon_position ) {
				if ( ! empty( $crafto_menu_item_icon ) && '' !== $crafto_menu_item_icon ) {
					$item_output .= '<i class="menu-item-icon ' . esc_attr( $crafto_menu_item_icon ) . '"' . $crafto_icon_color_css . '></i>'; // phpcs:ignore
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

			if ( ! empty( $crafto_menu_item_label ) ) {
				$item_output .= '<span class="menu-item-label"' . $label_style_attr . '>' . $crafto_menu_item_label . '</span>';
			}

			if ( 'yes' === $disable_megamenu_link ) {
				$item_output .= '</span>';
			} else {
				$item_output .= '</a>';
			}

			if ( ( $depth > 0 ) && $args->walker->has_children ) {
				$item_output .= '<span class="handler"><i class="fa-solid fa-angle-right"></i></span>';
			}
			// Mobile Icon Dropdown.
			if ( $args->walker->has_children || 'yes' === $crafto_mega_submenu_status ) {
				$item_output .= '<i class="fa-solid fa-angle-down dropdown-toggle" data-bs-toggle="dropdown" aria-hidden="true"></i>';
			}

			if ( class_exists( 'Elementor\Plugin' ) && 'yes' === $crafto_mega_submenu_status ) {

				$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $crafto_mega_item );
				if ( $megamenu_hover_color && 'full-width' === $mega_menu_style_meta ) {
					$crafto_content_style = 'style="background-color:' . esc_attr( $megamenu_hover_color ) . '"';
				} else {
					$crafto_content_style = '';
				}
				if ( ! empty( $template_content ) ) {
					$item_output .= sprintf( '<div class="menu-back-div dropdown-menu megamenu-content" role="menu" ' . $crafto_content_style . '>%s</div>', do_shortcode( $template_content ) );// phpcs:ignore
				}
			}

			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @param string       $output Used to append additional content (passed by reference).
		 * @param array|object $item   An array of arguments.
		 * @param array|object $depth   An array of arguments.
		 * @param array|object $args   An array of arguments.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$n = '';
			} else {
				$n = "\n";
			}
			$output .= "</li>{$n}";
		}

		/**
		 * Ends the list of after the elements are added.
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

			/** Default class.*/
			$classes = array( 'sub-menu', 'dropdown-menu' );

			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$output .= "{$n}{$indent}<ul $class_names>{$n}";
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
	}
}
