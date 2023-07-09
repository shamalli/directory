( function( $ ) {

	var widgetSlides = function( $scope, $ ) {

		$( '.proframe-slides.owl-carousel' ).owlCarousel( {
			items: 1,
			loop: true,
			nav: true,
			margin: 30,
			dots: false,
			navText: [ '<i class="icon-arrow-left"></i>', '<i class="icon-arrow-right"></i>' ],
		} )

	};

	// Make sure we run this code under Elementor
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/proframe-slides.default', widgetSlides );
	} );

}( jQuery ) );
