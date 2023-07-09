<?php

function w2rr_is_w2dc() {
	
	if (!defined('W2DC_POST_TYPE')) {
		return false;
	}
	
	return in_array(W2DC_POST_TYPE, w2rr_getWorkingPostTypes());
}

add_action('w2dc_listing_title_html', 'w2rr_w2dc_render_rating', 10, 2);
add_filter('w2dc_listing_title_search_html', 'w2rr_w2dc_get_rating_stars', 10, 2); // in autocomplete keywords search field
add_action('w2dc_dashboard_listing_title', 'w2rr_w2dc_render_rating_dashboard');

add_filter('w2dc_map_info_window_fields', 'w2rr_w2dc_add_rating_field_to_map_window');
add_filter('w2dc_map_info_window_fields_values', 'w2rr_w2dc_render_rating_in_map_window', 10, 3);

add_filter('w2dc_default_orderby_options', 'w2rr_w2dc_order_by_rating_option');
add_filter('w2dc_ordering_options', 'w2rr_w2dc_order_by_rating_html', 10, 3);
add_filter('w2dc_order_args', 'w2rr_w2dc_order_by_rating_args', 101, 2);

add_filter('w2dc_comments_open', 'w2rr_w2dc_comments_open', 10, 2);
add_filter('w2dc_comments_label', 'w2rr_w2dc_comments_label', 10, 2);

add_action('save_post_' . W2RR_REVIEW_TYPE, 'w2rr_w2dc_clear_count_cache');
function w2rr_w2dc_clear_count_cache() {
	
	if (w2rr_is_w2dc()) {
		w2dc_clear_count_cache();
	}
}

add_filter('w2rr_build_settings', 'w2rr_w2dc_plugin_settings');
function w2rr_w2dc_plugin_settings($options) {
	
	if (w2rr_is_w2dc()) {
		$options['template']['menus']['ratings']['controls']['listings'] = array(
				'type' => 'section',
				'title' => __('Directory Listings Ratings settings', 'W2RR'),
				'fields' => array(
						array(
								'type' => 'radiobutton',
								'name' => 'w2rr_w2dc_ratings',
								'label' => __('Allow users to place ratings without reviews', 'W2RR'),
								'default' => get_option('w2rr_w2dc_ratings'),
								'items' => array(
										array(
												'value' => 'notallowed',
												'label' => __('Not allowed', 'W2RR'),
										),
										array(
												'value' => 'registered',
												'label' => __('Only registered users', 'W2RR'),
										),
										array(
												'value' => 'anybody',
												'label' => __('Anybody', 'W2RR'),
										),
								),
								'description' => esc_html('click on stars', 'W2RR'),
						),
				),
		);
	}
	
	return $options;
}

/**
 * prevent to save ratings without reviews when notallowed
 */
add_filter('w2rr_save_rating', 'w2rr_w2dc_save_rating');
function w2rr_w2dc_save_rating($do_save) {
	
	$user_id = get_current_user_id();
	
	if (get_option('w2rr_w2dc_ratings') == 'notallowed' || (get_option('w2rr_w2dc_ratings') == 'registered' && !$user_id)) {
		$do_save = false;
	}
	
	return $do_save;
}

function w2rr_w2dc_render_rating($listing, $meta_tags = false, $active = true, $show_avg = true) {
	
	if (w2rr_is_w2dc()) {
		if ($target_post = w2rr_getTargetPost($listing->post)) {
			if (get_option('w2dc_listings_comments_mode') == 'enabled' || (get_option('w2dc_listings_comments_mode') == 'wp_settings' && $listing->post->comment_status == 'open')) {
				$active = true;
				
				$active = apply_filters('w2rr_save_rating', $active);
				
				$target_post->renderAvgRating(array('show_avg' => true, 'active' => $active, 'noajax' => false));
			}
		}
	}
}

function w2rr_w2dc_get_rating_stars($title, $listing) {
	
	if (w2rr_is_w2dc()) {
		if ($target_post = w2rr_getTargetPost($listing->post)) {
			return $title . ' ' . $target_post->renderAvgRating(array('active' => false, 'stars_size' => 20), true);
		}
	}
	
	return $title;
}

function w2rr_w2dc_render_rating_dashboard($listing) {
	
	if (w2rr_is_w2dc()) {
		if ($target_post = w2rr_getTargetPost($listing->post)) {
			if (get_option('w2dc_listings_comments_mode') == 'enabled' || (get_option('w2dc_listings_comments_mode') == 'wp_settings' && $listing->post->comment_status == 'open')) {
				echo ' ';
				$target_post->renderAvgRating(array('active' => false, 'show_avg' => true, 'stars_size' => 20));
			}
		}
	}
	
	return $listing;
}

function w2rr_w2dc_add_rating_field_to_map_window($fields) {
	
	if (w2rr_is_w2dc()) {
		$fields = array('rating' => '') + $fields;
	}

	return $fields;
}

function w2rr_w2dc_render_rating_in_map_window($content_field, $field_slug, $listing) {
	
	if ($field_slug == 'rating') {
		if (w2rr_is_w2dc()) {
			if ($target_post = w2rr_getTargetPost($listing->post->ID)) {
				return $target_post->renderAvgRating(array('active' => false, 'show_avg' => true), true);
			}
		}
	}
}

function w2rr_w2dc_order_by_rating_args($args, $defaults = array(), $include_GET_params = true) {
	
	if (w2rr_is_w2dc()) {
		if ($include_GET_params && isset($_REQUEST['order_by']) && $_REQUEST['order_by']) {
			$order_by = $_REQUEST['order_by'];
			$order = w2rr_getValue($_REQUEST, 'order', 'DESC');
		} else {
			if (isset($defaults['order_by']) && $defaults['order_by']) {
				$order_by = $defaults['order_by'];
				$order = w2rr_getValue($defaults, 'order', 'DESC');
			}
		}
	
		if (isset($order_by) && $order_by == 'rating_order') {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = '_avg_rating';
			$args['order'] = $order;
			if (get_option('w2dc_orderby_sticky_featured')) {
				add_filter('get_meta_sql', 'w2rr_w2dc_add_null_values');
				add_filter('w2dc_frontend_controller_construct', 'w2rr_w2dc_remove_query_filters');
			}
			if (get_option('w2dc_orderby_exclude_null')) {
				add_filter('w2dc_frontend_controller_construct', 'w2rr_w2dc_remove_query_filters');
			}
		}
	}

	return $args;
}

/**
 * Listings with empty values must be sorted as well
 *
 */
function w2rr_w2dc_add_null_values($clauses) {
	
	$clauses['where'] = str_replace("wp_postmeta.meta_key = '_avg_rating'", "(wp_postmeta.meta_key = '_avg_rating' OR wp_postmeta.meta_value IS NULL)", $clauses['where']);
	return $clauses;
}
function w2rr_w2dc_remove_query_filters() {
	
	remove_filter('get_meta_sql', 'w2rr_w2dc_add_null_values');
}

function w2rr_w2dc_order_by_rating_option($ordering) {
	
	if (w2rr_is_w2dc()) {
		$ordering['rating_order'] = __('Rating', 'W2RR');
	}

	return $ordering;
}

function w2rr_w2dc_order_by_rating_html($ordering, $base_url, $defaults = array()) {
	
	if (w2rr_is_w2dc()) {
		$ordering->addLinks(array('rating_order' => array('DESC' => __('Best rating', 'W2RR'))));
	}

	return $ordering;
}

function w2rr_w2dc_comments_open($comments_open, $post_id = false) {
	
	global $w2rr_instance;
	
	$_post = get_post($post_id);
	
	// return true for the w2dc_comments_open() function,
	// comments_open() function always returns false because of disable_comments_on_review_page_template() in reviews_manager.php
	if (w2rr_is_w2dc() && (get_option('w2dc_listings_comments_mode') == 'enabled' || (get_option('w2dc_listings_comments_mode') == 'wp_settings' && $_post && $_post->comment_status === 'open'))) {
		return true;
	}

	return $comments_open;
}

function w2rr_w2dc_comments_label($label, $listing) {
	
	global $w2rr_instance;
	
	if (w2rr_is_w2dc()) {
		if ($target_post = w2rr_getTargetPost($listing->post)) {
			$reviews_counter = $w2rr_instance->reviews_manager->get_reviews_counter($target_post);
				
			return _n('Review', 'Reviews', $reviews_counter, 'W2RR') . ' (' . $reviews_counter . ')';
		}
	}

	return $label;
}

/**
 * Adds anchor to reviews counter link
 * 
 * @return string
 */
function w2rr_w2dc_counter_reviews_link($link, $post_id) {
	
	if (w2rr_is_w2dc()) {
		if (get_post_type($post_id) == W2DC_POST_TYPE) {
			$link .= '#comments-tab';
		}
	}

	return $link;
}
add_filter('w2rr_counter_reviews_link', 'w2rr_w2dc_counter_reviews_link', 11, 2);

/**
 * hide "Show reviews" checkbox and display a message when comments permanently enabled/disabled by W2DC settings
 *
 */
add_filter('w2rr_comments_open_metabox_setting', 'w2rr_w2dc_comments_open_metabox_setting', 10, 2);
function w2rr_w2dc_comments_open_metabox_setting($do_display, $target_post) {
	
	if (w2rr_is_w2dc() && $target_post->post->post_type == W2DC_POST_TYPE) {
		if (get_option('w2dc_listings_comments_mode') == 'enabled' || get_option('w2dc_listings_comments_mode') == 'disabled') {
			$do_display = false;
		}
	}
	
	return $do_display;
}

add_action('w2rr_comments_open_metabox', 'w2rr_w2dc_comments_open_metabox');
function w2rr_w2dc_comments_open_metabox($target_post) {
	
	if (w2rr_is_w2dc() && $target_post->post->post_type == W2DC_POST_TYPE && (get_option('w2dc_listings_comments_mode') == 'enabled' || get_option('w2dc_listings_comments_mode') == 'disabled')) {
		echo "<p>";
		if (get_option('w2dc_listings_comments_mode') == 'enabled') {
			 esc_html_e('Reviews always enabled by W2DC settings.', 'W2RR');
		} elseif (get_option('w2dc_listings_comments_mode') == 'disabled') {
			esc_html_e('Reviews always disabled by W2DC settings.', 'W2RR');
		}
		echo " <a href='".admin_url('admin.php?page=w2dc_settings#_listings')."'>" . esc_html__('Go to Listings settings tab to change "Listings comments mode" setting.', 'W2RR') . "</a>";
		
		echo "</p>";
	}
}

/**
 * Automatically disable W2DC Ratings addon, when 'Directory listings' enabled in working post types
 */
add_action('vp_w2rr_option_after_ajax_save', 'w2rr_w2dc_check_directory_listings', 11);
function w2rr_w2dc_check_directory_listings() {
	
	if (w2rr_is_w2dc()) {
		update_option('w2dc_ratings_addon', 0);
	}
}

add_action("w2dc_print_breadcrumbs", "w2dc_print_breadcrumbs");
function w2dc_print_breadcrumbs($controller) {
	
}

/**
 * when W2DC listings always enabled comments - return 'open'
 */
add_filter('w2rr_comment_status', 'w2rr_w2dc_comment_status', 10, 2);
function w2rr_w2dc_comment_status($comment_status, $target_post) {
	
	if (get_post_type($target_post->post) == 'w2dc_listing') {
		if (get_option('w2dc_listings_comments_mode') == 'enabled') {
			return 'open';
		}
	}
	
	return $comment_status;
}

?>