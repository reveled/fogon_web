( function( $ ) {

	"use strict";

	const $document = $( document );

	$document.ready( function() {
		/* On type check validation */
		$document.on( 'input', '.posttypesform #name, .taxonomiesui #name', function() {
			let $elThis    = $( this );
			let $thisValue = $elThis.val();

			if ( $thisValue === '' ) {
				$elThis.addClass( 'input-error' );
			} else {
				$elThis.removeClass( 'input-error' );
			}

			$elThis.val( generateSlug( $thisValue ) );
		});

		function generateSlug( value ) {
			return value
				.toLowerCase()
				.replace(/\s+/g, '_')
				.replace(/[^a-z_-]/g, '')
				.slice(0, 20);
		}

		/* On leave check validation */
		$document.on( 'blur', '.posttypesform #name, .posttypesform #label, .posttypesform #singular_label, .taxonomiesui #name, .taxonomiesui #label, .taxonomiesui #singular_label, .metaui #meta_slug, .metaui #meta_label, .metaui #title', function() {
			let $elThis    = $( this );
			let $thisValue = $elThis.val().trim();
			if ( $thisValue === '' ) {
				$elThis.addClass( 'input-error' );
			} else {
				$elThis.removeClass( 'input-error' );
			}
		});

		/* On post type form submit check validation */
		$( '.posttypesform' ).on( 'submit', function( event ) {
			let isValid         = true;
			const clickedButton = event.originalEvent.submitter;
			const action        = clickedButton.value;

			if ( action == 'Update Post Type' || action == 'Add Post Type' ) {
				$( this ).find( '#name, #label, #singular_label' ).each( function() {
					let $elThis    = $( this );
					let $thisValue = $elThis.val().trim();
					if ( $thisValue === '' ) {
						$elThis.addClass( 'input-error' );
						isValid = false;
					} else {
						$elThis.removeClass( 'input-error' );
					}
				});
			} else if ( action == 'Delete Post Type' ) {
				const confirmDelete = confirm( register_post_type_ajax_object.delete_posttype_confirm );
				if ( ! confirmDelete ) {
					isValid = false;
				}
			}

			if ( ! isValid ) {
				event.preventDefault();
			}
		});

		/* On taxonomies form submit check validation */
		$document.on( 'submit', '.taxonomiesui', function( event ) {
			let isValid         = true;
			const clickedButton = event.originalEvent.submitter;
			const action        = clickedButton.value;
			
			if ( action == 'Update Taxonomy' || action == 'Add Taxonomy' ) {
				$( this ).find( '#name, #label, #singular_label' ).each( function() {
					let $elThis    = $( this );
					let $thisValue = $elThis.val().trim();
					if ( $thisValue === '' ) {
						$elThis.addClass( 'input-error' );
						isValid = false;
					} else {
						$elThis.removeClass( 'input-error' );
					}
				});
	
				if ( $( 'input[name="crafto_post_types[]"]:checked' ).length === 0 ) {
					const userConfirmed = confirm( register_post_type_ajax_object.post_types_checkbox );
					isValid = false;
				}
			} else if ( action == 'Delete Taxonomy' ) {
				const confirmDelete = confirm( register_post_type_ajax_object.delete_taxonomy_confirm );
				if ( ! confirmDelete ) {
					isValid = false;
				}
			}
		
			if ( ! isValid ) {
				event.preventDefault();
			}
		});

		 /* Delete post type from listing */
		$document.on( 'click', '.delete-post', function( event ) {
			event.preventDefault();

			const $elThis      = $( this );
			const redirectUrl  = $elThis.attr( 'href' );
			const posttypeSlug = $elThis.data( 'posttype' );

			if ( redirectUrl !== '' && posttypeSlug !== '' ) {
				if ( confirm( register_post_type_ajax_object.delete_posttype_confirm ) ) {
					$.ajax({
						url: register_post_type_ajax_object.ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							'action': 'delete_custom_post_type',
							'redirect_url': redirectUrl,
							'posttype_slug': posttypeSlug,
						},
						success: function( response ) {
							if ( response.success ) {
								location.reload();
							} else {
								alert( 'An error occurred. Please try again.' );
							}
						},
						error() {
							alert( 'Failed to process the request. Please check your connection and try again.' );
						}
					});
				}
			}
		});

		/* Delete taxonomies from listing */
		$document.on( 'click', '.delete-taxonomies', function( event ) {
			event.preventDefault();

			const $elThis        = $( this );
			const redirectUrl    = $elThis.attr( 'href' );
			const taxonomiesSlug = $elThis.data( 'taxonomies' );

			if ( redirectUrl !== '' && taxonomiesSlug !== '' ) {
				if ( confirm( register_post_type_ajax_object.delete_taxonomy_confirm ) ) {
					$.ajax({
						url: register_post_type_ajax_object.ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							'action': 'delete_custom_taxonomies',
							'redirect_url': redirectUrl,
							'taxonomies_slug': taxonomiesSlug,
						},
						success: function( response ) {
							if ( response.success ) {
								location.reload();
							} else {
								alert( 'An error occurred. Please try again.' );
							}
						},
						error() {
							alert( 'Failed to process the request. Please check your connection and try again.' );
						}
					});
				}
			}
		});

		/* Toggle fields section */
		$document.on( 'click', '.registered-post-type-main-left .main-title, .registered-post-meta-main-left .main-title', function( event ) {
			event.preventDefault();
			$( this ).toggleClass( 'active' );
		});
		
		$( '#post_type_for, #taxonomies_for' ).select2();
		$( '.post_type_for, .taxonomies_for, .visible_at, .select_value, .option_value, .radio_value' ).hide();

		// Listen for changes to the 'meta_for' dropdown
		$document.on( 'change', '#meta_for', function( event ) {
			let selectedValue = $( this ).val();
			// Hide all fields first
			$( '.post_type_for, .taxonomies_for, .visible_at' ).hide();

			// Show the selected field based on the value
			if ( selectedValue === 'post' ) {
				$( '.post_type_for' ).show(); // Show post-related fields
			} else if ( selectedValue === 'taxonomy' ) {
				$( '.taxonomies_for' ).show(); // Show taxonomy-related fields
			} else if ( selectedValue === 'user' ) {
				$( '.visible_at' ).show(); // Show user-related fields
			}
		});

		$document.on( 'change', '#field_type', function( event ) {
			let selectedFieldValue = $( this ).val();
			// Hide all fields first.
			$( '.select_value, .option_value, .radio_value' ).hide();

			// Show the selected field based on the value
			if ( selectedFieldValue === 'select' ) {
				$( '.select_value' ).show();
			} else if ( selectedFieldValue === 'checkbox' ) {
				$( '.option_value' ).show();
			} else if ( selectedFieldValue === 'radio' ) {
				$( '.radio_value' ).show();
			}
		});

		// Trigger change event on page load to show the correct field
		$( '#meta_for, #field_type' ).trigger( 'change' );

		$document.on( 'blur', '#meta_label', function() {
			let labelValue = $( this ).val().trim();
			let $slugField = $( '#meta_slug' );

			if ( labelValue && $slugField.val().trim() === '' ) {
				let meta_slug = labelValue
					.toLowerCase()
					.replace( /\s+/g, '_' )
					.replace( /[^a-z0-9_-]/g, '' )
					.slice( 0, 20 );

				$slugField.val( meta_slug );
			}
		});

		$document.on( 'input', '#meta_slug', function() {
			let $thisItem = $( this );
			let meta_slug = $this.val()
				.toLowerCase()
				.replace( /\s+/g, '_' )
				.replace( /[^a-z0-9_-]/g, '' )
				.slice( 0, 20 );

			$thisItem.val( meta_slug );
		});

		$document.on( 'input', '#title', function() {
			let $thisItem = $( this );
			let clean_val = $thisItem.val().replace(/[^a-zA-Z0-9 _-]/g, '');
			$thisItem.val( clean_val );
		});

		$document.on( 'submit', '.metaui', function( event ) {
			let isValid         = true;
			const clickedButton = event.originalEvent.submitter;
			const action        = clickedButton.value;

			if ( action == 'Delete Meta Box' ) {
				const confirmDelete = confirm( register_post_type_ajax_object.delete_meta_confirm );
				if ( ! confirmDelete ) {
					isValid = false;
				}
			}

			if ( ! isValid ) {
				event.preventDefault();
			}
		});

		const $existingMeta = $( '#select_existing_meta' );
		const $titleInput   = $( '#id_title #title' );
		$existingMeta.on( 'change', function() {
			const selectedValue = $( this ).val();
			$titleInput.val( selectedValue === 'add_meta' ? '' : selectedValue );
		});

		/* Delete meta from listing */
		$document.on( 'click', '.delete-post-meta', function( event ) {
			event.preventDefault();

			const $elThis     = $( this );
			const redirectUrl = $elThis.attr( 'href' );
			const metaField   = $elThis.data( 'metatype' );

			if ( redirectUrl !== '' && metaField !== '' ) {
				if ( confirm( register_post_type_ajax_object.delete_meta_confirm ) ) {
					$.ajax({
						url: register_post_type_ajax_object.ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							'action': 'delete_custom_meta',
							'redirect_url': redirectUrl,
							'meta_field': metaField,
						},
						success: function( response ) {
							if ( response.success ) {
								location.reload();
							} else {
								alert( 'An error occurred. Please try again.' );
							}
						},
						error() {
							alert( 'Failed to process the request. Please check your connection and try again.' );
						}
					});
				}
			}
		});

		const searchInput = document.getElementById( 'crafto-posttype-search' );
		const rows = document.querySelectorAll( '.crafto-list-table-items' ); // your selector

		if ( searchInput ) {
			let noDataMsg = document.createElement( 'div' );
			noDataMsg.id = 'crafto-no-data-message';
			noDataMsg.textContent = register_post_type_ajax_object.post_types_no_data;
			noDataMsg.style.display = 'none';

			if ( rows.length > 0 ) {
				const tableContainer = document.querySelector( '.crafto-posttype-list-table' );
				if ( tableContainer ) {
					tableContainer.appendChild( noDataMsg );
				}
			}

			searchInput.addEventListener( 'input', function () {
				const query = this.value.toLowerCase();
				let visibleCount = 0;
	
				rows.forEach( function ( row ) {
					const nameCell = row.querySelector( '.crafto-list-table-item.name' );
					if ( nameCell ) {
						const text = nameCell.textContent.toLowerCase();
						if ( text.includes( query ) ) {
							row.style.display = '';
							visibleCount++;
						} else {
							row.style.display = 'none';
						}
					}
				});

				const hasNotFoundRow = Array.from( rows ).some( row => row.querySelector( '.not-found' ) );

				if ( hasNotFoundRow ) {
					noDataMsg.style.display = 'none';
				} else {
					noDataMsg.style.display = visibleCount === 0 ? 'block' : 'none';
				}
			});
		}
	});

})( jQuery );
