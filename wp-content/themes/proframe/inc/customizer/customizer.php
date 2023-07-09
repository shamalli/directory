<?php
/**
 * Proframe Theme Customizer
 */

// Loads custom control
require trailingslashit( get_template_directory() ) . 'inc/customizer/controls/title.php';

// Loads the customizer settings
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/retina-logo.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/general.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/colors.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/fonts.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/header.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/layouts.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/post.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/page.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/portfolio.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/options/footer.php';

/**
 * Custom customizer functions.
 */
function proframe_customize_functions( $wp_customize ) {

	// Register new panel: Proframe Options
	$wp_customize->add_panel( 'proframe_options', array(
		'title'       => esc_html__( 'Theme Options', 'proframe' ),
		'description' => esc_html__( 'This panel is used for customizing the Proframe theme.', 'proframe' ),
		'priority'    => 130,
	) );

	// Live preview of Site Title and Description
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Enable selective refresh to the Site Title
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'         => '.site-title a',
			'settings'         => array( 'blogname' ),
			'render_callback'  => function() {
				return get_bloginfo( 'name', 'display' );
			}
		) );
	}

	// Enable selective refresh to the Site Description
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'         => '.site-description',
			'settings'         => array( 'blogdescription' ),
			'render_callback'  => function() {
				return get_bloginfo( 'description', 'display' );
			}
		) );
	}

	// Move the Colors section.
	$wp_customize->get_section( 'colors' )->panel    = 'proframe_options';
	$wp_customize->get_section( 'colors' )->priority = 2;

	// Move the Background Image section.
	$wp_customize->get_section( 'background_image' )->panel    = 'proframe_options';
	$wp_customize->get_section( 'background_image' )->priority = 3;
	$wp_customize->get_section( 'background_image' )->title    = esc_html__( 'Background', 'proframe' );

	// Move background color to background image section.
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

}
add_action( 'customize_register', 'proframe_customize_functions', 99 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function proframe_customize_preview_js() {
	wp_enqueue_script( 'proframe-customizer', get_template_directory_uri() . '/inc/customizer/assets/js/preview.js', array( 'customize-preview', 'jquery' ) );
}
add_action( 'customize_preview_init', 'proframe_customize_preview_js' );

/**
 * Display theme documentation on customizer page.
 */
function proframe_documentation_link() {

	// Enqueue the script
	wp_enqueue_script( 'proframe-doc', get_template_directory_uri() . '/inc/customizer/assets/js/doc.js', array(), null, true );

	// Localize the script
	wp_localize_script( 'proframe-doc', 'proframeL10n',
		array(
			'proframeURL'   => esc_url( 'https://docs.theme-junkie.com/proframe/' ),
			'proframeLabel' => esc_html__( 'Documentation', 'proframe' ),
		)
	);

}
add_action( 'customize_controls_enqueue_scripts', 'proframe_documentation_link' );

/**
 * Custom RSS feed url.
 */
function proframe_custom_rss_url( $output, $feed ) {

	// Get the custom rss feed url
	$url = get_theme_mod( 'proframe_custom_rss' );

	// Do not redirect comments feed
	if ( strpos( $output, 'comments' ) ) {
		return $output;
	}

	// Check the settings.
	if ( ! empty( $url ) ) {
		$output = esc_url( $url );
	}

	return $output;
}
add_filter( 'feed_link', 'proframe_custom_rss_url', 10, 2 );
