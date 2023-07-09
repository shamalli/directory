<?php 

function w2rr_install_plugin() {
	global $wpdb;
	
	if (!get_option('w2rr_installed_plugin')) {
		add_option('w2rr_working_post_types', array('post', 'page'));
		add_option('w2rr_page_add_review');
		add_option('w2rr_page_dashboard');
		add_option('w2rr_reviews_allowed_users', 'guests');
		add_option('w2rr_reviews_moderation', 0);
		add_option('w2rr_edit_reviews_moderation', 0);
		add_option('w2rr_allow_edit_profile', 1);
		add_option('w2rr_tospage');
		add_option('w2rr_submit_login_page');
		add_option('w2rr_reviews_number_allowed', 0);
		add_option('w2rr_reviews_images_number', 5);
		add_option('w2rr_reviews_number_per_page', 10);
		add_option('w2rr_reviews_multi_rating');
		add_option('w2rr_enable_stats', 1);
		add_option('w2rr_hide_views_counter', 0);
		add_option('w2rr_hide_creation_date', 0);
		add_option('w2rr_hide_author_link', 0);
		add_option('w2rr_paginator_button', 'more_reviews');
		add_option('w2rr_reviews_votes', 1);
		add_option('w2rr_reviews_comments', 1);
		add_option('w2rr_show_orderby_links', 1);
		add_option('w2rr_default_orderby', 'post_date');
		add_option('w2rr_default_order', 'DESC');
		add_option('w2rr_enable_breadcrumbs', 1);
		add_option('w2rr_hide_home_link_breadcrumb', 0);
		add_option('w2rr_enable_lightbox_gallery', 1);
		add_option('w2rr_auto_slides_gallery', 0);
		add_option('w2rr_auto_slides_gallery_delay', 3000);
		add_option('w2rr_100_single_logo_width', 1);
		add_option('w2rr_single_logo_width', 270);
		add_option('w2rr_big_slide_bg_mode', 'cover');
		add_option('w2rr_enable_description', 1);
		add_option('w2rr_enable_summary', 1);
		add_option('w2rr_excerpt_length', 25);
		add_option('w2rr_cropped_content_as_excerpt', 1);
		add_option('w2rr_strip_excerpt', 1);
		add_option('w2rr_admin_notifications_email', get_option('admin_email'));
		add_option('w2rr_newreview_admin_notification', 'Hello,

user [user] created new review "[review]".

You may manage this review at
[link]');
		add_option('w2rr_editreview_admin_notification', 'Hello,

user [user] modified review "[review]". Now it is pending review.

You may manage this review at
[link]');
		add_option('w2rr_approval_review_notification', 'Hello [author],

your review "[review]" was successfully approved.

You may manage this review at
[link]');
		add_option('w2rr_force_include_js_css', 1);
		add_option('w2rr_images_lightbox', 1);
		add_option('w2rr_prevent_users_see_other_media', 1);
		add_option('w2rr_enable_recaptcha');
		add_option('w2rr_recaptcha_version', 'v3');
		add_option('w2rr_recaptcha_public_key');
		add_option('w2rr_recaptcha_private_key');
		add_option('w2rr_color_scheme', 'default');
		add_option('w2rr_primary_color', '#2393ba');
		add_option('w2rr_stars_color', '#FFB300');
		add_option('w2rr_links_color', '#2393ba');
		add_option('w2rr_links_hover_color', '#2a6496');
		add_option('w2rr_button_1_color', '#2393ba');
		add_option('w2rr_button_2_color', '#1f82a5');
		add_option('w2rr_button_text_color', '#FFFFFF');
		add_option('w2rr_button_gradient', 0);
		add_option('w2rr_share_buttons_style', 'arbenta');
		add_option('w2rr_share_buttons', array());
		add_option('w2rr_share_counter', 0);
		add_option('w2rr_share_buttons_place', 'title');
		add_option('w2rr_share_buttons_width', 40);
		add_option('w2rr_hide_admin_bar', 0);
		add_option('w2rr_single_logo_height', 0);
		add_option('w2rr_display_mode', 'comments');
		add_option('w2rr_views_switcher_default', 'list');
		add_option('w2rr_reviews_view_grid_columns', 2);
		add_option('w2rr_mobile_reviews_grid_columns', 1);
		add_option('w2rr_reviews_view_grid_masonry', 0);
		add_option('w2rr_enable_pros_cons', 1);
		add_option('w2rr_newuser_notification', 'Hello [author],
		
thank you for review submission "[review]".
		
You may manage this review by
login: [login]
password: [password]');
		add_option('w2rr_w2dc_ratings', 'registered');
		add_option('w2rr_stars_size', 20);
		add_option('w2rr_single_review_is_on_page', 1);
		
		add_option('w2rr_installed_plugin', true);
		add_option('w2rr_installed_plugin_version', W2RR_VERSION);
		add_option('w2rr_installed_plugin_time', time());
	} elseif (get_option('w2rr_installed_plugin_version') != W2RR_VERSION) {
		$upgrades_list = array(
				'1.0.3',
				'1.0.4',
				'1.1.0',
				'1.1.1',
				'1.1.9',
				'1.1.13',
				'1.2.0',
				'1.2.4',
				'1.2.6',
				'1.3.2',
		);

		$old_version = get_option('w2rr_installed_plugin_version');
		foreach ($upgrades_list AS $upgrade_version) {
			if (!$old_version || version_compare($old_version, $upgrade_version, '<')) {
				$upgrade_function_name = 'w2rr_upgrade_to_' . str_replace('.', '_', $upgrade_version);
				if (function_exists($upgrade_function_name))
					$upgrade_function_name();
				do_action('w2rr_version_upgrade', $upgrade_version);
			}
		}

		w2rr_save_dynamic_css();

		update_option('w2rr_installed_plugin_version', W2RR_VERSION);
		
		if (!get_option('w2rr_installed_plugin_time')) {
			add_option('w2rr_installed_plugin_time', time());
		}
		
		echo '<script>location.reload();</script>';
		exit;
	}
	
	global $w2rr_instance;
	$w2rr_instance->loadClasses();
}

function w2rr_upgrade_to_1_0_3() {
	update_option('w2rr_force_include_js_css', 1);
}

function w2rr_upgrade_to_1_0_4() {
	update_option('w2rr_hide_admin_bar', 0);
}

function w2rr_upgrade_to_1_1_0() {
	add_option('w2rr_single_logo_height', 0);
}
function w2rr_upgrade_to_1_1_1() {
	
	add_option('w2rr_display_mode', 'comments');
	
	add_option('w2rr_views_switcher_default', 'list');
	add_option('w2rr_reviews_view_grid_columns', 2);
	add_option('w2rr_mobile_reviews_grid_columns', 1);
	add_option('w2rr_reviews_view_grid_masonry', 0);
}

function w2rr_upgrade_to_1_1_9() {
	add_option('w2rr_enable_pros_cons', 1);
}

function w2rr_upgrade_to_1_1_11() {
	add_option('w2rr_newuser_notification', 'Hello [author],

thank you for review submission "[review]".

You may manage this review by 
login: [login]
password: [password]');
}

function w2rr_upgrade_to_1_1_13() {
	add_option('w2rr_recaptcha_version', 'v3');
	
	add_option('w2rr_w2dc_ratings', 'registered');
}

function w2rr_upgrade_to_1_2_0() {
	flush_rewrite_rules();
}

function w2rr_upgrade_to_1_2_4() {
	
	if (w2rr_is_wc()) {
		
		w2rr_create_avg_rating_for_products();
	}
}

function w2rr_upgrade_to_1_2_6() {
	
	add_option('w2rr_stars_size', 20);
}

function w2rr_upgrade_to_1_3_2() {
	
	flush_rewrite_rules();
	
	add_option('w2rr_single_review_is_on_page', 1);
}

?>