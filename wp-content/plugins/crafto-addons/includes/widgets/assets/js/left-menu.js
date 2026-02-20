( function( $ ) {

	"use strict";

	let CraftoAddonsInit = {
		init: function init() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-left-menu.default', CraftoAddonsInit.LeftMenuInit );
		},
		LeftMenuInit:function() {
			const $document = $( document );

			let tabletBreakPoint = 991;
			if ( typeof elementorFrontendConfig != 'undefined' ) {
				if ( typeof elementorFrontendConfig.breakpoints != 'undefined' ) {
					if ( typeof elementorFrontendConfig.breakpoints.lg != 'undefined' ) {
						tabletBreakPoint = elementorFrontendConfig.breakpoints.lg - 1;
					}
				}
			}

			function getWindowWidth() {
				return window.innerWidth;
			}

			const target               = $( '.header-common-wrapper:not(.left-menu-classic) .crafto-left-menu-wrap' );
			const scrollbarTheme       = target.data( 'scrollbar-theme' );
			const $elLeftHeaderWrapper = $( '.left-sidebar-wrapper .header-left-wrapper' );
			const el_sub_menu_item     = $( '.sub-menu-item' );
			const el_left_menu_classic = $( '.header-common-wrapper.left-menu-classic, .header-common-wrapper.left-menu-modern' );

			// Initialize custom scrollbar if conditions are met
			if ( target.length > 0 && ( undefined !== typeof CraftoMain ) && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) > 0 ) {
				target.mCustomScrollbar( { "theme": scrollbarTheme } );
			}

			// Navbar toggler click event
			$document.on( 'click', '.navbar-toggler', function() {
				if ( ( $( '.elementor-widget-crafto-left-menu-toggle' ).length > 0 ) && getWindowWidth() <= tabletBreakPoint ) {
					$( 'body' ).toggleClass( 'left-classic-mobile-menu navbar-collapse-show' );
				}

				el_sub_menu_item.collapse( 'hide' );
				$( '.menu-list-item.open' ).removeClass( 'show' );
			});

			// Sticky left menu
			stickyElement();
			function stickyElement() {
				if ( $elLeftHeaderWrapper.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'sticky-kit', CraftoMain.disable_scripts ) < 0 ) {
					if ( getWindowWidth() >= tabletBreakPoint ) { 
						$elLeftHeaderWrapper.stick_in_parent({ recalc: 1 });
					}
				}
			}

			// Side menu submenu toggle.
			let timerLeftSidebarWrap;
			let el_left_sidebar_wrapper= $( '.left-sidebar-wrapper' );
			$( document ).on( 'click', '.sub-menu-item > li.menu-item-has-children > .menu-toggle', function( e ) {
				e.preventDefault();

				var _parent     = $( this ).parent().parent( '.sub-menu-item' ).find( '.sub-menu-item' );
				var _parentAttr = $( this ).attr( 'data-bs-target' );

				if ( _parent.length > 0 ) {
					_parent.each( function() {
						var _this = $( this ),
							_attr = _this.parent().find( '.menu-toggle' ).attr( 'data-bs-target' );

						if ( _attr != _parentAttr ) {
							_this.parent().find( '.menu-toggle:not(.collapsed)' ).addClass( 'collapsed' );
							_this.collapse( 'hide' );
						}
					});
				}

				if ( el_left_sidebar_wrapper.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'sticky-kit', CraftoMain.disable_scripts ) < 0 ) {
					clearTimeout( timerLeftSidebarWrap );
					timerLeftSidebarWrap = setTimeout(() => {
						el_left_sidebar_wrapper.trigger( 'sticky_kit:recalc' );
					}, 500 );
				}
			});

			// Side menu submenu toggle.
			$document.on( 'click', '.crafto-left-menu > li.menu-item-has-children > .menu-toggle', function() {
				if ( el_sub_menu_item.length > 0 ) {
					el_sub_menu_item.each( function() {
						$( this ).collapse( 'hide' );
					});
				}

				if ( $elLeftHeaderWrapper.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'sticky-kit', CraftoMain.disable_scripts ) < 0 ) {
					setTimeout( function() {
						$elLeftHeaderWrapper.trigger( 'sticky_kit:recalc' );
					}, 500 );
				}
			});

			// For mobile left menu classic
			if ( $( '.header-common-wrapper' ).hasClass( 'left-menu-classic' ) ) {
				const leftMenu = el_left_menu_classic.find( '.elementor-widget-crafto-left-menu' );
				if ( leftMenu.length > 0 ) {
					leftMenu.parents( '.e-parent' ).addClass( 'left-menu-classic-section' );
				}
			}

			// Resize event with debounce
			let resizeTimeout;
			$( window ).on( 'resize', function() {
				clearTimeout( resizeTimeout );
				resizeTimeout = setTimeout( function() {
					stickyElement();
				}, 100 ); // 100ms debounce
			});
		}
	}

	$( window ).on( 'elementor/frontend/init', CraftoAddonsInit.init );

} )( jQuery );
