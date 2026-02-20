( function( $ ) {

	'use strict';
	
	var customFonts   = [];
	var customTypekit = false;

	var CraftoEditor = {
		init: function() {
			window.elementor.on( 'preview:loaded', CraftoEditor.onPreviewLoaded );
			window.elementor.channels.editor.on( 'font:insertion', CraftoEditor.onFontChange );
			window.elementor.on( 'panel:init', CraftoEditor.addMenuItems );

			// Set up a listener for the panel changes
			function updateTabsClass() {
				const styleTabActive = $( '.elementor-tab-control-style' ).hasClass( 'elementor-active' );
				if ( styleTabActive ) {
					$( '.elementor-control-type-section.e-open' ).each( function() {
						$( '.elementor-control-type-tabs' ).each( function() {
							var hasHiddenControl = $( this ).find( '.elementor-hidden-control' ).length > 0;
							var has_hidden_class = $( '.elementor-control-type-tabs' ).hasClass( 'elementor-hidden-control' );
							if ( hasHiddenControl && ! has_hidden_class ) {
								$( this ).addClass( 'remove-tab-spacing' );
							} else {
								$( this ).removeClass( 'remove-tab-spacing' );
							}
						});
					});
				} else {
					$( '.elementor-control-type-tabs' ).removeClass( 'remove-tab-spacing' );
				}
			}

			/* AI Image Generation JS START */

			$( document ).on( 'click', '#ai_image_button', function( e ) {
				e.preventDefault();

				const widget_type = $( this ).attr( 'data-aicontroltype' );

				if ( $( '#crafto_ai_image_modal' ).length === 0 ) {
					$.ajax({
						url: CraftoEditorScript.ajaxurl,
						type: 'POST',
						data: {
							action: 'get_modal_ai_image_html'
						},
						success: function( response ) {
							if ( response.success ) {
								if ( $( '#crafto_ai_image_modal' ).length === 0 ) {
									$( 'body' ).append( response.data );
									$( '.close-icon' ).on( 'click', function() {
										$( '#crafto_ai_image_modal' ).hide();
									} );
								}
							}
						},
					});
				}

				$( '#crafto_ai_image_modal' ).show();
				setTimeout( function() {
					$( '#generate_image' ).off( 'click' ).on( 'click', function() {
						const prompt          = $( '#ai_prompt' ).val();
						const size            = $( '#image_size' ).val();
						const image_art       = $( '#image_art' ).val();
						const image_lightning = $( '#image_lightning' ).val();
						const image_mood      = $( '#image_mood' ).val();
						const image_number    = $( '#image_number' ).val();
						const image_quality   = $( '#image_quality' ).val();
	
						if ( prompt === '' ) {
							alert( CraftoEditorScript.ai_image_prompt_empty_alert );
							return;
						}

						$( '#generate_image' ).toggleClass( 'ai-btn-loading' );
	
						$.ajax({
							url: CraftoEditorScript.ajaxurl,
							method: 'POST',
							data: {
								action: 'generate_ai_image',
								prompt: prompt,
								size: size,
								image_art: image_art,
								image_lightning: image_lightning,
								image_mood: image_mood,
								image_number: image_number,
								image_quality: image_quality,
							},
							success: function( response ) {
								$( '#generate_image' ).toggleClass( 'ai-btn-loading' );
								const images = response.data;
								$( '#ai_images' ).empty();
								
								if ( images.length > 0 ) {
									const image_title = $( '<span>' ) .addClass( 'ai-images-title' ).html( 'Generated Image' );
									const image = images[0];
									const imgElement = $( '<img>' ).attr( 'src', image.url ).css({
										width: '200px',
									});
									const iconElement = $( '<span>' ).addClass( 'image-download-icon' );
									const descriptionElement = $( '<div>' ).addClass( 'description crafto-ai-recreate' ).html( 'Not satisfied? <span>Generate Again.</span>' );

									iconElement.on( 'click', function() {
										const selectedImageUrl = image.url;
										$( '#crafto_ai_image_modal' ).hide();
										$( window ).trigger( 'image_selected', [ selectedImageUrl, widget_type ] );
									});

									$( '#ai_images' ).append( image_title ).append( imgElement ).append( iconElement ).append( descriptionElement );
									$( '.crafto-ai-image-modal-content' ).toggleClass( 'result' );
								} else {
									images.forEach( image => {
										const image_title = $( '<span>' ).addClass( 'ai-images-title' ).html( 'Generated Image' );
										const imgElement = $( '<img>' ).attr( 'src', image.url ).css({
											width: '200px',
										});
										const iconElement = $( '<span>' ).addClass( 'image-download-icon' );
							
										iconElement.on( 'click', function() {
											const selectedImageUrl = image.url;
											$( '#crafto_ai_image_modal' ).hide();
											$( window ).trigger( 'image_selected', [ selectedImageUrl, widget_type ] );
										});
							
										$( '#ai_images' ).append( image_title ).append( imgElement ).append( iconElement ).append( descriptionElement );
										$( '.crafto-ai-image-modal-content' ).toggleClass( 'result' );
									});
								}
							},						
							error: function() {
								alert( CraftoEditorScript.ai_image_generating_error_alert );
							}
						});
					});
					$( document ).on( 'click', '.crafto-ai-recreate', function( e ) {
						$( '.crafto-ai-image-modal-content' ).toggleClass( 'result' );
					});
				}, 2000 );
			});

			// Handle image selection event
			$( window ).on( 'image_selected', function( event, selectedImageUrl, widget_type_image ) {
				var widget_type_image_selected = widget_type_image;

				$.ajax({
					url: CraftoEditorScript.ajaxurl,
					method: 'POST',
					data: {
						action: 'upload_ai_image',
						security: CraftoEditorScript.nonce,
						image_url: selectedImageUrl,
						aicontrol: widget_type_image_selected
					},
					success: function( response ) {
						if ( response.success ) {
							const attachmentId = response.data.attachment_id;
							var aicontrol_widgets = response.data.aicontrol;

							$.ajax({
								url: CraftoEditorScript.ajaxurl,
								method: 'POST',
								data: {
									action: 'get_attachment_url',
									attachment_id: attachmentId,
									aicontrol_widgets: aicontrol_widgets,
								},
								success: function( urlResponse ) {
									if ( urlResponse.success ) {
										const localImageUrl = urlResponse.data.url;
										const widget_name   = urlResponse.data.widget_name;

										if ( typeof elementor !== 'undefined' && elementor.getPanelView ) {
											const panelView = elementor.getPanelView();
											if ( panelView ) {
												const pageView = panelView.getCurrentPageView();
												if ( pageView && pageView.model ) {
													const model = pageView.model;

													model.setSetting( widget_name, { id: attachmentId, url: localImageUrl } );
													model.trigger( 'change:' + widget_name );
													elementor.reloadPreview();

													$( '.elementor-panel-footer-save' ).removeClass( 'elementor-button-disabled' ).prop( 'disabled', false );
													$( '.elementor-button' ).removeClass( 'elementor-disabled' ).prop( 'disabled', false );
													$( '.crafto-ai-image-modal-content' ).toggleClass( 'result' );
												}
											}
										}
									}
								},
							});
						}
					},
					error: function() {
						alert( CraftoEditorScript.ai_image_upload_failed_alert );
					}
				});
				
			});

			/* AI Image Generation JS END */

			/* AI Text Generation JS Start */

			$( document ).on( 'click', '#ai_text_button', function( e ) {
				e.preventDefault();

				const widget_type = $( this ).attr( 'data-aicontroltype' );

				if ( $( '#crafto_ai_text_modal' ).length === 0 ) {
					$.ajax({
						url: CraftoEditorScript.ajaxurl,
						type: 'POST',
						data: {
							action: 'get_modal_ai_content_html'
						},
						success: function( response ) {
							if ( response.success ) {
								if ( $( '#crafto_ai_text_modal' ).length === 0 ) {
									$( 'body' ).append( response.data );
									$( '.close-icon' ).on( 'click', function() {
										$( '#crafto_ai_text_modal' ).hide();
									} );
								}
							}
						},
					});
				}

				// Display the modal
				$( '#crafto_ai_text_modal' ).show();
				setTimeout( function() {
					$( 'form#crafto-ai-form' ).on( 'submit', function( e ) {
						$( 'form#crafto-ai-form .button' ).toggleClass( 'ai-btn-loading' );
						$.ajax( {
							url: CraftoEditorScript.ajaxurl,
							type: 'POST',
							data: {
								action: 'crafto_generate_openai_text',
								prompt: $( 'form#crafto-ai-form #prompt' ).val(),
								model: $( 'form#crafto-ai-form #model' ).val(),
								temperature: $( 'form#crafto-ai-form #temperature' ).val(),
								operation: 'post',
								language: $( 'form#crafto-ai-form #language' ).val(),
								tone_of_voice: $( 'form#crafto-ai-form #tone-of-voice' ).val(),
								maximum_length: $( 'form#crafto-ai-form #maximum-length' ).val(),
							},
							success: function( data ) {

								$( 'form#crafto-ai-form .button' ).toggleClass( 'ai-btn-loading' );
				
								if ( data.error === true ) {
									alert( data.message );
								} else {
									add_form_data( 'insert_data', data.post );
									$( '.crafto-ai-template-content' ).addClass( 'result' );
								}
							}
						} );
						e.preventDefault();
					} );

					$( 'form#crafto-ai-form-result' ).off( 'submit' ).on( 'submit', function( e ) {
						const textareaValue = document.getElementById( 'content' ).value;
						const panelView     = elementor.getPanelView();
						if ( panelView ) {
							const pageView = panelView.getCurrentPageView();
							if ( pageView && pageView.model ) {
								const model = pageView.model;

								model.setSetting( widget_type, textareaValue );

								model.trigger( 'change:' + widget_type );

								pageView.render();
								elementor.reloadPreview();
								$( '.elementor-panel-footer-save' ).removeClass( 'elementor-button-disabled' ).prop( 'disabled', false );
								$( '.elementor-button' ).removeClass( 'elementor-disabled' ).prop( 'disabled', false );
								$( ".crafto-ai-text-modal" ).css( 'display', 'none' );
							}
						}
						e.preventDefault();
					} );

					function add_form_data( action, post ) {
						var content = $( 'form#crafto-ai-form-result #content' );
				
						switch ( action ) {
							case "insert_data":
								content.val( post.content );
								break;
						}
					}

					$( document ).on( 'click', '.crafto-ai-recreate', function( e ) {
						e.preventDefault();
						$( '.crafto-ai-template-content' ).removeClass( 'result' );
					});
				}, 2000 );
			});

			/* AI Text Generation JS End */

			// Function to initialize MutationObserver
			function initMutationObserver() {
				const targetNode = document.querySelector( '.elementor-panel' );
				if ( ! targetNode ) {
					return;
				}

				const observer = new MutationObserver( function( mutations ) {
					mutations.forEach( function( mutation ) {
						if ( mutation.addedNodes.length > 0 ) {
							updateTabsClass(); // Check the state when nodes are added
						}
					});
				});

				const config = { childList: true, subtree: true };
				observer.observe( targetNode, config );
			}
	
			// Hook into Elementor's panel open action
			elementor.hooks.addAction( 'panel/open_editor/widget', function() {
				initMutationObserver(); // Initialize the observer when the panel opens
			});
	
			// Hook into Elementor's panel refresh action
			elementor.hooks.addAction( 'panel/refresh', function() {
				updateTabsClass(); // Recheck state on refresh
			});

			elementor.channels.editor.on( 'section:activated', function( sectionName ) {
				injectCustomButton();
				injectCustomTextButton();
			});

			// Initial check in case elements are already present
			updateTabsClass();

			function injectCustomButton() {
				setTimeout( function() {
					$( '.elementor-control-media' ).each( function() {
						if ( $( this ).find( '.elementor-control-media-video' ).length === 0 ) {
							if ( $( this ).find( '.custom-media-button' ).length === 0 ) {
								if ( $( this ).find( '.crafto-ai-image-generate' ).length === 0 ) {
									var controlType = $( this ).find( 'input[type="hidden"]' ).data( 'setting' );
									$( this ).find( '.e-ai-button' ).before( '<button id="ai_image_button" data-aicontroltype="' + controlType +'" class="crafto-ai-image-generate"><img src="'+ CraftoEditorScript.ai_button_logo_url +'" class="attachment-full size-full" alt="ai-logo"></button>' );
								}
							}
						}
					});
				}, 1000 );
			}

			function injectCustomTextButton() {
				setTimeout( function() {
					$( '.elementor-control-type-text, .elementor-control-type-textarea' ).each( function() {
						if ( ! $( this ).find( '.crafto-ai-text-generate' ).length ) {
							var controlType = $( this ).find( 'input, textarea' ).data( 'setting' );
							$( this ).find( '.e-ai-button' ).before( '<button id="ai_text_button" data-aicontroltype="' + controlType +'" class="crafto-ai-text-generate"><img src="'+ CraftoEditorScript.ai_button_logo_url +'" class="attachment-full size-full" alt="ai-logo"></button>' );
						}
					});

					$( '.elementor-control-type-wysiwyg' ).each( function() {
						// Attempt to extract control ID from the class name pattern
						var classes = $( this ).attr( 'class' ).split( /\s+/ );
						var controlType = null;

						// Find the class that matches the pattern elementor-control-<control_name>
						for ( var i = 0; i < classes.length; i++ ) {
							if ( classes[i].startsWith( 'elementor-control-' ) && classes[i] !== 'elementor-control-type-wysiwyg' ) {
								controlType = classes[i].replace( 'elementor-control-', '' );
								break;
							}
						}

						if ( controlType && ! $( this ).find( '.crafto-ai-text-generate' ).length ) {
							$( this ).find( '.e-ai-button' ).before( '<button id="ai_text_button" data-aicontroltype="' + controlType + '" class="crafto-ai-text-generate"><img src="'+ CraftoEditorScript.ai_button_logo_url +'" class="attachment-full size-full" alt="ai-logo"></button>' );
						}
					});
				}, 1000 );
			}
		},
		onPreviewLoaded: function() {
			const widgets_hooks = [
				'crafto-accordion.default',
				'crafto-dynamic-slider.default',
				'crafto-hamburger-menu.default',
				'crafto-popup.default',
				'crafto-price-table.default',
				'crafto-stack-section.default',
				'crafto-tabs.default',
			];

			widgets_hooks.forEach( hook => {
				elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, function( $scope ) {
					editTemplatePopup( $scope );
				});
			});

			elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-template.default', function( $scope ) {
				var templateEditLink = $scope.find( '.edit-template-with-light-box' ).data( 'template-edit-link' );
				$scope.find( '.edit-template-with-light-box' ).on( 'click', function() {
					window.open( templateEditLink, '_blank' );
				} );
				$scope.find( '.elementor-custom-new-template-link' ).on( 'click', function() {
					window.location.href = $( this ).attr( 'href' );
				});
			});

			function editTemplatePopup( $scope ) {
				$scope.find( '.edit-template-with-light-box' ).on( 'click', function( event ) {
					event.preventDefault();
					if ( typeof CraftoEditor !== 'undefined' && typeof CraftoEditor.showTemplatesModal === 'function' ) {
						CraftoEditor.showTemplatesModal( this );
					}
				});

				$scope.find( '.elementor-custom-new-template-link' ).on( 'click', function() {
					window.location.href = $( this ).attr( 'href' );
				});
			}

			$( document ).on( 'click', '#custom-template-edit-modal .dialog-lightbox-close-button', function( e ) {
				e.preventDefault();
				window.elementor.reloadPreview();
			});
		},
		showTemplatesModal: function( $scope ) {
			var editLink = $( $scope ).data( 'template-edit-link' );
			CraftoEditor.showModal( editLink );
		},
		showModal: function( link ) {
			CraftoEditor.getModal().show();

			var el_iframe,
				el_loader;
			var el_dialog_message = $( '#custom-template-edit-modal .dialog-message' );

			var dialogFrame = '';
				dialogFrame += '<iframe src="';
				dialogFrame += link;
				dialogFrame += '" id="tabs-edit-frame" width="100%" height="100%"></iframe>';

			var el_temp_loader = '';
				el_temp_loader += '<div id="elementor-template-loading">';
				el_temp_loader += '<div class="elementor-loader-wrapper">';
				el_temp_loader += '<div class="elementor-loader">';
				el_temp_loader += '<div class="elementor-loader-boxes">';
				el_temp_loader += '<div class="elementor-loader-box"></div>';
				el_temp_loader += '<div class="elementor-loader-box"></div>';
				el_temp_loader += '<div class="elementor-loader-box"></div>';
				el_temp_loader += '<div class="elementor-loader-box"></div>';
				el_temp_loader += '</div>';
				el_temp_loader += '</div>';
				el_temp_loader += '<div class="elementor-loading-title">Loading</div>';
				el_temp_loader += '</div>';
				el_temp_loader += '</div>';

			el_dialog_message.html( dialogFrame );
			el_dialog_message.append( el_temp_loader );

			el_iframe = $( '#tabs-edit-frame' );
			el_loader = $( '#elementor-template-loading' );
			el_iframe.on( 'load', function() {
				el_loader.fadeOut( 300 );
			} );
		},
		getModal: function( link ) {
			if ( ! CraftoEditor.modal ) {
				this.modal = elementor.dialogsManager.createWidget( 'lightbox', {
					id: 'custom-template-edit-modal',
					closeButton: true,
					closeButtonClass: 'eicon-close',
					hide: {
						onBackgroundClick: false
					}
				} );
			}
			return CraftoEditor.modal;
		},
		onFontChange: function( fontType, font ) {
			if ( 'custom' !== fontType && 'typekit' !== fontType ) {
				return;
			}

			if ( -1 !== customFonts.indexOf( font ) ) {
				return;
			}

			if ( 'typekit' === fontType && customTypekit ) {
				return;
			}

			CraftoEditor.craftoCustomFontsCallback( fontType, font );
		},
		craftoCustomFontsCallback: function( fontType, font ) {
			elementorCommon.ajax.addRequest( 'crafto_custom_fonts_action_data', {
				unique_id: 'font_' + fontType + font,
				data: {
					service: 'font',
					type: fontType,
					font: font
				},
				success: function success( data ) {
					if ( data.font_face ) {
						var dataFontFace = '';
							dataFontFace += '<style type="text/css">';
							dataFontFace += data.font_face;
							dataFontFace += '</style>';

						elementor.$previewContents.find( 'style:last' ).after( dataFontFace );
					}
					if ( data.font_url ) {
						var dataFontURL = '';
							dataFontURL += '<link href="';
							dataFontURL += data.font_url;
							dataFontURL += '" rel="stylesheet" type="text/css">';

						elementor.$previewContents.find( 'link:last' ).after( dataFontURL );
					}
				}
			});

			customFonts.push( font );

			if ( 'typekit' === fontType ) {
				customTypekit = true;
			}
		},
		addMenuItems: function() {
			if ( 'undefined' !== typeof elementorCommonConfig.finder ) {
				var items = [{
					name: 'crafto-theme-settings-url',
					icon: 'eicon-settings',
					title: elementor.config.i18n.crafto_panel_menu_item_customizer,
					type: 'link',
					link: elementorCommonConfig.finder.data.site.items['wordpress-customizer'].url,
					newTab: true
				}];
				
				items.forEach( function( item ) {
					elementor.modules.layouts.panel.pages.menu.Menu.addItem( item, 'more', 'exit-to-dashboard' );
				});
			}
		}
	}

	$( window ).on( 'elementor:init', CraftoEditor.init );

})( jQuery );
