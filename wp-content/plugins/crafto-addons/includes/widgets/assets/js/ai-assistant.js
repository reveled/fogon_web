( function( $ ) {

	"use strict";

	const $window = $( window );

	let CraftoAddonsInit = {
		init: function init() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-ai-assistant.default', CraftoAddonsInit.ChatBot );
		},
		ChatBot: function() {
			let chat           = [];
			const $chatList    = $( '.chat-list' );
			const $chatTextBox = $( '.chat-textbox' );
			const $chatButton  = $( '#generate-openai-chat' );
			const $chatWrap    = $( '.chat-bot-wrap' );
			const $chatNew     = $( '.chat-form-start-new' );
			const $chatForm    = $( '.openai-chat-form' );

			$chatNew.on( 'click', function( e ) {
				e.preventDefault();
				resetChat();
			} );

			function resetChat() {
				$chatNew.addClass( 'start-new-hidden' );
				$chatList.empty();
				$chatForm.find( '.chat-list' ).slideUp();
				$chatTextBox.val( '' ).trigger( 'change' ).focus();
				chat = [];
			}

			function toggleButtonState() {
				$chatButton.prop( 'disabled', $chatTextBox.val().trim() === '' );
			}

			$chatTextBox.on( 'keyup', toggleButtonState );
			toggleButtonState(); // Check on page load

			$chatButton.on( 'click', function( e ) {
				e.preventDefault();
				let inputChat = $chatTextBox.val().trim();
				if ( ! inputChat ) {
					return
				};

				$( '#openai-chat-form' ).addClass( 'generated-chat' );
				add_to_chat( inputChat, 'user' );
				show_loading();
				$chatNew.removeClass( 'start-new-hidden' );

				$.ajax({
					url: ( typeof CraftoFrontend !== 'undefined' ) ? CraftoFrontend.ajaxurl : '',
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'crafto_generate_openai_chat',
						input_chat: inputChat
					},
					success: function( response ) {
						hide_loading();
						if ( response.success && response.data ) {
							add_to_chat( response.data, 'assistant' );
						} else {
							show_error( response.data?.error || 'Error processing request.' );
						}
					},
					error: function() {
						hide_loading();
						show_error( 'API Error. Please enter your API Key in Appearance > Customize > Advanced Theme Options > API Keys > Open AI API Key' );
					}
				});

				$chatTextBox.val( '' ).trigger( 'change' );
				toggleButtonState();
			});

			function get_chat_list_item( message, role ) {
				return `<li class="chat-list-item chat-list-item-${role}">
					<span class="chat-list-item-wrap">
						<span class="chat-list-item-content">${message}</span>
					</span>
				</li>`;
			}

			function add_to_chat( message, role ) {
				chat.push({
					role,
					content: message
				});
				$chatList.append( get_chat_list_item( message, role ) );
			}

			function show_loading() {
				$chatWrap.addClass( 'chat-form-loading' );
				let chatLoader = '<span class="chat-loading">';
					chatLoader += '<span class="chat-list-item-loading-dot"></span>';
					chatLoader += '<span class="chat-list-item-loading-dot"></span>';
					chatLoader += '<span class="chat-list-item-loading-dot"></span>';
					chatLoader += '</span>';
				$chatList.append( get_chat_list_item( chatLoader, 'loading' ) );
			}

			function hide_loading() {
				$chatWrap.removeClass( 'chat-form-loading' );
				$( '.chat-loading' ).parent().remove();
			}

			function show_error( message ) {
				let $errorMessage = $( `<div class="ai-error">${message}</div>` );
				$chatForm.after( $errorMessage );
				$errorMessage.css({
					'color': '#e65656',
					'background-color': '#fbf1f1',
					'padding': '7px 25px',
					'border-radius': '5px',
					'font-size': '14px',
					'margin-top': '20px'
				});
			}
		}
	}

	$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );

} )( jQuery );
