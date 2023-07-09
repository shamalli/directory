<?php
/**
 * Theme functions file
 *
 * Contains all of the Theme's setup functions, custom functions,
 * custom hooks and Theme settings.
 */

if ( ! function_exists( 'proframe_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function proframe_theme_setup() {

		// Make the theme available for translation.
		load_theme_textdomain( 'proframe', trailingslashit( get_template_directory() ) . 'languages' );

		// Add custom stylesheet file to the TinyMCE visual editor.
		add_editor_style( array( 'assets/css/editor-style.css', proframe_fonts_url() ) );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );

		// Declare image sizes.
		add_image_size( 'proframe-post', 795, 485, true );
		add_image_size( 'proframe-post-small', 492, 330, true );
		add_image_size( 'proframe-post-large', 1110, 600, true );
		add_image_size( 'proframe-portfolio', 700, 700, true );

		// Register custom navigation menu.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Navigation', 'proframe' ),
				'mobile'  => esc_html__( 'Mobile Navigation', 'proframe' ),
				'footer'  => esc_html__( 'Footer Navigation', 'proframe' ),
				'social'  => esc_html__( 'Social Navigation', 'proframe' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'proframe_custom_background_args', array(
			'default-color' => 'ffffff'
		) ) );

		// Enable support for Custom Logo
		add_theme_support( 'custom-logo', array(
			'height'      => 26,
			'width'       => 200,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable layouts extensions.
		add_theme_support( 'theme-layouts',
			array(
				'full-width'        => esc_html__( 'Full width', 'proframe' ),
				'full-width-narrow' => esc_html__( 'Full width narrow', 'proframe' ),
				'right-sidebar'     => esc_html__( 'Right sidebar', 'proframe' ),
				'left-sidebar'      => esc_html__( 'Left sidebar', 'proframe' )
			),
			array( 'customize' => false, 'default' => 'right-sidebar' )
		);

	}
endif; // proframe_theme_setup
add_action( 'after_setup_theme', 'proframe_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function proframe_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'proframe_content_width', 825 );
}
add_action( 'after_setup_theme', 'proframe_content_width', 0 );

/**
 * Sets custom content width when current layout is full-width
 */
if ( ! function_exists( 'proframe_fullwidth_content_width' ) ) :

	function proframe_fullwidth_content_width() {
		global $content_width;

		if ( in_array( get_theme_mod( 'theme_layout' ), array( 'full-width' ) ) ) {
			$content_width = 1110;
		}
	}

endif;
add_action( 'template_redirect', 'proframe_fullwidth_content_width' );

/**
 * Registers custom widgets.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_widget
 */
function proframe_widgets_init() {

	// Register recent posts thumbnail widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-posts.php';
	register_widget( 'Proframe_Posts_Widget' );

	// Register social widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-social.php';
	register_widget( 'Proframe_Social_Widget' );

	// Register twitter widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-twitter.php';
	register_widget( 'Proframe_Twitter_Widget' );

	// Register facebook widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-facebook.php';
	register_widget( 'Proframe_Facebook_Widget' );

}
add_action( 'widgets_init', 'proframe_widgets_init' );

/**
 * Registers widget areas and custom widgets.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function proframe_sidebars_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary', 'proframe' ),
			'id'            => 'primary',
			'description'   => esc_html__( 'Main sidebar that appears on the right.', 'proframe' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title module-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Portfolio', 'proframe' ),
			'id'            => 'portfolio',
			'description'   => esc_html__( 'Main sidebar that appears on the right on Portfolio page.', 'proframe' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title module-title">',
			'after_title'   => '</h3>',
		)
	);

	// Get the footer widget column from Customizer.
	$widget_columns = get_theme_mod( 'proframe_footer_widget_column', '4' );
	for ( $i = 1; $i <= $widget_columns; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer %s', 'proframe' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Sidebar that appears on the bottom of your site.', 'proframe' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title module-title">',
				'after_title'   => '</h3>',
			)
		);
	}

}
add_action( 'widgets_init', 'proframe_sidebars_init' );

/**
 * Register Google fonts.
 */
function proframe_fonts_url() {

	// Get the customizer data
	$body_font    = get_theme_mod( 'proframe_body_font', 'Montserrat:400,400i,600,600i,900' );
	$heading_font = get_theme_mod( 'proframe_heading_font', 'Montserrat:400,400i,600,600i,900' );

	// Important variable
	$fonts_url = '';
	$fonts     = array();

	if ( $body_font ) {
		$fonts[] = esc_attr( str_replace( '+', ' ', $body_font ) );
	}

	if ( $heading_font && ( $body_font != $heading_font ) ) {
		$fonts[] = esc_attr( str_replace( '+', ' ', $heading_font ) );
	}

	if ( $fonts ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Post views count
 */
function proframe_post_views( $id ) {

	if ( is_singular() ) {

		$key   = 'post_views';
		$count = get_post_meta( $id, $key, true );

		if ( $count == '' ) {
			$count = 0;
			delete_post_meta( $id, $key );
			add_post_meta( $id, $key, '0' );
		} else {
			$count++;
			update_post_meta( $id, $key, $count );
		}
	}

}

if ( ! function_exists( 'proframe_is_elementor_active' ) ) :
	/**
	 * Check if Elementor is active
	 */
	function proframe_is_elementor_active() {
		return defined( 'ELEMENTOR_VERSION' );
	}
endif;

/**
 * Custom template tags for this theme.
 */
require trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Enqueue scripts and styles.
 */
require trailingslashit( get_template_directory() ) . 'inc/scripts.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require trailingslashit( get_template_directory() ) . 'inc/extras.php';

/**
 * Require and recommended plugins list.
 */
require trailingslashit( get_template_directory() ) . 'inc/plugins.php';

/**
 * Customizer.
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer/customizer.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/sanitize.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/style.php';

/**
 * We use some part of Hybrid Core to extends our themes.
 *
 * @link  http://themehybrid.com/hybrid-core Hybrid Core site.
 */
require trailingslashit( get_template_directory() ) . 'inc/extensions/layouts.php';

/**
 * Demo importer
 */
require trailingslashit( get_template_directory() ) . 'inc/demo/demo-importer.php';

/**
 * Load Elementor compatibility file.
 */
if ( proframe_is_elementor_active() ) {
	require trailingslashit( get_template_directory() ) . 'inc/elementor/elementor.php';
}

// MailOptin integration
require get_template_directory() . '/inc/extensions/mailoptin.php';

/**
	 * Footer Text
	 */
	function proframe_footer_text() {

		// Get the customizer data
		$default = '&copy; Copyright ' . date( 'Y' ) . ' - <a href="' . esc_url( home_url() ) . '">' . esc_attr( get_bloginfo( 'name' ) ) . '</a>. All Rights Reserved. <br /> Designed & Developed by <a href="https://www.theme-junkie.com/">Theme Junkie</a>';
		$footer_text = get_theme_mod( 'proframe_footer_credits', $default );

		// Display the data
		echo '<p class="copyright">' . wp_kses_post( $footer_text ) . '</p>';

	}