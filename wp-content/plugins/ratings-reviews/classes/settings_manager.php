<?php

global $w2rr_wpml_dependent_options;
if (empty($w2rr_wpml_dependent_options)) {
	$w2rr_wpml_dependent_options[] = 'w2rr_page_add_review';
	$w2rr_wpml_dependent_options[] = 'w2rr_page_dashboard';
}

class w2rr_settings_manager {
	public function __construct() {
		add_action('init', array($this, 'plugin_settings'), 100); // priority 100  we need to collect all custom post types from 3rd party plugins
		
		if (!defined('W2RR_DEMO') || !W2RR_DEMO) {
			add_action('w2rr_vp_option_after_ajax_save', array($this, 'save_option'), 10, 3);
		}
		
		add_action('w2rr_settings_panel_bottom', array($this, 'our_plugins'));
	}
	
	public function our_plugins() {
		w2rr_renderTemplate('our_plugins.tpl.php');
	}
	
	public function plugin_settings() {
		global $w2rr_instance, $w2rr_social_services, $wp_post_types, $sitepress;
		
		if (defined('W2RR_DEMO') && W2RR_DEMO) {
			$capability = 'publish_posts';
		} else {
			$capability = 'edit_theme_options';
		}

		$ordering_items = w2rr_reviewsOrderingItems();
		
		$w2rr_social_services = array(
			'facebook' => array('value' => 'facebook', 'label' => esc_html__('Facebook', 'w2rr')),
			'twitter' => array('value' => 'twitter', 'label' => esc_html__('Twitter', 'w2rr')),
			'google' => array('value' => 'google', 'label' => esc_html__('Google+', 'w2rr')),
			'linkedin' => array('value' => 'linkedin', 'label' => esc_html__('LinkedIn', 'w2rr')),
			'digg' => array('value' => 'digg', 'label' => esc_html__('Digg', 'w2rr')),
			'reddit' => array('value' => 'reddit', 'label' => esc_html__('Reddit', 'w2rr')),
			'pinterest' => array('value' => 'pinterest', 'label' => esc_html__('Pinterest', 'w2rr')),
			'tumblr' => array('value' => 'tumblr', 'label' => esc_html__('Tumblr', 'w2rr')),
			'stumbleupon' => array('value' => 'stumbleupon', 'label' => esc_html__('StumbleUpon', 'w2rr')),
			'vk' => array('value' => 'vk', 'label' => esc_html__('VK', 'w2rr')),
			'whatsapp' => array('value' => 'whatsapp', 'label' => esc_html__('WhatsApp', 'w2rr')),
			'telegram' => array('value' => 'telegram', 'label' => esc_html__('Telegram', 'w2rr')),
			'viber' => array('value' => 'viber', 'label' => esc_html__('Viber', 'w2rr')),
			'email' => array('value' => 'email', 'label' => esc_html__('Email', 'w2rr')),
		);
		
		$w2rr_exclude_post_types = array(
				W2RR_REVIEW_TYPE,
				'attachment',
		);
		
		$w2rr_post_types = array();
		foreach ($wp_post_types AS $post_type) {
			if ($post_type->public && !in_array($post_type->name, $w2rr_exclude_post_types) && post_type_supports($post_type->name, 'comments')) {
				$w2rr_post_types[] = array('value' => $post_type->name, 'label' => $post_type->label);
			}
		}
		
		$pages = get_pages();
		$all_pages[] = array('value' => 0, 'label' => esc_html__('- Select page -', 'w2rr'));
		foreach ($pages AS $page) {
			$all_pages[] = array('value' => $page->ID, 'label' => $page->post_title);
		}
		
		$theme_options = array(
				'option_key' => 'vpt_option',
				'page_slug' => 'w2rr_settings',
				'template' => array(
					'title' => esc_html__('Ratings & Reviews Settings', 'w2rr'),
					'logo' => W2RR_RESOURCES_URL . 'images/settings.png',
					'menus' => array(
						'general' => array(
							'name' => 'general',
							'title' => esc_html__('General settings', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-home',
							'controls' => array(
								'pages' => array(
									'type' => 'section',
									'title' => esc_html__('Pages', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_page_add_review'), // adapted for WPML
											'label' => esc_html__('Submission page*', 'w2rr'),
											'description' => esc_html__('This page will be used for review submission.', 'w2rr') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_page_add_review') ? array(w2rr_get_wpml_dependent_option('w2rr_page_add_review')) : array(0)), // adapted for WPML
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_page_single_review'), // adapted for WPML
											'label' => esc_html__('Single review page', 'w2rr'),
											'description' => esc_html__('Clicking a review will open this page. Or single review will be displayed along with other content.', 'w2rr') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_page_single_review') ? array(w2rr_get_wpml_dependent_option('w2rr_page_single_review')) : array(0)), // adapted for WPML
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_page_dashboard'), // adapted for WPML
											'label' => esc_html__('Dashboard page', 'w2rr'),
											'description' => esc_html__('A page for frontend users dashboard.', 'w2rr') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_page_dashboard') ? array(w2rr_get_wpml_dependent_option('w2rr_page_dashboard')) : array(0)), // adapted for WPML
										),
									)
								),
								'post_types' => array(
									'type' => 'section',
									'title' => esc_html__('Working post types', 'w2rr'),
									'fields' => array(
									 	array(
											'type' => 'checkbox',
											'name' => 'w2rr_working_post_types',
											'label' => esc_html__('Select post types', 'w2rr'),
											'default' => get_option('w2rr_working_post_types'),
									 		'items' => $w2rr_post_types,
									 		'description' => esc_html__('Select post types you wish to work. Ratings and reviews will be displayed instead of comments.', 'w2rr'),
										),
									),
								),
								'display_mode' => array(
									'type' => 'section',
									'title' => esc_html__('How to display reviews', 'w2rr'),
									'fields' => array(
									 	array(
											'type' => 'radiobutton',
											'name' => 'w2rr_display_mode',
											'label' => esc_html__('How to display reviews', 'w2rr'),
											'default' => get_option('w2rr_display_mode'),
									 		'items' => array(
													array(
														'value' => 'comments',
														'label' => esc_html__('display reviews content in comments section', 'w2rr'),	
													),
													array(
														'value' => 'shortcodes',
														'label' => esc_html__('use shortcodes', 'w2rr'),	
													),
											),
									 		'description' => esc_html__('2 ways to display reviews and ratings: in comments section or by using shortcodes on a page', 'w2rr'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_single_review_is_on_page',
											'label' => esc_html__('Open review on new page, otherwise open in popup.', 'w2rr'),
											'default' => get_option('w2rr_single_review_is_on_page'),
										),
									),
								),
								'submission' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews submission', 'w2rr'),
									'fields' => array(
									 	array(
											'type' => 'radiobutton',
											'name' => 'w2rr_reviews_allowed_users',
											'label' => esc_html__('Who can place reviews', 'w2rr'),
											'default' => get_option('w2rr_reviews_allowed_users'),
											'items' => array(
													array(
														'value' => 'admins',
														'label' => esc_html__('only admins', 'w2rr'),	
													),
													array(
														'value' => 'login',
														'label' => esc_html__('logged in users (registration required)', 'w2rr'),	
													),
													array(
														'value' => 'required_contact_form',
														'label' => esc_html__('users and guests (required to fill in contact form)', 'w2rr'),	
													),
													array(
														'value' => 'guests',
														'label' => esc_html__('users and guests (ask to fill in contact form)', 'w2rr'),	
													),
													array(
														'value' => 'no_contact_form',
														'label' => esc_html__('do not ask guests to fill in contact form', 'w2rr'),	
													),
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_moderation',
											'label' => esc_html__('Enable pre-moderation of reviews', 'w2rr'),
											'default' => get_option('w2rr_reviews_moderation'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_edit_reviews_moderation',
											'label' => esc_html__('Enable moderation after a review was modified', 'w2rr'),
											'default' => get_option('w2rr_edit_reviews_moderation'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_allow_edit_profile',
											'label' => esc_html__('Allow users to manage own profile at the frontend dashboard', 'w2rr'),
											'default' => get_option('w2rr_allow_edit_profile'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_admin_bar',
											'label' => esc_html__('Hide top admin bar at the frontend for regular users', 'w2rr'),
											'default' => get_option('w2rr_hide_admin_bar'),
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_tospage'), // adapted for WPML
											'label' => esc_html__('Require Terms of Services on submission page?', 'w2rr'),
											'description' => esc_html__('If yes, create a WordPress page containing your TOS agreement and assign it using the dropdown above.', 'w2rr') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_tospage') ? array(w2rr_get_wpml_dependent_option('w2rr_tospage')) : array(0)), // adapted for WPML
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_submit_login_page'), // adapted for WPML
											'label' => esc_html__('Use custom login page for reviews submission process', 'w2rr'),
											'description' => esc_html__('You may use any 3rd party plugin to make custom login page and assign it with submission process using the dropdown above.', 'w2rr') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_submit_login_page') ? array(w2rr_get_wpml_dependent_option('w2rr_submit_login_page')) : array(0)), // adapted for WPML
										),
									),
								),
							),
						),
						'ratings' => array(
							'name' => 'ratings',
							'title' => esc_html__('Ratings & Reviews', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-star',
							'controls' => array(
								'reviews' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews settings', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2rr_reviews_number_allowed',
											'label' => esc_html__('Number of reviews a user can add for one post', 'w2rr'),
											'description' => esc_html__('Enter 0 to set unlimit', 'w2rr'),
											'default' => get_option('w2rr_reviews_number_allowed'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_reviews_images_number',
											'label' => esc_html__('Number of images allowed to upload in review', 'w2rr'),
											'description' => esc_html__('Enter 0 to disable images', 'w2rr'),
											'default' => get_option('w2rr_reviews_images_number'),
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_reviews_multi_rating',
											'label' => esc_html__('Ratings multi-criteria', 'w2rr'),
											'description' => esc_html__('Enter each criteria on a separate line', 'w2rr'),
											'default' => get_option('w2rr_reviews_multi_rating'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_stats',
											'label' => esc_html__('Enable statistics functionality', 'w2rr'),
											'default' => get_option('w2rr_enable_stats'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_views_counter',
											'label' => esc_html__('Hide views counter', 'w2rr'),
											'default' => get_option('w2rr_hide_views_counter'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_creation_date',
											'label' => esc_html__('Hide creation date', 'w2rr'),
											'default' => get_option('w2rr_hide_creation_date'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_author_link',
											'label' => esc_html__('Hide author information', 'w2rr'),
											'description' => esc_html__('Author name and possible link to author website will be hidden on reivews.', 'w2rr'),
											'default' => get_option('w2rr_hide_author_link'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_reviews_number_per_page',
											'label' => esc_html__('Number of reviews per page', 'w2rr'),
											'default' => get_option('w2rr_reviews_number_per_page'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_paginator_button',
											'label' => esc_html__('Paginator mode', 'w2rr'),
											'default' => array(get_option('w2rr_paginator_button')),
											'items' => array(
													array(
														'value' => 'paginator',
														'label' => esc_html__('Display default paginator', 'w2rr'),	
													),
													array(
														'value' => 'more_reviews',
														'label' => esc_html__('"Show More Reviews" button', 'w2rr'),	
													),
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_votes',
											'label' => esc_html__('Enable votes in reviews', 'w2rr'),
											'description' => esc_html__('Up and down votes', 'w2rr'),
											'default' => get_option('w2rr_reviews_votes'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_comments',
											'label' => esc_html__('Enable comments in reviews', 'w2rr'),
											'default' => get_option('w2rr_reviews_comments'),
										),
									),
								),
								'sorting' => array(
									'type' => 'section',
									'title' => esc_html__('Sorting settings', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_show_orderby_links',
											'label' => esc_html__('Show sorting options', 'w2rr'),
											'default' => get_option('w2rr_show_orderby_links'),
										),
										array(
											'type' => 'select',
											'name' => 'w2rr_default_orderby',
											'label' => esc_html__('Default order by', 'w2rr'),
											'items' => $ordering_items,
											'default' => get_option('w2rr_default_orderby'),
										),
										array(
											'type' => 'select',
											'name' => 'w2rr_default_order',
											'label' => esc_html__('Default order direction', 'w2rr'),
											'items' => array(
												array(
													'value' => 'ASC',
													'label' => esc_html__('Ascending', 'w2rr'),
												),
												array(
													'value' => 'DESC',
													'label' => esc_html__('Descending', 'w2rr'),
												),
											),
											'default' => get_option('w2rr_default_order'),
										),
									),
								),
							),
						),
						'layout' => array(
							'name' => 'layout',
							'title' => esc_html__('Layout', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-list-alt',
							'controls' => array(
								'breadcrumbs' => array(
									'type' => 'section',
									'title' => esc_html__('Breadcrumbs settings', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_breadcrumbs',
											'label' => esc_html__('Enable breadcrumbs', 'w2rr'),
											'default' => get_option('w2rr_enable_breadcrumbs'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_home_link_breadcrumb',
											'label' => esc_html__('Hide home link in breadcrumbs', 'w2rr'),
											'default' => get_option('w2rr_hide_home_link_breadcrumb'),
										),
									),
								),
								'reviews_view' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews view', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_views_switcher_default',
											'label' => esc_html__('Reviews view', 'w2rr'),
											'default' => array(get_option('w2rr_views_switcher_default')),
											'items' => array(
													array(
														'value' => 'list',
														'label' => esc_html__('List view', 'w2rr'),
													),
													array(
														'value' => 'grid',
														'label' => esc_html__('Grid view', 'w2rr'),
													),
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_reviews_view_grid_columns',
											'label' => esc_html__('Number of columns for reviews Grid View', 'w2rr'),
											'min' => 1,
											'max' => 4,
											'default' => get_option('w2rr_reviews_view_grid_columns'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_mobile_reviews_grid_columns',
											'label' => esc_html__('Number of columns for mobile devices', 'w2rr'),
											'min' => 1,
											'max' => 2,
											'default' => get_option('w2rr_mobile_reviews_grid_columns'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_view_grid_masonry',
											'label' => esc_html__('Enable masonry in Grid View', 'w2rr'),
											'default' => get_option('w2rr_reviews_view_grid_masonry'),
										),
									),
								),
								'logos' => array(
									'type' => 'section',
									'title' => esc_html__('Review images (on a Review page)', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_lightbox_gallery',
											'label' => esc_html__('Enable lightbox on images gallery', 'w2rr'),
											'default' => get_option('w2rr_enable_lightbox_gallery'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_auto_slides_gallery',
											'label' => esc_html__('Enable automatic rotating slideshow on images gallery', 'w2rr'),
											'default' => get_option('w2rr_auto_slides_gallery'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_auto_slides_gallery_delay',
											'label' => esc_html__('The delay in rotation (in ms)', 'w2rr'),
											'default' => get_option('w2rr_auto_slides_gallery_delay'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_100_single_logo_width',
											'label' => esc_html__('Enable 100% width of images gallery', 'w2rr'),
											'default' => get_option('w2rr_100_logo_width'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_single_logo_width',
											'label' => esc_html__('Images gallery width (in pixels)', 'w2rr'),
											'description' => esc_html__('This option needed only when 100% width of images gallery is switched off'),
											'min' => 100,
											'max' => 800,
											'default' => get_option('w2rr_single_logo_width'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_single_logo_height',
											'label' => esc_html__('Images gallery height (in pixels)', 'w2rr'),
											'description' => esc_html__('Set to 0 to fit full height', 'w2rr'),
											'min' => 0,
											'max' => 800,
											'default' => get_option('w2rr_single_logo_height'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_big_slide_bg_mode',
											'label' => esc_html__('Do crop images gallery', 'w2rr'),
											'default' => array(get_option('w2rr_big_slide_bg_mode')),
											'items' => array(
													array(
														'value' => 'cover',
														'label' => esc_html__('Cut off image to fit width and height of main slide', 'w2rr'),	
													),
													array(
														'value' => 'contain',
														'label' => esc_html__('Full image inside main slide', 'w2rr'),	
													),
											),
											'description' => esc_html__('Works when gallery height is limited (not set to 0)', 'w2rr'),
										),
									),
								),
								'excerpts' => array(
									'type' => 'section',
									'title' => esc_html__('Description & Excerpt settings', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_description',
											'label' => esc_html__('Enable description field', 'w2rr'),
											'default' => get_option('w2rr_enable_description'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_summary',
											'label' => esc_html__('Enable summary (excerpt) field', 'w2rr'),
											'default' => get_option('w2rr_enable_summary'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_pros_cons',
											'label' => esc_html__('Enable Pros & Cons', 'w2rr'),
											'default' => get_option('w2rr_enable_pros_cons'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_excerpt_length',
											'label' => esc_html__('Excerpt max length', 'w2rr'),
											'description' => esc_html__('Insert the number of words you want to show in the reviews excerpts', 'w2rr'),
											'default' => get_option('w2rr_excerpt_length'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_cropped_content_as_excerpt',
											'label' => esc_html__('Use cropped content as excerpt', 'w2rr'),
											'description' => esc_html__('When excerpt field is empty - use cropped main content', 'w2rr'),
											'default' => get_option('w2rr_cropped_content_as_excerpt'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_strip_excerpt',
											'label' => esc_html__('Strip HTML from excerpt', 'w2rr'),
											'description' => esc_html__('Check the box if you want to strip HTML from the excerpt content only', 'w2rr'),
											'default' => get_option('w2rr_strip_excerpt'),
										),
									),
								),
							),
						),
						
						'notifications' => array(
							'name' => 'notifications',
							'title' => esc_html__('Email notifications', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-envelope',
							'controls' => array(
								'notifications' => array(
									'type' => 'section',
									'title' => esc_html__('Email notifications', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2rr_admin_notifications_email',
											'label' => esc_html__('This email will be used for notifications to admin and in "From" field. Required to send emails.', 'w2rr'),
											'default' => get_option('w2rr_admin_notifications_email'),
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_newreview_admin_notification',
											'label' => esc_html__('Notification to admin about new review creation', 'w2rr'),
											'default' => get_option('w2rr_newreview_admin_notification'),
											'description' => esc_html__('Tags allowed: ', 'w2rr') . '[user], [review], [link]',
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_editreview_admin_notification',
											'label' => esc_html__('Notification to admin about review modification and pending status', 'w2rr'),
											'default' => get_option('w2rr_editreview_admin_notification'),
											'description' => esc_html__('Tags allowed: ', 'w2rr') . '[user], [review], [link]',
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_approval_review_notification',
											'label' => esc_html__('Notification to author about successful review approval', 'w2rr'),
											'default' => get_option('w2rr_approval_review_notification'),
											'description' => esc_html__('Tags allowed: ', 'w2rr') . '[author], [review], [link]',
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_newuser_notification',
											'label' => esc_html__('Notification to new user with generated password', 'w2rr'),
											'default' => get_option('w2rr_newuser_notification'),
											'description' => esc_html__('Tags allowed: ', 'w2rr') . '[author], [review], [login], [password]',
										),
									),
								),
							),
						),
						'advanced' => array(
							'name' => 'advanced',
							'title' => esc_html__('Advanced settings', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-gear',
							'controls' => array(
								'js_css' => array(
									'type' => 'section',
									'title' => esc_html__('JavaScript & CSS', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_images_lightbox',
											'label' => esc_html__('Include lightbox slideshow library', 'w2rr'),
											'description' =>  esc_html__('Some themes and 3rd party plugins include own lightbox library - this may cause conflicts.', 'w2rr'),
											'default' => get_option('w2rr_images_lightbox'),
										),
									),
								),
								'miscellaneous' => array(
									'type' => 'section',
									'title' => esc_html__('Miscellaneous', 'w2rr'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2rr_prevent_users_see_other_media',
											'label' => esc_html__('Prevent users to see media items of another users', 'w2rr'),
											'default' => get_option('w2rr_prevent_users_see_other_media'),
										),
									),
								),
								'recaptcha' => array(
									'type' => 'section',
									'title' => esc_html__('reCaptcha settings', 'w2rr'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_recaptcha',
											'label' => esc_html__('Enable reCaptcha', 'w2rr'),
											'default' => get_option('w2rr_enable_recaptcha'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_recaptcha_version',
											'label' => esc_html__('reCaptcha version', 'w2rr'),
											'default' => get_option('w2rr_recaptcha_version'),
									 		'items' => array(
												array('value' => 'v2', 'label' => esc_html__('reCaptcha v2', 'w2rr')),
												array('value' => 'v3', 'label' => esc_html__('reCaptcha v3', 'w2rr')),
											),
										),
									 	array(
											'type' => 'textbox',
											'name' => 'w2rr_recaptcha_public_key',
											'label' => esc_html__('reCaptcha site key', 'w2rr'),
											'description' => sprintf(esc_html__('get your reCAPTCHA API Keys %s', 'w2rr'), '<a href="http://www.google.com/recaptcha" target="_blank">here</a>'),
											'default' => get_option('w2rr_recaptcha_public_key'),
										),
									 	array(
											'type' => 'textbox',
											'name' => 'w2rr_recaptcha_private_key',
											'label' => esc_html__('reCaptcha secret key', 'w2rr'),
											'default' => get_option('w2rr_recaptcha_private_key'),
										),
									),
								),
							),
						),
						'customization' => array(
							'name' => 'customization',
							'title' => esc_html__('Customization', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-check',
							'controls' => array(
								'color_schemas' => array(
									'type' => 'section',
									'title' => esc_html__('Color palettes', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_compare_palettes',
											'label' => esc_html__('Compare palettes at the frontend', 'w2rr'),
									 		'description' =>  esc_html__('Do not forget to switch off this setting when comparison will be completed.', 'w2rr'),
											'default' => get_option('w2rr_compare_palettes'),
										),
										array(
											'type' => 'select',
											'name' => 'w2rr_color_scheme',
											'label' => esc_html__('Color palette', 'w2rr'),
											'items' => array(
												array('value' => 'default', 'label' => esc_html__('Default', 'w2rr')),
												array('value' => 'orange', 'label' => esc_html__('Orange', 'w2rr')),
												array('value' => 'red', 'label' => esc_html__('Red', 'w2rr')),
												array('value' => 'yellow', 'label' => esc_html__('Yellow', 'w2rr')),
												array('value' => 'green', 'label' => esc_html__('Green', 'w2rr')),
												array('value' => 'gray', 'label' => esc_html__('Gray', 'w2rr')),
												array('value' => 'blue', 'label' => esc_html__('Blue', 'w2rr')),
											),
											'default' => array(get_option('w2rr_color_scheme')),
										),
										array(
											'type' => 'notebox',
											'description' => esc_attr__("Don't forget to clear cache of your browser and on server (when used) after customization changes were made.", 'w2rr'),
											'status' => 'warning',
										),
									),
								),
								'main_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Main colors', 'w2rr'),
									'fields' => array(
										array(
												'type' => 'color',
												'name' => 'w2rr_primary_color',
												'label' => esc_html__('Primary color', 'w2rr'),
												'description' =>  esc_html__('The color of ratings elements, loaders, pagination', 'w2rr'),
												'default' => get_option('w2rr_primary_color'),
												'binding' => array(
														'field' => 'w2rr_color_scheme',
														'function' => 'w2rr_affect_setting_w2rr_primary_color'
												),
										),
										array(
												'type' => 'color',
												'name' => 'w2rr_stars_color',
												'label' => esc_html__('Stars color', 'w2rr'),
												'default' => get_option('w2rr_stars_color'),
												'binding' => array(
														'field' => 'w2rr_color_scheme',
														'function' => 'w2rr_affect_setting_w2rr_stars_color'
												),
										),
										array(
												'type' => 'slider',
												'name' => 'w2rr_stars_size',
												'label' => esc_html__('Stars size', 'w2rr'),
												'default' => get_option('w2rr_stars_size'),
												'min' => 10,
												'max' => 120,
												'description' => '<label class="w2rr-rating-icon w2rr-stars-size-setting-sample w2rr-fa w2rr-fa-star" style="font-size: ' . get_option('w2rr_stars_size') . 'px; color: ' . get_option('w2rr_stars_color') .  '"></label>',
										),
									),
								),
								'links_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Links & buttons', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'color',
											'name' => 'w2rr_links_color',
											'label' => esc_html__('Links color', 'w2rr'),
											'default' => get_option('w2rr_links_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_links_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_links_hover_color',
											'label' => esc_html__('Links hover color', 'w2rr'),
											'default' => get_option('w2rr_links_hover_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_links_hover_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_button_1_color',
											'label' => esc_html__('Button primary color', 'w2rr'),
											'default' => get_option('w2rr_button_1_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_button_1_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_button_2_color',
											'label' => esc_html__('Button secondary color', 'w2rr'),
											'default' => get_option('w2rr_button_2_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_button_2_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_button_text_color',
											'label' => esc_html__('Button text color', 'w2rr'),
											'default' => get_option('w2rr_button_text_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_button_text_color'
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_button_gradient',
											'label' => esc_html__('Use gradient on buttons', 'w2rr'),
											'description' => esc_html__('This will remove all icons from buttons'),
											'default' => get_option('w2rr_button_gradient'),
										),
									),
								),
							),
						),
						'social_sharing' => array(
							'name' => 'social_sharing',
							'title' => esc_html__('Social Sharing', 'w2rr'),
							'icon' => 'font-awesome:w2rr-fa-facebook ',
							'controls' => array(
								'social_sharing' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews Social Sharing Buttons', 'w2rr'),
									'fields' => array(
										array(
											'type' => 'radioimage',
											'name' => 'w2rr_share_buttons_style',
											'label' => esc_html__('Buttons style', 'w2rr'),
									 		'items' => array(
									 			array(
									 				'value' => 'arbenta',
									 				'label' =>esc_html__('Arbenta', 'w2rr'),
									 				'img' => W2RR_RESOURCES_URL . 'images/social/arbenta/facebook.png'
									 			),
									 			array(
									 				'value' => 'flat',
													'label' =>esc_html__('Flat', 'w2rr'),
									 				'img' => W2RR_RESOURCES_URL . 'images/social/flat/facebook.png'
									 			),
									 			array(
									 				'value' => 'somacro',
													'label' =>esc_html__('Somacro', 'w2rr'),
									 				'img' => W2RR_RESOURCES_URL . 'images/social/somacro/facebook.png'
									 			),
									 		),
											'default' => array(get_option('w2rr_share_buttons_style')),
										),
										array(
											'type' => 'sorter',
											'name' => 'w2rr_share_buttons',
											'label' => esc_html__('Include and order buttons', 'w2rr'),
									 		'items' => $w2rr_social_services,
											'default' => get_option('w2rr_share_buttons'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_share_counter',
											'label' => esc_html__('Enable counter', 'w2rr'),
											'default' => get_option('w2rr_share_counter'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_share_buttons_place',
											'label' => esc_html__('Buttons place', 'w2rr'),
											'items' => array(
												array(
													'value' => 'title',
													'label' =>esc_html__('After title', 'w2rr'),
												),
												array(
													'value' => 'before_content',
													'label' =>esc_html__('Before text content', 'w2rr'),
												),
												array(
													'value' => 'after_content',
													'label' =>esc_html__('After text content', 'w2rr'),
												),
											),
											'default' => array(
													get_option('w2rr_share_buttons_place')
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_share_buttons_width',
											'label' => esc_html__('Social buttons width (in pixels)', 'w2rr'),
											'default' => get_option('w2rr_share_buttons_width'),
									 		'min' => 24,
									 		'max' => 64,
										),
									),
								),
							),
						),
					)
				),
				'use_auto_group_naming' => true,
				'use_util_menu' => false,
				'minimum_role' => $capability,
				'layout' => 'fixed',
				'page_title' => esc_html__('Ratings & Reviews settings', 'w2rr'),
				'menu_label' => esc_html__('Ratings & Reviews settings', 'w2rr'),
		);
		
		// adapted for WPML /////////////////////////////////////////////////////////////////////////
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$theme_options['template']['menus']['advanced']['controls']['wpml'] = array(
				'type' => 'section',
				'title' => esc_html__('WPML Settings', 'w2rr'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'w2rr_map_language_from_wpml',
						'label' => esc_html__('Force WPML language on maps', 'w2rr'),
						'description' => esc_html__("Ignore the browser's language setting and force it to display information in a particular WPML language", 'w2rr'),
						'default' => get_option('w2rr_map_language_from_wpml'),
					),
				),
			);
		}
		
		$theme_options = apply_filters('w2rr_build_settings', $theme_options);

		$W2RR_VP_Option = new W2RR_VP_Option($theme_options);
	}

	public function save_option($opts, $old_opts, $status) {
		global $w2rr_wpml_dependent_options, $sitepress;

		if ($status) {
			foreach ($opts AS $option=>$value) {
				// adapted for WPML
				if (in_array($option, $w2rr_wpml_dependent_options)) {
					if (function_exists('wpml_object_id_filter') && $sitepress) {
						if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
							update_option($option.'_'.ICL_LANGUAGE_CODE, $value);
							continue;
						}
					}
				}
				
				$value = apply_filters("w2rr_update_option", $value, $option);

				update_option($option, $value);
			}
			
			// force to re-build rewrite rules, because function flush_rewrite_rules() does not work here
			delete_option('rewrite_rules');
			
			w2rr_save_dynamic_css();
		}
	}
}

function w2rr_save_dynamic_css() {
	$upload_dir = wp_upload_dir();
	$filename = trailingslashit($upload_dir['basedir']) . 'w2rr-plugin.css';
		
	ob_start();
	include W2RR_PATH . '/classes/customization/dynamic_css.php';
	$dynamic_css = ob_get_contents();
	ob_get_clean();
		
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}
		
	if ($wp_filesystem) {
		$wp_filesystem->put_contents(
				$filename,
				$dynamic_css,
				FS_CHMOD_FILE // predefined mode settings for WP files
		);
	}
}

// adapted for WPML
function w2rr_get_wpml_dependent_option_name($option) {
	global $w2rr_wpml_dependent_options, $sitepress;

	if (in_array($option, $w2rr_wpml_dependent_options))
		if (function_exists('wpml_object_id_filter') && $sitepress)
			if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE)
				if (get_option($option.'_'.ICL_LANGUAGE_CODE) !== false)
					return $option.'_'.ICL_LANGUAGE_CODE;

	return $option;
}
function w2rr_get_wpml_dependent_option($option) {
	return get_option(w2rr_get_wpml_dependent_option_name($option));
}
function w2rr_get_wpml_dependent_option_description() {
	global $sitepress;
	return ((function_exists('wpml_object_id_filter') && $sitepress) ? sprintf(esc_html__('%s This is multilingual option, each language may have own value.', 'w2rr'), '<br /><img src="'.W2RR_RESOURCES_URL . 'images/multilang.png" /><br />') : '');
}

add_filter("w2rr_update_option", "w2rr_check_add_review_page", 10, 2);
function w2rr_check_add_review_page($value = false, $option = false) {
	global $w2rr_instance;

	if (
	!w2rr_get_wpml_dependent_option_name('w2rr_page_add_review') &&
	!$w2rr_instance->add_review_page_id
	) {
		$page_args = array(
				'post_status' => 'publish',
				'post_name' => 'submit-review',
				'post_title' => esc_html__('Add Review', 'w2rr'),
				'post_type' => 'page',
				'post_content' => '',
				'comment_status' => 'closed'
		);
		$page_id = wp_insert_post($page_args);
		
		if (!is_wp_error($page_id)) {
			update_option('w2rr_page_add_review', $page_id);
			$w2rr_instance->add_review_page_id = $page_id;
		}
	}

	return $value;
}

/**
 * Update option for the vafpress framework
 * 
 */
add_action('update_option', 'w2rr_update_option_action', 10, 3);
function w2rr_update_option_action($option, $old_value, $value) {
	if ($option != 'vpt_option' && strpos($option, 'w2rr_') === 0) {
		$vpt_option = get_option('vpt_option');
		$vpt_option[$option] = $value;
		update_option('vpt_option', $vpt_option);
	}
}

?>