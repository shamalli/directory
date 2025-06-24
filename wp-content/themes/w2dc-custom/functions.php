<?php 

function wdt_demo_links() {
	
	global $wp;
	
	if (class_exists("w2dc_demo_links_controller") && strpos($wp->request, 'documentation') === false) {
		echo '<div class="container">';
		$demo_links_controller = new w2dc_demo_links_controller();
		echo $demo_links_controller->display();
		echo '</div>';
	}
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

}

remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');

function rss_post_thumbnail($content) {
	global $post;
	if(has_post_thumbnail($post->ID)) {
		$content = '<p>' . get_the_post_thumbnail($post->ID,array(32,32)) .'</p>' . get_the_content();
	}
	return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

/* function _remove_script_version($src){
	$parts = explode('?ver', $src);
	return $parts[0];
}
add_filter('script_loader_src', '_remove_script_version', 15, 1);
add_filter('style_loader_src', '_remove_script_version', 15, 1); */

add_action('wp_enqueue_scripts', 'enqueue_scripts_styles');
function enqueue_scripts_styles() {
	wp_register_script('w2dc_theme_script', get_stylesheet_directory_uri() . '/js.js', array('jquery', 'wdt-main'), false, true);
	wp_enqueue_script('w2dc_theme_script');
}
/* add_action('wp_head', 'format_sticky_nav');
function format_sticky_nav() {
	global $post;
	
	if (!$post) {
		return ;
	}
	
	$parents_and_post = get_post_ancestors($post);
	$parents_and_post[] = $post->ID;
	$is_docs = false;
	foreach ($parents_and_post AS $post_id) {
		$_post = get_page($post_id);
		if ($_post->post_name == 'documentation-old') {
			$is_docs = true;
		}
	}
	
	if ($post && $is_docs) {
		echo "<script>
		
	</script>";
	}
} */

function remove_envato_top_bar() {

	echo "<script>

if (document.referrer.indexOf('preview.codecanyon.net') != -1) top.location.replace(self.location.href);

</script>";

}
// it suddenly does not work (september 2020) (in chrome)
add_action('wp_head', 'remove_envato_top_bar', 1);

function add_target_top_to_links() {

	echo "<script>

(function($) {
	'use strict';
	
	$(function() {

		if (document.referrer.indexOf('preview.codecanyon.net') != -1) {
			$('a').attr('target', '_top');
		}

	});
})(jQuery);

</script>";

}
add_action('wp_footer', 'add_target_top_to_links', 1);


function add_google_analytics() {
	if (strpos($_SERVER['SERVER_NAME'], 'salephpscripts.com') !== false) {
		echo "
<!-- Google Analytics -->

<script async src='https://www.googletagmanager.com/gtag/js?id=G-M1K5L8X0SC'></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'G-M1K5L8X0SC');
</script>

<!-- End Google Analytics -->
				
";
	}
}
add_action('wp_head', 'add_google_analytics', 9999);
add_action('admin_head', 'add_google_analytics', 9999);


function download_free_link() {
	echo "<a class='button w2dc-download-free' href='https://wordpress.org/plugins/web-directory-free/'>Download Free</a>";
	
	//echo "<a class='button w2dc-download-free' href='" . file_get_contents('https://salephpscripts.com/license-get-download-url?product=w2dc_free') . "'>Download Free</a>";
	
	//echo "<a class='button w2dc-download-free' href='https://www.salephpscripts.com/directory-free/'>Download Free</a>";
}
add_action('wdt_before_navigation', 'download_free_link', 11);

function buy_plugin_link() {
	/* echo "<div class='w2dc-codecanyon-link-block'>";
	echo "<a class='w2dc-codecanyon-link-text' href='https://codecanyon.net/item/web-20-directory-plugin-for-wordpress/6463373?ref=Shamalli'>Purchase plugin</a>";
	echo "<a class='w2dc-codecanyon-link-img' href='https://codecanyon.net/item/web-20-directory-plugin-for-wordpress/6463373?ref=Shamalli'>";
	echo "<img src='" . get_stylesheet_directory_uri() . '/buy_plugin.jpg' . "' />";
	echo "</a>";
	echo "</div>"; */
	echo "<a class='button w2dc-codecanyon-button' href='https://store.payproglobal.com/checkout?products[1][id]=75383' target='_blank'><span class='w2dc-purchase-icon fa fa-shopping-cart '></span> Purchase Plugin</a>";
}
add_action('wdt_before_navigation', 'buy_plugin_link');

function submit_listing() {
	if (function_exists('w2dc_submitUrl')) {
		echo "<a class='button w2dc-submit-listing-button' href='" . w2dc_submitUrl() . "'>Submit Listing</a>";
	}
}
add_action('wdt_before_navigation', 'submit_listing', 12);


if (function_exists("w2rr_addMessage")) {
	//w2rr_addMessage(esc_html__('Reviews and votes displayed by our Ratings & Reviews plugin for WordPress', 'W2DC') . '<br /><a href="https://www.salephpscripts.com/ratings-reviews/" target="_blank">read more</a>' ,'error');
}
/* add_action('w2dc_pre_comments_tab', 'pre_comments_tab');
function pre_comments_tab() {
	if (class_exists('w2rr_plugin')) {
		w2dc_renderMessages(esc_html__('Reviews and votes displayed by our Ratings & Reviews plugin for WordPress', 'W2DC') . '<br /><a href="https://1.envato.market/LBbGa" target="_blank">https://codecanyon.net/item/ratings-reviews-plugin-for-wordpress/25458834</a>' ,'error');
	}
} */

function remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

function w2dc_map_language( $lang ) {
	
	$lang = 'en';
	
	return $lang;
}
add_filter( 'w2dc_map_language', 'w2dc_map_language' );

function w2dc_recaptcha_language( $lang ) {
	
	$lang = 'en';
	
	return $lang;
}
add_filter( 'w2dc_recaptcha_language', 'w2dc_recaptcha_language' );


// remove 'Posts' from admin
add_filter('register_post_type_args', function($args, $postType){
	if ($postType === 'post') {
		$args['public']                = false;
		$args['show_ui']               = false;
		$args['show_in_menu']          = false;
		$args['show_in_admin_bar']     = false;
		$args['show_in_nav_menus']     = false;
		$args['can_export']            = false;
		$args['has_archive']           = false;
		$args['exclude_from_search']   = true;
		$args['publicly_queryable']    = false;
		$args['show_in_rest']          = false;
		$args['map_meta_cap']          = false;
		$args['capabilities'] = array(
			'edit_post' => false,
			'read_post' => false,
			'delete_post' => false,
			'edit_posts' => false,
			'edit_others_posts' => false,
			'publish_posts' => false,
			'read' => false,
			'delete_posts' => false,
			'delete_private_posts' => false,
			'delete_published_posts' => false,
			'delete_others_posts' => false,
			'edit_private_posts' => false,
			'edit_published_posts' => false,
			'create_posts' => false,
		);
	}

	return $args;
}, 0, 2);


?>