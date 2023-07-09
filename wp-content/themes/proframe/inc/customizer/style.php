<?php
/**
 * Customizer: Custom styles
 */

function proframe_custom_css() {

	// Set up empty variable.
	$css = '';

	// Get the customizer value.
	// Colors
	$footer_bg_color      = get_theme_mod( 'proframe_footer_bg_color', '#1e1e1e' );

	// Typography
	$heading_font         = get_theme_mod( 'proframe_heading_font_family', '\'Montserrat\', sans-serif' );
	$body_font            = get_theme_mod( 'proframe_body_font_family', '\'Montserrat\', sans-serif' );

	if ( $heading_font != '\'Montserrat\', sans-serif' ) {
		$css .= '
			h1, h2, h3, h4, h5, h6 {
				font-family: ' . wp_kses_post( $heading_font ) . ';
			}
		';
	}

	if ( $body_font != '\'Montserrat\', sans-serif' ) {
		$css .= '
			body {
				font-family: ' . wp_kses_post( $body_font ) . ';
			}
		';
	}

	if ( $footer_bg_color != '#1e1e1e' ) {
		$css .= '.site-bottom { background-color: ' . sanitize_hex_color( $footer_bg_color ) . '; }';
	}

	// Print the custom style
	wp_add_inline_style( 'proframe-style', $css );

}
add_action( 'wp_enqueue_scripts', 'proframe_custom_css' );
