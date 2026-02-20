<?php
/**
 * Metabox Mapping
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_meta_box_text' ) ) {

	/**
	 * Meta Box Text.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_short_desc meta short description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @param mixed $crafto_placeholoder desctiption.
	 * @param mixed $crafto_parent_dependency desctiption.
	 * @since 1.0
	 */
	function crafto_meta_box_text( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_short_desc = '', $crafto_dependency = '', $crafto_placeholoder = '', $crafto_parent_dependency = '' ) {
		// Meta Prefix.
		$parent_dependency_attr = '';
		$dependency_attr        = '';
		$dependency_arr         = [];
		$parent_dependency_arr  = [];

		if ( $crafto_parent_dependency ) {
			$parent_dependency_arr[] = 'data-parent-element="' . $crafto_parent_dependency['parent-element'] . '"';
			foreach ( $crafto_parent_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$parent_dep_list         = implode( ',', $val );
			$parent_dependency_arr[] = 'data-parent-value="' . $parent_dep_list . '"';
			$parent_dependency_attr  = implode( ' ', $parent_dependency_arr );
		}
		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . $parent_dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<input type="text" id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '"  placeholder="' . $crafto_placeholoder . '" value="' . $crafto_get_post_meta . '" />';
		if ( $crafto_short_desc ) {
			$html .= '<span class="short-description">' . esc_html( $crafto_short_desc ) . '</span>';
		}
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_number' ) ) {
	/**
	 * Meta Box Text.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_short_desc meta short description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_number( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_short_desc = '', $crafto_dependency = '' ) {

		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<input type="number" id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '" value="' . $crafto_get_post_meta . '" min="0"/>';
		if ( $crafto_short_desc ) {
			$html .= '<span class="short-description">' . esc_html( $crafto_short_desc ) . '</span>';
		}
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_dropdown' ) ) {

	/**
	 * Meta Box Dropdown.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_options options.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @param mixed $crafto_parent_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_dropdown( $crafto_meta_key, $crafto_label, $crafto_options, $crafto_desc = '', $crafto_dependency = '', $crafto_parent_dependency = '' ) {
		global $post;

		// Meta Prefix.
		$parent_dependency_attr = '';
		$dependency_attr        = '';
		$dependency_arr         = [];
		$parent_dependency_arr  = [];

		if ( $crafto_parent_dependency ) {
			$parent_dependency_arr[] = 'data-parent-element="' . $crafto_parent_dependency['parent-element'] . '"';
			foreach ( $crafto_parent_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$parent_dep_list         = implode( ',', $val );
			$parent_dependency_arr[] = 'data-parent-value="' . $parent_dep_list . '"';
			$parent_dependency_attr  = implode( ' ', $parent_dependency_arr );
		}
		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		if ( 'crafto_theme_builder_template' === $crafto_meta_key ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );
		} else {
			$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );
		}

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . $parent_dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}

		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<select id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '">';
		foreach ( $crafto_options as $key => $option ) {
			$selected = ( '' !== $crafto_get_post_meta && $crafto_get_post_meta === (string) $key ) ? ' selected="selected"' : '';
			$html    .= '<option' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_dropdown_multiple' ) ) {

	/**
	 * Meta Box Dropdown Sidebar.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_options options.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_dropdown_multiple( $crafto_meta_key, $crafto_label, $crafto_options, $crafto_desc = '', $crafto_dependency = '' ) {
		global $post;
		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];
		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );
		if ( 'crafto_template_specific_post' === $crafto_meta_key && 'single-post' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_post', true );
		} elseif ( 'crafto_template_specific_exclude_post' === $crafto_meta_key && 'single-post' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_exclude_post', true );
		} elseif ( 'crafto_template_specific_portfolio' === $crafto_meta_key && 'single-portfolio' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_portfolio', true );
		} elseif ( 'crafto_template_specific_exclude_portfolio' === $crafto_meta_key && 'single-portfolio' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_exclude_portfolio', true );
		} elseif ( 'crafto_template_specific_properties' === $crafto_meta_key && 'single-properties' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_properties', true );
		} elseif ( 'crafto_template_specific_exclude_properties' === $crafto_meta_key && 'single-properties' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_exclude_properties', true );
		} elseif ( 'crafto_template_specific_tours' === $crafto_meta_key && 'single-tours' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_tours', true );
		} elseif ( 'crafto_template_specific_exclude_tours' === $crafto_meta_key && 'single-tours' === $crafto_template_type ) {
			$crafto_get_post_meta = get_post_meta( $post->ID, '_crafto_template_specific_exclude_tours', true );
		} else {
			$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );
		}

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<select class="crafto-dropdown-select2" id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '[]" multiple="multiple" style="width:46.5%;max-width:25em;">';
		foreach ( $crafto_options as $key => $option ) {
			$crafto_selected = ( is_array( $crafto_get_post_meta ) && in_array( $key, $crafto_get_post_meta ) ) ? ' selected="selected"' : ''; // phpcs:ignore
			$html           .= '<option' . $crafto_selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_textarea' ) ) {

	/**
	 * Meta Box Textarea.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_default meta default value.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_textarea( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_default = '', $crafto_dependency = '' ) {
		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<textarea cols="120" id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '">' . $crafto_get_post_meta . '</textarea>';
		$html .= '</div>';
		$html .= '</div>';

		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_codemirror' ) ) {

	/**
	 * Meta Box Textarea.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_default meta default value.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_custom_css( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_default = '', $crafto_dependency = '' ) {
		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<textarea rows="10" id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '">' . $crafto_get_post_meta . '</textarea>';
		$html .= '</div>';
		$html .= '</div>';

		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_upload' ) ) {

	/**
	 * Meta Box Upload.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @param mixed $crafto_parent_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_upload( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_dependency = '', $crafto_parent_dependency = '' ) {
		// Meta Prefix.
		$dependency_attr        = '';
		$parent_dependency_attr = '';
		$dependency_arr         = [];
		$parent_dependency_arr  = [];

		if ( $crafto_parent_dependency ) {
			$parent_dependency_arr[] = 'data-parent-element="' . $crafto_parent_dependency['parent-element'] . '"';
			foreach ( $crafto_parent_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$parent_dep_list         = implode( ',', $val );
			$parent_dependency_arr[] = 'data-parent-value="' . $parent_dep_list . '"';
			$parent_dependency_attr  = implode( ' ', $parent_dependency_arr );
		}

		if ( ! empty( $crafto_dependency ) ) {
			$val = [];

			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_meta_box_upload_img_id  = crafto_meta_box_values( $crafto_meta_key );
		$crafto_meta_box_upload_img_src = wp_get_attachment_url( $crafto_meta_box_upload_img_id );

		$cls_hidden = ( ! empty( $crafto_meta_box_upload_img_id ) ) ? '' : ' hidden';

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . $parent_dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<input name="' . $crafto_meta_key . '" class="upload_field hidden" type="text" value="' . $crafto_meta_box_upload_img_id . '" />';
		$html .= '<img class="upload_image_screenshort" src="' . $crafto_meta_box_upload_img_src . '" />';
		$html .= '<input class="crafto_upload_button" id="crafto_upload_button" type="button" value="' . esc_attr__( 'Browse', 'crafto-addons' ) . '" />';
		$html .= '<span class="crafto_remove_button button' . $cls_hidden . '">' . esc_html__( 'Remove', 'crafto-addons' ) . '</span>';
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_upload_multiple' ) ) {

	/**
	 * Meta Box Upload Multiple.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_upload_multiple( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_dependency = '' ) {
		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );
		$crafto_val           = ! empty( $crafto_get_post_meta ) ? explode( ',', $crafto_get_post_meta ) : array();

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<input name="' . $crafto_meta_key . '" class="upload_field upload_field_multiple" id="crafto_upload" type="hidden" value="' . $crafto_get_post_meta . '" />';
		$html .= '<div class="multiple_images">';

		if ( ! empty( $crafto_val ) ) {
			foreach ( $crafto_val as $key => $value ) {
				if ( ! empty( $value ) ) {
					$crafto_image_url = wp_get_attachment_url( $value );

					$html .= '<div id="' . esc_attr( $value ) . '">';
					$html .= '<img class="upload_image_screenshort_multiple" src="' . esc_url( $crafto_image_url ) . '" 	style="width:100px;" />';
					$html .= '<a href="javascript:void(0)" class="remove">' . esc_html__( 'Remove', 'crafto-addons' ) . '</a>';
					$html .= '</div>';
				}
			}
		}

		$html .= '</div>';
		$html .= '<div class="crafto_upload_button_multiple_wrap"><input class="crafto_upload_button_multiple" id="crafto_upload_button_multiple" type="button" value="' . esc_attr__( 'Browse', 'crafto-addons' ) . '" /><span>' . esc_html__( 'Select Files', 'crafto-addons' ) . '</span></div>';
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_colorpicker' ) ) {

	/**
	 * Meta Box Colorpicker.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_colorpicker( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_dependency = '' ) {
		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val = [];

			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$crafto_get_post_meta = crafto_meta_box_values( $crafto_meta_key );

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';
		$html .= '<input type="text" class="crafto-color-picker" id="' . $crafto_meta_key . '" name="' . $crafto_meta_key . '" value="' . $crafto_get_post_meta . '" />';
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_separator' ) ) {

	/**
	 * Meta Box Separator.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_short_desc meta short description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_separator( $crafto_meta_key, $crafto_label, $crafto_desc = '', $crafto_short_desc = '', $crafto_dependency = '' ) {
		// Meta Prefix.
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$html  = '<div class="' . $crafto_meta_key . '_box separator_box"' . $dependency_attr . '>';
		$html .= '<div class="meta-heading-separator">';
		$html .= '<h3>' . $crafto_label . '</h3>';
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '</div>';
		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_after_main_separator_start' ) ) {

	/**
	 * Meta Box Main Wrap Start.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_after_main_separator_start( $crafto_meta_key, $crafto_dependency = '' ) {

		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency[ 'element' ] . '"'; // phpcs:ignore
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"'; // phpcs:ignore
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		echo '<div class="' . $crafto_meta_key . '_main_content_wrap"' . $dependency_attr . '>'; // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_after_inner_separator_start' ) ) {

	/**
	 * Meta Box Inner Wrap Start.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_after_inner_separator_start( $crafto_meta_key, $crafto_dependency = '' ) {

		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency[ 'element' ] . '"'; // phpcs:ignore
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"'; // phpcs:ignore
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		echo '<div class="' . $crafto_meta_key . '_content_wrap"' . $dependency_attr . '>'; // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_before_inner_separator_end' ) ) {

	/**
	 * Meta Box Inner Wrap End.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_before_inner_separator_end( $crafto_meta_key, $crafto_dependency = '' ) {

		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val = [];

			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"'; // phpcs:ignore
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'crafto_before_main_separator_end' ) ) {

	/**
	 * Meta Box Main Wrap End.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_before_main_separator_end( $crafto_meta_key, $crafto_dependency = '' ) {

		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val = [];

			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"'; // phpcs:ignore
			$dependency_attr  = implode( ' ', $dependency_arr );
		}
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'crafto_meta_box_preload' ) ) {

	/**
	 * Meta Box Textarea.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_options meta default value.
	 * @param mixed $crafto_desc meta description.
	 * @param mixed $crafto_dependency meta dependency.
	 * @since 1.0
	 */
	function crafto_meta_box_preload( $crafto_meta_key, $crafto_label, $crafto_options, $crafto_desc = '', $crafto_dependency = '' ) {
		$dependency_attr = '';
		$dependency_arr  = [];

		if ( ! empty( $crafto_dependency ) ) {
			$val              = [];
			$dependency_arr[] = 'data-element="' . $crafto_dependency['element'] . '"';
			foreach ( $crafto_dependency['value'] as $key => $value ) {
				$val[] = $value;
			}
			$dep_list         = implode( ',', $val );
			$dependency_arr[] = 'data-value="' . $dep_list . '"';
			$dependency_attr  = implode( ' ', $dependency_arr );
		}

		$preload_resources = crafto_meta_box_values( 'crafto_preload_resources' );

		if ( empty( $preload_resources ) ) {
			$preload_resources = [
				[
					'textarea'      => '',
					'select'        => '',
					'select_device' => '',
				],
			];
		}

		$html  = '<div class="' . $crafto_meta_key . '_box description_box"' . $dependency_attr . '>';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';

		foreach ( $preload_resources as $index => $resource ) {
			$textarea_value = isset( $resource['textarea'] ) ? esc_textarea( $resource['textarea'] ) : '';
			$select_value   = isset( $resource['select'] ) ? esc_html( $resource['select'] ) : '';
			$device_value   = isset( $resource['select_device'] ) ? esc_html( $resource['select_device'] ) : ''; // Get saved device value.

			$html .= '<div class="dynamic-fields">';
			$html .= '<input type="text" id="' . $crafto_meta_key . '" name="crafto_preload_resources[' . $index . '][textarea]" value="' . $textarea_value . '" />';

			// First Dropdown.
			$html .= '<select name="crafto_preload_resources[' . $index . '][select]">';
			foreach ( $crafto_options as $key => $option ) {
				$selected = ( $select_value === (string) $key ) ? ' selected="selected"' : '';
				$html    .= '<option' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			}
			$html .= '</select>';

			// New Device Dropdown.
			$html          .= '<select name="crafto_preload_resources[' . $index . '][select_device]">';
			$device_options = [
				'all'     => esc_html__( 'All Devices', 'crafto-addons' ),
				'desktop' => esc_html__( 'Desktop', 'crafto-addons' ),
				'mobile'  => esc_html__( 'Mobile', 'crafto-addons' ),
			];
			foreach ( $device_options as $key => $option ) {
				$selected = ( $device_value === (string) $key ) ? ' selected="selected"' : '';
				$html    .= '<option' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			}
			$html .= '</select>';

			$html .= '<button class="remove-field">' . esc_html__( 'Remove', 'crafto-addons' ) . '</button>';
			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '<button class="add-field">' . esc_html__( '+ Add Preload', 'crafto-addons' ) . '</button>';
		$html .= '</div>';

		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_meta_box_dequeue_scripts' ) ) {

	/**
	 * Meta Box Dequeue Scripts Textarea.
	 *
	 * @param mixed $crafto_meta_key meta key.
	 * @param mixed $crafto_label meta label.
	 * @param mixed $crafto_desc meta description.
	 * @since 1.0
	 */
	function crafto_meta_box_dequeue_scripts( $crafto_meta_key, $crafto_label, $crafto_desc = '' ) {
		$dequeue_scripts = crafto_meta_box_values( 'crafto_dequeue_scripts' );

		if ( empty( $dequeue_scripts ) ) {
			$dequeue_scripts = [
				[
					'textarea' => '',
				],
			];
		}

		$html  = '<div class="' . $crafto_meta_key . '_box description_box">';
		$html .= '<div class="left-part">';
		$html .= $crafto_label;
		if ( ! empty( $crafto_desc ) ) {
			$html .= '<span class="description">' . $crafto_desc . '</span>';
		}
		$html .= '</div>';
		$html .= '<div class="right-part">';

		foreach ( $dequeue_scripts as $index => $scripts ) {
			$textbox_value = isset( $scripts['textarea'] ) ? esc_textarea( $scripts['textarea'] ) : '';

			$html .= '<div class="dequeue-fields">';
			$html .= '<input type="text" id="' . $crafto_meta_key . '" name="crafto_dequeue_scripts[' . $index . '][textarea]" value="' . $textbox_value . '" />';
			$html .= '<button class="remove-dequeue-field">' . esc_html__( 'Remove', 'crafto-addons' ) . '</button>';
			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '<button class="add-dequeue-field">' . esc_html__( '+ Add', 'crafto-addons' ) . '</button>';
		$html .= '</div>';

		echo sprintf( '%s', $html ); // phpcs:ignore
	}
}
