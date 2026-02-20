( function( $ ) {

	"use strict";

	let CraftoAddonsInit = {
		init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-accordion',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.accordionInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-accordion.default', CraftoAddonsInit.accordionInit );
			}
		},
		accordionInit: function( $scope ) {
			$scope.each( function() {
				var $scope = $( this );
				let settings = {
					selectors: {
						tabTitle: '.elementor-tab-title',
						tabContent: '.elementor-tab-content',
					},
					classes: {
						active: 'elementor-active',
						activeItem: 'elementor-item-active',
					},
					toggleSelf: true,
					hidePrevious: true,
				};

				let elements = {
					$tabTitles: $scope.find( settings.selectors.tabTitle ),
					$tabContents: $scope.find( settings.selectors.tabContent ),
				};

				function deactivateActiveTab( tabIndex ) {
					const activeClass     = settings.classes.active;
					const activeItemClass = settings.classes.activeItem;
					const activeFilter    = tabIndex ? '[data-tab="' + tabIndex + '"]' : '.' + activeClass;
					const $activeTitle    = elements.$tabTitles.filter( activeFilter );
					const $activeContent  = elements.$tabContents.filter( activeFilter );

					$activeTitle.add( $activeContent ).removeClass( activeClass );
					$activeTitle.parent().removeClass( activeItemClass );
					$activeTitle.attr({
						tabindex: '-1',
						'aria-expanded': 'false',
					});

					$activeContent.css( 'max-height', 0 ).removeClass( activeClass );
				}

				function activateTab( tabIndex ) {
					const activeClass       = settings.classes.active;
					const activeItemClass   = settings.classes.activeItem;
					const $requestedTitle   = elements.$tabTitles.filter( '[data-tab="' + tabIndex + '"]' );
					const $requestedContent = elements.$tabContents.filter( '[data-tab="' + tabIndex + '"]' );

					$requestedTitle.add( $requestedContent ).addClass( activeClass );
					$requestedTitle.parent().addClass( activeItemClass );
					$requestedTitle.attr({
						tabindex: '0',
						'aria-expanded': 'true',
					});

					// Dynamic height animation
					$requestedContent.css( 'max-height', 'none' );
					const scrollHeight = $requestedContent.prop( 'scrollHeight' ) + 'px';
					$requestedContent.css( 'max-height', 0 );

					requestAnimationFrame(() => {
						$requestedContent.css( 'max-height', scrollHeight );
					});
				}

				function changeActiveTab( tabIndex ) {
					const $target  = elements.$tabTitles.filter( '[data-tab="' + tabIndex + '"]' );
					const isActive = $target.hasClass( settings.classes.active );

					if ( ( settings.toggleSelf || !isActive ) && settings.hidePrevious ) {
						deactivateActiveTab();
					}

					if ( ! settings.hidePrevious && isActive ) {
						deactivateActiveTab( tabIndex );
					}

					if ( ! isActive ) {
						activateTab( tabIndex );
					}
				}

				function bindEvents() {
					elements.$tabTitles.on( 'click keydown', function( event ) {
						if ( event.type === 'keydown' && event.key !== 'Enter' ) return;
						event.preventDefault();
						const tabIndex = this.getAttribute( 'data-tab' );
						changeActiveTab( tabIndex );
					});
				}

				function activateDefaultTab() {
					const $firstTitle   = elements.$tabTitles.first();
					const $firstContent = elements.$tabContents.first();

					$firstTitle.add( $firstContent ).addClass( settings.classes.active );
					$firstTitle.parent().addClass( settings.classes.activeItem );
					$firstTitle.attr({
						tabindex: '0',
						'aria-expanded': 'true',
					});

					setTimeout(() => {
						$firstContent.css( 'max-height', 'none' );
						const scrollHeight = $firstContent.prop( 'scrollHeight' ) + 'px';
						$firstContent.css( 'max-height', 0 );

						requestAnimationFrame(() => {
							$firstContent.css( 'max-height', scrollHeight );
						});
					}, 300);
				}

				$( 'a[data-bs-toggle="tab"]' ).on( 'shown.bs.tab', function( e ) {
					const targetPane = $( $( this ).attr( 'href' ) );

					if ( $scope.closest( '.tab-pane' ).is( targetPane ) ) {
						elements.$tabTitles.removeClass( settings.classes.active )
							.attr({ tabindex: '-1', 'aria-expanded': 'false' })
							.parent().removeClass( settings.classes.activeItem );

						elements.$tabContents.removeClass( settings.classes.active ).css( 'max-height', 0 );

						activateDefaultTab();
					}
				});

				bindEvents();

				if ( $scope.find( '.elementor-accordion' ).hasClass( 'elementor-default-active-yes' ) ) {
					activateDefaultTab();
				}
			});
		}
	};

	// If Elementor is already initialized, manually trigger
	if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
		if ( typeof elementorFrontend !== 'undefined' && ! elementorFrontend.isEditMode() ) {
			CraftoAddonsInit.init();
		} else {
			$( window ).on( 'elementor/frontend/init', CraftoAddonsInit.init );
		}
	} else {
		$( window ).on( 'elementor/frontend/init', CraftoAddonsInit.init );
	}

})( jQuery );
