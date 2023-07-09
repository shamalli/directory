<?php
/**
 * Contstants
 */
define( 'LISTING_MANAGER_FRONT_PRODUCT_EXCERPT_LENGTH', 10 );
define( 'LISTING_MANAGER_FRONT_POST_EXCERPT_LENGTH', 20 );

define('W2THEME_PATH', get_template_directory());
define('W2THEME_URL', get_template_directory_uri());

define('W2THEME_RESOURCES_PATH', W2THEME_PATH . 'resources/');
define('W2THEME_RESOURCES_URL', W2THEME_URL . 'resources/');

/**
 * Libraries
 */
//require_once get_template_directory() . '/assets/libraries/class-tgm-plugin-activation.php';
include_once get_template_directory() . '/includes/vafpress-framework/bootstrap.php';
include_once get_template_directory() . '/includes/settings_manager.php';

$settings = new w2theme_settings_manager();

/**
 * Register fonts
 *
 * Translators: If there are characters in your language that are not supported
 * by chosen font(s), translate this to 'off'. Do not translate into your own language.
 *
 * @see https://gist.github.com/kailoon/e2dc2a04a8bd5034682c
 * @return string
 */
function listing_manager_front_fonts() {	
	$font_url = '';

	if ( 'off' !== _x( 'on', 'Google font: on or off', 'listing-manager-front' ) ) {
		$font_url = add_query_arg( 'family', urlencode(  'Handlee|Poppins:300,400,500,600,700&subset=latin,latin-ext' ), '//fonts.googleapis.com/css' );
	}	
	return $font_url;
}

/**
 * Enqueue scripts & styles
 *
 * @see wp_enqueue_scripts
 * @return void
 */
function listing_manager_front_enqueue() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css' );
	wp_enqueue_style( 'listing-manager-front-fonts', listing_manager_front_fonts(), array(), '1.0.0' );
	wp_enqueue_style( 'listing-manager-front', get_template_directory_uri() . '/assets/css/listing-manager-front.css' );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css' );
	
	wp_enqueue_script( 'listing-manager-front', get_template_directory_uri() . '/assets/js/listing-manager-front.js', array( 'jquery' ) );
	wp_enqueue_script( 'images-loaded', get_template_directory_uri() . '/assets/js/images-loaded.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/assets/js/masonry.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/assets/js/jquery.scrollTo.min.js', array( 'jquery' ) );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( ! isset( $content_width ) ) {
		$content_width = 1170;
	}

	// Include dynamically generated css file if this file exists
	$upload_dir = wp_upload_dir();
	$filename = trailingslashit(set_url_scheme($upload_dir['baseurl'])) . 'w2dc-theme.css';
	$filename_dir = trailingslashit($upload_dir['basedir']) . 'w2dc-plugin.css';
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	if ($wp_filesystem && trim($wp_filesystem->get_contents($filename_dir))) // if css file creation success
		wp_enqueue_style('w2theme-dynamic-css', $filename);
}
add_action( 'wp_enqueue_scripts', 'listing_manager_front_enqueue' );

/**
 * Custom widget areas
 *
 * @see widgets_init
 * @return void
 */
function listing_manager_front_sidebars() {
	$sidebars = array(
		'sidebar-1' 			=> esc_html__( 'Primary', 'listing-manager-front' ),
        'main-top' 			    => esc_html__( 'Main Top', 'listing-manager-front' ),
		'content-top' 			=> esc_html__( 'Content Top', 'listing-manager-front' ),
		'product' 				=> esc_html__( 'Product', 'listing-manager-front' ),
		'footer-left' 		    => esc_html__( 'Footer Left ', 'listing-manager-front' ),
		'footer-right' 		    => esc_html__( 'Footer Right ', 'listing-manager-front' ),
	);

	foreach ( $sidebars as $key => $value ) {
		register_sidebar( array( 
			'name' 			=> $value, 
			'id' 			=> $key, 
			'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' 	=> '</div>'
		 ) );
	}	
}
add_action( 'widgets_init', 'listing_manager_front_sidebars' );

/**
 * Comments template
 *
 * @param string $comment Comment message.
 * @param array  $args Arguments.
 * @param int    $depth Depth.
 * @return void
 */
function listing_manager_front_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
	include get_template_directory() . '/templates/content-comment.php';
}

/**
 * Body classes
 *
 * @hook body_class
 * @param array $body_class
 * @return array
 */
function listing_manager_front_body_classes( $body_class ) {
	$body_class[] = 'w2dc-theme';
	
	if (is_page_template('page-sidebar.php')) {
		$body_class[] = 'has-sidebar';
	}
	
	/* if ( is_active_sidebar( 'sidebar-1' ) ) {
		$body_class[] = 'has-sidebar';
	}

	if ( is_active_sidebar( 'main-top' ) ) {
	    $body_class[] = 'has-main-top';
    } */
	
	if (class_exists('WooCommerce')) {
		$body_class[] = 'woocommerce';
		
		if (is_shop() || is_singular('product')) {
			$body_class[] = 'has-sidebar';
		}

		if (is_cart() && count(WC()->cart->cart_contents) === 0) {			
			$body_class[] = 'empty-cart';
		}
	}

	return $body_class;
}
add_filter( 'body_class', 'listing_manager_front_body_classes' );

/**
 * Additional after theme setup functions
 *
 * @see after_setup_theme
 * @return void
 */
function listing_manager_front_after_theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	//add_theme_support( 'menus' );
	//add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );
	//add_theme_support( 'custom-logo' );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'listing_manager_front_after_theme_setup' );

/**
 * Enable shortcodes in text widgets
 *
 * @see after_setup_theme
 * @return void
 */
function listing_manager_front_enable_shortcodes_in_text_widget() {
	add_filter( 'widget_text', 'do_shortcode' );
}
add_action( 'after_setup_theme', 'listing_manager_front_enable_shortcodes_in_text_widget' );

/**
 * Enable theme translation
 *
 * @see after_setup_theme
 * @return void
 */
function listing_manager_front_load_textdomain() {
	load_theme_textdomain( 'listing-manager-front', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'listing_manager_front_after_theme_setup' );

/**
 * Register navigations
 *
 * @hook init
 * @return void
 */
function listing_manager_front_menu() {
	register_nav_menu( 'primary', esc_html__( 'Primary', 'listing-manager-front' ) );
	register_nav_menu( 'authenticated', esc_html__( 'Authenticated', 'listing-manager-front' ) );
}
add_action( 'init', 'listing_manager_front_menu' );

/**
 * Custom excerpt length
 *
 * @hook excerpt_length 
 * @param int $length String length. 
 * @return int
 */
function listing_manager_front_excerpt_length( $length ) {
	global $post;

	if ( 'post' === $post->post_type  ) {
		return LISTING_MANAGER_FRONT_POST_EXCERPT_LENGTH;
	} 

	return $length;
}
add_filter( 'excerpt_length', 'listing_manager_front_excerpt_length' );

/**
 * Custom read more
 *
 * @hook excerpt_more 
 * @param string $more Read more string.
 * @return string
 */
function listing_manager_front_excerpt_more( $more ) {
	return '<div class="read-more-wrapper"><a href="' . get_the_permalink(). '" class="button button-primary read-more">' . esc_html__( 'Read More', 'listing-manager-front' ) . '</a></div>';
}
add_filter( 'excerpt_more', 'listing_manager_front_excerpt_more' );


/**
 * Disable admin's bar top margin
 *
 * @see get_header
 * @return void
 */
function listing_manager_front_disable_admin_bar_top_margin() {
	//remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'listing_manager_front_disable_admin_bar_top_margin' );

/**
 * Adds wrapper around content and sidebar
 *
 * @see listing_manager_front_before_main
 * @return void
 */
function listing_manager_front_add_main_before() {
	if ( is_page_template( 'page-promo-page.php') ) {
		return;
	}

	get_template_part( 'templates/content', 'main-before' );
}
add_action( 'listing_manager_front_before_main', 'listing_manager_front_add_main_before' );

/**
 * Adds wrapper around content and sidebar
 *
 * @see listing_manager_front_after_main
 * @return void
 */
function listing_manager_front_add_main_after() {
	if ( is_page_template( 'page-promo-page.php') ) {
		return;
	}

	get_template_part( 'templates/content', 'main-after' );
}
add_action( 'listing_manager_front_after_main', 'listing_manager_front_add_main_after' );

/**
 * Adds woocommerce_after_main_content
 *
 * @see listing_manager_front_before_main
 * @return void
 */
function listing_manager_front_woocommerce_before_main_content() {
	echo '<div class="content">';
}
add_action( 'woocommerce_before_main_content', 'listing_manager_front_woocommerce_before_main_content', 1 );

/**
 * Adds wrapper around content
 *
 * @see woocommerce_after_main_content
 * @return void
 */
function listing_manager_front_woocommerce_after_main_content() {
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'listing_manager_front_woocommerce_after_main_content', 1);

/**
 * Change the breadcrumb position
 *
 * @see init
 * @return void
 */
function listing_manager_front_woocommerce_breadcrumb() {	
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'listing_manager_front_woocommerce_breadcrumb' );

/**
 * Change WooCommerce breadcrumb values
 *
 * @see woocommerce_breadcrumb_defaults
 * @param array $args
 * @return array
 */
function listing_manager_front_woocommerce_breadcrumb_defaults( $args ) {
	$args['delimiter'] = '<span class="separator">/</span>';
	return $args;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'listing_manager_front_woocommerce_breadcrumb_defaults' );

/**
 * Removes add to cart button from the loop page
 *
 * @see init
 * @return void
 */
function listing_manager_front_woocommerce_remove_loop_button(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action( 'init','listing_manager_front_woocommerce_remove_loop_button' );

/**
 * Removes WooCommerce title
 *
 * @see woocommerce_show_page_title
 * @return bool
 */
function listing_manager_front_woocommerce_show_page_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'listing_manager_front_woocommerce_show_page_title' );

/**
 * Adds location after shop title in loop
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_front_woocommerce_loop_add_location() {
	$name = Listing_Manager_Product_Listing::get_location_name();
	if ( ! empty( $name ) ) {
		echo '<div class="product-location">' . Listing_Manager_Product_Listing::get_location_name() . '</div>';
	}	
}
//add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_front_woocommerce_loop_add_location' );

/**
 * Adds favorite button after title
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_front_woocommerce_loop_add_favorite() {
	if ( has_term( 'listing', 'product_type' ) ) {
		Listing_Manager_Favorites::render_button( get_the_ID() );
	}	
}
//add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_front_woocommerce_loop_add_favorite' );

/**
 * Adds excerpt after shop title in loop
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_front_woocommerce_loop_add_excerpt() {
	woocommerce_template_single_excerpt();
}
add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_front_woocommerce_loop_add_excerpt' );

/**
 * Custom implementation of excerpt size for WooCommerce products
 *
 * @see woocommerce_short_description
 * @param string $excerpt
 * @return string
 */
function listing_manager_front_woocommerce_short_description( $excerpt ) {
	return '<p>' . wp_trim_words( $excerpt, LISTING_MANAGER_FRONT_PRODUCT_EXCERPT_LENGTH ) . '</p>';
}
add_filter ( 'woocommerce_short_description', 'listing_manager_front_woocommerce_short_description');

/**
 * Adds event after product in loop
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_front_woocommerce_loop_add_event() {
	$date = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'event_date', true );

	if ( ! empty( $date ) ) {
		echo '<div class="event-countdown" data-date="' . esc_attr( $date ) . '"></div>';
	}
}
//add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_front_woocommerce_loop_add_event' );

/**
 * Adds image wrapper for product images in loop
 *
 * @see woocommerce_before_shop_loop_item_title
 * @return string
 */
function listing_manager_front_product_loop_thumbnail( ) {
    global $post, $woocommerce;

    $default = '<img src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" alt="' . $post->post_title . '">';
    $output = '<div class="product-image-wrapper">';

    if ( has_post_thumbnail() ) {
    	$image= get_the_post_thumbnail( $post->ID, 'shop_catalog' );

    	if ( empty( $image ) ) {
    		$output .= $default;
    	} else {
			$output .= $image;
    	}        
    } else {
    	$output .= $default;
    }

    $output .= '</div>';
    echo $output;
}
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'listing_manager_front_product_loop_thumbnail', 10 );

/**
 * Custom rating formatting
 *
 * @param string $rating_html
 * @param float $rating
 * @return string
 */
function listing_manager_front_product_rating_html( $rating_html, $rating ) {
	return wc_get_template_html( 'templates/content-product-rating.php', array(
		'rating_html' 	=> $rating_html,
		'rating'		=> $rating,
	) );
}
add_filter( 'woocommerce_product_get_rating_html', 'listing_manager_front_product_rating_html', 10, 2 );

/**
 * Reorder rating stars in product loop
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating' );

/**
 * Change WooCommerce pagination values
 *
 * @see woocommerce_pagination_args
 * @param array $args
 * @return array
 */
function listing_manager_front_woocommerce_pagination_args( $args ) {
	$args['prev_text'] = '<i class="fa fa-chevron-left"></i>';
	$args['next_text'] = '<i class="fa fa-chevron-right"></i>';
	return $args;
}
add_filter( 'woocommerce_pagination_args', 'listing_manager_front_woocommerce_pagination_args' );

/**
 * Adds share buttons
 *
 * @see woocommerce_single_product_summary
 * @return void
 */
function listing_manager_front_woocommerce_share() {
	get_template_part( 'templates/content', 'share' );
}
add_action( 'woocommerce_single_product_summary', 'listing_manager_front_woocommerce_share', 100 );

/**
 * Add inquire form on product detail page
 *
 * @see woocommerce_after_single_product_summary
 * @return void
 */
function listing_manager_front_woocommerce_add_inquire_form() {
	get_template_part( 'templates/content', 'inquire-form' );
}
add_action( 'woocommerce_after_single_product_summary', 'listing_manager_front_woocommerce_add_inquire_form', 11 );

/**
 * Adds next/prev posts links
 *
 * @see woocommerce_after_single_product_summary
 * @return void
 */
function listing_manager_front_woocommerce_add_next_prev() {
	get_template_part( 'templates/content', 'next-prev-links' );
}
add_action( 'woocommerce_after_single_product_summary', 'listing_manager_front_woocommerce_add_next_prev', 100 );

/**
 * Limits max number of related products
 *
 * @see woocommerce_output_related_products_args
 * @param array $args
 * @return array
 */
function listing_manager_front_max_number_of_related( $args ) {
	$args['posts_per_page'] = 3; 
	$args['columns'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'listing_manager_front_max_number_of_related' );

/**
 * Posts pagination
 *
 * @return void
 */
function listing_manager_front_pagination() {
	the_posts_pagination( array(
		'prev_text'  => esc_html__( 'Previous', 'listing-manager-front' ),
		'next_text'  => esc_html__( 'Next', 'listing-manager-front' ),
		'mid_size'   => 2,
	) );
}

/**
 * Register plugins
 *
 * @hook tgmpa_register
 * @return void
 */
function listing_manager_front_register_required_plugins() {
	$plugins = array(
		array(
			'name'      			=> 'WooCommerce',
			'slug'      			=> 'woocommerce',
			'is_automatic'          => true,
			'required'  			=> false,
		),											
		array(
			'name'      			=> 'Page Builder by SiteOrigin',
			'slug'      			=> 'siteorigin-panels',
			'is_automatic'          => true,
			'required'  			=> false,
		),		
		array(
			'name'      			=> 'One Click',
			'slug'      			=> 'one-click',
			'source'				=> 'https://github.com/wearecodevision/one-click/archive/master.zip',
			'is_automatic'          => true,
			'required'  			=> false,
		),		
	);

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'listing_manager_front_register_required_plugins' );

/**
 * Customizations
 *
 * @hook customize_register
 * @param Obj $wp_customize
 * @return void
 */
function listing_manager_front_customizations( $wp_customize ) {	
	$wp_customize->add_section( 'listing_manager_front_hero_images', array( 'title' => esc_html__( 'Listing Manager Front Hero Images', 'listing-manager-front' ), 'priority' => 0 ) );

	// Title
	$wp_customize->add_setting( 'listing_manager_front_hero_images_title', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_title', array(
		'label'             => esc_html__( 'Title', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_title',
		'type'              => 'text',
	) );

	// Description
	$wp_customize->add_setting( 'listing_manager_front_hero_images_description', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_description', array(
		'label'             => esc_html__( 'Description', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_description',
		'type'              => 'textarea',
	) );

	// Primary Button Link
	$wp_customize->add_setting( 'listing_manager_front_hero_images_primary_button_link', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_primary_button_link', array(
		'label'             => esc_html__( 'Primary Button Link', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_primary_button_link',
		'type'              => 'text',
	) );	

	// Primary Button Text
	$wp_customize->add_setting( 'listing_manager_front_hero_images_primary_button_text', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_primary_button_text', array(
		'label'             => esc_html__( 'Primary Button Text', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_primary_button_text',
		'type'              => 'text',
	) );	


	// Secondary Button Link
	$wp_customize->add_setting( 'listing_manager_front_hero_images_secondary_button_link', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_secondary_button_link', array(
		'label'             => esc_html__( 'Secondary Button Link', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_secondary_button_link',
		'type'              => 'text',
	) );		

	// Secondary Button Text
	$wp_customize->add_setting( 'listing_manager_front_hero_images_secondary_button_text', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_secondary_button_text', array(
		'label'             => esc_html__( 'Secondary Button Text', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_secondary_button_text',
		'type'              => 'text',
	) );		

	// Secondary Button Description
	$wp_customize->add_setting( 'listing_manager_front_hero_images_secondary_button_description', array(
		'default'           => null,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'listing_manager_front_hero_images_secondary_button_description', array(
		'label'             => esc_html__( 'Secondary Button Description', 'listing-manager-front' ),
		'section'           => 'listing_manager_front_hero_images',
		'settings'          => 'listing_manager_front_hero_images_secondary_button_description',
		'type'              => 'text',
	) );	

	// Secondary Images
	for ( $i = 1; $i <= 3; $i++ ) {		
		$wp_customize->add_setting( 'listing_manager_front_hero_images_image_' . $i , array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'listing_manager_front_hero_images_image_' . $i, array(
			'label'             => esc_html__( 'Image', 'listing-manager-front' ),
			'section'           => 'listing_manager_front_hero_images',
			'settings'          => 'listing_manager_front_hero_images_image_' . $i,
			'type'              => 'text',
		) );	
	}	
}
add_action( 'customize_register', 'listing_manager_front_customizations' );


/* function w2dc_is_listing() {
	global $w2dc_instance;
	
	if ($w2dc_instance) {
		if (($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory')) || ($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory-listing'))) {
			if ($directory_controller->is_single) {
				return $directory_controller->listing;
			}
		}
	}
} */

function w2dc_get_page_title() {
	global $w2dc_instance;
	
	if ($w2dc_instance) {
		if (
		($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory')) ||
		($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory-listing-page')) ||
		($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory-listing')) ||
		($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory-category')) ||
		($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory-location')) ||
		($directory_controller = $w2dc_instance->getShortcodeProperty('webdirectory-tag'))
		) {
			return $directory_controller->getPageTitle();
		}
	}
}

add_shortcode('shortcodes', 'w2dc_renderShortcode');
function w2dc_renderShortcode($atts, $content = "" ) {
	return $content;
}

/**
 * Define product actions
 */

/* add_action( 'listing_manager_front_product_actions', array( 'Listing_Manager_Reports', 'render_button' ) );
add_action( 'listing_manager_front_product_actions', array( 'Listing_Manager_Claims', 'render_button' ) );
add_action( 'listing_manager_front_product_actions', array( 'Listing_Manager_Favorites', 'render_button' ) );

remove_action( 'woocommerce_after_single_product', array( 'Listing_Manager_Reports', 'render_button' ) );
remove_action( 'woocommerce_after_single_product', array( 'Listing_Manager_Claims', 'render_button' ) ); */

