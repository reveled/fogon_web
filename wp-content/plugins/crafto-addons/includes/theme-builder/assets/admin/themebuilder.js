( function( $ ) {

	"use strict";

		var el_select2                  = $( '.crafto-dropdown-select2' );
		var el_themebuilder_single_list = $( '.themebuilder-single-list' );

		if ( el_themebuilder_single_list.length > 0 ) {
			el_themebuilder_single_list.select2( {
				placeholder: craftoBuilder.i18n.placeholder
			});
		}

		if ( el_select2.length > 0 ) {
			el_select2.select2();
		}

		$( window ).on( 'load', function( e ) {
			hashChange();
		});

		$( '#themebuilder-new-template-form-post-title' ).on( 'keypress', function() {
			$( '#themebuilder-new-template-form-post-title' ).removeClass( 'required' );
		});

		$( '#menu-posts-themebuilder ul.wp-submenu li:nth-child(3)' ).on( 'click', function() {
			$( window ).on( 'hashchange', function() {
				hashChange();
			});
		});

		var href                  = $( '.nav-tab-active' ).attr( 'href' ),
			url                   = new URL( href, window.location.href ),
			templateType          = url.searchParams.get( 'template_type' ),
			$select_first_val     = $( '#themebuilder-template-type' ),
			select_template       = document.querySelector( '#themebuilder-template-type' ),
			select_template_style = $( '#themebuilder-template-style' );

		$select_first_val.find( 'option' ).each( function() {
			var $thisItem = $( this ); 
			if ( $thisItem.val() === templateType ) {
				$thisItem.prop( 'selected', true );
			}

			if ( 'all' === templateType ) {
				if ( $thisItem.val() === 'header' ) {
					$thisItem.prop( 'selected', true );
				}
			}
		});

		$( '.page-title-action:first' ).on( 'click', function() {
			if ( typeof( select_template ) != 'undefined' && select_template != null ) {
				var event = new Event( 'change' );
				$select_first_val.trigger( 'change' );
				select_template.dispatchEvent( event );
			}
		
			showModal();
			return false;
		});

		$( '.themebuilder-outer .close' ).on( 'click', function() {
			$( '.themebuilder-outer' ).fadeOut( 'slow' );
		});

		select_template.addEventListener( 'change', function( e ) {
			e.preventDefault();
			var _self         = $( this ),
				_parents      = _self.parents( '.themebuilder-inner' ),
				template_type = _self.val();

			if ( 'undefined' === typeof template_type || '' === template_type ) {
				return;
			}

			_parents.find( '.input-field-control' ).hide();
			_parents.find( '.' + template_type + '-form-field' ).show();

			let crafto_post_type = 'post';
			if ( 'single-portfolio' === template_type ) {
				crafto_post_type = 'portfolio';
			} else if ( 'single-properties' === template_type ) {
				crafto_post_type = 'properties';
			} else if ( 'single-tours' === template_type ) {
				crafto_post_type = 'tours';
			}

			if ( 'single' === template_type || 'single-portfolio' === template_type || 'single-properties' === template_type || 'single-tours' === template_type ) {
				$.ajax( {
					type: 'POST',
					url: craftoBuilder.ajaxurl,
					data: {
						'crafto_post_type': crafto_post_type,
						'action': 'crafto_get_posts_list_callback',
					},
					success: function( response ) {
						if ( response.length ) {
							$( '#themebuilder-' + template_type + '-list' ).html( response );
						}
					}
				});

				$.ajax( {
					type: 'POST',
					url: craftoBuilder.ajaxurl,
					data: {
						'crafto_post_type': crafto_post_type,
						'action': 'crafto_get_exclude_posts_list_callback',
					},
					success: function( response ) {
						if ( response.length ) {
							$( '#themebuilder-' + template_type + '-exclude-list' ).html( response );
						}
					}
				});

				_parents.find( '.input-field-control' ).hide();
				_parents.find( '.' + template_type + '-form-field' ).show();

				return false;
			}
		});
		
		function toggleStickyType() {
			var templateType = $( '#themebuilder-template-type' ).val();
			var headerStyle = select_template_style.val();
			
			if ( 'header' === templateType ) {
				if ( 'standard' === headerStyle ) {
					$( '.header-form-field' ).has( '#themebuilder-sticky-style' ).show();
				} else {
					$( '.header-form-field' ).has( '#themebuilder-sticky-style' ).hide();
				}
			}
		}
	
		toggleStickyType();
	
		select_template_style.on( 'change', function() {
			toggleStickyType();
		});
		select_template.addEventListener( 'change', function(  ) {
			toggleStickyType();
		});

		$( document ).on( 'click', '.create-template-button', function( event ) {
			event.preventDefault();

			var template_type                    = $( '.themebuilder-form-field-template option' ).filter( ':selected' ).val(),
				template_style                   = $( '.themebuilder-form-field-template-style option' ).filter( ':selected' ).val(),
				mini_header_sticky_style         = $( '.themebuilder-mini-header-sticky-style option' ).filter( ':selected' ).val(),
				header_sticky_style              = $( '.themebuilder-form-field-sticky-style option' ).filter( ':selected' ).val(),
				header_display_style             = $( '.themebuilder-form-field-display-style' ).select2().val(),
				crafto_footer_display_type       = $( '.themebuilder-form-field-footer-display-style' ).select2().val(),
				crafto_custom_title_display_type = $( '.themebuilder-form-field-custom-title-display-style' ).select2().val(),
				crafto_mini_header_display_type  = $( '.themebuilder-form-field-mini-header-display-style' ).select2().val(),
				footer_sticky_style              = $( '.themebuilder-footer-sticky-style option' ).filter( ':selected' ).val(),
				archive_style                    = $( '.themebuilder-form-field-archive-style' ).select2().val(),
				archive_portfolio_style          = $( '.themebuilder-form-field-archive-portfolio-style' ).select2().val(),
				archive_property_style           = $( '.themebuilder-form-field-archive-property-style' ).select2().val(),
				archive_tours_style              = $( '.themebuilder-form-field-archive-tours-style' ).select2().val(),
				specific_posts                   = $( '.themebuilder-single-list' ).select2().val(),
				specific_portfolio               = $( '.themebuilder-single-portfolio-list' ).select2().val(),
				specific_properties              = $( '.themebuilder-single-properties-list' ).select2().val(),
				specific_tours                   = $( '.themebuilder-single-tours-list' ).select2().val(),
				specific_exclude_posts           = $( '.themebuilder-single-exclude-list' ).select2().val(),
				specific_exclude_portfolio       = $( '.themebuilder-single-portfolio-exclude-list' ).select2().val(),
				specific_exclude_properties      = $( '.themebuilder-single-properties-exclude-list' ).select2().val(),
				specific_exclude_tours           = $( '.themebuilder-single-tours-exclude-list' ).select2().val(),
				template_title                   = $( '.themebuilder-new-template-form-post-title' ).val();

			if ( 'undefined' === typeof template_type || '' === template_type ) {
				return;
			}

			$.ajax( {
				type: 'POST',
				url: craftoBuilder.ajaxurl,
				data: {
					'action': 'crafto_theme_builder_lightbox',
					'template_type': template_type,
					'mini_header_sticky_style':	mini_header_sticky_style,
					'template_style': template_style,
					'header_sticky_style': header_sticky_style,
					'header_display_style': header_display_style,
					'crafto_footer_display_type': crafto_footer_display_type,
					'crafto_custom_title_display_type': crafto_custom_title_display_type,
					'crafto_mini_header_display_type': crafto_mini_header_display_type,
					'footer_sticky_style': footer_sticky_style,
					'archive_style': archive_style,
					'archive_portfolio_style': archive_portfolio_style,
					'archive_property_style': archive_property_style,
					'archive_tours_style': archive_tours_style,
					'specific_posts': specific_posts,
					'specific_exclude_posts': specific_exclude_posts,
					'specific_portfolio': specific_portfolio,
					'specific_exclude_portfolio': specific_exclude_portfolio,
					'specific_properties': specific_properties,
					'specific_exclude_properties': specific_exclude_properties,
					'specific_tours': specific_tours,
					'specific_exclude_tours': specific_exclude_tours,
					'template_title': template_title
				},
				success: function( response ) {
					if ( 0 === response.length ) {
						alert( craftoBuilder.i18n.responseErrorMessage );
					} else {
						window.location.href = response;
					}
				}
			});
			return false;
		});

		function hashChange() {
			if ( '#add_new' === location.hash ) {
				if ( typeof( select_template ) != 'undefined' && select_template != null ) {
					var event = new Event( 'change' );
					$select_first_val.trigger( 'change' );
					select_template.dispatchEvent( event );
				}
				showModal();
				location.hash = '';
			}
		}
		function showModal() {
			$( '.themebuilder-outer' ).fadeIn( 'slow' );
			return false;
		}
}( jQuery ));
