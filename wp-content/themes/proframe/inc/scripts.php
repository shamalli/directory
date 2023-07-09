<?php
/**
 * Enqueue scripts and styles.
 */

/**
 * Loads the theme styles & scripts.
 */
function proframe_enqueue() {

	// Load plugins stylesheet
	wp_enqueue_style( 'proframe-plugins-style', trailingslashit( get_template_directory_uri() ) . 'assets/css/plugins.min.css' );

	// Fonts
	wp_enqueue_style( 'proframe-fonts', proframe_fonts_url() );

	// if WP_DEBUG and/or SCRIPT_DEBUG turned on, load the unminified styles & script.
	if ( ! is_child_theme() && WP_DEBUG || SCRIPT_DEBUG ) {

		// Load main stylesheet
		wp_enqueue_style( 'proframe-style', get_stylesheet_uri() );

		// Load custom js plugins.
		wp_enqueue_script( 'proframe-plugins', trailingslashit( get_template_directory_uri() ) . 'assets/js/plugins.min.js', array( 'jquery' ), null, true );

		// Load custom js methods.
		wp_enqueue_script( 'proframe-main', trailingslashit( get_template_directory_uri() ) . 'assets/js/main.js', array( 'jquery' ), null, true );

		// Script handle
		$script_handle = 'proframe-main';

	} else {

		// Load main stylesheet
		wp_enqueue_style( 'proframe-style', trailingslashit( get_template_directory_uri() ) . 'style.min.css' );

		// Load custom js plugins.
		wp_enqueue_script( 'proframe-scripts', trailingslashit( get_template_directory_uri() ) . 'assets/js/proframe.min.js', array( 'jquery' ), null, true );

		// Script handle
		$script_handle = 'proframe-scripts';

	}

	// Predefined colors
	$color = get_theme_mod( 'proframe_predefined_colors', 'default' );
	wp_enqueue_style( 'proframe-color', trailingslashit( get_template_directory_uri() ) . 'assets/css/colors/' . $color . '.css'  );

	// Set up variables to pass to the custom script.
	$featured_layout = get_theme_mod( 'proframe_featured_posts_layout', 'default' );
	global $wp_query;
	$localize_script = array(
		'next'              => esc_html__( 'Next', 'proframe' ),
		'prev'              => esc_html__( 'Prev', 'proframe' ),
		'featured_two_cols' => ( $featured_layout == 'two-cols' ) ? true : false,

		// Ajax load more
		'ajax_url'          => admin_url( 'admin-ajax.php' ),
		'posts'             => json_encode( $wp_query->query_vars ),
		'current_page'      => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page'          => $wp_query->max_num_pages,
		'loading'           => esc_html__( 'Loading...', 'proframe' ),
		'btn_text'          => esc_html__( 'More Posts', 'proframe' ),
		'is_archive'        => ( is_archive() || is_search() ) ? true : false
	);

	// Pass custom variables to the script.
	wp_localize_script( $script_handle, 'proframe_variables', $localize_script );

	/**
	 * js / no-js script.
	 *
	 * @copyright http://www.paulirish.com/2009/avoiding-the-fouc-v3/
	 */
	wp_add_inline_script( $script_handle, "document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'js');" );

	// If child theme is active, load the stylesheet.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'proframe-child-style', get_stylesheet_uri() );
	}

	// Load comment-reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Loads HTML5 Shiv
	wp_enqueue_script( 'proframe-html5', trailingslashit( get_template_directory_uri() ) . 'assets/js/html5shiv.min.js', array( 'jquery' ), null, false );
	wp_script_add_data( 'proframe-html5', 'conditional', 'lte IE 9' );

}
add_action( 'wp_enqueue_scripts', 'proframe_enqueue' );

/**
 * Custom category header image.
 */
function proframe_custom_category_header() {

	// Only display the image on category page.
	if ( !is_category() ) {
		return;
	}

	// Get term id
	$term_id = get_queried_object()->term_id;

	// Get the image attachment ID.
	$attachment_id = get_term_meta( $term_id, 'image', true );

	// If an attachment ID was found, get the image source.
	if ( !empty( $attachment_id ) )
		$image = wp_get_attachment_image_src( absint( $attachment_id ), 'proframe-post-large' );

	// Get the image URL.
	$url = !empty( $image ) && isset( $image[0] ) ? $image[0] : '';

	// Display the custom header via inline CSS.
	if ( $url ) :
		$header_css = '
			.archive-header .container {
				background-image: url("' . esc_url( $url ) . '");
				background-repeat: no-repeat;
				background-position: center;
				background-size: cover;
				position: relative;
			}
			.archive-header .container::after {
				content: "";
				display: block;
				width: 100%;
				height: 100%;
				background-color: rgba(255, 255, 255, .7);
				position: absolute;
				top: 0;
				left: 0;
				z-index: 0;
			}';
	endif;

	if ( ! empty( $header_css ) ) :
		wp_add_inline_style( 'proframe-style', $header_css );
	endif;

}
add_action( 'wp_enqueue_scripts', 'proframe_custom_category_header' );

/**
 * Enable sticky sidebar
 */
function proframe_sticky_sidebar() {

	// Get the customizer data
	$enable = get_theme_mod( 'proframe_sticky_sidebar', 0 );

	if ( $enable ) {
		?>
		<script type="text/javascript">
			( function( $ ) {
				$( function() {
					$( '.widget-area' ).theiaStickySidebar( {
						additionalMarginTop: 20
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}

}
add_action( 'wp_footer', 'proframe_sticky_sidebar', 15 );
