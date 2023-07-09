/**
 * Documentation notice for theme
 */

( function ( $ ) {

	// Add documentation message
	if ( 'undefined' !== typeof proframeL10n ) {
		doc = $( '<a class="theme-doc-link"></a>' )
			.attr( 'href', proframeL10n.proframeURL )
			.attr( 'target', '_blank' )
			.text( proframeL10n.proframeLabel )
			.css( {
				'display': 'inline-block',
				'background-color': '#2EA2CC',
				'color': '#fff',
				'text-transform': 'uppercase',
				'padding': '3px 6px',
				'font-size': '9px',
				'letter-spacing': '1px',
				'line-height': '1.5',
				'clear': 'both',
				'text-decoration': 'none'
			} );

		setTimeout( function () {
			$( '#customize-info .accordion-section-title' ).append( doc );
		}, 200 );
	}

} )( jQuery );
