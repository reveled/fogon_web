( function( $ ) {

	"use strict";

	const $window   = $( window );
	const $document = $( document );

	let CraftoAddonsInit = {
		init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-search-form',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.searchFormInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-search-form.default', CraftoAddonsInit.searchFormInit );
			}
		},
		searchFormInit: function( $scope ) {
			const $elBody           = $( 'body' );
			const $elhtml           = $( 'html' );
			$scope.each( function() {
				let searchTimeout;
				var $scope              = $( this );
				const $target           = $( $scope.find( '.search-form-wrapper' ) );
				const $searchLoader     = $( $scope.find( '.search-loader' ) );
				const $searchContainer  = $( $scope.find( '.search-results-container' ) );
				const $searchLive       = $( $scope.find( '.has-live-search' ) );
				const $elSearchFormWrap = $( $scope.find( '.search-form-content-wrap' ) );
				const $elSearchResult   = $( $scope.find( '.crafto-live-search-results' ) );
				const postLength        = $scope.find( '.search-results-container' ).data( 'post-length' );
				const simplePostlength  = $scope.find( '.crafto-live-search-results' ).data( 'post-length' );

				$searchLive.on( 'input', function() {
					let searchQuery = $( this ).val();
					let postTypes   = [];

					let $elSearchPostTypesList = $( $scope.find( '.search-post-types-list' ) );
					if ( $elSearchPostTypesList.length > 0 ) {
						$elSearchPostTypesList.each( function() {
							postTypes.push( $( this ).val() );
						});
					}

					$searchContainer.empty();
					$searchLoader.hide();

					if ( searchQuery.length > 2 ) { // Start searching after 3 characters
						$searchLoader.show(); // Show loader
						clearTimeout( searchTimeout );
						searchTimeout = setTimeout( function() {
							$.ajax( {
								url: ( 'undefined' != typeof CraftoFrontend ) ? CraftoFrontend.ajaxurl : '',
								type: 'GET',
								data: {
									action: 'crafto_live_search',
									s: searchQuery,
									post_type: postTypes,
									post_length: postLength
								},
								success: function( data ) {
									$searchContainer.html( data );
									// Update "View More" buttons for each tab
									updateViewMoreButtons( searchQuery );
								},
								complete: function() {
									$searchLoader.hide(); // Hide the loader when the search is complete
								}
							} );
						}, 300 ); // Delay to reduce the number of requests
					}
				} );

				if ( $searchLive.length > 0 ) {
					$searchLive.on( 'input', function() {
						let searchQuery = $( this ).val();
						let postTypes   = [];
		
						let $elSearchPostTypesList = $( $scope.find( '.search-post-types-list' ) );
						if ( $elSearchPostTypesList.length > 0 ) {
							$elSearchPostTypesList.each( function() {
								postTypes.push( $( this ).val() );
							});
						}
						
						if ( searchQuery.length > 2 ) {
							$searchLoader.show(); // Show loader
							$.ajax({
								url: ( 'undefined' != typeof CraftoFrontend ) ? CraftoFrontend.ajaxurl : '',
								type: 'GET',
								data: {
									action: 'crafto_simple_live_search',
									s: searchQuery,
									post_type: postTypes,
									post_length : simplePostlength
								},
								success: function( response ) {
									$searchLoader.hide(); // Hide loader
									$elSearchResult.html( response ).slideDown();
									if ( 'undefined' != typeof CraftoMain && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) < 0 ) {
										$( '.simple-search-results' ).mCustomScrollbar();
									}
								}
							});
						} else {
							$elSearchResult.slideUp();
						}
					});
				}

				// Update "View More" buttons when the tab changes
				$document.on( 'click', '#search-tab a', function( e ) {
					let searchQuery = $searchLive.val();
					if ( searchQuery.length > 2 ) { // Ensure there's a search query
						updateViewMoreButtons( searchQuery );
					}
				} );

				$document.on( 'click', '.search-form-icon', function( e ) {
					e.preventDefault();
					let $miniHeader = $( this ).closest( '.mini-header-main-wrapper' );
					if ( $miniHeader.length > 0 ) {
						$elBody.addClass( 'show-search-popup-mini-header' );
					}

					$target.addClass( 'active-form' );
					$elBody.addClass( 'show-search-popup' );

					setTimeout( function() {
						$elhtml.addClass( 'overflow-hidden' );
					}, 10);
				});

				$document.on( 'click', '.search-close', function( e ) {
					e.preventDefault();

					let $miniHeader = $( this ).closest( '.mini-header-main-wrapper' );

					$target.removeClass( 'active-form' );
					if ( $miniHeader.length > 0 ) {
						$elBody.removeClass( 'show-search-popup-mini-header' );
					}
					$elBody.removeClass( 'show-search-popup' );
					$elhtml.removeClass( 'overflow-hidden' );
				});

				$document.on( 'touchstart click', function( e ) {
					if ( 0 === $( e.target ).closest( '.search-form-wrapper' ).length || $( e.target ).is( '.form-wrapper' ) ) {
						hideSearchPopup();
					}

					if ( ! ( $( e.target ).closest( '.simple-search-listing' ).length || $( e.target ).closest( '.search-input' ).length ) ) {
						$elSearchResult.slideUp();
					}
				});

				if ( 'undefined' != typeof CraftoMain && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) < 0 ) {
					if ( $elSearchFormWrap.length > 0 ) {
						$elSearchFormWrap.mCustomScrollbar();
					}
				}

				$document.on( 'keydown', function( e ) {
					if ( 27 === e.keyCode ) {
						hideSearchPopup();
						$elSearchResult.slideUp();
					}
				});

				$window.on( 'orientationchange', function( e ) {
					hideSearchPopup();
				});

				function hideSearchPopup() {
					$target.removeClass( 'active-form' );
					$elBody.removeClass( 'show-search-popup' );
				}

				function updateViewMoreButtons( searchQuery ) {
					// Get all tab IDs
					$( '#search-tab a' ).each( function() {
						let tabId       = $( this ).attr( 'id' );
						let postType    = tabId ? tabId.replace( '-tab', '' ) : '';
						var viewMoreUrl = '?s=' + encodeURIComponent( searchQuery );
						let viewMore    = ( 'undefined' != typeof CraftoFrontend ) ? CraftoFrontend.i18n.viewMore : 'View All';
						if ( postType ) {
							viewMoreUrl += '&post_type[]=' + encodeURIComponent( postType );
						}

						// Create or update the "View More" button for this tab
						let buttonHtml = '<a href="' + viewMoreUrl + '" class="view-more-btn" data-post-type="' + postType + '"> ' + viewMore + ' </a>';

						// Append or replace the button in the corresponding tab pane
						$( '#' + postType ).find( '.view-more-btn-container' ).html( buttonHtml ); // Update only if container exists
					} );
				}
			});
		},
	}

	// If Elementor is already initialized, manually trigger
	if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
		if ( typeof elementorFrontend !== 'undefined' && ! elementorFrontend.isEditMode() ) {
			CraftoAddonsInit.init();
		} else {
			$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );
		}
	} else {
		$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );
	}

})( jQuery );
