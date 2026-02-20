( function( $, settings ) {

	'use strict';
	
	var craftoMenuAdmin = {

		instance: [],

		init: function() {

			this.initTriggers();
			$( document ).ready( this.render );
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-menu-trigger', this.initPopup );
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-menu-tabs__nav-item', this.switchTabs );
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-menu-editor', this.openEditor );
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-save-menu', this.saveMenu );
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-menu-popup__close', this.closePopup );
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-close-frame', this.closeEditor )
			$( document ).on( 'click.craftoMenuAdmin', '.crafto-menu-popup__overlay', this.closePopup )
		},
		render: function() {
			$( document ).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
				if ( ! $( event.target ).is( 'a' ) ) {
					var id = $( this ).find( '.crafto-menu-trigger' ).attr( 'data-item-id' );
					if ( $( '#crafto-popup-' + id ).length > 0 ) {
						$( '#crafto-popup-' + id ).remove();
					}
					setTimeout( update_megamenu_item_depth, 200 );
				}
			});

			function update_megamenu_item_depth() {
				var menu_li_items = $( '.menu-item' );
				menu_li_items.each( function( i ) {
					var depth = craftoMenuAdmin.getItemDepth( $( this ) );
					$( this ).find( '.crafto-menu-trigger' ).attr( 'data-item-depth', depth );
				});
			}

			$( document ).on( 'click', '.crafto_upload_button', function( event ) {
				var file_frame,
					button        = $( this ),
					button_parent = $( this ).parent(),
					id            = button_parent.find( '.upload_field' ).attr( 'class' ),
					remove_btn    = button_parent.find( '.crafto_remove_button' );

					event.preventDefault();
	
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
					var full_attachment = file_frame.state().get( 'selection' ).first().toJSON(),
						attachment      = file_frame.state().get( 'selection' ).first(),
						thumburl        = attachment,
						thumb_hidden    = button_parent.find( '.upload_field' ).attr( 'name' );
	
					if ( thumburl || full_attachment ) {
						button_parent.find( '.upload_field' ).val( full_attachment.id );
						button_parent.find( '.' + thumb_hidden + '_id' ).val( full_attachment.id );
						button_parent.find( '.upload_image_screenshort' ).attr( 'src', full_attachment.url );
						button_parent.find( '.upload_image_screenshort' ).slideDown();
						$( remove_btn ).removeClass( 'hidden' );
					}
				});
	
				// Finally, open the modal
				file_frame.open();
			});

			$( document ).on( 'click', '.crafto_remove_button', function( event ) {
				var remove_parent = $( this ).parent();
				remove_parent.find( '.upload_field' ).val( '' );
				remove_parent.find( 'input[type="hidden"]' ).val( '' );
				remove_parent.find( '.upload_image_screenshort' ).slideUp();
				$( this ).addClass( 'hidden' );
			});

			$( document ).on( 'click', '.enable-mega-submenu', function( event ) {
				var _self = $( this );
				var selectValue = $( '#select_mega_menu' ).val();

				if ( _self.is( ':checked' ) ) {

					$( '.menu-content-tb' ).removeClass( 'display-none' );

					if ( 'default' === selectValue ) {
						$( '.crafto-megamenu-hover-color' ).addClass( 'display-none' );
					} else {
						$( '.crafto-megamenu-hover-color' ).removeClass( 'display-none' );
					}
				} else {
					$( '.menu-content-tb' ).addClass( 'display-none' );
					$( '.crafto-megamenu-hover-color' ).addClass( 'display-none' );
				}
			});

			$( document ).on( 'change', '#select_mega_menu', function( event ) {
				var _self = $( this );
				if ( _self.val() === 'default' ) {
					$( '.crafto-megamenu-hover-color' ).addClass( 'display-none' );  // Hide the div when Full Width is selected
				} else {
					$( '.crafto-megamenu-hover-color' ).removeClass( 'display-none' );  // Show the div for other selections
				}
			});
		},
		saveMenu: function() {

			var _this                 = $( this ),
				data                  = [],
				preparedData          = {},
				current_menu_itemt_id = _this.parents( '.crafto-menu-popup' ).data( 'id' );
				data                  = $( '.crafto-menu-tabs__content input, .crafto-menu-tabs__content select' ).serializeArray();
				
			$.each( data, function( index, field ) {
				preparedData[ field.name ] = field.value;
			});

			preparedData.action                = 'crafto_save_mega_menu_settings';
			preparedData.current_menu          = settings.currentMenuId;
			preparedData.current_menu_itemt_id = current_menu_itemt_id;

			_this.parent().find( '.spinner' ).css( 'visibility', 'visible' );

			$.ajax( {
				url: ajaxurl,
				type: 'post',
				dataType: 'json',
				data: preparedData
			} ).done( function( response ) {

				_this.parent().find( '.spinner' ).css( 'visibility', 'hidden' );
				if ( true === response.success ) {
					_this.parent().find( '.dashicons-yes' ).removeClass( 'hidden' );
					setTimeout( function() { 
						_this.parent().find( '.dashicons-yes' ).addClass( 'hidden' );
						_this.parents( '.crafto-menu-popup' ).addClass( 'crafto-hidden' );
					}, 1000 );
				}
			});
		},
		getItemId: function( $item ) {

			var id = $item.attr( 'id' );
			return id.replace( 'menu-item-', '' );
		},
		getItemDepth: function( $item ) {

			var depthClass = $item.attr( 'class' ).match( /menu-item-depth-\d/ );

			if ( ! depthClass[0] ) {
				return 0;
			}

			return depthClass[0].replace( 'menu-item-depth-', '' );
		},
		initTriggers: function() {

			var trigger = wp.template( 'menu-trigger' );

			$( document ).on( 'menu-item-added', function( event, $menuItem ) {
				var id = craftoMenuAdmin.getItemId( $menuItem );
				$menuItem.find( '.item-title' ).append( trigger( { id: id, label: settings.i18n.triggerLabel } ) );
			});

			$( '#menu-to-edit .menu-item' ).each( function() {
				var _this = $( this ),
					depth = craftoMenuAdmin.getItemDepth( _this ),
					id    = craftoMenuAdmin.getItemId( _this );

				_this.find( '.item-title' ).append( trigger( {
					id: id,
					depth: depth,
					label: settings.i18n.triggerLabel
				} ) );
			});

			$( '.crafto-menu-icons, .select-mega-menu' ).select2();
		},
		initPopup: function(event) {

			var _this   = $( this ),
				id      = _this.attr( 'data-item-id' ),
				depth   = _this.attr( 'data-item-depth' ),
				content = null,
				wrapper = wp.template( 'popup-wrapper' ),
				tabs    = wp.template( 'popup-tabs' );

			content = wrapper( {
				id: id,
				content: tabs(
					{
						tabs: settings.tabs,
						depth: depth,
						menulogourl: settings.i18n.menulogourl
					},
				),
				saveLabel: settings.i18n.saveLabel,
			});

			$( 'body' ).append( content );
			craftoMenuAdmin.instance[ id ] = '#crafto-popup-' + id;

			$( craftoMenuAdmin.instance[ id ] ).removeClass( 'crafto-hidden' );

			craftoMenuAdmin.menuId = id;
			craftoMenuAdmin.depth  = depth;

			craftoMenuAdmin.tabs.showActive(
				$( craftoMenuAdmin.instance[ id ] ).find( '.crafto-menu-tabs__nav-item:first' )
			);
		},
		tabs: {
			showActive: function( $item ) {
				var tab      = $item.data( 'tab' ),
					action   = $item.data( 'action' ),
					template = $item.data( 'template' ),
					$content = $item.closest( '.crafto-settings-tabs' ).find( '.crafto-menu-tabs__content-item[data-tab="' + tab + '"]' ),
					loaded   = parseInt( $content.data( 'loaded' ) );

				if ( $item.hasClass( 'crafto-active-tab' ) ) {
					return;
				}

				var timeout_time = 200;
				if ( 0 === loaded ) {
					timeout_time = 900;
					setTimeout( function() {
						craftoMenuAdmin.tabs.loadTabContent( tab, $content, template, action );
					}, 100 );
				}

				$item.addClass( 'crafto-active-tab' ).siblings().removeClass( 'crafto-active-tab' );
				$content.removeClass( 'crafto-hidden-tab' ).siblings().addClass( 'crafto-hidden-tab' );

				$( $content ).append( '<div class="preloading-wrap"><div class="preloading"></div></div>' );
				
				setTimeout( function() {
					function MenuIconCallback( state ) {
						
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

					if ( $( '.crafto-menu-icons' ).length > 0 ) {
						$( '.crafto-menu-icons' ).select2({
							placeholder: CraftoMegamenu.i18n.placeholder,
							allowClear: true,
							templateResult: MenuIconCallback,
							templateSelection: MenuIconCallback,
							width: '50%'
						});
					}

					if ( $( '.select-mega-menu' ).length > 0 ) {
						$( '.select-mega-menu' ).select2({
							placeholder: CraftoMegamenu.i18n.selectMegamenu,
							allowClear: true,
							width: '50%'
						});
					}

					if ( $( '.menu-item-label-color' ).length > 0 ) {
						$( '.menu-item-label-color' ).wpColorPicker();
					}

					if ( $( '.crafto_megamenu_hover_color' ).length > 0 ) {
						$( '.crafto_megamenu_hover_color' ).wpColorPicker();
					}

					if ( $( '.menu-item-label-bg-color' ).length > 0 ) {
						$( '.menu-item-label-bg-color' ).wpColorPicker();
					}

					$( $content ).find( '.preloading-wrap' ).remove();
					
				}, timeout_time );
			},
			loadTabContent: function( tab, $content, template, action ) {

				if ( ! template && ! action ) {
					return;
				}

				var renderTemplate = null,
					$popup         = $content.closest( '.crafto-menu-popup' ),
					id             = $popup.attr( 'data-id' ),
					data           = {};

				$content.has( '.tab-loader' ).addClass( 'tab-loading' );

				if ( ! template ) {
					if ( 0 < settings.tabs[ tab ].data.length ) {
						data = settings.tabs[ tab ].data;
						data.action  = action;
						data.menu_id = id;
					} else {
						data = {
							action: action,
							menu_id: id
						};
					}
					$.ajax({
						url: ajaxurl,
						type: 'post',
						data: data

					}).done( function( response ) {
						$content.removeClass( 'tab-loading' ).html( response );

					});

				} else {
					renderTemplate = wp.template( template );
					$content.html( renderTemplate( settings.tabs[ tab ].data ) );
				}
				
				$content.data( 'loaded', 1 );
			}
		},
		switchTabs: function() {
			craftoMenuAdmin.tabs.showActive( $( this ) );
		},
		openEditor: function() {

			var $popup   = $( this ).closest( '.crafto-menu-popup' ),
				menuItem = $popup.attr( 'data-id' ),
				url      = settings.editURL.replace( '%id%', menuItem ),
				frame    = null,
				loader   = null,
				editor   = wp.template( 'editor-frame' );
				url      = url.replace( '%menuid%', settings.currentMenuId );
				
			$popup
				.addClass( 'crafto-menu-editor-active' )
				.find( '.crafto-menu-editor-wrap' )
				.addClass( 'crafto-editor-active' )
				.html( editor( { url: url } ) );

			frame  = $popup.find( '.crafto-edit-frame' )[0];
			loader = $popup.find( '#elementor-loading' );

			$( frame.contentWindow ).on( 'load', function() {
				$popup.find( '.crafto-close-frame' ).addClass( 'crafto-loaded' );
				loader.fadeOut( 300 );
			});

		},
		closePopup: function( event ) {

			event.preventDefault();

			craftoMenuAdmin.menuId = 0;
			craftoMenuAdmin.depth  = 0;

			$( this )
				.closest( '.crafto-menu-popup' ).addClass( 'crafto-hidden' )
				.removeClass( 'crafto-menu-editor-active' )
				.find( '.crafto-menu-editor-wrap.crafto-editor-active' ).removeClass( 'crafto-editor-active' )
				.find( '.crafto-close-frame' ).removeClass( 'crafto-loaded' )
				.siblings( '#elementor-loading' ).fadeIn( 0 );
		},
		closeEditor: function( event ) {
			var _this    = $( this ),
				$popup   = _this.closest( '.crafto-menu-popup' ),
				$frame   = $( this ).siblings( 'iframe' ),
				$loader  = $popup.find( '#elementor-loading' ),
				$editor  = $frame.closest( '.crafto-menu-editor-wrap' ),
				$content = $frame[0].contentWindow,
				saver    = null,
				enabled  = true;

			if ( $content.elementor.saver && 'function' === typeof $content.elementor.saver.isEditorChanged ) {
				saver = $content.elementor.saver;
			} else if ( 'function' === typeof $content.elementor.isEditorChanged ) {
				saver = $content.elementor;
			}

			if ( null !== saver &&  true === saver.isEditorChanged() ) {
				if ( ! confirm( settings.i18n.leaveEditor ) ) {
					enabled = false;
				}
			}

			if ( ! enabled ) {
				return;
			}

			$loader.fadeIn(0);
			$popup.removeClass( 'crafto-menu-editor-active' );
			_this.removeClass( 'crafto-loaded' );
			$editor.removeClass( 'crafto-editor-active' );
		},
	}

	craftoMenuAdmin.init();

}( jQuery, window.CraftoMegamenu ) );