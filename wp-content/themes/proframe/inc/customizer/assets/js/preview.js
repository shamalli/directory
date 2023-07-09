/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Set up variable
	api = wp.customize;

	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Footer background color
	api( 'proframe_footer_bg_color', function ( value ) {
		value.bind( function ( to ) {
			to = to ? to : '#1e1e1e';
			$( '.site-bottom' ).css( 'background-color', to );
		} );
	} );

} )( jQuery );
