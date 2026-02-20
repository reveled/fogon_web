( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		function toggleFields() {
			var selectedValue = $( '.crafto-attribute-type' ).val();
			
			$( '.crafto-attribute-color, .crafto-attribute-image' ).hide();
			setTimeout( function() {
				if ( 'crafto_color' === selectedValue ) {
					$( '.crafto-attribute-color' ).show();
				} else if ( 'crafto_image' === selectedValue ) {
					$( '.crafto-attribute-image' ).show();
				}
			}, 100 );
		}
		toggleFields();

		// Run function on change event
		$( document ).on( 'change', '.crafto-attribute-type',  function() {
			setTimeout( toggleFields, 100 );
		});

		/* Image Upload Button Click*/
		$( document ).on( 'click', '.crafto_upload_button, .crafto_upload_button_category', function( event ) {
			event.preventDefault();

			var file_frame,				
				btn_parent = $( this ).parent(),				
				img_field  = btn_parent.find( '.upload_field' ),
				remove_btn = btn_parent.find( '.crafto_remove_button' );

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media( {
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				var full_attachment = file_frame.state().get( 'selection' ).first().toJSON();
				if ( full_attachment ) {
					$( img_field ).attr( 'value', full_attachment.id );
					btn_parent.find( '.upload_image_screenshort' ).attr( 'src', full_attachment.url ).slideDown();
					$( remove_btn ).removeClass( 'hidden' );
				}
			});

			// Finally, open the modal
			file_frame.open();
		});

		/* Multiple image upload */
		$( document ).on( 'click', '.crafto_upload_button_multiple_category', function( event ) {
			var file_frame;
			var btn_parent = $( this ).parent();			

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: true  // Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				var selection = file_frame.state().get( 'selection' );
				selection.map( function( attachment ) {
					var attachment = attachment.toJSON();
					var imageHTML = '';
						imageHTML += '<div id="';
						imageHTML += attachment.id;
						imageHTML += '">';
						imageHTML += '<img src="';
						imageHTML += attachment.url;
						imageHTML += '" class="upload_image_screenshort_multiple" alt="" style="width:100px;"/>';
						imageHTML += '<a href="javascript:void(0)" class="remove">Remove</a>';
						imageHTML += '</div>';

					btn_parent.find( '.multiple_images' ).append( imageHTML );
				});
			});
			// Finally, open the modal
			file_frame.open();
		});

		// Remove button function to remove attach image and hide screenshort Div.
		$( document ).on( 'click', '.crafto_remove_button, .crafto_remove_button_category', function( event ) {
			var remove_parent = $( this ).parent();
			remove_parent.find( '.upload_field' ).attr( 'value', '' );
			remove_parent.find( 'input[type="hidden"]' ).attr( 'value', '' );
			remove_parent.find( '.upload_image_screenshort' ).slideUp();
		});

		var el_multiple_images = $( '.multiple_images' );
		$( document ).on( 'click', '.button-primary', function() {
			if ( el_multiple_images.length > 0 ) {
				el_multiple_images.each( function() {
					if ( $( this ).children().length > 0 ) {
						var attach_id = [];
						var pr_div    = $( this ).parent();
						$( this ).children( 'div' ).each( function() {
							attach_id.push( $( this ).attr( 'id' ) );
						});
						pr_div.find( '.upload_field_multiple' ).val( attach_id );
					} else {
						$( this ).parent().find( '.upload_field_multiple' ).attr( 'value', '' );
					}
				});
			}
		});

		$( document ).on( 'click', '.crafto_tab_reset_settings', function() {
			var reset_message = CraftoMetabox.i18n.reset_message,
				reset_name    = $( this ).attr( 'reset_key' );
				reset_message = reset_message.replace( /###|_/g, reset_name );

			var flag = confirm( reset_message );

			if ( flag ) {

				var reset_tab = $( this ).parents( '.crafto_meta_box_tab' );

				// for input type text field
				reset_tab.find( 'input[type="text"]' ).attr( 'value', '' );

				// for textarea
				reset_tab.find( 'textarea' ).attr( 'value', '' );

				// for select
				reset_tab.find( 'select' ).val( 'default' );

				reset_tab.find( '.crafto-dropdown-select2' ).val( '' ).trigger('change');

				// for colorpicker
				reset_tab.find( '.wp-color-result' ).attr( 'style', '' );

				// for input type hidden field
				reset_tab.find( 'input[type="hidden"]' ).attr( 'value', '' );

				// for image upload field
				reset_tab.find( '.crafto_remove_button, .multiple_images .remove' ).trigger( 'click' );

				$( '.dynamic-fields' ).not( ':first' ).each( function() {
					$( this ).remove();  // Remove the selected fields
				});

				reset_tab.find( '.crafto_preload_resources_box' ).find( 'select' ).val( 'document' );
				craftoToggleRemoveButton();

				reset_tab.find( '#crafto_preload_resources' ).val('');

			}
		});

		// Check on load for selected tab when user come before if not it show first one active.
		if ( $.cookie( 'crafto_metabox_active_id_' + $( '#post_ID' ).val() ) ) {
			
			var active_class = $.cookie( 'crafto_metabox_active_id_' + $( '#post_ID' ).val() );

			$( '#crafto_admin_options' ).find( '.crafto_meta_box_tabs li' ).removeClass( 'active' );
			$( '#crafto_admin_options' ).find( '.crafto_meta_box_tab' ).removeClass( 'active' ).hide();

			$( '.' + active_class ).addClass( 'active' ).fadeIn();
			$( '#crafto_admin_options' ).find( '#' + active_class ).addClass( 'active' ).fadeIn();
		} else {

			$( '.crafto_meta_box_tabs li:first-child' ).addClass( 'active' );
			$( '.crafto_meta_box_tab_content .crafto_meta_box_tab:first-child' ).addClass( 'active' ).fadeIn();
		}

		$( '.crafto_meta_box_tabs li a' ).on( 'click', function( e ) {
			e.preventDefault();

			var tab_click_id = $( this ).parent().attr( 'class' ).split( ' ' )[0];
			var tab_main_div = $( this ).parents( '#crafto_admin_options' );

			$.cookie( 'crafto_metabox_active_id_' + $( '#post_ID' ).val(), tab_click_id, { expires: 7 } );

			tab_main_div.find( '.crafto_meta_box_tabs li' ).removeClass( 'active' );
			tab_main_div.find( '.crafto_meta_box_tab' ).removeClass( 'active' ).hide();

			$( this ).parent().addClass( 'active' ).fadeIn();
			tab_main_div.find( '#' + tab_click_id ).addClass( 'active' ).fadeIn();
		});

		/* Metabox dependance of fields */
		$( '.crafto_select_parent' ).on( 'change', function () {
			var str_selected           = $( this ).find( 'option:selected' ).val(),
				tab_active_status_main = $( this ).parents( '#crafto_admin_options' );

			$( '.hide_dependent' ).find( 'input[type="hidden"]' ).val( '0' );
			tab_active_status_main.find( '.hide_dependent' ).addClass( 'hide_dependency' );

			if ( tab_active_status_main.find( '.hide_dependency' ).hasClass( str_selected + '_single' ) ) {
				tab_active_status_main.find( '.' + str_selected + '_single' ).removeClass( 'hide_dependency' );
				tab_active_status_main.find( '.' + str_selected + '_single' ).find( 'input[type="hidden"]' ).val( '1' );
			}

			/* Special case for Both sidebar*/ 
			if ( 'crafto_layout_both_sidebar' === str_selected ) {
				$( '.crafto_layout_left_sidebar_single' ).removeClass( 'hide_dependency' );
				$( '.crafto_layout_left_sidebar_single' ).find( 'input[type="hidden"]' ).val( '1' );
				$( '.crafto_layout_right_sidebar_single' ).removeClass( 'hide_dependency' );
				$( '.crafto_layout_right_sidebar_single' ).find( 'input[type="hidden"]' ).val( '1' );
			}
		});

		$( '#crafto_layout_settings_single' ).on( 'change', function () {
			var str_selected 		= $( this ).find( 'option:selected' ).val(),
				str_selected_parent = $( this ).parents( '#crafto_tab_layout_settings' );

			str_selected_parent.find( '.hide-child' ).addClass( 'hide-children' );
			str_selected_parent.find( '.' + str_selected + '_single_box' ).removeClass( 'hide-children' ).addClass( 'show-children' );
		});

		/* Dependency */
		$( '.description_box, .separator_box' ).each( function() {
			var el_data_element = $( this ).attr( 'data-element' );
			var el_data_value   = $( this ).attr( 'data-value' );
			var el_data_parent_element = $( this ).attr( 'data-parent-element' );
			var el_data_parent_value   = $( this ).attr( 'data-parent-value' );

			var headerStyle = $( '#crafto_header_sticky_type' ).val();
    
			if ( 'header-reverse' === headerStyle || 'reverse-back-scroll' === headerStyle ) {
				$( '.crafto_glass_effect_box' ).removeClass( 'hidden' );
			} else {
				$( '.crafto_glass_effect_box' ).addClass( 'hidden' );
			}

			if ( el_data_element && el_data_value ) {
				var data_val     = el_data_value,
					data_val_arr = data_val.split( ',' ),
					data_element = el_data_element,
					current      = $( this );

				$( document ).on( 'change', '#' + el_data_element, function () {
					var val = $( this ).val();

					if ( $.inArray( val, data_val_arr ) !== -1 ) {
						$( current ).removeClass( 'hidden' );
					} else {
						$( current ).addClass( 'hidden' );
					}
				});

				if ( $.inArray( $( '#' + data_element ).val(), data_val_arr ) !== -1 ) {
					$( current ).removeClass( 'hidden' );
				} else {
					$( current ).addClass( 'hidden' );
				}
			}

			if ( el_data_parent_element && el_data_parent_value ) {
				var data_parent_val     = el_data_parent_value,
					data_parent_val_arr = data_parent_val.split( ',' ),
					data_parent_element = el_data_parent_element,
					parent_current      = $( this );

				/** Start Glass Effect Custom JS. */
				$( '.crafto_glass_effect_box' ).addClass( 'hidden' );
				/** End Glass Effect Custom JS. */

				$( document ).on( 'change', '#' + el_data_parent_element, function () {
					var parent_val = $( this ).val();
					var header_style = $( '#crafto_header_sticky_type' ).val();

					if ( $.inArray( parent_val, data_parent_val_arr ) !== -1 ) {
						$( parent_current ).removeClass( 'hidden' );
					} else {
						$( parent_current ).addClass( 'hidden' );
					}

					/** Start Glass Effect Custom JS. */
					if ( 'standard' === parent_val ) {
						if ( 'header-reverse' === header_style || 'reverse-back-scroll' === headerStyle ) {
							$( '.crafto_glass_effect_box' ).removeClass( 'hidden' );
						} else {
							$( '.crafto_glass_effect_box' ).addClass( 'hidden' );
						}
					}
					/** End Glass Effect Custom JS. */
				});

				/** Start Glass Effect Custom JS. */
				$( '#crafto_header_sticky_type' ).on( 'change', function() {
					var __this = $( this ).val();
					if ( 'header-reverse' !== __this && 'reverse-back-scroll' !== __this ) {
						$( '.crafto_glass_effect_box' ).addClass( 'hidden' );
					} else {
						$( '.crafto_glass_effect_box' ).removeClass( 'hidden' );
					}
				});
				/** End Glass Effect Custom JS. */

				$( document ).on( 'change', '#' + el_data_element, function () {
					var val         = $( this ).val(),
						tmp_type    = $( '#crafto_template_header_style' ).val(),
						header_data = $( '#crafto_header_sticky_type' ).val();

					if ( val === el_data_value ) {
						if ( $.inArray( $( '#' + data_parent_element ).val(), data_parent_val_arr ) !== -1 ) {
							$( parent_current ).removeClass( 'hidden' );
						} else {
							$( parent_current ).addClass( 'hidden' );
						}
					}

					/** Start Glass Effect Custom JS. */
					if ( 'header' === val ) {
						if ( 'standard' === tmp_type ) {
							if ( 'header-reverse' === header_data || 'reverse-back-scroll' === header_data) {
								$( '.crafto_glass_effect_box' ).removeClass( 'hidden' );
							} else {
								$( '.crafto_glass_effect_box' ).addClass( 'hidden' );
							}
						}
					}
					/** End Glass Effect Custom JS. */
				});

				if ( $.inArray( $( '#' + data_parent_element ).val(), data_parent_val_arr ) ) {
					$( parent_current ).addClass( 'hidden' );
				}
			}
			
		});
		/* End Dependency */

		// Preload Resources
		craftoToggleRemoveButton();
		$( document ).on( 'click', '.add-field', function( e ) {
			e.preventDefault();
			var index = $( '.dynamic-fields' ).length;
			var newRow = '<div class="dynamic-fields">' +
				'<input type="text" id="crafto_preload_resources" name="crafto_preload_resources[' + index + '][textarea]" value="" />' +
				'<select name="crafto_preload_resources[' + index + '][select]">' +
				'<option value="document">' + CraftoMetabox.preload_document + '</option>' +
				'<option value="font">' + CraftoMetabox.preload_font + '</option>' +
				'<option value="image">' + CraftoMetabox.preload_image + '</option>' +
				'<option value="script">' + CraftoMetabox.preload_script + '</option>' +
				'<option value="style">' + CraftoMetabox.preload_style + '</option>' +
				'</select>' +
				'<select name="crafto_preload_resources[' + index + '][select_device]">' +
				'<option value="all">' + CraftoMetabox.preload_all + '</option>' +
				'<option value="desktop">' + CraftoMetabox.preload_desktop + '</option>' +
				'<option value="mobile">' + CraftoMetabox.preload_mobile + '</option>' +
				'</select>' +
				'<button class="remove-field">Remove</button>' +
				'</div>';

			$( '.crafto_preload_resources_box .right-part' ).append( newRow );
		
			craftoToggleRemoveButton();
		});

		$( document ).on( 'click', '.crafto_preload_resources_box .remove-field', function( e ) {
			e.preventDefault();
			$( this ).closest( '.dynamic-fields' ).remove();
			craftoToggleRemoveButton();
		});

		function craftoToggleRemoveButton() {		
			// Hide the remove button if there is only one field
			if (  1 === $( '.dynamic-fields' ).length ) {
				$( '.remove-field' ).hide();
			} else {
				$( '.remove-field' ).show();
			}
		}

		// End Preload Resources

		/* Dequeue Scripts */
		craftoToggleScriptRemoveButton();
		$( document ).on( 'click', '.add-dequeue-field', function( e ) {
			e.preventDefault();
			var index = $( '.dequeue-fields' ).length;
			var newRow = '<div class="dequeue-fields">' +
				'<input type="text" id="crafto_dequeue_scripts" name="crafto_dequeue_scripts[' + index + '][textarea]" value="" />' +
				'<button class="remove-dequeue-field">Remove</button>' +
				'</div>';

			$( '.crafto_dequeue_scripts_box .right-part' ).append( newRow );
		
			craftoToggleScriptRemoveButton();
		});

		$( document ).on( 'click', '.crafto_dequeue_scripts_box .remove-dequeue-field', function( e ) {
			e.preventDefault();
			$( this ).closest( '.dequeue-fields' ).remove();
			craftoToggleScriptRemoveButton();
		});

		function craftoToggleScriptRemoveButton() {
			// Hide the remove button if there is only one field
			if (  1 === $( '.dequeue-fields' ).length ) {
				$( '.remove-dequeue-field' ).hide();
			} else {
				$( '.remove-dequeue-field' ).show();
			}
		}
		/* End Dequeue Scripts */

		/* Color picker for meta */
		var link_color = $( '.crafto-color-picker' );
		if ( link_color.length > 0 ) {
			link_color.each( function () {
				$( this ).alphaColorPicker();
			});
		}

		/* Image Sortable */
		if ( el_multiple_images.length > 0 ) {
			el_multiple_images.sortable();
		}

		if ( $( 'body' ).hasClass( 'block-editor-page' ) ) {

			/* Multiple image upload */
			$( document ).on( 'click', '.crafto_upload_button_multiple', function( event ) {
				var file_frame,				
					btn_parent = $( this ).parent().parent();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: $( this ).data( 'uploader_title' ),
					button: {
						text: $( this ).data( 'uploader_button_text' ),
					},
					multiple: true  // Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					var selection = file_frame.state().get( 'selection' );

					selection.map( function( attachment ) {
						var attachment = attachment.toJSON();
							var imageHTML = '';
								imageHTML += '<div id="';
								imageHTML += attachment.id;
								imageHTML += '">';
								imageHTML += '<img src="';
								imageHTML += attachment.url;
								imageHTML += '" class="upload_image_screenshort_multiple" alt="Remove" style="width:100px;"/>';
								imageHTML += '<a href="javascript:void(0)" class="remove">Remove</a>';
								imageHTML += '</div>';

							btn_parent.find( '.multiple_images' ).append( imageHTML );

						el_multiple_images.each( function() {
							if ( $( this ).children().length > 0 ) {
								var attach_id = [],
									pr_div    = $( this ).parent();

								$( this ).children( 'div' ).each( function() {
									attach_id.push( $( this ).attr( 'id' ) );
								});

								pr_div.find( '.upload_field' ).val( attach_id );
							} else {
								$( this ).parent().find( '.upload_field' ).attr( 'value', '' );
							}
						});
					});
				});
				// Finally, open the modal
				file_frame.open();
			});

			el_multiple_images.on( 'click', '.remove', function() {
				var remove_Item = $( this ).parent().attr( 'id' );

				el_multiple_images.each( function() {
					if ( $( this ).children().length > 0 ) {
						var attach_id = [],
							pr_div    = $( this ).parent();
						$( this ).children( 'div' ).each( function() {
							attach_id.push( $( this ).attr( 'id' ) );
						});
						attach_id = $.grep( attach_id, function( value ) {
							return value != remove_Item;
						});
						pr_div.find( '.upload_field' ).val( attach_id );
					} else {
						$( this ).parent().find( '.upload_field' ).attr( 'value', '' );
					}
				});

				$( this ).parent().slideUp().remove();
			});

			/* Multiple image upload End. */

			/*==============================================================*/
			// Post Format Meta Start
			/*==============================================================*/
			function post_format_selection_options( format_val ) {
				setTimeout( function() {
					// Remove post format from portfolio.
					var itemList = [
						'image',
						'quote',
						'audio',
					];

					for ( var i = 0; i < itemList.length; i++ ) {
						$( 'body.post-type-portfolio select[id^="post-format-selector"] option[value="' + itemList[i] + '"]' ).remove();
					}
				}, 500 );

				$( 'body.post-type-post #crafto_admin_options_single' ).hide();

				if ( 'link' === format_val ) {

					$( 'body.post-type-post #crafto_admin_options_single' ).show();

					$( '.crafto_audio_single_box, .crafto_quote_single_box, .crafto_video_type_single_box, .crafto_enable_mute_single_box, .crafto_video_mp4_single_box, .crafto_video_ogg_single_box, .crafto_video_webm_single_box, .crafto_video_single_box, .crafto_featured_image_single_box, .crafto_lightbox_image_single_box, .crafto_gallery_single_box, .crafto_quote_author_single_box' ).hide();

					$( '.crafto_portfolio_video_type_single_box, .crafto_portfolio_enable_mute_single_box, .crafto_portfolio_video_mp4_single_box, .crafto_portfolio_video_mp4_single_box, .crafto_portfolio_external_video_single_box, .crafto_portfolio_gallery_single_box' ).hide();

					$( '.crafto_portfolio_external_link_single_box' ).fadeIn();
					$( '.crafto_portfolio_link_target_single_box' ).fadeIn();
					$( '.crafto_post_external_link_single_box' ).fadeIn();
					$( '.crafto_post_link_target_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				} else if ( 'gallery' === format_val ) {

					$( 'body.post-type-post #crafto_admin_options_single' ).show();

					$( '.crafto_audio_single_box, .crafto_quote_single_box, .crafto_video_type_single_box, .crafto_enable_mute_single_box, .crafto_video_mp4_single_box, .crafto_video_ogg_single_box, .crafto_video_webm_single_box, .crafto_video_single_box, .crafto_post_external_link_single_box, .crafto_post_link_target_single_box, .crafto_quote_author_single_box' ).hide();

					$( '.crafto_portfolio_video_type_single_box, .crafto_portfolio_enable_mute_single_box, .crafto_portfolio_video_mp4_single_box, .crafto_portfolio_external_video_single_box, .crafto_portfolio_external_link_single_box, .crafto_portfolio_link_target_single_box' ).hide();

					$( '.crafto_gallery_single_box' ).fadeIn();
					$( '.crafto_lightbox_image_single_box' ).fadeIn();
					$( '.crafto_featured_image_single_box' ).fadeIn();
					$( '.crafto_portfolio_gallery_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				} else if ( 'video' === format_val ) {
					$( 'body.post-type-post #crafto_admin_options_single' ).show();

					$( '.crafto_audio_single_box, .crafto_quote_single_box, .crafto_lightbox_image_single_box, .crafto_gallery_single_box, .crafto_post_external_link_single_box, .crafto_post_link_target_single_box, .crafto_quote_author_single_box' ).hide();

					$( '.crafto_portfolio_external_link_single_box, .crafto_portfolio_link_target_single_box, .crafto_portfolio_gallery_single_box' ).hide();

					$( '.crafto_portfolio_video_type_single_box' ).fadeIn();
					$( '.crafto_portfolio_enable_mute_single_box' ).fadeIn();
					$( '.crafto_portfolio_video_mp4_single_box' ).fadeIn();
					$( '.crafto_portfolio_external_video_single_box' ).fadeIn();

					$( '.crafto_video_type_single_box' ).fadeIn();
					$( '.crafto_enable_mute_single_box' ).fadeIn();
					$( '.crafto_video_mp4_single_box' ).fadeIn();
					$( '.crafto_video_ogg_single_box' ).fadeIn();
					$( '.crafto_video_webm_single_box' ).fadeIn();
					$( '.crafto_video_single_box' ).fadeIn();
					$( '.crafto_featured_image_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				} else if ( 'audio' === format_val ) {
					$( 'body.post-type-post #crafto_admin_options_single' ).show();

					$( '.crafto_video_type_single_box, .crafto_enable_mute_single_box, .crafto_video_mp4_single_box, .crafto_video_ogg_single_box, .crafto_video_webm_single_box, .crafto_video_single_box, .crafto_gallery_single_box, .crafto_lightbox_image_single_box, .crafto_quote_single_box, .crafto_post_external_link_single_box, .crafto_post_link_target_single_box, .crafto_quote_author_single_box' ).hide();

					$( '.crafto_audio_single_box' ).fadeIn();
					$( '.crafto_featured_image_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				} else if ( 'quote' === format_val ) {
					$( 'body.post-type-post #crafto_admin_options_single' ).show();

					$( '.crafto_audio_single_box, .crafto_video_type_single_box, .crafto_enable_mute_single_box, .crafto_video_mp4_single_box, .crafto_video_ogg_single_box, .crafto_video_webm_single_box, .crafto_video_single_box, .crafto_gallery_single_box, .crafto_lightbox_image_single_box, .crafto_post_external_link_single_box, .crafto_post_link_target_single_box' ).hide();

					$( '.crafto_quote_single_box' ).fadeIn();
					$( '.crafto_featured_image_single_box' ).fadeIn();
					$( '.crafto_quote_author_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				} else if ( 'image' === format_val ) {
					$( 'body.post-type-post #crafto_admin_options_single' ).show();

					$( '.crafto_audio_single_box, .crafto_video_type_single_box, .crafto_enable_mute_single_box, .crafto_video_mp4_single_box, .crafto_video_ogg_single_box, .crafto_video_webm_single_box, .crafto_video_single_box, .crafto_gallery_single_box, .crafto_lightbox_image_single_box, .crafto_quote_single_box, .crafto_post_external_link_single_box, .crafto_post_link_target_single_box, .crafto_quote_author_single_box' ).hide();

					$( '.crafto_image_single_box' ).fadeIn();
					$( '.crafto_featured_image_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				} else {
					$( 'body.post-type-post #crafto_admin_options_single' ).show();
					$( '.crafto_audio_single_box, .crafto_gallery_single_box, .crafto_lightbox_image_single_box, .crafto_quote_single_box, .crafto_video_type_single_box, .crafto_enable_mute_single_box, .crafto_video_mp4_single_box, .crafto_video_ogg_single_box, .crafto_video_webm_single_box, .crafto_video_single_box, .crafto_post_external_link_single_box, .crafto_post_link_target_single_box, .crafto_quote_author_single_box' ).hide();

					$( '.crafto_portfolio_video_mp4_single_box, .crafto_portfolio_external_video_single_box, .crafto_portfolio_video_type_single_box, .crafto_portfolio_enable_mute_single_box, .crafto_portfolio_external_link_single_box, .crafto_portfolio_gallery_single_box, .crafto_portfolio_link_target_single_box' ).hide();

					$( '.crafto_subtitle_single_box' ).fadeIn();
					$( '.crafto_featured_image_single_box' ).fadeIn();

					post_format_video_selection();
					post_format_portfolio_video_selection();
				}
			}

			let previousValue = '';
			function checkButtonValue() {
				const labels = document.querySelectorAll( '.editor-post-panel__row-label' );

				labels.forEach( label => {
					if ( label.textContent.trim() === 'Format' ) {
						const row = label.closest( '.editor-post-panel__row' );
						if ( row ) {
							const button = row.querySelector( '.components-button' );
							if ( button ) {
								const currentValue = button.textContent.trim().toLowerCase();
								if ( currentValue !== previousValue ) {
									previousValue = currentValue;
									post_format_selection_options( previousValue );
								}
							}
						}
					}
				});
			}

			setInterval( checkButtonValue, 1000 );
			/*==============================================================*/
			// Post Format Meta End
			/*==============================================================*/
		} else {

			/* multiple image upload */
			$( document ).on( 'click', '.crafto_upload_button_multiple', function( event ) {

				var file_frame,
					btn_parent = $( this ).parent().parent();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: $( this ).data( 'uploader_title' ),
					button: {
						text: $( this ).data( 'uploader_button_text' ),
					},
					multiple: true  // Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					var selection = file_frame.state().get( 'selection' );

					selection.map( function( attachment ) {
						var attachment = attachment.toJSON();
						var imageHTML = '';
							imageHTML += '<div id="';
							imageHTML += attachment.id;
							imageHTML += '">';
							imageHTML += '<img src="';
							imageHTML += attachment.url;
							imageHTML += '" class="upload_image_screenshort_multiple" alt="" style="width:100px;"/>';
							imageHTML += '<a href="javascript:void(0)" class="remove">remove</a>';
							imageHTML += '</div>';

						btn_parent.find( '.multiple_images' ).append( imageHTML );

						el_multiple_images.each( function() {

							if ( $( this ).children().length > 0 ) {
								var attach_id = [],
									pr_div    = $( this ).parent();

								$( this ).children( 'div' ).each( function() {
									attach_id.push( $( this ).attr( 'id' ) );
								});

								pr_div.find( '.upload_field' ).val( attach_id );
							} else {
								$( this ).parent().find( '.upload_field' ).attr( 'value', '' );
							}
						});
					});
				});
				// Finally, open the modal
				file_frame.open();
			});

			el_multiple_images.on( 'click', '.remove', function() {
				var remove_Item = $( this ).parent().attr( 'id' );
				el_multiple_images.each( function() {
					if ( $( this ).children().length > 0 ) {
						var attach_id = [],
							pr_div    = $( this ).parent();
						$( this ).children( 'div' ).each( function() {
							attach_id.push( $( this ).attr( 'id' ) );
						});
						attach_id = $.grep( attach_id, function( value ) {
							return value != remove_Item;
						});
						pr_div.find( '.upload_field' ).val( attach_id );
					} else {
						$( this ).parent().find( '.upload_field' ).attr( 'value', '' );
					}
				});

				$( this ).parent().slideUp().remove();
			});
		}

		/*==============================================================*/
		// Video Post Format Meta Change
		/*==============================================================*/

		$( '#crafto_video_type_single' ).on( 'change', function() {
			post_format_video_selection();
		});

		function post_format_video_selection() {
			var crafto_video_type_val = $( '#crafto_video_type_single' ).val();
			var crafto_enable_mute    = $( '.crafto_enable_mute_single_box' );
			var crafto_video_mp4      = $( '.crafto_video_mp4_single_box' );
			var crafto_video_ogg      = $( '.crafto_video_ogg_single_box' );
			var crafto_video_webm     = $( '.crafto_video_webm_single_box' );
			var crafto_video          = $( '.crafto_video_single_box' );
			var selected_value        = '';

			const labels = document.querySelectorAll( '.editor-post-panel__row-label' );

			labels.forEach( label => {
				if ( label.textContent.trim() === 'Format' ) {
					const row = label.closest( '.editor-post-panel__row' );
					if ( row ) {
						const button = row.querySelector( '.components-button' );
						if ( button ) {
							const currentValue = button.textContent.trim().toLowerCase();
							if ( currentValue !== selected_value ) {
								selected_value = currentValue;
							}
						}
					}
				}
			});

			if ( 'self' === crafto_video_type_val && ( 'video' === selected_value ) ) {
				crafto_enable_mute.addClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video_mp4.addClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video_ogg.addClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video_webm.addClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video.removeClass( 'show_div' ).addClass( 'hide_div' );
			} else if ( 'external' === crafto_video_type_val && ( 'video' === selected_value ) ) {
				crafto_enable_mute.removeClass( 'show_div' ).addClass( 'hide_div' );
				crafto_video_mp4.removeClass( 'show_div' ).addClass( 'hide_div' );
				crafto_video_ogg.removeClass( 'show_div' ).addClass( 'hide_div' );
				crafto_video_webm.removeClass( 'show_div' ).addClass( 'hide_div' );
				crafto_video.addClass( 'show_div' ).removeClass( 'hide_div' );
			} else {
				crafto_enable_mute.removeClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video_mp4.removeClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video_ogg.removeClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video_webm.removeClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_video.removeClass( 'show_div' ).removeClass( 'hide_div' );
			}
		}

		$( '#crafto_portfolio_video_type_single' ).on( 'change', function() {
			post_format_portfolio_video_selection();
		});

		function post_format_portfolio_video_selection() {
			var crafto_portfolio_video_type_val = $( '#crafto_portfolio_video_type_single' ).val();
			var crafto_portfolio_enable_mute    = $( '.crafto_portfolio_enable_mute_single_box' );
			var crafto_portfolio_video_mp4      = $( '.crafto_portfolio_video_mp4_single_box' );
			var crafto_portfolio_video          = $( '.crafto_portfolio_external_video_single_box' );
			var selected_value        = '';
			const labels = document.querySelectorAll( '.editor-post-panel__row-label' );

			labels.forEach( label => {
				if ( label.textContent.trim() === 'Format' ) {
					const row = label.closest( '.editor-post-panel__row' );
					if ( row ) {
						const button = row.querySelector( '.components-button' );
						if ( button ) {
							const currentValue = button.textContent.trim().toLowerCase();
							if ( currentValue !== selected_value ) {
								selected_value = currentValue;
							}
						}
					}
				}
			});

			if ( 'self' === crafto_portfolio_video_type_val && ( 'video' === selected_value ) ) {
				crafto_portfolio_enable_mute.addClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_portfolio_video_mp4.addClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_portfolio_video.removeClass( 'show_div' ).addClass( 'hide_div' );
			} else if ( 'external' === crafto_portfolio_video_type_val && ( 'video' === selected_value ) ) {
				crafto_portfolio_enable_mute.removeClass( 'show_div' ).addClass( 'hide_div' );
				crafto_portfolio_video_mp4.removeClass( 'show_div' ).addClass( 'hide_div' );
				crafto_portfolio_video.addClass( 'show_div' ).removeClass( 'hide_div' );
			} else  {
				crafto_portfolio_enable_mute.removeClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_portfolio_video_mp4.removeClass( 'show_div' ).removeClass( 'hide_div' );
				crafto_portfolio_video.removeClass( 'show_div' ).removeClass( 'hide_div' );
			}
		}
		/*==============================================================*/
		// Video Post Format Meta End
		/*==============================================================*/

		/*==============================================================*/
		// Custom CSS
		/*==============================================================*/
		var codeMirrorEditor;
		var customCSSField = document.getElementById( 'crafto_performance_custom_css' );

		if ( customCSSField ) {
			var settings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
			settings.codemirror = _.extend( {}, settings.codemirror, {
				mode: 'css',
				lineNumbers: true,
				viewportMargin: Infinity,
				theme: 'default'
			});

			function initializeCodeMirror() {
				if ( ! codeMirrorEditor ) {
					codeMirrorEditor = wp.codeEditor.initialize( $( customCSSField ), settings );
				}
			}

			function refreshCodeMirror() {
				if ( codeMirrorEditor ) {
					codeMirrorEditor.codemirror.refresh();
					setTimeout( function() {
						codeMirrorEditor.codemirror.refresh();
					}, 100 );
				}
			}

			function isCustomCSSTabVisible() {
				return $( customCSSField ).is( ':visible' );
			}

			function handleClassicEditor() {
				$( '.crafto_tab_custom-css a' ).on( 'click', function () {
					setTimeout( function () {
						if ( isCustomCSSTabVisible() ) {
							initializeCodeMirror();
							refreshCodeMirror();
						}
					}, 200 );
				});

				if ( isCustomCSSTabVisible() ) {
					initializeCodeMirror();
					refreshCodeMirror();
				}

				$( '#post' ).on( 'submit', function () {
					customCSSField.value = codeMirrorEditor.codemirror.getValue();
				});
			}

			function handleGutenbergEditor() {
				if ( typeof wp !== 'undefined' && wp.data && wp.data.select ) {
					wp.data.subscribe( function () {
						const editorStore        = wp.data.select( 'core/editor' );
						const isEditorReady      = editorStore.getEditedPostAttribute( 'status' ) !== undefined;
						const isSavingPost       = editorStore.isSavingPost ? editorStore.isSavingPost() : false;
						const isAutosavingPost   = editorStore.isAutosavingPost ? editorStore.isAutosavingPost() : false;
						const isPostSavingLocked = editorStore.isPostSavingLocked ? editorStore.isPostSavingLocked() : false;

						if ( isEditorReady ) {
							initializeCodeMirror();
							refreshCodeMirror();
						}

						if ( isSavingPost && ! isAutosavingPost && ! isPostSavingLocked ) {
							if ( codeMirrorEditor && codeMirrorEditor.codemirror ) {
								customCSSField.value = codeMirrorEditor.codemirror.getValue();
							}
						}
					});
				}
			}

			function detectEditor() {
				if ( typeof wp !== 'undefined' && wp.data && wp.domReady && wp.editPost ) {
					handleGutenbergEditor();
				} else {
					handleClassicEditor();
				}
			}

			detectEditor();
		}
		/*==============================================================*/
		// Custom CSS
		/*==============================================================*/

		// Check if the tools container exists
		setTimeout( function() {
			const toolsDiv = document.querySelector( '.post-type-post .editor-document-tools' );
			if ( toolsDiv && ! document.querySelector( '#ai_post_button' ) ) {
				// Create the button
				const button = document.createElement( 'button' );
				button.id = 'ai_post_button';
				button.className = 'crafto-ai-post-generate';
				button.innerHTML = '<img src="'+ CraftoMetabox.ai_post_button +'" class="attachment-full size-full" alt="ai-post-logo">';
				// Append the button into the toolbar container
				toolsDiv.appendChild( button );

				// Add a click event listener
				$( '#ai_post_button' ).on( 'click', function () {
					$( '.crafto-ai-template' ).css( 'display', 'grid' );
				} );

				$( '.crafto-ai-template--close' ).on( 'click', function () {
					$( '.crafto-ai-template' ).css( 'display', 'none' );
				} );
			}

		}, 500 );

		setTimeout( function() {
			$( '.crafto-ai-recreate' ).on( 'click', function( event ) {
				event.preventDefault();
				$( '.crafto-ai-template-content' ).toggleClass( 'result' ); // Remove the class
			});
		}, 2000 );

		$( 'form#crafto-ai-form' ).on( 'submit', function ( e ) {
			$( 'form#crafto-ai-form .button' ).toggleClass( 'ai-btn-loading' );
			$.ajax( {
				url: CraftoMetabox.ajaxurl,
				type: 'POST',
				data: {
					action: 'crafto_ai_post_actions',
					prompt: $( 'form#crafto-ai-form #prompt' ).val(),
					model: $( 'form#crafto-ai-form #model' ).val(),
					temperature: $( 'form#crafto-ai-form #temperature' ).val(),
					operation: 'post',
					language: $( 'form#crafto-ai-form #language' ).val(),
					tone_of_voice: $( 'form#crafto-ai-form #tone-of-voice' ).val(),
					maximum_length: $( 'form#crafto-ai-form #maximum-length' ).val(),
				},
				success: function ( data ) {

					$( 'form#crafto-ai-form .button' ).toggleClass( 'ai-btn-loading' );

					if ( data.error === true ) {
						alert( data.message );
					} else {
						$( '.crafto-ai-template-content' ).toggleClass( 'result' );
						add_form_data( 'insert_data', data.post );	
					}
				}
			} );
			e.preventDefault();
		} );

		function add_form_data( action, post ) {
			var title   = $( 'form#crafto-ai-form-result #title' ),
				content = $( 'form#crafto-ai-form-result #content' ),
				tags    = $( 'form#crafto-ai-form-result #tags' );

			switch ( action ) {
				case "insert_data":
					title.val( post.title );
					content.val( post.content );
					tags.val( post.tags );
					break;
			}
		}
		$( 'form#crafto-ai-form-result' ).on( 'submit', function ( e ) {
			$( 'form#crafto-ai-form-result .button' ).toggleClass( 'ai-btn-loading' );
			$.ajax( {
				url: CraftoMetabox.ajaxurl,
				type: 'POST',
				data: {
					action: 'crafto_ai_update_post',
					posts: {
						post_id: $( 'form#crafto-ai-form-result #post_id' ).val(),
						title: $( 'form#crafto-ai-form-result #title' ).val(),
						content: $( 'form#crafto-ai-form-result #content' ).val(),
						tags: $( 'form#crafto-ai-form-result #tags' ).val(),
					},
					security: $( 'form#crafto-ai-form #security' ).val()
				},
				success: function ( data ) {
					$( 'form#crafto-ai-form-result .button' ).toggleClass( 'ai-btn-loading' );
					$( '.crafto-ai-template-content' ).toggleClass( 'result' );
					$( '.crafto-ai-template' ).css( 'display', 'none' );

					if ( data.error === true ) {
						alert( data.message );
					} else {
						window.location.href = data.redirect;
					}

				}
			} );

			e.preventDefault();
		} );

		/** Custom meta datepicker and timepicker. */
		if ( $( '.inside, .form-field, .custom-meta-wrap' ).length > 0 ) {
			$( '.inside, .form-field, .custom-meta-wrap' ).each( function() {
				var datepicker = $( this ).find( '.custom-meta-datepicker' );
				var timepicker = $( this ).find( 'input[type="time"]' );

				datepicker.datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true,
					yearRange: "1900:2100",
				});

				flatpickr( timepicker, {
					enableTime: true,
					noCalendar: true,
					dateFormat: "H:i",
				});
			});
		}

		$( document ).on( 'click', '.upload-image-button', function ( e ) {
			e.preventDefault();

			const button = $( this ); // The clicked button
			const parentDiv = button.closest( '.custom-media' ); // Only this media block

			// Set up the media frame
			const mediaFrame = wp.media({
				title: 'Select or Upload Image',
				button: {
					text: 'Use this image'
				},
				multiple: false
			});

			// When an image is selected
			mediaFrame.on( 'select', function() {
				const attachment = mediaFrame.state().get( 'selection' ).first().toJSON();

				// Update the hidden input field with the selected image URL
				parentDiv.find( 'input[type="hidden"]' ).val( attachment.url );

				// Remove any previous image and insert the new one
				parentDiv.find( 'img' ).remove();
				parentDiv.prepend( '<img class="custom-upload-media-image" src="' + attachment.url + '" alt="Selected Image" width="100" />' );

				// Show the "Remove Image" button if not already shown
				if ( parentDiv.find( '.remove-image-button' ).length === 0 ) {
					parentDiv.append( '<button type="button" class="remove-image-button button">Remove Image</button>' );
				}
			});

			// Open the media frame
			mediaFrame.open();
		});

		$( document ).on( 'click', '.remove-image-button', function ( e ) {
			e.preventDefault();

			const $customMedia = $( this ).closest( '.custom-media' );
			$customMedia.find( 'img' ).remove(); // Remove the image
			$customMedia.find( 'input[type="hidden"]' ).val( '' ); // Clear the hidden input field

			$( this ).remove();
		});

		setTimeout( function() {
			function IconpickerCallback( state ) {
				if ( ! state.id ) {
					return state.text;
				}

				var icontext = state.text;
				if ( icontext.indexOf( 'fa-' ) >= 0 ) {
					var iconTextHTML = '';
						iconTextHTML += '<span>';
						iconTextHTML += '<i class="';
						iconTextHTML += state.element.value.toLowerCase();
						iconTextHTML += '"></i>  ';
						iconTextHTML += icontext;
						iconTextHTML += '</span>';
					var $state = $( iconTextHTML );
				} else {
					var iconTextHTML = '';
						iconTextHTML += '<span>';
						iconTextHTML += '<i class="';
						iconTextHTML += state.element.value;
						iconTextHTML += '"></i>  ';
						iconTextHTML += icontext;
						iconTextHTML += '</span>';
					var $state = $( iconTextHTML );
				}
				return $state;
			};

			if ( $( '.crafto-iconpicker' ).length > 0 ) {
				$( '.crafto-iconpicker' ).select2({
					placeholder: CraftoMetabox.custom_meta_iconpicker,
					allowClear: true,
					templateResult: IconpickerCallback,
					templateSelection: IconpickerCallback,
					width: '40%'
				});
			}
		}, 500 );
	});
})( jQuery );
