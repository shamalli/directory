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
			add_action('vp_w2rr_option_after_ajax_save', array($this, 'save_option'), 10, 3);
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
			'facebook' => array('value' => 'facebook', 'label' => esc_html__('Facebook', 'W2RR')),
			'twitter' => array('value' => 'twitter', 'label' => esc_html__('Twitter', 'W2RR')),
			'google' => array('value' => 'google', 'label' => esc_html__('Google+', 'W2RR')),
			'linkedin' => array('value' => 'linkedin', 'label' => esc_html__('LinkedIn', 'W2RR')),
			'digg' => array('value' => 'digg', 'label' => esc_html__('Digg', 'W2RR')),
			'reddit' => array('value' => 'reddit', 'label' => esc_html__('Reddit', 'W2RR')),
			'pinterest' => array('value' => 'pinterest', 'label' => esc_html__('Pinterest', 'W2RR')),
			'tumblr' => array('value' => 'tumblr', 'label' => esc_html__('Tumblr', 'W2RR')),
			'stumbleupon' => array('value' => 'stumbleupon', 'label' => esc_html__('StumbleUpon', 'W2RR')),
			'vk' => array('value' => 'vk', 'label' => esc_html__('VK', 'W2RR')),
			'whatsapp' => array('value' => 'whatsapp', 'label' => esc_html__('WhatsApp', 'W2RR')),
			'telegram' => array('value' => 'telegram', 'label' => esc_html__('Telegram', 'W2RR')),
			'viber' => array('value' => 'viber', 'label' => esc_html__('Viber', 'W2RR')),
			'email' => array('value' => 'email', 'label' => esc_html__('Email', 'W2RR')),
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
		$all_pages[] = array('value' => 0, 'label' => esc_html__('- Select page -', 'W2RR'));
		foreach ($pages AS $page) {
			$all_pages[] = array('value' => $page->ID, 'label' => $page->post_title);
		}
		
		$theme_options = array(
				//'is_dev_mode' => true,
				'option_key' => 'vpt_option',
				'page_slug' => 'w2rr_settings',
				'template' => array(
					'title' => esc_html__('Ratings & Reviews Settings', 'W2RR'),
					'logo' => W2RR_RESOURCES_URL . 'images/settings.png',
					'menus' => array(
						'general' => array(
							'name' => 'general',
							'title' => esc_html__('General settings', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-home',
							'controls' => array(
								'pages' => array(
									'type' => 'section',
									'title' => esc_html__('Pages', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_page_add_review'), // adapted for WPML
											'label' => esc_html__('Submission page*', 'W2RR'),
											'description' => esc_html__('This page will be used for review submission.', 'W2RR') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_page_add_review') ? array(w2rr_get_wpml_dependent_option('w2rr_page_add_review')) : array(0)), // adapted for WPML
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_page_single_review'), // adapted for WPML
											'label' => esc_html__('Single review page', 'W2RR'),
											'description' => esc_html__('Clicking a review will open this page. Or single review will be displayed along with other content.', 'W2RR') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_page_single_review') ? array(w2rr_get_wpml_dependent_option('w2rr_page_single_review')) : array(0)), // adapted for WPML
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_page_dashboard'), // adapted for WPML
											'label' => esc_html__('Dashboard page', 'W2RR'),
											'description' => esc_html__('A page for frontend users dashboard.', 'W2RR') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_page_dashboard') ? array(w2rr_get_wpml_dependent_option('w2rr_page_dashboard')) : array(0)), // adapted for WPML
										),
									)
								),
								'post_types' => array(
									'type' => 'section',
									'title' => esc_html__('Working post types', 'W2RR'),
									'fields' => array(
									 	array(
											'type' => 'checkbox',
											'name' => 'w2rr_working_post_types',
											'label' => esc_html__('Select post types', 'W2RR'),
											'default' => get_option('w2rr_working_post_types'),
									 		'items' => $w2rr_post_types,
									 		'description' => esc_html__('Select post types you wish to work. Ratings and reviews will be displayed instead of comments.', 'W2RR'),
										),
									),
								),
								'display_mode' => array(
									'type' => 'section',
									'title' => esc_html__('How to display reviews', 'W2RR'),
									'fields' => array(
									 	array(
											'type' => 'radiobutton',
											'name' => 'w2rr_display_mode',
											'label' => esc_html__('How to display reviews', 'W2RR'),
											'default' => get_option('w2rr_display_mode'),
									 		'items' => array(
													array(
														'value' => 'comments',
														'label' => esc_html__('display reviews content in comments section', 'W2RR'),	
													),
													array(
														'value' => 'shortcodes',
														'label' => esc_html__('use shortcodes', 'W2RR'),	
													),
											),
									 		'description' => esc_html__('2 ways to display reviews and ratings: in comments section or by using shortcodes on a page', 'W2RR'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_single_review_is_on_page',
											'label' => esc_html__('Open review on new page, otherwise open in popup.', 'W2RR'),
											'default' => get_option('w2rr_single_review_is_on_page'),
										),
									),
								),
								'submission' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews submission', 'W2RR'),
									'fields' => array(
									 	array(
											'type' => 'radiobutton',
											'name' => 'w2rr_reviews_allowed_users',
											'label' => esc_html__('Who can place reviews', 'W2RR'),
											'default' => get_option('w2rr_reviews_allowed_users'),
											'items' => array(
													array(
														'value' => 'admins',
														'label' => esc_html__('only admins', 'W2RR'),	
													),
													array(
														'value' => 'login',
														'label' => esc_html__('logged in users (registration required)', 'W2RR'),	
													),
													array(
														'value' => 'required_contact_form',
														'label' => esc_html__('users and guests (required to fill in contact form)', 'W2RR'),	
													),
													array(
														'value' => 'guests',
														'label' => esc_html__('users and guests (ask to fill in contact form)', 'W2RR'),	
													),
													array(
														'value' => 'no_contact_form',
														'label' => esc_html__('do not ask guests to fill in contact form', 'W2RR'),	
													),
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_moderation',
											'label' => esc_html__('Enable pre-moderation of reviews', 'W2RR'),
											'default' => get_option('w2rr_reviews_moderation'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_edit_reviews_moderation',
											'label' => esc_html__('Enable moderation after a review was modified', 'W2RR'),
											'default' => get_option('w2rr_edit_reviews_moderation'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_allow_edit_profile',
											'label' => esc_html__('Allow users to manage own profile at the frontend dashboard', 'W2RR'),
											'default' => get_option('w2rr_allow_edit_profile'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_admin_bar',
											'label' => __('Hide top admin bar at the frontend for regular users', 'W2RR'),
											'default' => get_option('w2rr_hide_admin_bar'),
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_tospage'), // adapted for WPML
											'label' => esc_html__('Require Terms of Services on submission page?', 'W2RR'),
											'description' => esc_html__('If yes, create a WordPress page containing your TOS agreement and assign it using the dropdown above.', 'W2RR') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_tospage') ? array(w2rr_get_wpml_dependent_option('w2rr_tospage')) : array(0)), // adapted for WPML
										),
										array(
											'type' => 'select',
											'name' => w2rr_get_wpml_dependent_option_name('w2rr_submit_login_page'), // adapted for WPML
											'label' => esc_html__('Use custom login page for reviews submission process', 'W2RR'),
											'description' => esc_html__('You may use any 3rd party plugin to make custom login page and assign it with submission process using the dropdown above.', 'W2RR') . w2rr_get_wpml_dependent_option_description(),
											'items' => $all_pages,
											'default' => (w2rr_get_wpml_dependent_option('w2rr_submit_login_page') ? array(w2rr_get_wpml_dependent_option('w2rr_submit_login_page')) : array(0)), // adapted for WPML
										),
									),
								),
							),
						),
						'ratings' => array(
							'name' => 'ratings',
							'title' => esc_html__('Ratings & Reviews', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-star',
							'controls' => array(
								'reviews' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews settings', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2rr_reviews_number_allowed',
											'label' => esc_html__('Number of reviews a user can add for one post', 'W2RR'),
											'description' => esc_html__('Enter 0 to set unlimit', 'W2RR'),
											'default' => get_option('w2rr_reviews_number_allowed'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_reviews_images_number',
											'label' => esc_html__('Number of images allowed to upload in review', 'W2RR'),
											'description' => esc_html__('Enter 0 to disable images', 'W2RR'),
											'default' => get_option('w2rr_reviews_images_number'),
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_reviews_multi_rating',
											'label' => esc_html__('Ratings multi-criteria', 'W2RR'),
											'description' => esc_html__('Enter each criteria on a separate line', 'W2RR'),
											'default' => get_option('w2rr_reviews_multi_rating'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_stats',
											'label' => esc_html__('Enable statistics functionality', 'W2RR'),
											'default' => get_option('w2rr_enable_stats'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_views_counter',
											'label' => esc_html__('Hide views counter', 'W2RR'),
											'default' => get_option('w2rr_hide_views_counter'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_creation_date',
											'label' => esc_html__('Hide creation date', 'W2RR'),
											'default' => get_option('w2rr_hide_creation_date'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_author_link',
											'label' => esc_html__('Hide author information', 'W2RR'),
											'description' => esc_html__('Author name and possible link to author website will be hidden on reivews.', 'W2RR'),
											'default' => get_option('w2rr_hide_author_link'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_reviews_number_per_page',
											'label' => esc_html__('Number of reviews per page', 'W2RR'),
											'default' => get_option('w2rr_reviews_number_per_page'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_paginator_button',
											'label' => esc_html__('Paginator mode', 'W2RR'),
											'default' => array(get_option('w2rr_paginator_button')),
											'items' => array(
													array(
														'value' => 'paginator',
														'label' => esc_html__('Display default paginator', 'W2RR'),	
													),
													array(
														'value' => 'more_reviews',
														'label' => esc_html__('"Show More Reviews" button', 'W2RR'),	
													),
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_votes',
											'label' => esc_html__('Enable votes in reviews', 'W2RR'),
											'description' => esc_html__('Up and down votes', 'W2RR'),
											'default' => get_option('w2rr_reviews_votes'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_comments',
											'label' => esc_html__('Enable comments in reviews', 'W2RR'),
											'default' => get_option('w2rr_reviews_comments'),
										),
									),
								),
								'sorting' => array(
									'type' => 'section',
									'title' => esc_html__('Sorting settings', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_show_orderby_links',
											'label' => esc_html__('Show sorting options', 'W2RR'),
											'default' => get_option('w2rr_show_orderby_links'),
										),
										array(
											'type' => 'select',
											'name' => 'w2rr_default_orderby',
											'label' => esc_html__('Default order by', 'W2RR'),
											'items' => $ordering_items,
											'default' => get_option('w2rr_default_orderby'),
										),
										array(
											'type' => 'select',
											'name' => 'w2rr_default_order',
											'label' => esc_html__('Default order direction', 'W2RR'),
											'items' => array(
												array(
													'value' => 'ASC',
													'label' => esc_html__('Ascending', 'W2RR'),
												),
												array(
													'value' => 'DESC',
													'label' => esc_html__('Descending', 'W2RR'),
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
							'title' => esc_html__('Layout', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-list-alt',
							'controls' => array(
								'breadcrumbs' => array(
									'type' => 'section',
									'title' => esc_html__('Breadcrumbs settings', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_breadcrumbs',
											'label' => esc_html__('Enable breadcrumbs', 'W2RR'),
											'default' => get_option('w2rr_enable_breadcrumbs'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_hide_home_link_breadcrumb',
											'label' => esc_html__('Hide home link in breadcrumbs', 'W2RR'),
											'default' => get_option('w2rr_hide_home_link_breadcrumb'),
										),
									),
								),
								'reviews_view' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews view', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_views_switcher_default',
											'label' => __('Reviews view', 'W2RR'),
											'default' => array(get_option('w2rr_views_switcher_default')),
											'items' => array(
													array(
														'value' => 'list',
														'label' => __('List view', 'W2RR'),
													),
													array(
														'value' => 'grid',
														'label' => __('Grid view', 'W2RR'),
													),
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_reviews_view_grid_columns',
											'label' => __('Number of columns for reviews Grid View', 'W2RR'),
											'min' => 1,
											'max' => 4,
											'default' => get_option('w2rr_reviews_view_grid_columns'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_mobile_reviews_grid_columns',
											'label' => __('Number of columns for mobile devices', 'W2RR'),
											'min' => 1,
											'max' => 2,
											'default' => get_option('w2rr_mobile_reviews_grid_columns'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_reviews_view_grid_masonry',
											'label' => esc_html__('Enable masonry in Grid View', 'W2RR'),
											'default' => get_option('w2rr_reviews_view_grid_masonry'),
										),
									),
								),
								'logos' => array(
									'type' => 'section',
									'title' => esc_html__('Review images (on a Review page)', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_lightbox_gallery',
											'label' => esc_html__('Enable lightbox on images gallery', 'W2RR'),
											'default' => get_option('w2rr_enable_lightbox_gallery'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_auto_slides_gallery',
											'label' => esc_html__('Enable automatic rotating slideshow on images gallery', 'W2RR'),
											'default' => get_option('w2rr_auto_slides_gallery'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_auto_slides_gallery_delay',
											'label' => esc_html__('The delay in rotation (in ms)', 'W2RR'),
											'default' => get_option('w2rr_auto_slides_gallery_delay'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_100_single_logo_width',
											'label' => esc_html__('Enable 100% width of images gallery', 'W2RR'),
											'default' => get_option('w2rr_100_logo_width'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_single_logo_width',
											'label' => esc_html__('Images gallery width (in pixels)', 'W2RR'),
											'description' => esc_html__('This option needed only when 100% width of images gallery is switched off'),
											'min' => 100,
											'max' => 800,
											'default' => get_option('w2rr_single_logo_width'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_single_logo_height',
											'label' => __('Images gallery height (in pixels)', 'W2RR'),
											'description' => __('Set to 0 to fit full height'),
											'min' => 0,
											'max' => 800,
											'default' => get_option('w2rr_single_logo_height'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_big_slide_bg_mode',
											'label' => esc_html__('Do crop images gallery', 'W2RR'),
											'default' => array(get_option('w2rr_big_slide_bg_mode')),
											'items' => array(
													array(
														'value' => 'cover',
														'label' => esc_html__('Cut off image to fit width and height of main slide', 'W2RR'),	
													),
													array(
														'value' => 'contain',
														'label' => esc_html__('Full image inside main slide', 'W2RR'),	
													),
											),
											'description' => __('Works when gallery height is limited (not set to 0)', 'W2RR'),
										),
									),
								),
								'excerpts' => array(
									'type' => 'section',
									'title' => esc_html__('Description & Excerpt settings', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_description',
											'label' => esc_html__('Enable description field', 'W2RR'),
											'default' => get_option('w2rr_enable_description'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_summary',
											'label' => esc_html__('Enable summary (excerpt) field', 'W2RR'),
											'default' => get_option('w2rr_enable_summary'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_pros_cons',
											'label' => esc_html__('Enable Pros & Cons', 'W2RR'),
											'default' => get_option('w2rr_enable_pros_cons'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2rr_excerpt_length',
											'label' => esc_html__('Excerpt max length', 'W2RR'),
											'description' => esc_html__('Insert the number of words you want to show in the reviews excerpts', 'W2RR'),
											'default' => get_option('w2rr_excerpt_length'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_cropped_content_as_excerpt',
											'label' => esc_html__('Use cropped content as excerpt', 'W2RR'),
											'description' => esc_html__('When excerpt field is empty - use cropped main content', 'W2RR'),
											'default' => get_option('w2rr_cropped_content_as_excerpt'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_strip_excerpt',
											'label' => esc_html__('Strip HTML from excerpt', 'W2RR'),
											'description' => esc_html__('Check the box if you want to strip HTML from the excerpt content only', 'W2RR'),
											'default' => get_option('w2rr_strip_excerpt'),
										),
									),
								),
							),
						),
						
						'notifications' => array(
							'name' => 'notifications',
							'title' => esc_html__('Email notifications', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-envelope',
							'controls' => array(
								'notifications' => array(
									'type' => 'section',
									'title' => esc_html__('Email notifications', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2rr_admin_notifications_email',
											'label' => esc_html__('This email will be used for notifications to admin and in "From" field. Required to send emails.', 'W2RR'),
											'default' => get_option('w2rr_admin_notifications_email'),
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_newreview_admin_notification',
											'label' => esc_html__('Notification to admin about new review creation', 'W2RR'),
											'default' => get_option('w2rr_newreview_admin_notification'),
											'description' => esc_html__('Tags allowed: ', 'W2RR') . '[user], [review], [link]',
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_editreview_admin_notification',
											'label' => esc_html__('Notification to admin about review modification and pending status', 'W2RR'),
											'default' => get_option('w2rr_editreview_admin_notification'),
											'description' => esc_html__('Tags allowed: ', 'W2RR') . '[user], [review], [link]',
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_approval_review_notification',
											'label' => esc_html__('Notification to author about successful review approval', 'W2RR'),
											'default' => get_option('w2rr_approval_review_notification'),
											'description' => esc_html__('Tags allowed: ', 'W2RR') . '[author], [review], [link]',
										),
										array(
											'type' => 'textarea',
											'name' => 'w2rr_newuser_notification',
											'label' => esc_html__('Notification to new user with generated password', 'W2RR'),
											'default' => get_option('w2rr_newuser_notification'),
											'description' => esc_html__('Tags allowed: ', 'W2RR') . '[author], [review], [login], [password]',
										),
									),
								),
							),
						),
						'advanced' => array(
							'name' => 'advanced',
							'title' => esc_html__('Advanced settings', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-gear',
							'controls' => array(
								'js_css' => array(
									'type' => 'section',
									'title' => esc_html__('JavaScript & CSS', 'W2RR'),
									'fields' => array(
										/* array(
											'type' => 'toggle',
											'name' => 'w2rr_force_include_js_css',
											'label' => esc_html__("Include plugin's JS and CSS files on all pages", 'W2RR'),
											'default' => get_option('w2rr_force_include_js_css'),
										), */
										array(
											'type' => 'toggle',
											'name' => 'w2rr_images_lightbox',
											'label' => esc_html__('Include lightbox slideshow library', 'W2RR'),
											'description' =>  esc_html__('Some themes and 3rd party plugins include own lightbox library - this may cause conflicts.', 'W2RR'),
											'default' => get_option('w2rr_images_lightbox'),
										),
									),
								),
								'miscellaneous' => array(
									'type' => 'section',
									'title' => esc_html__('Miscellaneous', 'W2RR'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2rr_prevent_users_see_other_media',
											'label' => esc_html__('Prevent users to see media items of another users', 'W2RR'),
											'default' => get_option('w2rr_prevent_users_see_other_media'),
										),
									),
								),
								'recaptcha' => array(
									'type' => 'section',
									'title' => esc_html__('reCaptcha settings', 'W2RR'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2rr_enable_recaptcha',
											'label' => esc_html__('Enable reCaptcha', 'W2RR'),
											'default' => get_option('w2rr_enable_recaptcha'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_recaptcha_version',
											'label' => __('reCaptcha version', 'W2RR'),
											'default' => get_option('w2rr_recaptcha_version'),
									 		'items' => array(
												array('value' => 'v2', 'label' => __('reCaptcha v2', 'W2RR')),
												array('value' => 'v3', 'label' => __('reCaptcha v3', 'W2RR')),
											),
										),
									 	array(
											'type' => 'textbox',
											'name' => 'w2rr_recaptcha_public_key',
											'label' => esc_html__('reCaptcha site key', 'W2RR'),
											'description' => sprintf(esc_html__('get your reCAPTCHA API Keys %s', 'W2RR'), '<a href="http://www.google.com/recaptcha" target="_blank">here</a>'),
											'default' => get_option('w2rr_recaptcha_public_key'),
										),
									 	array(
											'type' => 'textbox',
											'name' => 'w2rr_recaptcha_private_key',
											'label' => esc_html__('reCaptcha secret key', 'W2RR'),
											'default' => get_option('w2rr_recaptcha_private_key'),
										),
									),
								),
							),
						),
						'customization' => array(
							'name' => 'customization',
							'title' => esc_html__('Customization', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-check',
							'controls' => array(
								'color_schemas' => array(
									'type' => 'section',
									'title' => esc_html__('Color palettes', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2rr_compare_palettes',
											'label' => esc_html__('Compare palettes at the frontend', 'W2RR'),
									 		'description' =>  esc_html__('Do not forget to switch off this setting when comparison will be completed.', 'W2RR'),
											'default' => get_option('w2rr_compare_palettes'),
										),
										array(
											'type' => 'select',
											'name' => 'w2rr_color_scheme',
											'label' => esc_html__('Color palette', 'W2RR'),
											'items' => array(
												array('value' => 'default', 'label' => esc_html__('Default', 'W2RR')),
												array('value' => 'orange', 'label' => esc_html__('Orange', 'W2RR')),
												array('value' => 'red', 'label' => esc_html__('Red', 'W2RR')),
												array('value' => 'yellow', 'label' => esc_html__('Yellow', 'W2RR')),
												array('value' => 'green', 'label' => esc_html__('Green', 'W2RR')),
												array('value' => 'gray', 'label' => esc_html__('Gray', 'W2RR')),
												array('value' => 'blue', 'label' => esc_html__('Blue', 'W2RR')),
											),
											'default' => array(get_option('w2rr_color_scheme')),
										),
										array(
											'type' => 'notebox',
											'description' => esc_attr__("Don't forget to clear cache of your browser and on server (when used) after customization changes were made.", 'W2RR'),
											'status' => 'warning',
										),
									),
								),
								'main_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Main colors', 'W2RR'),
									'fields' => array(
										array(
												'type' => 'color',
												'name' => 'w2rr_primary_color',
												'label' => esc_html__('Primary color', 'W2RR'),
												'description' =>  esc_html__('The color of ratings elements, loaders, pagination', 'W2RR'),
												'default' => get_option('w2rr_primary_color'),
												'binding' => array(
														'field' => 'w2rr_color_scheme',
														'function' => 'w2rr_affect_setting_w2rr_primary_color'
												),
										),
										array(
												'type' => 'color',
												'name' => 'w2rr_stars_color',
												'label' => esc_html__('Stars color', 'W2RR'),
												'default' => get_option('w2rr_stars_color'),
												'binding' => array(
														'field' => 'w2rr_color_scheme',
														'function' => 'w2rr_affect_setting_w2rr_stars_color'
												),
										),
										array(
												'type' => 'slider',
												'name' => 'w2rr_stars_size',
												'label' => esc_html__('Stars size', 'W2RR'),
												'default' => get_option('w2rr_stars_size'),
												'min' => 10,
												'max' => 120,
										),
									),
								),
								'links_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Links & buttons', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'color',
											'name' => 'w2rr_links_color',
											'label' => esc_html__('Links color', 'W2RR'),
											'default' => get_option('w2rr_links_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_links_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_links_hover_color',
											'label' => esc_html__('Links hover color', 'W2RR'),
											'default' => get_option('w2rr_links_hover_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_links_hover_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_button_1_color',
											'label' => esc_html__('Button primary color', 'W2RR'),
											'default' => get_option('w2rr_button_1_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_button_1_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_button_2_color',
											'label' => esc_html__('Button secondary color', 'W2RR'),
											'default' => get_option('w2rr_button_2_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_button_2_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2rr_button_text_color',
											'label' => esc_html__('Button text color', 'W2RR'),
											'default' => get_option('w2rr_button_text_color'),
											'binding' => array(
												'field' => 'w2rr_color_scheme',
												'function' => 'w2rr_affect_setting_w2rr_button_text_color'
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_button_gradient',
											'label' => esc_html__('Use gradient on buttons', 'W2RR'),
											'description' => esc_html__('This will remove all icons from buttons'),
											'default' => get_option('w2rr_button_gradient'),
										),
									),
								),
							),
						),
						'social_sharing' => array(
							'name' => 'social_sharing',
							'title' => esc_html__('Social Sharing', 'W2RR'),
							'icon' => 'font-awesome:w2rr-fa-facebook ',
							'controls' => array(
								'social_sharing' => array(
									'type' => 'section',
									'title' => esc_html__('Reviews Social Sharing Buttons', 'W2RR'),
									'fields' => array(
										array(
											'type' => 'radioimage',
											'name' => 'w2rr_share_buttons_style',
											'label' => esc_html__('Buttons style', 'W2RR'),
									 		'items' => array(
									 			array(
									 				'value' => 'arbenta',
									 				'label' =>esc_html__('Arbenta', 'W2RR'),
									 				'img' => W2RR_RESOURCES_URL . 'images/social/arbenta/facebook.png'
									 			),
									 			array(
									 				'value' => 'flat',
													'label' =>esc_html__('Flat', 'W2RR'),
									 				'img' => W2RR_RESOURCES_URL . 'images/social/flat/facebook.png'
									 			),
									 			array(
									 				'value' => 'somacro',
													'label' =>esc_html__('Somacro', 'W2RR'),
									 				'img' => W2RR_RESOURCES_URL . 'images/social/somacro/facebook.png'
									 			),
									 		),
											'default' => array(get_option('w2rr_share_buttons_style')),
										),
										array(
											'type' => 'sorter',
											'name' => 'w2rr_share_buttons',
											'label' => esc_html__('Include and order buttons', 'W2RR'),
									 		'items' => $w2rr_social_services,
											'default' => get_option('w2rr_share_buttons'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2rr_share_counter',
											'label' => esc_html__('Enable counter', 'W2RR'),
											'default' => get_option('w2rr_share_counter'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2rr_share_buttons_place',
											'label' => esc_html__('Buttons place', 'W2RR'),
											'items' => array(
												array(
													'value' => 'title',
													'label' =>esc_html__('After title', 'W2RR'),
												),
												array(
													'value' => 'before_content',
													'label' =>esc_html__('Before text content', 'W2RR'),
												),
												array(
													'value' => 'after_content',
													'label' =>esc_html__('After text content', 'W2RR'),
												),
											),
											'default' => array(
													get_option('w2rr_share_buttons_place')
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2rr_share_buttons_width',
											'label' => esc_html__('Social buttons width (in pixels)', 'W2RR'),
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
				//'menu_page' => 'w2rr_settings',
				'use_auto_group_naming' => true,
				'use_util_menu' => false,
				'minimum_role' => $capability,
				'layout' => 'fixed',
				'page_title' => esc_html__('Ratings & Reviews settings', 'W2RR'),
				'menu_label' => esc_html__('Ratings & Reviews settings', 'W2RR'),
		);
		
		// adapted for WPML /////////////////////////////////////////////////////////////////////////
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$theme_options['template']['menus']['advanced']['controls']['wpml'] = array(
				'type' => 'section',
				'title' => esc_html__('WPML Settings', 'W2RR'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'w2rr_map_language_from_wpml',
						'label' => esc_html__('Force WPML language on maps', 'W2RR'),
						'description' => esc_html__("Ignore the browser's language setting and force it to display information in a particular WPML language", 'W2RR'),
						'default' => get_option('w2rr_map_language_from_wpml'),
					),
				),
			);
		}
		
		$theme_options = apply_filters('w2rr_build_settings', $theme_options);

		$VP_W2RR_Option = new VP_W2RR_Option($theme_options);
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
	return ((function_exists('wpml_object_id_filter') && $sitepress) ? sprintf(esc_html__('%s This is multilingual option, each language may have own value.', 'W2RR'), '<br /><img src="'.W2RR_RESOURCES_URL . 'images/multilang.png" /><br />') : '');
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
				'post_title' => esc_html__('Add Review', 'W2RR'),
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