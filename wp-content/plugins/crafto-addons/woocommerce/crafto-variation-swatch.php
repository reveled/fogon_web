<?php
/**
 * Crafto Variation Swatch
 *
 * @package Crafto
 * @since   1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_addons_init_attribute_hooks' ) ) {
	/**
	 * To add Color & Image Attribute Hooks.
	 */
	function crafto_addons_init_attribute_hooks() {
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( empty( $attribute_taxonomies ) ) {
			return;
		}

		foreach ( $attribute_taxonomies as $tax ) {
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', 'crafto_addons_add_attribute_fields' );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', 'crafto_addons_edit_attribute_fields', 10, 2 );

			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', 'crafto_addons_add_attribute_columns' );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', 'crafto_addons_add_attribute_column_content', 10, 3 );
		}

		add_action( 'created_term', 'crafto_addons_save_attribute_fields', 10, 3 );
		add_action( 'edit_term', 'crafto_addons_save_attribute_fields', 10, 3 );
	}
}

if ( ! function_exists( 'crafto_addons_add_attribute_fields' ) ) {
	/**
	 * Add Attribute Types & Color Picker and Image Upload.
	 */
	function crafto_addons_add_attribute_fields() {
		?>
		<div class="form-field">
			<label for="term-label"><?php echo esc_html__( 'Select Type', 'crafto-addons' ); ?></label>
			<select name="crafto_attribute_type" id="crafto_attribute_type" class="crafto-attribute-type">
				<option value=""><?php echo esc_html__( 'Select Type', 'crafto-addons' ); ?></option>
				<option value="crafto_color"><?php echo esc_html__( 'Color', 'crafto-addons' ); ?></option>
				<option value="crafto_image"><?php echo esc_html__( 'Image', 'crafto-addons' ); ?></option>
			</select>
		</div>
		<div class="form-field crafto-attribute-color">
			<label for="term-label"><?php echo esc_html__( 'Select Color', 'crafto-addons' ); ?></label>
			<input type="textarea" id="crafto_attribute_color" class="crafto-color-picker" name="crafto_color" value="" />
		</div>
		<div class="form-field crafto-attribute-image">
			<label for="crafto_attribute_image"><?php echo esc_html__( 'Image', 'crafto-addons' ); ?></label>
			<input name="crafto_attribute_image" class="upload_field hidden" id="crafto_upload" type="text" value="" />
			<img class="upload_image_screenshort" src="" />
			<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
			<span class="crafto_remove_button button"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
		</div>
		<?php
	}
}

if ( ! function_exists( 'crafto_addons_edit_attribute_fields' ) ) {
	/**
	 * Edit Attribute Types & Color Picker and Image Upload.
	 *
	 * @param mixed $term get term.
	 */
	function crafto_addons_edit_attribute_fields( $term ) {
		$attribute_value  = ! empty( get_term_meta( $term->term_id, 'crafto_attribute_type', true ) ) ? get_term_meta( $term->term_id, 'crafto_attribute_type', true ) : '';
		$color_value      = ! empty( get_term_meta( $term->term_id, 'crafto_color', true ) ) ? get_term_meta( $term->term_id, 'crafto_color', true ) : '';
		$crafto_image_id  = ! empty( get_term_meta( $term->term_id, 'crafto_image', true ) ) ? get_term_meta( $term->term_id, 'crafto_image', true ) : '';
		$crafto_image_url = wp_get_attachment_url( $crafto_image_id );

		$cls_hidden = ! empty( $crafto_image_id ) ? '' : ' hidden';
		?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="crafto_attribute_type"><?php echo esc_html__( 'Attribute Type', 'crafto-addons' ); ?></label>
			</th>
			<td>
				<select name="crafto_attribute_type" id="" class="crafto-attribute-type">
					<option value="" <?php echo selected( $attribute_value, '', false ); ?>><?php echo esc_html__( 'None', 'crafto-addons' ); ?></option>
					<option value="crafto_color" <?php echo selected( $attribute_value, 'crafto_color', false ); ?>><?php echo esc_html__( 'Color', 'crafto-addons' ); ?></option>
					<option value="crafto_image" <?php echo selected( $attribute_value, 'crafto_image', false ); ?>><?php echo esc_html__( 'Image', 'crafto-addons' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field crafto-attribute-color">
			<th scope="row" valign="top">
				<label for="crafto_color"><?php echo esc_html__( 'Color', 'crafto-addons' ); ?></label>
			</th>
			<td>
				<input type="text" name="crafto_color" id="crafto_color" class="crafto-color-picker" value="<?php echo esc_attr( $color_value ); ?>">
			</td>
		</tr>
		<tr class="form-field crafto-attribute-image">
			<th scope="row" valign="top">
				<label for="crafto_image"><?php echo esc_html__( 'Image', 'crafto-addons' ); ?></label>
			</th>
			<td>
				<input name="crafto_attribute_image" class="upload_field hidden" id="crafto_upload" type="text" value="<?php echo esc_attr( $crafto_image_id ); ?>" />
				<img class="upload_image_screenshort" src="<?php echo esc_url( $crafto_image_url ); ?>" />
				<input class="crafto_upload_button_category" id="crafto_upload_button_category" type="button" value="<?php echo esc_html__( 'Browse', 'crafto-addons' ); ?>" />
				<span class="crafto_remove_button button<?php echo esc_attr( $cls_hidden ); ?>"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
			</td>
		</tr>
		<?php
	}
}

// Save Attributes.
if ( ! function_exists( 'crafto_addons_save_attribute_fields' ) ) {
	/**
	 * Edit Attribute Types & Color Picker and Image Upload.
	 *
	 * @param mixed $term_id get term ID.
	 * @param mixed $taxonomy get taxonomy.
	 */
	function crafto_addons_save_attribute_fields( $term_id, $taxonomy ) { // phpcs:ignore

		if ( isset( $_POST['crafto_attribute_type'] ) && ! is_wp_error( $_POST['crafto_attribute_type'] ) ) { // phpcs:ignore

			update_term_meta( $term_id, 'crafto_attribute_type', $_POST['crafto_attribute_type'] ); // phpcs:ignore

			if ( isset( $_POST['crafto_color'] ) ) { // phpcs:ignore
				update_term_meta( $term_id, 'crafto_color', $_POST['crafto_color'] ); // phpcs:ignore
			}

			if ( isset( $_POST['crafto_attribute_image'] ) ) { // phpcs:ignore
				update_term_meta( $term_id, 'crafto_image', $_POST['crafto_attribute_image'] ); // phpcs:ignore
			}
		}
	}
}

if ( ! function_exists( 'crafto_addons_add_attribute_columns' ) ) {
	/**
	 * Add Attribute Column In WordPress Admin.
	 *
	 * @param mixed $columns get columns.
	 */
	function crafto_addons_add_attribute_columns( $columns ) {
		$new_columns          = [];
		$new_columns['cb']    = ! empty( $columns['cb'] ) ? $columns['cb'] : '';
		$new_columns['thumb'] = '';
		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}
}

if ( ! function_exists( 'crafto_addons_add_attribute_column_content' ) ) {
	/**
	 * Add Attribute Column In WordPress Admin.
	 *
	 * @param mixed $columns get columns.
	 * @param mixed $column get column.
	 * @param mixed $term_id get term id.
	 */
	function crafto_addons_add_attribute_column_content( $columns, $column, $term_id ) {
		$attribute_value = ! empty( get_term_meta( $term_id, 'crafto_attribute_type', true ) ) ? get_term_meta( $term_id, 'crafto_attribute_type', true ) : '';

		if ( ! empty( $attribute_value ) && ! is_wp_error( $attribute_value ) ) {
			switch ( $attribute_value ) {
				case 'crafto_color':
					$value = ! empty( get_term_meta( $term_id, 'crafto_color', true ) ) ? get_term_meta( $term_id, 'crafto_color', true ) : '';
					printf( '<div class="swatch-preview swatch-color" style="background-color:%s;"></div>', esc_attr( $value ) );
					break;
				case 'crafto_image':
					$crafto_image_id  = ! empty( get_term_meta( $term_id, 'crafto_image', true ) ) ? get_term_meta( $term_id, 'crafto_image', true ) : '';
					$crafto_image_url = wp_get_attachment_url( $crafto_image_id );

					$image = $crafto_image_url ? $crafto_image_url : WC()->plugin_url() . '/assets/images/placeholder.png';
					printf( '<img class="swatch-preview swatch-image" src="%s" width="44px" height="44px">', esc_url( $image ) );
					break;
			}
		} else {
			$term = get_term( $term_id );
			printf( '<div class="swatch-preview swatch-label">%s</div>', esc_html( $term->name ) );
		}
	}
}

if ( ! function_exists( 'crafto_addons_dropdown_variation_attribute_options' ) ) {
	/**
	 * Output a list of variation attributes for use in the cart forms.
	 *
	 * @param mixed $args args.
	 */
	function crafto_addons_dropdown_variation_attribute_options( $args = [] ) {
		$args = wp_parse_args(
			apply_filters(
				'woocommerce_dropdown_variation_attribute_options_args',
				$args,
			),
			array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => esc_html__( 'Choose an option', 'crafto-addons' ),
			)
		);

		// Get selected value.
		if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
			$selected_key     = 'attribute_' . sanitize_title( $args['attribute'] );
			$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] ); // phpcs:ignore
		}

		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = ! empty( $args['class'] ) ? ' ' . $args['class'] : '';
		$show_option_none      = (bool) $args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : esc_html__( 'Choose an option', 'crafto-addons' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html = '<div class="crafto-attribute-filter alt-font' . esc_attr( $class ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms          = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);
				$crafto_tooltip = crafto_option( 'crafto_single_product_variation_swatch_tooltip', '0' );
				foreach ( $terms as $term ) {
					$attrbute_type            = get_term_meta( $term->term_taxonomy_id, 'crafto_attribute_type', true );
					$crafto_color             = get_term_meta( $term->term_taxonomy_id, 'crafto_color', true );
					$crafto_image_id          = ! empty( get_term_meta( $term->term_taxonomy_id, 'crafto_image', true ) ) ? get_term_meta( $term->term_taxonomy_id, 'crafto_image', true ) : '';
					$crafto_image_url         = wp_get_attachment_url( $crafto_image_id );
					$variation_swatch_tooltip = ( '1' === $crafto_tooltip ) ? ' data-original-title="' . esc_attr( $term->name ) . '" data-placement="top"' : '';

					if ( in_array( $term->slug, $options, true ) ) {
						if ( ! empty( $attrbute_type ) && ( ! empty( $crafto_color ) || ! empty( $crafto_image ) ) ) {
							if ( ! empty( $crafto_color ) ) {
								$active_class = sanitize_title( $args['selected'] ) === $term->slug ? ' active' : '';
								$html        .= '<div class="crafto-swatch crafto-attribute-color' . $active_class . '" style="background-color:' . $crafto_color . '"' . $variation_swatch_tooltip . 'data-value="' . esc_attr( $term->slug ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</div>';
							} elseif ( ! empty( $crafto_image_id ) ) {
								$active_class = sanitize_title( $args['selected'] ) === $term->slug ? ' active' : '';

								$html .= '<div class="crafto-swatch crafto-attribute-image' . $active_class . '" style="background-image:url(' . esc_url( $crafto_image_url ) . ')"' . $variation_swatch_tooltip . ' data-value="' . esc_attr( $term->slug ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</div>';
							}
						} else {
							$active_class = sanitize_title( $args['selected'] ) === $term->slug ? ' active' : '';
							$html        .= '<div class="crafto-swatch crafto-attribute-label' . $active_class . '"' . $variation_swatch_tooltip . 'data-value="' . esc_attr( $term->slug ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</div>';
						}
					}
				}
			} else {
				foreach ( $options as $option ) {
					$active_class = ( ( sanitize_title( $args['selected'] ) === $option ) || ( $args['selected'] === $option ) ) ? ' active' : '';
					$html        .= '<div class="crafto-swatch crafto-attribute-label' . $active_class . '" data-value="' . esc_attr( $option ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</div>';
				}
			}
		}

		$html .= '</div>';

		echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args ); // phpcs:ignore
	}
}

if ( ! function_exists( 'crafto_single_product_variation_after' ) ) {
	/**
	 * Crafto Single Product Variation After.
	 *
	 * @param mixed $options options.
	 * @param mixed $attribute_name Attribute Name.
	 * @param mixed $product Product.
	 */
	function crafto_single_product_variation_after( $options, $attribute_name, $product ) {

		$crafto_style = crafto_option( 'crafto_single_product_variation_swatch_style', 'boxed' );

		if ( 'boxed' === $crafto_style ) {
			crafto_addons_dropdown_variation_attribute_options(
				array(
					'options'   => $options,
					'attribute' => $attribute_name,
					'product'   => $product,
				)
			);
		}
	}
}

/**
 * To add Color & Image Attribute Hooks
 *
 * @see crafto_addons_init_attribute_hooks()
 */

add_action( 'admin_init', 'crafto_addons_init_attribute_hooks' );

/**
 * Variation.php file template overright
 *
 * @see crafto_single_product_variation_after()
 */
add_action( 'crafto_single_product_variation_after', 'crafto_single_product_variation_after', 10, 3 );

/**
 * To Remove bredcrumbs
 *
 * @see woocommerce_breadcrumb()
 */
function crafto_remove_breadcrumbs() {
	if ( is_product() ) {
		// Check if the breadcrumb is enabled.
		$is_breadcrumb_enabled = get_theme_mod( 'crafto_single_product_enable_title_after_breadcrumb', '1' );

		if ( '0' === $is_breadcrumb_enabled ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		}
	}
}
add_action( 'wp', 'crafto_remove_breadcrumbs' );

