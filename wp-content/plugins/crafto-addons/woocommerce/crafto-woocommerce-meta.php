<?php
/**
 * Crafto Woocommerce Meta.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_custom_tab_options_tab' ) ) {
	/**
	 * Crafto Custom Tab Options Tab.
	 */
	function crafto_custom_tab_options_tab() {
		?>
		<li class="custom_tab wc-special-product">
			<a href="#custom_tab_data">
				<span><?php echo esc_html__( 'Crafto Options', 'crafto-addons' ); ?></span>
			</a>
		</li>
		<?php
	}
}
add_action( 'woocommerce_product_write_panel_tabs', 'crafto_custom_tab_options_tab' );

if ( ! function_exists( 'custom_repeatable_meta_box_save' ) ) {
	/**
	 * Save Product Tab in backend.
	 *
	 * @param mixed $post_id Get ID.
	 */
	function custom_repeatable_meta_box_save( $post_id ) {
		$old_data       = get_post_meta( $post_id, '_crafto_custom_product_tab', true );
		$new_data       = array();
		$tabtitle       = ! empty( $_POST['tabdata']['tabtitle'] ) ? $_POST['tabdata']['tabtitle'] : array(); // phpcs:ignore
		$tabdescription = ! empty( $_POST['tabdata']['tabdescription'] ) ? $_POST['tabdata']['tabdescription'] : array(); // phpcs:ignore
		$tabuniquekey   = ! empty( $_POST['tabdata']['tabuniquekey'] ) ? $_POST['tabdata']['tabuniquekey'] : array(); // phpcs:ignore

		if ( ! empty( $tabtitle ) ) {
			$count = count( $tabtitle ); // Count title.

			for ( $i = 0; $i < $count; $i++ ) {
				if ( '' !== isset( $tabtitle[ $i ] ) && $tabtitle[ $i ] ) {
					$new_data[ $i ]['tabtitle']       = stripslashes( wp_strip_all_tags( $tabtitle[ $i ] ) );
					$new_data[ $i ]['tabdescription'] = stripslashes( $tabdescription[ $i ] );
					$new_data[ $i ]['tabuniquekey']   = $tabuniquekey[ $i ];
				}
			}
		}

		if ( ! empty( $new_data ) && $old_data !== $new_data ) {
			update_post_meta( $post_id, '_crafto_custom_product_tab', $new_data );
		} elseif ( empty( $new_data ) && $old_data ) {
			delete_post_meta( $post_id, '_crafto_custom_product_tab', $old_data );
		}
	}
}
add_action( 'woocommerce_process_product_meta', 'custom_repeatable_meta_box_save' );

if ( ! function_exists( 'crafto_custom_tab_options' ) ) {
	/**
	 * Crafto Custom Tab Options.
	 */
	function crafto_custom_tab_options() {
		global $post;

		if ( empty( $post->ID ) ) {
			return;
		}

		if ( ! isset( $post->ID ) ) {
			return;
		}

		$crafto_tabs_group = get_post_meta( $post->ID, '_crafto_custom_product_tab', true );
		?>
		<div id="custom_tab_data" class="panel woocommerce_options_panel">
			<!--Custom Tabbing Start in Product Edit Page-->
			<div id="crafto-custom-product-tab-repeater" class="crafto-custom-product-tab-repeater">
				<label><?php echo esc_html__( 'Custom Product Tab', 'crafto-addons' ); ?></label>
				<div id="crafto-accordion-product-tab">
					<?php
					if ( ! empty( $crafto_tabs_group ) ) {
						$i = 1;
						foreach ( $crafto_tabs_group as $field ) {
							?>
							<div class="crafto-single-product-tab-main-structure">
								<h3 class="crafto-single-product-tab-title">
									<?php
									if ( '' !== $field['tabtitle'] ) {
										echo esc_attr( $field['tabtitle'] );
										// Remove icon not display in default tab.
										if ( 'description' !== $field['tabuniquekey'] && 'additional_information' !== $field['tabuniquekey'] && 'reviews' !== $field['tabuniquekey'] ) {
											?>
											<a class="button remove-row" href="javascript:void(0);"></a>
											<?php
										}
									} else {
										echo esc_html__( 'Blank Tab', 'crafto-addons' );
									}
									?>
								</h3>
								<div class="crafto-single-product-tab-details">
									<div class="crafto-single-product-tab-details-title" >
										<?php
										if ( '' !== $field['tabtitle'] ) {
											$title = esc_attr( $field['tabtitle'] );
										}
										if ( '' === $field['tabuniquekey'] ) {
											?>
											<lable><?php echo esc_html__( 'Tab Title', 'crafto-addons' ); ?></lable>
											<input type="text" class="crafto_input" name="tabdata[tabtitle][]" value="<?php echo esc_attr( $title ); ?>">
											<?php
										} else {
											?>
											<input type="hidden" class="crafto_input" name="tabdata[tabtitle][]" value="<?php echo esc_attr( $title ); ?>">
											<p><?php echo esc_html__( 'Show Default Content', 'crafto-addons' ); ?></p>
											<?php
										}
										?>
									</div>
									<div class="crafto-single-product-tab-details-description">
										<lable><?php echo esc_html__( 'Tab Content', 'crafto-addons' ); ?></lable>
										<?php
										if ( '' === $field['tabuniquekey'] ) {
											$content = ( ! empty( $field['tabdescription'] ) ) ? $field['tabdescription'] : '';

											$settings          = array(
												'wpautop' => true,
												'media_buttons' => false,
												'textarea_name' => 'tabdata[tabdescription][]',
												'textarea_rows' => 10,
												'teeny'   => true,
												'tinymce' => true,
												'editor_class' => 'crafto-textarea',
											);
											$tabdescription_id = 'edit_post' . ( $i++ );

											wp_editor( $content, $tabdescription_id, $settings );
											?>
											<input type="hidden" name="tabdata[tabuniquekey][]" value="">
											<?php
										} elseif ( 'description' === $field['tabuniquekey'] ) {
											?>
											<input type="hidden" name="tabdata[tabdescription][]">
											<input type="hidden" name="tabdata[tabuniquekey][]" value="description">
											<?php
										} elseif ( 'additional_information' === $field['tabuniquekey'] ) {
											?>
											<input type="hidden" name="tabdata[tabdescription][]">
											<input type="hidden" name="tabdata[tabuniquekey][]" value="additional_information">
											<?php
										} elseif ( 'reviews' === $field['tabuniquekey'] ) {
											?>
											<input type="hidden" name="tabdata[tabdescription][]" />
											<input type="hidden" name="tabdata[tabuniquekey][]" value="reviews">
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
						} // end foreach
					} else {
						?>
						<!-- Description Tab Start -->
						<div class="crafto-single-product-tab-main-structure">
							<h3 class="crafto-single-product-tab-title"><?php echo esc_html__( 'Description', 'crafto-addons' ); ?></h3>
							<div class="crafto-single-product-tab-details">
								<div class="crafto-single-product-tab-details-title" >
									<input type="hidden" class="crafto_input" name="tabdata[tabtitle][]" value="<?php echo esc_html__( 'Description', 'crafto-addons' ); ?>">
									<p><?php echo esc_html__( 'Show Default Content', 'crafto-addons' ); ?></p>
								</div>
								<div class="crafto-single-product-tab-details-description">
									<input type="hidden" name="tabdata[tabdescription][]">
									<input type="hidden" name="tabdata[tabuniquekey][]" value="description">
								</div>
							</div>
						</div>
						<!-- Description Tab End -->

						<!-- Additional Information Tab Start -->
						<div class="crafto-single-product-tab-main-structure">
							<h3 class="crafto-single-product-tab-title">
								<?php echo esc_html__( 'Additional Information', 'crafto-addons' ); ?>
							</h3>
							<div class="crafto-single-product-tab-details">
								<div class="crafto-single-product-tab-details-title" >
									<input type="hidden" class="crafto_input" name="tabdata[tabtitle][]" value="<?php echo esc_html__( 'Additional Information', 'crafto-addons' ); ?>">
									<p><?php echo esc_html__( 'Show Default Content', 'crafto-addons' ); ?></p>
								</div>
								<div class="crafto-single-product-tab-details-description">
									<input type="hidden" name="tabdata[tabdescription][]">
									<input type="hidden" name="tabdata[tabuniquekey][]" value="additional_information">
								</div>
							</div>
						</div>
						<!-- Additional Information Tab End -->
						<!-- Reviews Tab Start -->
						<div class="crafto-single-product-tab-main-structure">
							<h3 class="crafto-single-product-tab-title">
								<?php echo esc_html__( 'Reviews', 'crafto-addons' ); ?>
							</h3>
							<div class="crafto-single-product-tab-details">
								<div class="crafto-single-product-tab-details-title" >
									<input type="hidden" class="crafto_input" name="tabdata[tabtitle][]" value="<?php echo esc_html__( 'Reviews', 'crafto-addons' ); ?>">
									<p><?php echo esc_html__( 'Show Default Content', 'crafto-addons' ); ?></p>
								</div>
								<div class="crafto-single-product-tab-details-description">
									<input type="hidden" name="tabdata[tabdescription][]">
									<input type="hidden" name="tabdata[tabuniquekey][]" value="reviews">
								</div>
							</div>
						</div>
						<!-- Reviews Tab End -->
						<?php
					}
					?>
				</div>
			</div>
			<p>
				<a id="add-row" class="button add-row button-primary" href="javascript:void(0);">
					<?php echo esc_html__( 'Add a Tab', 'crafto-addons' ); ?>
				</a>
			</p>
		</div>
		<?php
	}
}
add_action( 'woocommerce_product_data_panels', 'crafto_custom_tab_options' );

if ( ! function_exists( 'crafto_custom_tab_details' ) ) {
	/**
	 * Custom Tab Details.
	 */
	function crafto_custom_tab_details() {
		$newtabid = ( ! empty ( $_POST['tabid'] ) ) ? $_POST['tabid'] : ''; // phpcs:ignore
		?>
		<div class="crafto-single-product-tab-main-structure">
			<h3 class="crafto-single-product-tab-title">
				<?php echo esc_html__( 'New Tab', 'crafto-addons' ); ?>
				<a class="button remove-row" href="javascript:void(0);"></a>
			</h3>
			<div class="crafto-single-product-tab-details">
				<div class="crafto-single-product-tab-details-title" >
					<lable><?php echo esc_html__( 'Tab Title', 'crafto-addons' ); ?></lable>
					<input type="text" class="crafto_input" name="tabdata[tabtitle][]" value="">
				</div>
				<div class="crafto-single-product-tab-details-description" >
					<?php
					$settings = array(
						'wpautop'       => true,
						'media_buttons' => false,
						'textarea_name' => 'tabdata[tabdescription][]',
						'textarea_rows' => 10,
						'teeny'         => true,
						'tinymce'       => true,
						'editor_class'  => 'crafto-textarea',
					);

					$tabdescription_id = 'edit_post' . $newtabid;
					wp_editor( '', $tabdescription_id, $settings );
					?>
					<input type="hidden" name="tabdata[tabuniquekey][]" value="">
				</div>
			</div>
			<input type="hidden" class="newtabid" value="<?php echo esc_attr( $newtabid ); ?>">
		</div>
		<?php
		wp_die();
	}
}
add_action( 'wp_ajax_crafto_custom_tab_details', 'crafto_custom_tab_details' );
add_action( 'wp_ajax_nopriv_crafto_custom_tab_details', 'crafto_custom_tab_details' );

if ( ! function_exists( 'custom_product_tabs' ) ) {
	/**
	 * Creating Custom Tab in Woocommerce Tabbing.
	 *
	 * @param mixed $tabs Tabs.
	 */
	function custom_product_tabs( $tabs ) {

		global $post, $product;

		if ( empty( $post->ID ) ) {
			return $tabs;
		}

		if ( ! isset( $post->ID ) ) {
			return $tabs;
		}

		$custom_tabbing = get_post_meta( $post->ID, '_crafto_custom_product_tab', true );

		if ( ! empty( $custom_tabbing ) ) {
			$i = 10;
			foreach ( $custom_tabbing as $key => $details ) {
				$title     = ! empty( $details['tabtitle'] ) ? $details['tabtitle'] : '';
				$title_key = 'crafto-tab' . $key;
				$desc      = $details['tabdescription'] ? $details['tabdescription'] : '';

				if ( empty( $details['tabuniquekey'] ) ) {

					$tabs[ $title_key ] = array(
						'title'    => $title,
						'priority' => $i,
						'callback' => 'crafto_product_tab_content',
					);

				} elseif ( isset( $tabs['description'] ) && isset( $details['tabuniquekey'] ) && 'description' === $details['tabuniquekey'] ) {

					$tabs['description']['priority'] = $i;

				} elseif ( isset( $tabs['additional_information'] ) && isset( $details['tabuniquekey'] ) && 'additional_information' === $details['tabuniquekey'] ) {

					$tabs['additional_information']['priority'] = $i;

				} elseif ( isset( $tabs['reviews'] ) && isset( $details['tabuniquekey'] ) && 'reviews' === $details['tabuniquekey'] ) {

					$tabs['reviews']['priority'] = $i;
				}
				$i = $i + 10;
			}
		}
		return $tabs;
	}
}
add_filter( 'woocommerce_product_tabs', 'custom_product_tabs', 98 );

if ( ! function_exists( 'crafto_product_tab_content' ) ) {
	/**
	 * Add content to custom tab in product single pages (1).
	 *
	 * @param mixed $key custom tab key.
	 */
	function crafto_product_tab_content( $key ) {

		global $post;

		if ( empty( $post->ID ) ) {
			return false;
		}

		if ( ! isset( $post->ID ) ) {
			return false;
		}

		$custom_tabs = get_post_meta( $post->ID, '_crafto_custom_product_tab', true );

		if ( ! empty( $custom_tabs ) ) {
			$main  = str_replace( 'crafto-tab', '', $key );
			$title = $custom_tabs[ $main ]['tabtitle'];
			$desc  = $custom_tabs[ $main ]['tabdescription'];

			if ( ! empty( $desc ) ) {
				echo do_shortcode( wpautop( $desc ) );
			}
		}
	}
}
