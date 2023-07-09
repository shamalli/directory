( function( $ ) {

	/**
	 * Responsive video
	 */
	function responsiveVideo() {
		$( '.entry, .widget' ).fitVids();
	}

	/**
	 * Search pop up
	 */
	function searchPopup() {
		$( '.search-toggle' ).magnificPopup( {
			type: 'inline',
			mainClass: 'popup-fade',
			closeOnBgClick: false,
			closeBtnInside: false,
			callbacks: {
				open: function() {
					setTimeout( function() {
						$( '.search-popup input' ).focus();
					}, 1000 );
				}
			}
		} );
	}

	/**
	 * Back to top
	 */
	function backToTop() {
		if ( $( '.back-to-top' ).length ) {
			var scrollTrigger = 100,
				backToTop = function() {
					var scrollTop = $( window ).scrollTop();
					if ( scrollTop > scrollTrigger ) {
						$( '.back-to-top' ).addClass( 'show' );
					} else {
						$( '.back-to-top' ).removeClass( 'show' );
					}
				};

			backToTop();
			$( window ).on( 'scroll', function() {
				backToTop();
			} );

			$( '.back-to-top' ).on( 'click', function( e ) {
				e.preventDefault();
				$( 'html, body' ).animate( {
					scrollTop: 0
				}, 700 );
			} );

		}
	}

	/**
	 * Load more posts
	 */
	function loadMorePosts() {

		// Setup a variables.
		var selector = '.load-more-posts',
			action = 'loadmore';

		// Re-setup the variables if on archive and search page.
		if ( proframe_variables.is_archive ) {
			selector = '.load-more-archive-posts';
			action = 'loadmore_archive';
		}

		// Start the ajax pagination.
		$( selector ).on( 'click', function( e ) {

			e.preventDefault();

			var button = $( this ),
				data = {
					'action': action,
					'query': proframe_variables.posts,
					'page': proframe_variables.current_page
				};

			$.ajax( {
				url: proframe_variables.ajax_url, // AJAX handler
				data: data,
				type: 'POST',
				beforeSend: function( xhr ) {
					button.text( proframe_variables.loading );
				},
				success: function( data ) {
					if ( data ) {
						button.text( proframe_variables.btn_text ).before( data ); // Insert new posts
						proframe_variables.current_page++;

						if ( proframe_variables.current_page == proframe_variables.max_page )
							button.remove(); // If last page, remove the button

					} else {
						button.remove(); // If no data, remove the button as well
					}
				}
			} );
		} );

	}

	/**
	 * Mobile nav
	 */
	function mobileNav() {

		var $site = $( '.site' );

		$( '.menu-toggle' ).on( 'click', function( e ) {
			e.preventDefault();

			if ( $site.hasClass( 'show-mobile-nav' ) ) {
				$site.removeClass( 'show-mobile-nav' );
			} else {
				$site.addClass( 'show-mobile-nav' );
			}
		} )

	}

	/**
	 * Remove transform: none; by Sticky Sidebar
	 */
	function removeTransform() {

		var $selector = $( '.site' ),
			style = 'style',
			width = $( window ).width();

		if ( style && width < 800 ) {
			$selector.removeAttr( style );
		} else {
			$selector.attr( 'style', 'transform: none' );
		}

	}

	// Document ready
	$( function() {
		responsiveVideo();
		searchPopup();
		backToTop();
		loadMorePosts();
		mobileNav();

		// Fix conflict between sticky sidebar and mobile menu.
		removeTransform();
		$( window ).resize( function() {
			removeTransform();
		} );

	} );

}( jQuery ) );
