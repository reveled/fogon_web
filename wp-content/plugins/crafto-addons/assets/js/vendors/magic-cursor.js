( function( $ ) {

	"use strict";

	$( document ).ready( function() {
		var el_magic_cursor = $( '.magic-cursor' );
		if ( el_magic_cursor.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
			setTimeout( function() {
				const magicCursorImage = craftoMagicCursor.magicCursorImage;
				const enableimage = craftoMagicCursor.enableImage;
				const cursorStyle = craftoMagicCursor.cursorStyle;

				const $image_html = $('<div class="magic-cursor-image"></div>');

				var magic_cursor_html = '<div class="magic-cursor-wrapper">';
					magic_cursor_html += '<div id="ball-cursor">';
					magic_cursor_html += '<div id="ball-cursor-loader"></div>';
					magic_cursor_html += '</div>';
					magic_cursor_html += '</div>';
				
				$( magic_cursor_html ).clone( false ).appendTo( 'body' );

				function loadImage( url, $el ) {
					const ext = url.split( '.' ).pop().toLowerCase();
					if ( ext === 'svg' ) {
						fetch( url )
							.then( res => res.text() )
							.then( svg => {
								$el.html( svg );
							} );
					} else {
						$el.html( `<img src="${url}" alt="">` );
					}
           		}

				var el_magic_cursor_wrap = $( '.magic-cursor-wrapper' );
				if ( el_magic_cursor.hasClass( 'cursor-icon' ) ) {
					el_magic_cursor_wrap.addClass( 'magic-cursor-icon' );
				}
	
				if ( el_magic_cursor.hasClass( 'cursor-label' ) ) {
					el_magic_cursor_wrap.addClass( 'magic-cursor-label alt-font' );
				}
				
				if ( el_magic_cursor.hasClass( 'round-cursor' )) {
					el_magic_cursor_wrap.addClass( 'magic-round-cursor' );
				}
				
				var ball = document.getElementById( 'ball-cursor' );

				if ( enableimage > 0 && cursorStyle === 'cursor-icon' ) {
					$( '#ball-cursor' ).append( $image_html );
					$( '#ball-cursor' ).addClass( 'magic-cursor-img-set' );
					if ( typeof magicCursorImage === 'string' && magicCursorImage.trim() !== '' ) {
						loadImage( magicCursorImage, $image_html );
					}
				} else {
					$( '.magic-cursor-image' ).remove();
				}
	
				let lastMouseX = window.innerWidth / 2;
				let lastMouseY = window.innerHeight / 2;

				function mouseMove( e ) {
					lastMouseX = e.clientX;
					lastMouseY = e.clientY;
					anime({
						targets: ball,
						translateX: lastMouseX - ball.offsetWidth / 2,
						translateY: lastMouseY - ball.offsetHeight / 2,
						duration: 20,
						easing: 'easeInOutQuad'
					});
				}

				document.addEventListener( 'mousemove', mouseMove );

				function repositionMagicCursor() {
					if ( ! ball ) {
						return;
					}
					anime( {
						targets: ball,
						translateX: lastMouseX - ball.offsetWidth / 2,
						translateY: lastMouseY - ball.offsetHeight / 2,
						duration: 0,
						easing: 'linear'
					} );
				}

				['scroll', 'keydown', 'wheel', 'touchmove'].forEach( evt => {
					window.addEventListener( evt, repositionMagicCursor, { passive: true } );
				} );

				document.addEventListener( 'slideChangeTransitionEnd', repositionMagicCursor );

				$( '.magic-cursor' ).on( 'mouseenter', function() {
					anime({
						target: '#ball-cursor',
						borderWidth: '2px',
						opacity: 1,
					});
					anime({
						target: '#ball-cursor-loader',
						borderWidth: '2px',
					});
	
					el_magic_cursor_wrap.addClass( 'sliderhover' );
	
					if ( $( this ).hasClass( 'magic-cursor-vertical' ) ) {
						el_magic_cursor_wrap.addClass( 'vertical' );
					}
				});
	
				$( '.magic-cursor' ).on( 'mouseleave', function() {
					anime({
						target: '#ball-cursor',
						borderWidth: '2px',
						opacity: 0
					});
					anime({
						target: '#ball-cursor-loader',
						borderWidth: '2px',
					
					});
					el_magic_cursor_wrap.removeClass( 'sliderhover' );
				});
	
				$( document ).on( 'mouseenter', '.elementor-swiper-button-next, .elementor-swiper-button-prev, .swiper-pagination, a:not(.force-magic-cursor), .slider-custom-image-pagination', function() {
					el_magic_cursor_wrap.css( { 'opacity': 0 } );
				}).on( 'mouseleave', '.elementor-swiper-button-next, .elementor-swiper-button-prev, .swiper-pagination, a:not(.force-magic-cursor), .slider-custom-image-pagination', function() {
					el_magic_cursor_wrap.css( { 'opacity': 1 } );
				});
			}, 1000 );
		}
	});

} )( jQuery );
