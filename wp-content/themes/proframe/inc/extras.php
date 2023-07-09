<?php
/**
 * Custom functions that act independently of the theme templates
 * Eventually, some of the functionality here could be replaced by core features
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function proframe_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'proframe_pingback_header' );

/**
 * Adds custom classes to the array of body classes.
 */
function proframe_body_classes( $classes ) {

	// Adds a class of multi-author to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'multi-author';
	}

	// Adds a class if a post or page has featured image.
	if ( has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	// Adds a class for the container style.
	$container = get_theme_mod( 'proframe_container_style', 'fullwidth' );
	if ( $container == 'fullwidth' ) {
		$classes[] = 'full-width-container';
	} elseif ( $container == 'boxed' ) {
		$classes[] = 'boxed-container';
	} else {
		$classes[] = 'framed-container';
	}

	// Adds a custom class for blog page.
	if ( is_home() ) {
		// Blog types.
		$layout_types = get_theme_mod( 'proframe_blog_types', 'default' );
		$classes[] = 'layout-type-' . $layout_types;

		// Featured posts
		$featured_layout = get_theme_mod( 'proframe_featured_posts_layout', 'default' );
		$classes[] = 'featured-layout-' . $featured_layout;
	}

	// Custom header layout class.
	$header = get_theme_mod( 'proframe_header_layout', 'default' );
	$classes[] = 'layout-header-' . $header;

	return $classes;
}
add_filter( 'body_class', 'proframe_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 */
function proframe_post_classes( $classes ) {

	// Adds a class if a post hasn't a thumbnail.
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'no-post-thumbnail';
	}

	// Replace hentry class with entry.
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'proframe_post_classes' );

/**
 * Remove 'hentry' from post_class()
 */
function proframe_remove_hentry( $class ) {
	$class = array_diff( $class, array( 'hentry' ) );
	return $class;
}
add_filter( 'post_class', 'proframe_remove_hentry' );

/**
 * Change the excerpt more string.
 */
function proframe_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'proframe_excerpt_more' );

/**
 * Filter the excerpt length.
 */
function proframe_custom_excerpt_length( $length ) {

	// Default
	$length = 55;

	// Change the length if user visiting using a mobile device.
	if ( wp_is_mobile() ) {
		$length = 35;
	}

	// Layout types
	$type = get_theme_mod( 'proframe_blog_types', 'default' );

	// Use different length with several condition.
	if ( is_archive() || is_search() || $type == 'grid' || $type == 'list' || $type == 'alternate' ) {
		$length = 28;
	}

	return $length;
}
add_filter( 'excerpt_length', 'proframe_custom_excerpt_length', 999 );

/**
 * Extend archive title
 */
function proframe_extend_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif( is_post_type_archive( 'portfolio' ) ) {
		$title = get_theme_mod( 'proframe_portfolio_title', esc_html__( 'Our Portfolio', 'proframe' ) );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'proframe_extend_archive_title' );

/**
 * Customize tag cloud widget
 */
function proframe_customize_tag_cloud( $args ) {
	$args['largest']  = 13;
	$args['smallest'] = 13;
	$args['unit']     = 'px';
	$args['number']   = 20;
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'proframe_customize_tag_cloud' );

/**
 * Modifies the theme layout.
 */
function proframe_mod_theme_layout( $layout ) {

	// Change the layout to Full Width on Attachment page.
	if ( is_attachment() && wp_attachment_is_image() ) {
		$post_layout = get_post_layout( get_queried_object_id() );
		if ( 'default' === $post_layout ) {
			$layout = 'full-width';
		}
	}

	// Layout on home/blog page.
	if ( is_home() ) {
		$blog_layouts = get_theme_mod( 'proframe_blog_layouts', 'right-sidebar' );
		$layout = $blog_layouts;
	}

	// Post layout.
	if ( is_single() ) {
		$post_layout = get_post_layout( get_queried_object_id() );
		$global_post_layouts = get_theme_mod( 'proframe_post_layouts', 'right-sidebar' );

		if ( 'default' === $post_layout ) {
			$layout = $global_post_layouts;
		} else {
			$layout = $post_layout;
		}
	}

	// Page layout.
	if ( is_page() ) {
		$page_layout = get_post_layout( get_queried_object_id() );
		$global_page_layouts = get_theme_mod( 'proframe_page_layouts', 'right-sidebar' );

		if ( 'default' === $page_layout ) {
			$layout = $global_page_layouts;
		} else {
			$layout = $page_layout;
		}
	}

	// Portfolio layout.
	if ( is_post_type_archive( 'portfolio' ) ) {
		$portfolio_layout = get_theme_mod( 'proframe_portfolio_layouts', 'full-width' );
		$layout = $portfolio_layout;
	}

	// Change the layout to Full Width Narrow.
	if ( ! is_active_sidebar( 'primary' ) ) {
		if ( is_single() || is_page() || is_home() ) {
			$post_layout = get_post_layout( get_queried_object_id() );
			if ( 'default' == $post_layout ) {
				$layout = 'full-width-narrow';
			}
		}
	}

	// Change the layout to Full Width Narrow.
	// if ( ! is_active_sidebar( 'portfolio' ) ) {
	// 	if ( is_post_type_archive( 'portfolio' ) ) {
	// 		$layout = 'full-width';
	// 	}
	// }

	// Layout on 404 page.
	if ( is_404() ) {
		$layout = 'full-width-narrow';
	}

	return $layout;
}
add_filter( 'theme_mod_theme_layout', 'proframe_mod_theme_layout', 15 );

/**
 * Remove theme-layouts meta box on attachment and bbPress post type.
 */
function proframe_remove_theme_layout_metabox() {
	remove_post_type_support( 'attachment', 'theme-layouts' );

	// bbPress
	remove_post_type_support( 'forum', 'theme-layouts' );
	remove_post_type_support( 'topic', 'theme-layouts' );
	remove_post_type_support( 'reply', 'theme-layouts' );

	// Portfolio
	add_post_type_support( 'portfolio', 'theme-layouts' );
}
add_action( 'init', 'proframe_remove_theme_layout_metabox', 11 );

/**
 * Load more posts
 */
function proframe_loadmore_ajax_handler() {

	// Get the customizer data.
	$type  = get_theme_mod( 'proframe_blog_types', 'default' );

	// Prepare our arguments for the query
	$args                = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged']       = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	query_posts( $args );

	if ( have_posts() ) :

		// Run the loop
		while ( have_posts() ): the_post();

			if ( $type == 'default' ) {
				get_template_part( 'partials/content' );
			} elseif ( $type == 'grid' ) {
				get_template_part( 'partials/content', 'grid' );
			} elseif ( $type == 'list' ) {
				get_template_part( 'partials/content', 'list' );
			} elseif ( $type == 'alternate' ) {
				if ( $wp_query->current_post == 0 && !is_paged() ) {
					get_template_part( 'partials/content' );
				} else {
					get_template_part( 'partials/content', 'list' );
				}
			}

		endwhile;

	endif;

	die; // Here we exit the script and even no wp_reset_query() required!

}
add_action( 'wp_ajax_loadmore', 'proframe_loadmore_ajax_handler' ); // wp_ajax_{action}
add_action( 'wp_ajax_nopriv_loadmore', 'proframe_loadmore_ajax_handler' ); // wp_ajax_nopriv_{action}

/**
 * Load more archive posts
 */
function proframe_archive_loadmore_ajax_handler() {

	// Prepare our arguments for the query
	$args                = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged']       = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	query_posts( $args );

	if ( have_posts() ) :

		// Run the loop
		while ( have_posts() ): the_post();

			get_template_part( 'partials/content', 'grid' );

		endwhile;

	endif;

	die; // Here we exit the script and even no wp_reset_query() required!

}
add_action( 'wp_ajax_loadmore_archive', 'proframe_archive_loadmore_ajax_handler' ); // wp_ajax_{action}
add_action( 'wp_ajax_nopriv_loadmore_archive', 'proframe_archive_loadmore_ajax_handler' ); // wp_ajax_nopriv_{action}

/**
 * Set portfolio per page
 */
function proframe_portfolio_per_page( $query ) {

	$number = get_theme_mod( 'proframe_portfolio_number', 6 );

	if ( $query->is_post_type_archive( 'portfolio' ) && $query->is_main_query() ) {
		$query->set( 'posts_per_page', absint( $number ) );
	}

}
add_action( 'pre_get_posts', 'proframe_portfolio_per_page' );
