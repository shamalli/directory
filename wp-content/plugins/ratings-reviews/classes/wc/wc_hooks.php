<?php

function w2rr_is_wc() {
	if (!class_exists('woocommerce')) {
		return false;
	}

	return in_array('product', w2rr_getWorkingPostTypes());
}


/**
 * 2 functions temporarily modify breadcrumbs to match target post 
 * 
 * @param array $defaults
 * @return array
 */
function w2rr_wc_breadcrumb_defaults($defaults) {
	global $post, $w2rr_temp_post;
	
	$w2rr_temp_post = $post;
	
	$controller = new w2rr_frontend_controller();
	$target_post = $controller->getTargetPost();
	if ($target_post) {
		$post = $target_post->post;
	}
	
	return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'w2rr_wc_breadcrumb_defaults', 9);

function w2rr_wc_breadcrumb() {
	global $post, $w2rr_temp_post;
	
	$post = $w2rr_temp_post;
}
add_action('woocommerce_breadcrumb', 'w2rr_wc_breadcrumb', 11);


/**
 * counter of reviews of a product
 *
 * @param number $value
 * @param object|wc_product $wc_product
 * @return number
 */
function w2rr_wc_reviews_counter($value, $wc_product) {
	global $w2rr_instance;

	if (w2rr_is_wc()) {
		if ($reviews = $w2rr_instance->reviews_manager->getReviewsOfPost($wc_product->get_id())) {
			$value = count($reviews);
		}
	}

	return $value;
}
add_filter('woocommerce_product_get_review_count', 'w2rr_wc_reviews_counter', 10, 2);
add_filter('woocommerce_product_variation_get_review_count', 'w2rr_wc_reviews_counter', 10, 2);

// remove reviews count from rating template
add_filter('woocommerce_locate_template', 'w2rr_plugin_template', 1, 3);
function w2rr_plugin_template($template, $template_name, $template_path) {
	if ($template_name == 'single-product/rating.php') {
		return W2RR_TEMPLATES_PATH . 'wc/rating.php';
	}
	
	return $template;
}

/**
 * print rating stars on products and single products pages
 */
add_filter('woocommerce_product_get_rating_html', 'w2rr_wc_product_get_rating_html', 10, 3);
function w2rr_wc_product_get_rating_html($html, $rating, $count) {
	if (w2rr_is_wc()) {
		$target_post = w2rr_getTargetPost(get_post());
		
		if ($target_post) {
			$html = $target_post->renderAvgRating(array('show_avg' => true, 'active' => false, 'stars_size' => 20), true);
		}
	}
	
	return $html;
}

add_filter('woocommerce_product_get_rating_counts', 'w2rr_wc_product_get_rating_counts', 10, 2);
add_filter('woocommerce_product_variation_get_rating_counts', 'w2rr_wc_product_get_rating_counts', 10, 2);
function w2rr_wc_product_get_rating_counts($value, $wc_product) {
	global $w2rr_instance;
	
	if (w2rr_is_wc()) {
		$target_post = w2rr_getTargetPost($wc_product->get_id());

		if ($reviews_posts = $w2rr_instance->reviews_manager->getReviewsOfPost($wc_product->get_id())) {
			// return array of ratings counts e.g. result[5]=2, result[4]=3, result[3]=1, ...
			$result = array();
			foreach ($reviews_posts AS $post) {
				$review = w2rr_getReview($post);
				if (isset($result[round($review->getAvgRating())])) {
					$result[round($review->getAvgRating())]++;
				} else {
					$result[round($review->getAvgRating())] = 1;
				}
			}
			$value = $result;
		} else {
			$value = array();
		}
	}
	
	return $value;
}

add_filter('woocommerce_product_get_average_rating', 'w2rr_wc_product_get_average_rating', 10, 2);
add_filter('woocommerce_product_variation_get_average_rating', 'w2rr_wc_product_get_average_rating', 10, 2);
function w2rr_wc_product_get_average_rating($value, $wc_product) {
	global $w2rr_instance;
	
	if (w2rr_is_wc()) {
		$target_post = w2rr_getTargetPost($wc_product->get_id());

		if ($target_post) {
			$value = $target_post->getAvgRating();
		}
	}
	
	return $value;
}


/**
 * theme_mod_header_image hook, modifies header image URL for the Storefront theme
 * 
 * @param string $image_url
 * @return string
 */
function w2rr_theme_mod_header_image($image_url) {
	global $w2rr_instance, $product;
	
	if (w2rr_is_wc()) {
		if (is_product() && ($product = wc_get_product())) {
			$id = $product->get_id();
			$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
			$image_url = $image_src[0];
		}
	}
	
	if (class_exists('w2rr_reviews_controller')) {
		if (get_query_var('reviews') == 'all') { // image of a target post
			$target_post = w2rr_getTargetPost();
			
			if ($target_post && get_post_thumbnail_id($target_post->post->ID)) {
				$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($target_post->post->ID), 'full');
				$image_url = $image_src[0];
			}
		} elseif ($review = w2rr_getCurrentReviewByQueryVar()) { // image of a review, get current review by query var 'reviews'
			if ($review->logo_image) {
				$image_src = wp_get_attachment_image_src($review->logo_image, 'full');
				$image_url = $image_src[0];
			}
		}
	}
	
	return $image_url;
}
add_filter('theme_mod_header_image', 'w2rr_theme_mod_header_image');


/**
 * Adds #tab-reviews to all WC products permalinks
 *
 * @return string
 */
if (defined('W2RR_DEMO') && W2RR_DEMO) {
	function w2rr_woocommerce_loop_product_link($link) {
		if (w2rr_is_wc()) {
			return get_the_permalink() . '#tab-reviews';
		}
		
		return $link;
	}
	add_filter('woocommerce_loop_product_link', 'w2rr_woocommerce_loop_product_link');
}

/**
 * Adds #tab-reviews to all reviews permalinks, for the Storefront theme
 * 
 * @param string $permalink
 * @return string
 */
function w2rr_wc_review_permalink($permalink, $review_post) {
	if (w2rr_is_wc()) {
		if (($review = w2rr_getReview($review_post)) && $review->target_post) {
			if (get_post_type($review->target_post->post) == 'product') {
				$permalink .= '#tab-reviews';
			}
		}
	}
	
	return $permalink;
}
add_filter('w2rr_review_permalink', 'w2rr_wc_review_permalink', 10, 2);


/**
 * modified SQL of WC ordering by average rating
 * 
 * @param array $args
 * @return array
 */
function w2rr_wc_order_by_rating_post_clauses($args) {
	global $wpdb;
	
	$args['join'] = $args['join'] . " LEFT JOIN {$wpdb->postmeta} w2rr_pm ON $wpdb->posts.ID = w2rr_pm.post_id ";
	$args['where'] = $args['where'] . " AND w2rr_pm.meta_key = '_avg_rating' ";
	$args['orderby'] = ' w2rr_pm.meta_value DESC ';
	
	return $args;
}
function w2rr_wc_order_by_rating($args, $orderby, $order) {
	
	if (in_array('product', w2rr_getWorkingPostTypes())) {
		if ($orderby == 'rating') {
			add_filter('posts_clauses', 'w2rr_wc_order_by_rating_post_clauses', 11);
		}
	}
	
	return $args;
}
add_filter('woocommerce_get_catalog_ordering_args', 'w2rr_wc_order_by_rating', 10, 3);

/**
 * modified SQL of WC ordering by average rating on AJAX with WCSEARCH plugin
 * 
 * @param string $meta_key
 * @return string
 */
function w2rr_wc_rating_order_meta_key($meta_key) {
	
	if (in_array('product', w2rr_getWorkingPostTypes())) {
		$meta_key = '_avg_rating';
	}
	
	return $meta_key;
}
add_filter('wcsearch_wc_rating_order_meta_key', 'w2rr_wc_rating_order_meta_key');

/**
 * create _avg_rating meta key for all WC products, those do not have them yet
 * 
 */
function w2rr_create_avg_rating_for_products() {
	global $wpdb;
	
	if (in_array('product', w2rr_getWorkingPostTypes())) {
		$results = $wpdb->get_results("
				SELECT DISTINCT(wp_posts.ID) FROM wp_posts
	
				LEFT JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id )
	
				WHERE wp_posts.post_type = 'product' AND NOT EXISTS( SELECT null FROM wp_postmeta WHERE wp_posts.ID = wp_postmeta.post_id AND wp_postmeta.meta_key = '_avg_rating')", ARRAY_A);
	
	
		foreach ($results AS $row) {
			add_post_meta($row['ID'], '_avg_rating', 0);
		}
	}
}
add_action('woocommerce_update_product', 'w2rr_create_avg_rating_for_products');
add_action('woocommerce_new_product', 'w2rr_create_avg_rating_for_products');


/**
 * hide "Show reviews" checkbox and display a message when comments permanently enabled/disabled by WC settings
 * 
 */
add_filter('w2rr_comments_open_metabox_setting', 'w2rr_wc_comments_open_metabox_setting', 10, 2);
function w2rr_wc_comments_open_metabox_setting($do_display, $target_post) {
	if ($target_post->post->post_type == 'product' && get_option('woocommerce_enable_reviews', null) !== null) {
		$do_display = false;
	}

	return $do_display;
}

add_action('w2rr_comments_open_metabox', 'w2rr_wc_comments_open_metabox');
function w2rr_wc_comments_open_metabox($target_post) {
	if ($target_post->post->post_type == 'product' && get_option('woocommerce_enable_reviews', null) !== null) {
		echo "<p>";
		if (get_option('woocommerce_enable_reviews') == 'yes') {
			esc_html_e('Reviews always enabled by WooCommerce settings.', 'w2rr');
		} elseif (get_option('woocommerce_enable_reviews') == 'no') {
			esc_html_e('Reviews always disabled by WooCommerce settings.', 'w2rr');
		}
		echo " <a href='".admin_url('admin.php?page=wc-settings&tab=products')."'>" . esc_html__('Change it in WC settings.', 'w2rr') . "</a>";
		
		echo "</p>";
	}
}


/**
 * save WC review to get back compatibility with WooCommerce
 */
add_action('w2rr_save_review', 'w2rr_wc_save_review');
add_action('w2rr_csv_create_review', 'w2rr_wc_save_review');
add_action('w2rr_csv_update_review', 'w2rr_wc_save_review');
function w2rr_wc_save_review($review_id) {
	if ($review = w2rr_getReview($review_id)) {
		if (get_post_type($review->target_post->post) == 'product') {
			$product_id = $review->target_post->post->ID;
			
			// Insert/update records in comments tables
			$rating = $review->getAvgRating();
			
			$user_id = 0;
			$display_name = '';
			$user_email = '';
			if ($user = get_userdata(get_current_user_id())) {
				$user_id = $user->ID;
				$display_name = $user->display_name;
				$user_email = $user->user_email;
			}
			
			$request = new WP_REST_Request();
			$request->set_query_params(array(
					'rating' => $rating,
					'product_id' => $product_id,
					'review' => $review->post->post_content,
					'user_id' => $user_id,
					'reviewer' => $display_name,
					'reviewer_email' => $user_email,
			));
			
			$reviews_controller = new WC_REST_Product_Reviews_Controller;
			
			$comment_id = get_post_meta($review_id, '_associated_wc_comment', true);
			
			if (!$comment_id) {
				$response = $reviews_controller->create_item($request);

				if (!is_wp_error($response) && isset($response->data['id'])) {
					$comment_id = $response->data['id'];
					
					update_post_meta($review_id, '_associated_wc_comment', $comment_id);
				}
			} else {
				$wc_review = get_comment($comment_id);
				
				if ($wc_review && !empty($wc_review->comment_post_ID)) {
					$wc_post = get_post((int) $wc_review->comment_post_ID);
				
					if (get_post_type((int) $review->comment_post_ID) == 'product') {
						$request['id'] = $comment_id;
						
						$reviews_controller->update_item($request);
					}
				}
			}
			
			if ($comment_id) {
				if ($review->post->post_status != 'publish') {
					wp_trash_comment($comment_id);
				} else {
					wp_untrash_comment($comment_id);
				}
			}
			
			// Update product post meta
			$avg_rating = $review->target_post->getAvgRating();
			$review_count = $review->target_post->avg_rating->ratings_count;
			$rating_count = $review->target_post->avg_rating->calculateTotals();
			
			update_post_meta($product_id, '_wc_average_rating', $avg_rating);
			update_post_meta($product_id, '_wc_review_count', $review_count);
			update_post_meta($product_id, '_wc_rating_count', $rating_count);
		}
	}
}

add_action('w2rr_review_status_changed', 'w2rr_wc_review_status_changed', 10, 3);
function w2rr_wc_review_status_changed($new_status, $old_status, $post) {
	$review = w2rr_getReview($post);
	
	if ('publish' != $new_status) {
		$comment_id = get_post_meta($review->post->ID, '_associated_wc_comment', true);
		if ($comment_id && ($wc_review = get_comment($comment_id))) {
			wp_trash_comment($comment_id);
		}
	} elseif ('publish' == $new_status) {
		$comment_id = get_post_meta($review->post->ID, '_associated_wc_comment', true);
		if ($comment_id && ($wc_review = get_comment($comment_id))) {
			wp_untrash_comment($comment_id);
		}
	}
}

add_action('trashed_post', 'w2rr_wc_trash_comment', 11);
function w2rr_wc_trash_comment($post_id) {
	if (get_post_type($post_id) == W2RR_REVIEW_TYPE) {
		$review = w2rr_getReview($post_id);
		
		$comment_id = get_post_meta($review->post->ID, '_associated_wc_comment', true);
		if ($comment_id && ($wc_review = get_comment($comment_id))) {
			wp_trash_comment($comment_id);
		}
	}
}

add_action('untrashed_post', 'w2rr_wc_untrash_comment', 11);
function w2rr_wc_untrash_comment($post_id) {
	if (get_post_type($post_id) == W2RR_REVIEW_TYPE) {
		$review = w2rr_getReview($post_id);

		$comment_id = get_post_meta($review->post->ID, '_associated_wc_comment', true);
		if ($comment_id && ($wc_review = get_comment($comment_id))) {
			wp_untrash_comment($comment_id);
		}
	}
}

add_action('delete_post', 'w2rr_wc_delete_comment', 11);
function w2rr_wc_delete_comment($post_id) {
	if (get_post_type($post_id) == W2RR_REVIEW_TYPE) {
		$review = w2rr_getReview($post_id);
		
		$comment_id = get_post_meta($review->post->ID, '_associated_wc_comment', true);
		if ($comment_id && ($wc_review = get_comment($comment_id))) {
			wp_delete_comment($comment_id, true);
		}
	}
}


/**
 * Add Reviews menu item link to the Ratings & Reviews dashboard
 */
add_filter('woocommerce_account_menu_items', 'w2rr_wc_account_menu_items');
function w2rr_wc_account_menu_items($items) {
	global $w2rr_instance;
	
	if (w2rr_is_wc()) {
		if ($w2rr_instance->dashboard_page_id) {
			$offset = 1;
			$items = array_slice($items, 0, $offset, true) +
					array('ratings-reviews' => esc_html__('Reviews', 'w2rr')) +
					array_slice($items, $offset, NULL, true);
		}
	}
	
	return $items;
}
add_action('init', 'w2rr_wc_account_add_endpoint');
function w2rr_wc_account_add_endpoint() {
	add_rewrite_endpoint('ratings-reviews', EP_PAGES);
}
add_action('woocommerce_account_ratings-reviews_endpoint', 'w2rr_wc_account_endpoint_content');
function w2rr_wc_account_endpoint_content() {
	$dashboard = new w2rr_dashboard_controller();
	$dashboard->init();
	
	echo $dashboard->display();
}


add_action('w2rr_slider_caption', 'w2rr_wc_slider_caption', 10, 2);
function w2rr_wc_slider_caption($slider_caption_addon, $review) {
	if (w2rr_is_wc()) {
		$product_id = $review->target_post->post->ID;
		
		if ($product = wc_get_product($product_id)) {
			$slider_caption_addon .= '<span class="w2rr-slider-wc-price">' . wc_price($product->get_price()) . '</span>';
		}
	}
	
	return $slider_caption_addon;
}


?>