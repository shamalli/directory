<?php

function w2rr_getMultiRatings() {
	$ratings_criterias = array();
	
	if (get_option('w2rr_reviews_multi_rating')) {
		$ratings_criterias = preg_split("/\\r\\n|\\r|\\n/", get_option('w2rr_reviews_multi_rating'));
	}
	
	$ratings_criterias = array_filter($ratings_criterias);
	
	return apply_filters('w2rr_multi_ratings', $ratings_criterias);
}

function w2rr_current_user_can_edit_review($review_id) {
	if (!current_user_can('edit_others_posts')) {
		$post = get_post($review_id);
		$current_user = wp_get_current_user();
		if ($current_user->ID != $post->post_author)
			return false;
		if ($post->post_status == 'pending'  && !is_admin())
			return false;
	}
	return true;
}

function w2rr_show_edit_review_button($review_id) {
	global $w2rr_instance;
	if (
		w2rr_current_user_can_edit_review($review_id)
		&&
		(
			($w2rr_instance->dashboard_page_id)
			||
			(!$w2rr_instance->dashboard_page_id && !get_option('w2rr_hide_admin_bar') && current_user_can('edit_posts'))
		)
	)
		return true;
}

function w2rr_get_edit_review_link($review_id, $context = 'display') {
	if (w2rr_current_user_can_edit_review($review_id)) {
		$post = get_post($review_id);
		$current_user = wp_get_current_user();
		if (current_user_can('edit_others_posts') && $current_user->ID != $post->post_author) {
			return get_edit_post_link($review_id, $context);
		} else {
			return apply_filters('w2rr_get_edit_review_link', get_edit_post_link($review_id, $context), $review_id);
		}
	}
}

function w2rr_getAddReviewPage() {
	global $wpdb, $w2rr_instance;
	
	if (w2rr_get_wpml_dependent_option('w2rr_page_add_review')) {
		return w2rr_get_wpml_dependent_option('w2rr_page_add_review');
	}

	if ($pages = $wpdb->get_results("SELECT ID AS id FROM {$wpdb->posts} WHERE post_content LIKE '%[" . W2RR_ADD_REVIEW_PAGE_SHORTCODE . "%' AND post_status = 'publish' AND post_type = 'page'", ARRAY_A)) {
		$page_id = $pages[0]['id'];

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($tpage = apply_filters('wpml_object_id', $page_id, 'page')) {
				$page_id = $tpage;
			}

		}

		return $page_id;
	}
}

function w2rr_getAllReviewsPage() {
	global $wpdb, $w2rr_instance;

	if (w2rr_get_wpml_dependent_option('w2rr_page_all_reviews')) {
		return w2rr_get_wpml_dependent_option('w2rr_page_all_reviews');
	}

	if ($pages = $wpdb->get_results("SELECT ID AS id FROM {$wpdb->posts} WHERE post_content LIKE '%[" . W2RR_ALL_REVIEWS_PAGE_SHORTCODE . "%' AND post_status = 'publish' AND post_type = 'page'", ARRAY_A)) {
		$page_id = $pages[0]['id'];

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($tpage = apply_filters('wpml_object_id', $page_id, 'page')) {
				$page_id = $tpage;
			}

		}

		return $page_id;
	}
}

function w2rr_getDashboardPage() {
	global $wpdb, $w2rr_instance;
	
	if (w2rr_get_wpml_dependent_option('w2rr_page_dashboard')) {
		return w2rr_get_wpml_dependent_option('w2rr_page_dashboard');
	}

	if ($pages = $wpdb->get_results("SELECT ID AS id FROM {$wpdb->posts} WHERE post_content LIKE '%[" . W2RR_DASHBOARD_SHORTCODE . "%'  AND post_status = 'publish' AND post_type = 'page'", ARRAY_A)) {
		$page_id = $pages[0]['id'];

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($tpage = apply_filters('wpml_object_id', $page_id, 'page')) {
				$page_id = $tpage;
			}

		}

		return $page_id;
	}
}

function w2rr_getReviewPage() {
	global $wpdb;
	
	if (w2rr_get_wpml_dependent_option('w2rr_page_single_review')) {
		return w2rr_get_wpml_dependent_option('w2rr_page_single_review');
	}

	if ($pages = $wpdb->get_results("SELECT ID AS id FROM {$wpdb->posts} WHERE post_content LIKE '%[" . W2RR_REVIEW_PAGE_SHORTCODE . "%' AND post_status = 'publish' AND post_type = 'page'", ARRAY_A)) {
		$page_id = $pages[0]['id'];

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($tpage = apply_filters('wpml_object_id', $page_id, 'page')) {
				$page_id = $tpage;
			}

		}

		return $page_id;
	}
}

function w2rr_get_add_review_link($target_post_id, $admin = false) {
	global $w2rr_instance;
	
	if ($admin) {
		if (current_user_can('manage_options')) {
			return admin_url('post-new.php?post_type='.W2RR_REVIEW_TYPE.'&target_post_id='.$target_post_id);
		}
	}
	
	if ($w2rr_instance->add_review_page_id) {
		$add_review_page_url = get_the_permalink($w2rr_instance->add_review_page_id);
		
		return add_query_arg(array('target-post' => $target_post_id), $add_review_page_url);
	}
}

function w2rr_can_user_add_review($post_id) {
	global $w2rr_instance;
	
	$reviews_counter = w2rr_getReviewsCounterByAuthorByPost($post_id);
	
	// number of reviews for one user exceed limit
	if (get_option('w2rr_reviews_number_allowed') && $reviews_counter >= get_option('w2rr_reviews_number_allowed')) {
		return false;
	}
	
	// only admins can post
	if (!current_user_can('manage_options') && get_option('w2rr_reviews_allowed_users') == 'admin') {
		return false;
	}
	
	// regular user can not post without add-review-page
	if (!current_user_can('manage_options') && !$w2rr_instance->add_review_page_id) {
		return false;
	}
	
	// user should be logged in
	if (get_option('w2rr_reviews_allowed_users') == 'login' && !is_user_logged_in()) {
		return false;
	}
	
	return true;
}

function w2rr_show_add_review_button($post_id) {
	global $w2rr_instance;
	
	$reviews_counter = w2rr_getReviewsCounterByAuthorByPost($post_id);
	
	// number of reviews for one user exceed limit
	if (get_option('w2rr_reviews_number_allowed') && $reviews_counter >= get_option('w2rr_reviews_number_allowed')) {
		return false;
	}
	
	// only admins can post
	if (!current_user_can('manage_options') && get_option('w2rr_reviews_allowed_users') == 'admin') {
		return false;
	}
	
	// regular user can not post without add-review-page
	if (!$w2rr_instance->add_review_page_id) {
		return false;
	}
	
	return true;
}

function w2rr_show_add_review_button_message($post_id) {
	global $w2rr_instance;
	
	$reviews_counter = w2rr_getReviewsCounterByAuthorByPost($post_id);
	
	// number of reviews for one user exceed limit
	if (get_option('w2rr_reviews_number_allowed') && $reviews_counter >= get_option('w2rr_reviews_number_allowed')) {
		return esc_html__("Number of reviews for one user exceed limit", "w2rr");
	}
	
	// only admins can post
	if (!current_user_can('manage_options') && get_option('w2rr_reviews_allowed_users') == 'admin') {
		return esc_html__("Only admins can post", "w2rr");
	}
	
	// regular user can not post without add-review-page
	if (!$w2rr_instance->add_review_page_id) {
		return esc_html__("No page to submit a review", "w2rr");
	}
}

function w2rr_get_all_reviews_link($target_post) {
	global $wp_rewrite;

	$post_url = get_permalink($target_post->post);

	if ($wp_rewrite->using_permalinks()) {
		$url = rtrim($post_url, '/');
		if (strstr($url, '#', true)) {
			$url = strstr($url, '#', true);
		}
		$url = $url . '/reviews/';
		return $url;
	} else {
		$all_reviews_page_url = '';

		return add_query_arg(array('reviews-all' => 1, 'target-post' => $target_post->post->post_name), $all_reviews_page_url);
	}
}

/**
 * Get current review by query var 'reviews'
 * 
 * @return object w2rr_review|'all'|false
 */
function w2rr_getCurrentReviewByQueryVar() {
	if (w2rr_isReview()) {
		
		if (get_query_var(W2RR_REVIEW_TYPE)) {
			$name = get_query_var(W2RR_REVIEW_TYPE);
		} elseif (get_query_var("review-w2rr")) {
			$name = get_query_var("review-w2rr");
		} elseif (get_query_var("reviews") && get_query_var("reviews") != 'all') {
			$name = get_query_var("reviews");
		}
		
		$reviews_controller = new w2rr_reviews_controller();
		$reviews_controller->init(array(
				'name' => $name,
		));
		if ($reviews_controller->review) {
			return $reviews_controller->review;
		} else {
			return 'all';
		}
	}
}

global $w2rr_reviews;
function w2rr_getReview($post) {
	global $w2rr_reviews;
	
	if (is_object($post)) {
		$post_id = $post->ID;
	} elseif (is_numeric($post)) {
		$post_id = $post;
	}
	
	if (isset($post_id) && isset($w2rr_reviews[$post_id])) {
		return $w2rr_reviews[$post_id];
	}
	
	$review = new w2rr_review;
	if ($review->loadReviewFromPost($post)) {
		
		if (isset($post_id)) {
			$w2rr_reviews[$post_id] = $review;
		}
		
		return $review;
	}
}

function w2rr_getActiveReviewsCounterByPostId($post_id = false) {
	global $wpdb, $w2rr_reviews_counters;
	
	$reviews_counter = 0;
	
	if (!$post_id && ($target_post = w2rr_getTargetPost())) {
		$post_id = $target_post->post->ID;
	}
	
	if ($post_id) {
		
		if (isset($w2rr_reviews_counters[$post_id])) {
			return $w2rr_reviews_counters[$post_id];
		} else {
			$reviews_counter = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} AS p LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID=pm.post_id WHERE p.post_type='" . W2RR_REVIEW_TYPE . "' AND p.post_status='publish' AND pm.meta_key='_post_id' AND pm.meta_value={$post_id}");
			
			$w2rr_reviews_counters[$post_id] = $reviews_counter;
		}
	}
	
	return $reviews_counter;
}

function w2rr_getReviewsCounterByAuthorByPost($post_id, $user_id = false) {
	global $w2rr_instance, $wpdb;
	
	if (!$user_id) {
		$current_user = wp_get_current_user();
	} else {
		$current_user = get_user_by('ID', $user_id);
	}
	
	$reviews_counter = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} AS p LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID=pm.post_id WHERE p.post_type='" . W2RR_REVIEW_TYPE . "' AND (p.post_status='publish' OR p.post_status='pending') AND p.post_author={$current_user->ID} AND pm.meta_key='_post_id' AND pm.meta_value={$post_id}");
	
	return $reviews_counter;
}

function w2rr_getReviewsCounterByAuthor($user_id = false) {
	global $w2rr_instance, $wpdb;
	
	if (!$user_id) {
		$current_user = wp_get_current_user();
	} else {
		$current_user = get_user_by('ID', $user_id);
	}
	
	$reviews_counter = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} AS p WHERE p.post_type='" . W2RR_REVIEW_TYPE . "' AND p.post_status IN ('publish', 'pending') AND p.post_author={$current_user->ID}");
	
	return $reviews_counter;
}

function w2rr_reviewsOrderLinks($base_url, $defaults = array(), $return = false, $shortcode_hash = null) {
	global $w2rr_instance;

	if (isset($_GET['reviews_order_by']) && $_GET['reviews_order_by']) {
		$order_by = $_GET['reviews_order_by'];
		$order = w2rr_getValue($_GET, 'reviews_order', 'ASC');
	} else {
		if (isset($defaults['reviews_order_by']) && $defaults['reviews_order_by']) {
			$order_by = $defaults['reviews_order_by'];
			$order = w2rr_getValue($defaults, 'reviews_order', 'ASC');
		} else {
			$order_by = 'post_date';
			$order = 'DESC';
		}
	}

	$ordering = array();
	$ordering['post_date']['DESC'] = esc_html__('Newest first', 'w2rr');
	$ordering['post_date']['ASC'] = esc_html__('Oldest first', 'w2rr');
	$ordering['rating'] = esc_html__('Best rating', 'w2rr');
	if (get_option('w2rr_reviews_votes')) {
		$ordering['votes'] = esc_html__('Best voted', 'w2rr');
	}
	
	$ordering_links = new w2rr_orderingLinks($ordering, $base_url, $order_by, $order);
	
	$ordering_links = apply_filters('w2rr_reviews_ordering_options', $ordering_links, $base_url, $defaults, $shortcode_hash);
	
	return $ordering_links;
}

function w2rr_reviewsOrderingItems() {
	global $w2rr_instance;

	$ordering = array('post_date' => esc_html__('Date', 'w2rr'), 'votes' => esc_html__('Votes', 'w2rr'), 'rating' => esc_html__('Rating', 'w2rr'), 'rand' => esc_html__('Random', 'w2rr'));

	$ordering = apply_filters('w2rr_default_reviews_orderby_options', $ordering);
	$ordering_items = array();
	foreach ($ordering AS $field_slug=>$field_name) {
		$ordering_items[] = array('value' => $field_slug, 'label' => $field_name);
	}

	return $ordering_items;
}

function w2rr_renderAvgRating($avg_rating, $post_id, $args = array(), $return = false) {
	
	$show_counter = true;
	
	if (w2rr_isReview() || w2rr_isAddReviewPage()) {
		$show_counter = false;
	}
	
	$args = array_merge(
			array(
					'avg_rating' => $avg_rating,									// object to render stars, contains avg value
					'post_id' => $post_id,											// target post ID
					'noajax' => true,												// whether to send AJAX request to 'w2rr_save_rating'
					'meta_tags' => false,											// include metatags of aggregateRating: ratingValue and ratingCount
					'active' => true,												// hover on stars and save rating on click
					'show_avg' => false,											// the circle with average rating
					'stars_size' => w2rr_get_dynamic_option('w2rr_stars_size'),
					'show_counter' => $show_counter,								// the link with number of reviews near stars '(X Reviews)'
			),
			$args);
	
	return $avg_rating->render_avg_rating($post_id, $args, $return);
}

?>