<?php

// @codingStandardsIgnoreFile

global $w2dc_wpml_dependent_options;
$w2dc_wpml_dependent_options[] = 'w2dc_listing_contact_form_7';
$w2dc_wpml_dependent_options[] = 'w2dc_directory_title';
$w2dc_wpml_dependent_options[] = 'w2dc_sticky_label';
$w2dc_wpml_dependent_options[] = 'w2dc_featured_label';

class w2dc_settings_manager {
	public function __construct() {
		add_action('init', array($this, 'plugin_settings'));
		
		if (!defined('W2DC_DEMO') || !W2DC_DEMO) {
			add_action('w2dc_vp_option_after_ajax_save', array($this, 'save_option'), 10, 3);
		}
		
		add_action('w2dc_settings_panel_bottom', array($this, 'our_plugins'));
	}
	
	public function our_plugins() {
		w2dc_renderTemplate('our_plugins.tpl.php');
	}
	
	public function plugin_settings() {
		global $w2dc_instance, $w2dc_social_services, $w2dc_google_maps_styles, $sitepress;
		
		if (defined('W2DC_DEMO') && W2DC_DEMO) {
			$capability = 'publish_posts';
		} else {
			$capability = 'edit_theme_options';
		}

		if ($w2dc_instance->index_page_id === 0 && isset($_GET['action']) && $_GET['action'] == 'directory_page_installation') {
			$page = array('post_status' => 'publish', 'post_title' => esc_html__('Web 2.0 Directory', 'w2dc'), 'post_type' => 'page', 'post_content' => '[webdirectory]', 'comment_status' => 'closed');
			if (wp_insert_post($page)) {
				w2dc_addMessage(esc_html__('"Web 2.0 Directory" page with [webdirectory] shortcode was successfully created, thank you!'));
			}
		}
		
		$w2dc_search_forms = array();
		foreach (wcsearch_get_search_forms_posts() AS $id=>$title) {
			$w2dc_search_forms[$id] = array('value' => $id, 'label' => $title);
		}

		$ordering_items = w2dc_orderingItems();
		
		$w2dc_social_services = array(
			'facebook' => array('value' => 'facebook', 'label' => esc_html__('Facebook', 'w2dc')),
			'twitter' => array('value' => 'twitter', 'label' => esc_html__('Twitter', 'w2dc')),
			'google' => array('value' => 'google', 'label' => esc_html__('Google+', 'w2dc')),
			'linkedin' => array('value' => 'linkedin', 'label' => esc_html__('LinkedIn', 'w2dc')),
			'digg' => array('value' => 'digg', 'label' => esc_html__('Digg', 'w2dc')),
			'reddit' => array('value' => 'reddit', 'label' => esc_html__('Reddit', 'w2dc')),
			'pinterest' => array('value' => 'pinterest', 'label' => esc_html__('Pinterest', 'w2dc')),
			'tumblr' => array('value' => 'tumblr', 'label' => esc_html__('Tumblr', 'w2dc')),
			'stumbleupon' => array('value' => 'stumbleupon', 'label' => esc_html__('StumbleUpon', 'w2dc')),
			'vk' => array('value' => 'vk', 'label' => esc_html__('VK', 'w2dc')),
			'whatsapp' => array('value' => 'whatsapp', 'label' => esc_html__('WhatsApp', 'w2dc')),
			'telegram' => array('value' => 'telegram', 'label' => esc_html__('Telegram', 'w2dc')),
			'viber' => array('value' => 'viber', 'label' => esc_html__('Viber', 'w2dc')),
			'email' => array('value' => 'email', 'label' => esc_html__('Email', 'w2dc')),
		);

		$listings_tabs = array(
				array('value' => 'addresses-tab', 'label' => esc_html__('Addresses tab', 'w2dc')),
				array('value' => 'comments-tab', 'label' => esc_html__('Comments tab', 'w2dc')),
				array('value' => 'videos-tab', 'label' => esc_html__('Videos tab', 'w2dc')),
				array('value' => 'contact-tab', 'label' => esc_html__('Contact tab', 'w2dc')),
				array('value' => 'report-tab', 'label' => esc_html__('Report tab', 'w2dc')));
		foreach ($w2dc_instance->content_fields->content_fields_groups_array AS $fields_group) {
			if ($fields_group->on_tab) {
				$listings_tabs[] = array('value' => 'field-group-tab-'.$fields_group->id, 'label' => $fields_group->name);
			}
		}
			
		$google_map_styles = array(array('value' => 'default', 'label' => 'Default style'));
		foreach ($w2dc_google_maps_styles AS $name=>$style) {
			$google_map_styles[] = array('value' => $name, 'label' => $name);
		}
		$mapbox_map_styles = array();
		foreach (w2dc_getMapBoxStyles() AS $name=>$style) {
			$mapbox_map_styles[] = array('value' => $style, 'label' => $name);
		}

		$country_codes = array(array('value' => 0, 'label' => 'Worldwide'));
		$w2dc_country_codes = w2dc_country_codes();
		foreach ($w2dc_country_codes AS $country=>$code) {
			$country_codes[] = array('value' => $code, 'label' => $country);
		}
		
		$map_zooms = array(
						array(
							'value' => '0',
							'label' =>esc_html__('Auto', 'w2dc'),
						),
						array('value' => 1, 'label' => 1),
						array('value' => 2, 'label' => 2),
						array('value' => 3, 'label' => 3),
						array('value' => 4, 'label' => 4),
						array('value' => 5, 'label' => 5),
						array('value' => 6, 'label' => 6),
						array('value' => 7, 'label' => 7),
						array('value' => 8, 'label' => 8),
						array('value' => 9, 'label' => 9),
						array('value' => 10, 'label' => 10),
						array('value' => 11, 'label' => 11),
						array('value' => 12, 'label' => 12),
						array('value' => 13, 'label' => 13),
						array('value' => 14, 'label' => 14),
						array('value' => 15, 'label' => 15),
						array('value' => 16, 'label' => 16),
						array('value' => 17, 'label' => 17),
						array('value' => 18, 'label' => 18),
						array('value' => 19, 'label' => 19),
		);
		
		$theme_options = array(
				'option_key' => 'vpt_option',
				'page_slug' => 'w2dc_settings',
				'template' => array(
					'title' => esc_html__('Web 2.0 Directory Settings', 'w2dc'),
					'logo' => W2DC_RESOURCES_URL . 'images/settings.png',
					'menus' => array(
						'general' => array(
							'name' => 'general',
							'title' => esc_html__('General settings', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-home',
							'controls' => array(
								'ajax_map_loading' => array(
									'type' => 'section',
									'title' => esc_html__('AJAX loading', 'w2dc'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_ajax_load',
											'label' => esc_html__('Use AJAX loading', 'w2dc'),
									 		'description' => esc_html__('Load maps and listings using AJAX when click sorting buttons and pagination buttons. Manage search settings', 'w2dc') . " " . "<a href='" . admin_url("edit.php?post_type=wcsearch_form") . "'>" . esc_html__("here", "w2dc") . "</a>",
											'default' => get_option('w2dc_ajax_load'),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_show_more_button',
											'label' => esc_html__('Display "Show More Listings" button instead of default paginator', 'w2dc'),
											'default' => get_option('w2dc_show_more_button'),
										),
									),
								),
								'title_slugs' => array(
									'type' => 'section',
									'title' => esc_html__('Titles, Labels & Permalinks', 'w2dc'),
									'fields' => array(
									 	array(
											'type' => 'textbox',
											'name' => w2dc_get_wpml_dependent_option_name('w2dc_directory_title'), // adapted for WPML
											'label' => esc_html__('Directory title', 'w2dc'),
									 		'description' => w2dc_get_wpml_dependent_option_description(),
											'default' => w2dc_get_wpml_dependent_option('w2dc_directory_title'),  // adapted for WPML
										),
									 	array(
											'type' => 'textbox',
											'name' => w2dc_get_wpml_dependent_option_name('w2dc_sticky_label'), // adapted for WPML
											'label' => esc_html__('Sticky listing label', 'w2dc'),
									 		'description' => w2dc_get_wpml_dependent_option_description(),
											'default' => w2dc_get_wpml_dependent_option('w2dc_sticky_label'),  // adapted for WPML
										),
									 	array(
											'type' => 'textbox',
											'name' => w2dc_get_wpml_dependent_option_name('w2dc_featured_label'), // adapted for WPML
											'label' => esc_html__('Featured listing label', 'w2dc'),
									 		'description' => w2dc_get_wpml_dependent_option_description(),
											'default' => w2dc_get_wpml_dependent_option('w2dc_featured_label'),  // adapted for WPML
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_permalinks_structure',
											'label' => esc_html__('Listings permalinks structure', 'w2dc'),
											'description' => wp_kses(__('<b>/%postname%/</b> works only when directory page is not front page.<br /><b>/%post_id%/%postname%/</b> will not work when /%post_id%/%postname%/ or /%year%/%postname%/ was enabled for native WP posts.', 'w2dc'), 'post'),
											'default' => array(get_option('w2dc_permalinks_structure')),
											'items' => array(
													array(
														'value' => 'postname',
														'label' => '/%postname%/',	
													),
													array(
														'value' => 'post_id',
														'label' => '/%post_id%/%postname%/',	
													),
													array(
														'value' => 'listing_slug',
														'label' => '/%listing_slug%/%postname%/',	
													),
													array(
														'value' => 'category_slug',
														'label' => '/%listing_slug%/%category%/%postname%/',	
													),
													array(
														'value' => 'location_slug',
														'label' => '/%listing_slug%/%location%/%postname%/',	
													),
													array(
														'value' => 'tag_slug',
														'label' => '/%listing_slug%/%tag%/%postname%/',	
													),
											),
										),
									),
								),
							),
						),
						'listings' => array(
							'name' => 'listings',
							'title' => esc_html__('Listings', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-list-alt',
							'controls' => array(
								'listings' => array(
									'type' => 'section',
									'title' => esc_html__('Listings settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_listings_on_index',
											'label' => esc_html__('Show listings on home page', 'w2dc'),
											'default' => get_option('w2dc_listings_on_index'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_listings_number_index',
											'label' => esc_html__('Number of listings on home page', 'w2dc'),
											'description' => esc_html__('Per page', 'w2dc'),
											'default' => get_option('w2dc_listings_number_index'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_listings_number_excerpt',
											'label' => esc_html__('Number of listings on excerpt pages (categories, locations, tags, search results)', 'w2dc'),
											'description' => esc_html__('Per page', 'w2dc'),
											'default' => get_option('w2dc_listings_number_excerpt'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_listing_contact_form',
											'label' => esc_html__('Enable contact form on listing page', 'w2dc'),
											'description' => esc_html__('Contact Form 7 or standard form will be displayed on each listing page', 'w2dc'),
											'default' => get_option('w2dc_listing_contact_form'),
										),
										array(
											'type' => 'textbox',
											'name' => w2dc_get_wpml_dependent_option_name('w2dc_listing_contact_form_7'),
											'label' => esc_html__('Contact Form 7 shortcode', 'w2dc'),
											'description' => esc_html__('This will work only when Contact Form 7 plugin enabled, otherwise standard contact form will be displayed.', 'w2dc') . w2dc_get_wpml_dependent_option_description(),
											'default' => w2dc_get_wpml_dependent_option('w2dc_listing_contact_form_7'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_anonymous_contact_form',
											'label' => esc_html__('Show contact form only for logged in users', 'w2dc'),
											'default' => get_option('w2dc_hide_anonymous_contact_form'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_custom_contact_email',
											'label' => esc_html__('Allow custom contact emails', 'w2dc'),
											'description' => esc_html__('When enabled users may set up custom contact emails, otherwise messages will be sent directly to authors emails', 'w2dc'),
											'default' => get_option('w2dc_custom_contact_email'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_report_form',
											'label' => esc_html__('Enable report form', 'w2dc'),
											'default' => get_option('w2dc_report_form'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_favourites_list',
											'label' => esc_html__('Enable bookmarks list', 'w2dc'),
											'default' => get_option('w2dc_favourites_list'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_print_button',
											'label' => esc_html__('Show print listing button', 'w2dc'),
											'default' => get_option('w2dc_print_button'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_pdf_button',
											'label' => esc_html__('Show listing in PDF button', 'w2dc'),
											'default' => get_option('w2dc_pdf_button'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_pdf_page_orientation',
											'label' => esc_html__('PDF page orientation', 'w2dc'),
											'default' => get_option('w2dc_pdf_page_orientation'),
											'items' => array(
													array(
														'value' => 'portrait',
														'label' => esc_html__('Portrait', 'w2dc'),	
													),
													array(
														'value' => 'landscape',
														'label' => esc_html__('Landscape', 'w2dc'),	
													),
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_change_expiration_date',
											'label' => esc_html__('Allow regular users to change listings expiration dates', 'w2dc'),
											'default' => get_option('w2dc_change_expiration_date'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_comments_number_on_index',
											'label' => esc_html__('Hide comments (reviews) number on index and excerpt pages', 'w2dc'),
											'default' => get_option('w2dc_hide_comments_number_on_index'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_listing_title',
											'label' => esc_html__('Hide listing title', 'w2dc'),
											'description' => esc_html__('Hides title on a single listing page.', 'w2dc'),
											'default' => get_option('w2dc_hide_listing_title'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_stats',
											'label' => esc_html__('Enable statistics functionality', 'w2dc'),
											'default' => get_option('w2dc_enable_stats'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_views_counter',
											'label' => esc_html__('Hide listings views counter', 'w2dc'),
											'default' => get_option('w2dc_hide_views_counter'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_listings_creation_date',
											'label' => esc_html__('Hide listings creation date', 'w2dc'),
											'default' => get_option('w2dc_hide_listings_creation_date'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_author_link',
											'label' => esc_html__('Hide author information', 'w2dc'),
											'description' => esc_html__('Author name and possible link to author website will be hidden on single listing pages.', 'w2dc'),
											'default' => get_option('w2dc_hide_author_link'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_listings_comments_mode',
											'label' => esc_html__('Listings comments (reviews) mode', 'w2dc'),
											'default' => array(get_option('w2dc_listings_comments_mode')),
											'items' => array(
													array(
														'value' => 'enabled',
														'label' => esc_html__('Always enabled', 'w2dc'),	
													),
													array(
														'value' => 'disabled',
														'label' => esc_html__('Always disabled', 'w2dc'),	
													),
													array(
														'value' => 'wp_settings',
														'label' => esc_html__('As configured in WP settings', 'w2dc'),	
													),
											),
										),
										array(
											'type' => 'sorter',
											'name' => 'w2dc_listings_tabs_order',
											'label' => esc_html__('Listing tabs order', 'w2dc'),
									 		'items' => $listings_tabs,
											'default' => get_option('w2dc_listings_tabs_order'),
										),
									),
								),
								'breadcrumbs' => array(
									'type' => 'section',
									'title' => esc_html__('Breadcrumbs settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_breadcrumbs',
											'label' => esc_html__('Enable breadcrumbs', 'w2dc'),
											'default' => get_option('w2dc_enable_breadcrumbs'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_home_link_breadcrumb',
											'label' => esc_html__('Hide home link in breadcrumbs', 'w2dc'),
											'default' => get_option('w2dc_hide_home_link_breadcrumb'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_breadcrumbs_mode',
											'label' => esc_html__('Breadcrumbs mode on single listing page', 'w2dc'),
											'default' => array(get_option('w2dc_breadcrumbs_mode')),
											'items' => array(
													array(
														'value' => 'title',
														'label' => esc_html__('%listing title%', 'w2dc'),	
													),
													array(
														'value' => 'category',
														'label' => esc_html__('%category% » %listing title%', 'w2dc'),	
													),
													array(
														'value' => 'location',
														'label' => esc_html__('%location% » %listing title%', 'w2dc'),	
													),
											),
										),
									),
								),
								'logos' => array(
									'type' => 'section',
									'title' => esc_html__('Listings logos & images', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_images_submit_required',
											'label' => esc_html__('Images required', 'w2dc'),
											'default' => get_option('w2dc_images_submit_required'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_lightbox_gallery',
											'label' => esc_html__('Enable lightbox on images gallery', 'w2dc'),
											'default' => get_option('w2dc_enable_lightbox_gallery'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_auto_slides_gallery',
											'label' => esc_html__('Enable automatic rotating slideshow on images gallery', 'w2dc'),
											'default' => get_option('w2dc_auto_slides_gallery'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_auto_slides_gallery_delay',
											'label' => esc_html__('The delay in rotation (in ms)', 'w2dc'),
											'default' => get_option('w2dc_auto_slides_gallery_delay'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_exclude_logo_from_listing',
											'label' => esc_html__('Exclude logo image from images gallery on single listing page', 'w2dc'),
											'default' => get_option('w2dc_exclude_logo_from_listing'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_nologo',
											'label' => esc_html__('Enable default logo image', 'w2dc'),
											'default' => get_option('w2dc_enable_nologo'),
										),
										array(
											'type' => 'upload',
											'name' => 'w2dc_nologo_url',
											'label' => esc_html__('Default logo image', 'w2dc'),
									 		'description' => esc_html__('This image will appear when listing owner did not upload own logo.', 'w2dc'),
											'default' => get_option('w2dc_nologo_url'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_100_single_logo_width',
											'label' => esc_html__('Enable 100% width of images gallery', 'w2dc'),
											'default' => get_option('w2dc_100_single_logo_width'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_single_logo_width',
											'label' => esc_html__('Images gallery width (in pixels)', 'w2dc'),
											'description' => esc_html__('This option needed only when 100% width of images gallery is switched off'),
											'min' => 100,
											'max' => 800,
											'default' => get_option('w2dc_single_logo_width'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_single_logo_height',
											'label' => esc_html__('Images gallery height (in pixels)', 'w2dc'),
											'description' => esc_html__('Set to 0 to fit full height'),
											'min' => 0,
											'max' => 800,
											'default' => get_option('w2dc_single_logo_height'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_big_slide_bg_mode',
											'label' => esc_html__('Do crop images gallery', 'w2dc'),
											'default' => array(get_option('w2dc_big_slide_bg_mode')),
											'items' => array(
													array(
														'value' => 'cover',
														'label' => esc_html__('Cut off image to fit width and height of main slide', 'w2dc'),	
													),
													array(
														'value' => 'contain',
														'label' => esc_html__('Full image inside main slide', 'w2dc'),	
													),
											),
											'description' => esc_html__('Works when gallery height is limited (not set to 0)', 'w2dc'),
										),
									),
								),
								'excerpts' => array(
									'type' => 'section',
									'title' => esc_html__('Description & Excerpt settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_description',
											'label' => esc_html__('Enable description field', 'w2dc'),
											'default' => get_option('w2dc_enable_description'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_html_description',
											'label' => esc_html__('Enable HTML and shortcodes in description field', 'w2dc'),
											'default' => get_option('w2dc_enable_html_description'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_summary',
											'label' => esc_html__('Enable summary field', 'w2dc'),
											'default' => get_option('w2dc_enable_summary'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_excerpt_length',
											'label' => esc_html__('Excerpt max length', 'w2dc'),
											'description' => esc_html__('Insert the number of words you want to show in the listings excerpts', 'w2dc'),
											'default' => get_option('w2dc_excerpt_length'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_cropped_content_as_excerpt',
											'label' => esc_html__('Use cropped content as excerpt', 'w2dc'),
											'description' => esc_html__('When excerpt field is empty - use cropped main content', 'w2dc'),
											'default' => get_option('w2dc_cropped_content_as_excerpt'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_strip_excerpt',
											'label' => esc_html__('Strip HTML from excerpt', 'w2dc'),
											'description' => esc_html__('Check the box if you want to strip HTML from the excerpt content only', 'w2dc'),
											'default' => get_option('w2dc_strip_excerpt'),
										),
									),
								),
							),
						),
						'pages_views' => array(
							'name' => 'pages_views',
							'title' => esc_html__('Pages & Views', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-external-link ',
							'controls' => array(
								'excerpt_views' => array(
									'type' => 'section',
									'title' => esc_html__('Excerpt views', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_show_listings_count',
											'label' => esc_html__('Show listings number', 'w2dc'),
											'default' => get_option('w2dc_show_listings_count'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_views_switcher',
											'label' => esc_html__('Enable views switcher', 'w2dc'),
											'default' => get_option('w2dc_views_switcher'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_views_switcher_default',
											'label' => esc_html__('Listings view by default', 'w2dc'),
											'description' => esc_html__('Selected view will be stored in cookies', 'w2dc'),
											'default' => array(get_option('w2dc_views_switcher_default')),
											'items' => array(
													array(
														'value' => 'list',
														'label' => esc_html__('List view', 'w2dc'),
													),
													array(
														'value' => 'grid',
														'label' => esc_html__('Grid view', 'w2dc'),
													),
											),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_listing_title_mode',
											'label' => esc_html__('Listing title mode', 'w2dc'),
											'description' => esc_html__('How to display listing title', 'w2dc'),
											'default' => array(get_option('w2dc_listing_title_mode')),
											'items' => array(
													array(
														'value' => 'inside',
														'label' => esc_html__('On listing logo', 'w2dc'),
													),
													array(
														'value' => 'outside',
														'label' => esc_html__('Outside listing logo', 'w2dc'),
													),
											),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_listing_logo_bg_mode',
											'label' => esc_html__('Logo image mode', 'w2dc'),
											'default' => array(get_option('w2dc_listing_logo_bg_mode')),
											'items' => array(
													array(
														'value' => 'cover',
														'label' => esc_html__('Cut off image to fit width and height listing logo', 'w2dc'),	
													),
													array(
														'value' => 'contain',
														'label' => esc_html__('Full image inside listing logo', 'w2dc'),	
													),
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_views_switcher_grid_columns',
											'label' => esc_html__('Number of columns for listings Grid View', 'w2dc'),
											'min' => 1,
											'max' => 4,
											'default' => get_option('w2dc_views_switcher_grid_columns'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_mobile_listings_grid_columns',
											'label' => esc_html__('Number of columns for mobile devices', 'w2dc'),
											'min' => 1,
											'max' => 2,
											'default' => get_option('w2dc_mobile_listings_grid_columns'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_grid_view_logo_ratio',
											'label' => esc_html__('Aspect ratio of logo in Grid View', 'w2dc'),
											'default' => array(get_option('w2dc_grid_view_logo_ratio')),
											'items' => array(
													array(
														'value' => '100',
														'label' => esc_html__('1:1 (square)', 'w2dc'),
													),
													array(
														'value' => '75',
														'label' => esc_html__('4:3', 'w2dc'),
													),
													array(
														'value' => '56.25',
														'label' => esc_html__('16:9', 'w2dc'),
													),
													array(
														'value' => '50',
														'label' => esc_html__('2:1', 'w2dc'),
													),
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_wrap_logo_list_view',
											'label' => esc_html__('Wrap logo image by text content in List View', 'w2dc'),
											'default' => get_option('w2dc_wrap_logo_list_view'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_listing_thumb_width',
											'label' => esc_html__('Listing thumbnail logo width (in pixels) in List View', 'w2dc'),
											'min' => '70',
											'max' => '640',
											'default' => '290',
										),
									),
								),
								'categories' => array(
									'type' => 'section',
									'title' => esc_html__('Categories settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_show_categories_index',
											'label' => esc_html__('Show categories list on index and excerpt pages', 'w2dc'),
											'default' => get_option('w2dc_show_categories_index'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_categories_nesting_level',
											'label' => esc_html__('Categories depth level', 'w2dc'),
											'min' => 1,
											'max' => 2,
											'default' => get_option('w2dc_categories_nesting_level'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_categories_columns',
											'label' => esc_html__('Categories columns number', 'w2dc'),
											'min' => 1,
											'max' => 4,
											'default' => get_option('w2dc_categories_columns'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_subcategories_items',
											'label' => esc_html__('Show subcategories items number', 'w2dc'),
											'description' => esc_html__('Leave 0 to show all subcategories', 'w2dc'),
											'default' => get_option('w2dc_subcategories_items'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_show_category_count',
											'label' => esc_html__('Show category listings count', 'w2dc'),
											'default' => get_option('w2dc_show_category_count'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_categories_order',
											'label' => esc_html__('Order by', 'w2dc'),
											'items' => array(
												array(
													'value' => 'default',
													'label' => esc_html__('Default (drag & drop in categories tree)', 'w2dc'),
												),
												array(
													'value' => 'name',
													'label' => esc_html__('Alphabetically', 'w2dc'),
												),
												array(
													'value' => 'count',
													'label' => esc_html__('Count', 'w2dc'),
												),
											),
											'default' => array(get_option('w2dc_categories_order')),
										),
									),
								),
								'locations' => array(
									'type' => 'section',
									'title' => esc_html__('Locations settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_show_locations_index',
											'label' => esc_html__('Show locations list on index and excerpt pages', 'w2dc'),
											'default' => get_option('w2dc_show_locations_index'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_locations_nesting_level',
											'label' => esc_html__('Locations depth level', 'w2dc'),
											'min' => 1,
											'max' => 2,
											'default' => get_option('w2dc_locations_nesting_level'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_locations_columns',
											'label' => esc_html__('Locations columns number', 'w2dc'),
											'min' => 1,
											'max' => 4,
											'default' => get_option('w2dc_locations_columns'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_sublocations_items',
											'label' => esc_html__('Show sublocations items number', 'w2dc'),
											'description' => esc_html__('Leave 0 to show all sublocations', 'w2dc'),
											'default' => get_option('w2dc_sublocations_items'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_show_location_count',
											'label' => esc_html__('Show location listings count', 'w2dc'),
											'default' => get_option('w2dc_show_locations_count'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_locations_order',
											'label' => esc_html__('Order by', 'w2dc'),
											'items' => array(
												array(
													'value' => 'default',
													'label' => esc_html__('Default (drag & drop in locations tree)', 'w2dc'),
												),
												array(
													'value' => 'name',
													'label' => esc_html__('Alphabetically', 'w2dc'),
												),
												array(
													'value' => 'count',
													'label' => esc_html__('Count', 'w2dc'),
												),
											),
											'default' => array(get_option('w2dc_locations_order')),
										),
									),
								),
								'sorting' => array(
									'type' => 'section',
									'title' => esc_html__('Sorting settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_show_orderby_links',
											'label' => esc_html__('Show "order by" options', 'w2dc'),
											'default' => get_option('w2dc_show_orderby_links'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_orderby_date',
											'label' => esc_html__('Allow sorting by date', 'w2dc'),
											'default' => get_option('w2dc_orderby_date'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_orderby_title',
											'label' => esc_html__('Allow sorting by title', 'w2dc'),
											'default' => get_option('w2dc_orderby_title'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_orderby_distance',
											'label' => esc_html__('Allow sorting by distance when search by radius', 'w2dc'),
											'default' => get_option('w2dc_orderby_distance'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_default_orderby',
											'label' => esc_html__('Default order by', 'w2dc'),
											'items' => $ordering_items,
											'default' => get_option('w2dc_default_orderby'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_default_order',
											'label' => esc_html__('Default order direction', 'w2dc'),
											'items' => array(
												array(
													'value' => 'ASC',
													'label' => esc_html__('Ascending', 'w2dc'),
												),
												array(
													'value' => 'DESC',
													'label' => esc_html__('Descending', 'w2dc'),
												),
											),
											'default' => get_option('w2dc_default_order'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_orderby_exclude_null',
											'label' => esc_html__('Exclude listings with empty values from sorted results', 'w2dc'),
											'default' => get_option('w2dc_orderby_exclude_null'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_orderby_sticky_featured',
											'label' => esc_html__('Sticky and featured listings always will be on top', 'w2dc'),
											'description' => esc_html__('When switched off - sticky and featured listings will be on top only when listings were sorted by date.', 'w2dc'),
											'default' => get_option('w2dc_orderby_sticky_featured'),
										),
									),
								),
							),
						),
						'search' => array(
							'name' => 'search',
							'title' => esc_html__('Search settings', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-search',
							'controls' => array(
								'search' => array(
									'type' => 'section',
									'title' => esc_html__('Search settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'select',
											'name' => 'w2dc_search_form_id',
											'label' => esc_html__('Search form', 'w2dc'),
											'description' => esc_html__("Manage search forms and settings", "w2dc") . " " . "<a href='" . admin_url("edit.php?post_type=wcsearch_form") . "'>" . esc_html__("here", "w2dc") . "</a>",
											'items' => $w2dc_search_forms,
											'default' => get_option('w2dc_search_form_id'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_main_search',
											'label' => esc_html__('Display search form in main part of a page', 'w2dc'),
											'default' => get_option('w2dc_main_search'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_miles_kilometers_in_search',
											'label' => esc_html__('Dimension in radius search', 'w2dc'),
											'items' => array(
												array(
													'value' => 'miles',
													'label' => esc_html__('miles', 'w2dc'),
												),
												array(
													'value' => 'kilometers',
													'label' => esc_html__('kilometers', 'w2dc'),
												),
											),
											'default' => array(get_option('w2dc_miles_kilometers_in_search')),
										),
									),
								),
							),
						),
						'maps' => array(
							'name' => 'maps',
							'title' => esc_html__('Maps & Addresses', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-map-marker',
							'controls' => array(
								'map_type' => array(
									'type' => 'section',
									'title' => esc_html__('Map type', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_map_type',
											'label' => esc_html__('Select map engine', 'w2dc'),
											'items' => array(
												array(
													'value' => 'none',
													'label' =>esc_html__('No maps', 'w2dc'),
												),
												array(
													'value' => 'google',
													'label' =>esc_html__('Google Maps', 'w2dc'),
												),
												array(
													'value' => 'mapbox',
													'label' =>esc_html__('MapBox (OpenStreetMap)', 'w2dc'),
												),
											),
											'default' => array(
												get_option('w2dc_map_type')
											),
										),
									),
								),
								'google_setting' => array(
									'type' => 'section',
									'title' => esc_html__('Google Maps Settings', 'w2dc'),
									'name' => 'section_google_setting',
									'dependency' => array(
										'field'    => 'w2dc_map_type',
										'function' => 'w2dc_google_type_setting',
									),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2dc_google_api_key',
											'label' => esc_html__('Google browser API key*', 'w2dc'),
											'description' => sprintf(wp_kses(__('get your Google API key <a href="%s" target="_blank">here</a>, following APIs must be enabled in the console: Directions API, Geocoding API, Maps JavaScript API, Maps Static API and Places API.', 'w2dc'), 'post'), 'https://console.developers.google.com/flows/enableapi?apiid=maps-backend.googleapis.com,geocoding-backend.googleapis.com,directions-backend.googleapis.com,static-maps-backend.googleapis.com,places-backend.googleapis.com&keyType=CLIENT_SIDE&reusekey=true'),
											'default' => get_option('w2dc_google_api_key'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_google_api_key_server',
											'label' => esc_html__('Google server API key*', 'w2dc'),
											'description' => sprintf(wp_kses(__('get your Google API key <a href="%s" target="_blank">here</a>, following APIs must be enabled in the console: Geocoding API and Places API.', 'w2dc'), 'post'), 'https://console.developers.google.com/flows/enableapi?apiid=geocoding-backend.googleapis.com,places-backend.googleapis.com&keyType=CLIENT_SIDE&reusekey=true') . ' ' . sprintf(__('Then check geolocation <a href="%s">response</a>.', 'w2dc'), admin_url('admin.php?page=w2dc_debug')),
											'default' => get_option('w2dc_google_api_key_server'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_directions_functionality',
											'label' => esc_html__('Directions functionality', 'w2dc'),
											'items' => array(
												array(
													'value' => 'builtin',
													'label' =>esc_html__('Built-in routing', 'w2dc'),
												),
												array(
													'value' => 'google',
													'label' =>esc_html__('Link to Google Maps', 'w2dc'),
												),
											),
											'default' => array(
													get_option('w2dc_directions_functionality')
											),
											'description' => esc_html__("On a single listing page", "w2dc"),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_google_map_style',
											'label' => esc_html__('Google Maps style', 'w2dc'),
									 		'items' => $google_map_styles,
											'default' => array(get_option('w2dc_google_map_style')),
										),
									),
								),
								'mapbox_settings' => array(
									'type' => 'section',
									'title' => esc_html__('MapBox Settings', 'w2dc'),
									'name' => 'section_mapbox_setting',
									'dependency' => array(
										'field'    => 'w2dc_map_type',
										'function' => 'w2dc_mapbox_type_setting',
									),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2dc_mapbox_api_key',
											'label' => esc_html__('MapBox Access Token', 'w2dc'),
											'description' => sprintf(wp_kses(__('get your MapBox Access Token <a href="%s" target="_blank">here</a>', 'w2dc'), 'post'), 'https://www.mapbox.com/account/'),
											'default' => get_option('w2dc_mapbox_api_key'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_mapbox_map_style',
											'label' => esc_html__('MapBox Maps style', 'w2dc'),
									 		'items' => $mapbox_map_styles,
											'default' => array(get_option('w2dc_mapbox_map_style')),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_mapbox_map_style_custom',
											'label' => esc_html__('MapBox Custom Map Style', 'w2dc'),
											'description' => esc_html__('Will be used instead of native styles. Example mapbox://styles/shamalli/cjhrfxqxu3zki2rmkka3a3hkp'),
											'default' => get_option('w2dc_mapbox_map_style_custom'),
										),
									),
								),
								'maps' => array(
									'type' => 'section',
									'title' => esc_html__('General Maps settings', 'w2dc'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_map_on_index',
											'label' => esc_html__('Show map on home page', 'w2dc'),
											'default' => get_option('w2dc_map_on_index'),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_map_on_excerpt',
											'label' => esc_html__('Show map on excerpt pages', 'w2dc'),
									 		'description' => esc_html__('Search results, categories, locations and tags pages', 'w2dc'),
											'default' => get_option('w2dc_map_on_excerpt'),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_map_on_single',
											'label' => esc_html__('Show map on single listing', 'w2dc'),
											'default' => get_option('w2dc_map_on_single'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_map_markers_is_limit',
											'label' => esc_html__('How many map markers to display on the map', 'w2dc'),
											'items' => array(
												array(
													'value' => 1,
													'label' =>esc_html__('The only map markers of visible listings will be displayed', 'w2dc'),
												),
												array(
													'value' => 0,
													'label' =>esc_html__('Display all map markers (lots of markers on one page may slow down page loading)', 'w2dc'),
												),
											),
											'default' => array(
													get_option('w2dc_map_markers_is_limit')
											),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_show_directions',
											'label' => esc_html__('Show directions panel on a single listing page', 'w2dc'),
											'default' => get_option('w2dc_show_directions'),
										),
									 	array(
											'type' => 'slider',
											'name' => 'w2dc_default_map_zoom',
											'label' => esc_html__('Default map zoom level (for submission page)', 'w2dc'),
									 		'min' => 1,
									 		'max' => 19,
											'default' => get_option('w2dc_default_map_zoom'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_default_map_height',
											'label' => esc_html__('Default map height (in pixels)', 'w2dc'),
											'default' => get_option('w2dc_default_map_height'),
											'validation' => 'numeric',
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_radius_search_circle',
											'label' => esc_html__('Show circle during radius search', 'w2dc'),
											'default' => get_option('w2dc_enable_radius_search_circle'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_clusters',
											'label' => esc_html__('Enable clusters of map markers', 'w2dc'),
											'default' => get_option('w2dc_enable_clusters'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_map_markers_required',
											'label' => esc_html__('Make map markers mandatory during submission of listings', 'w2dc'),
											'default' => get_option('w2dc_map_markers_required'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_geolocation',
											'label' => esc_html__('Enable automatic user Geolocation', 'w2dc'),
											'default' => get_option('w2dc_enable_geolocation'),
											'description' => esc_html__("Requires https", "w2dc"),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_start_zoom',
											'label' => esc_html__('Default zoom level', 'w2dc'),
											'items' => $map_zooms,
											'default' => array(
												get_option('w2dc_start_zoom')
											),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_map_min_zoom',
											'label' => esc_html__('The farest zoom level', 'w2dc'),
											'items' => $map_zooms,
											'default' => array(
												get_option('w2dc_map_min_zoom')
											),
											'description' => esc_html__("How far we can zoom out: 1 - the farest (whole world)", "w2dc"),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_map_max_zoom',
											'label' => esc_html__('The closest zoom level', 'w2dc'),
											'items' => $map_zooms,
											'default' => array(
												get_option('w2dc_map_max_zoom')
											),
											'description' => esc_html__("How close we can zoom in: 19 - the closest", "w2dc"),
										),
									),
								),
								'maps_controls' => array(
									'type' => 'section',
									'title' => esc_html__('Maps controls settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_draw_panel',
											'label' => esc_html__('Enable Draw Panel', 'w2dc'),
											'description' => esc_html__('Very important: MySQL version must be 5.6.1 and higher or MySQL server variable "thread stack" must be 256K and higher. Ask your hoster about it if "Draw Area" does not work.', 'w2dc'),
											'default' => get_option('w2dc_enable_draw_panel'),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_search_on_map',
											'label' => esc_html__('Show search form and listings sidebar on the map', 'w2dc'),
											'default' => get_option('w2dc_search_on_map'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_search_map_form_id',
											'label' => esc_html__('Select search form', 'w2dc'),
											'items' => $w2dc_search_forms,
											'default' => get_option('w2dc_search_map_form_id'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_full_screen',
											'label' => esc_html__('Enable full screen button', 'w2dc'),
											'default' => get_option('w2dc_enable_full_screen'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_wheel_zoom',
											'label' => esc_html__('Enable zoom by mouse wheel', 'w2dc'),
											'description' => esc_html__('For desktops', 'w2dc'),
											'default' => get_option('w2dc_enable_wheel_zoom'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_dragging_touchscreens',
											'label' => esc_html__('Enable map dragging on touch screen devices', 'w2dc'),
											'default' => get_option('w2dc_enable_dragging_touchscreens'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_center_map_onclick',
											'label' => esc_html__('Center map on marker click', 'w2dc'),
											'default' => get_option('w2dc_center_map_onclick'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_hide_search_on_map_mobile',
											'label' => esc_html__('Hide compact search form on the map for mobile devices', 'w2dc'),
											'description' => esc_html__('This setting for all maps', 'w2dc'),
											'default' => get_option('w2dc_hide_search_on_map_mobile'),
										),
									),
								),
								'addresses' => array(
									'type' => 'section',
									'title' => esc_html__('Addresses settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2dc_default_geocoding_location',
											'label' => esc_html__('Default country/state for correct geocoding', 'w2dc'),
											'description' => esc_html__('This value needed when you build local directory, all your listings place in one local area - country or state. This hidden string will be automatically added to the address for correct geocoding when users create/edit listings and when they search by address.', 'w2dc'),
											'default' => get_option('w2dc_default_geocoding_location'),
										),
										array(
											'type' => 'sorter',
											'name' => 'w2dc_addresses_order',
											'label' => esc_html__('Address format', 'w2dc'),
									 		'items' => array(
									 			array('value' => 'location', 'label' => esc_html__('Selected location', 'w2dc')),
									 			array('value' => 'line_1', 'label' => esc_html__('Address Line 1', 'w2dc')),
									 			array('value' => 'line_2', 'label' => esc_html__('Address Line 2', 'w2dc')),
									 			array('value' => 'zip', 'label' => esc_html__('Zip code or postal index', 'w2dc')),
									 			array('value' => 'space1', 'label' => esc_html__('-- Space ( ) --', 'w2dc')),
									 			array('value' => 'space2', 'label' => esc_html__('-- Space ( ) --', 'w2dc')),
									 			array('value' => 'space3', 'label' => esc_html__('-- Space ( ) --', 'w2dc')),
									 			array('value' => 'comma1', 'label' => esc_html__('-- Comma (,) --', 'w2dc')),
									 			array('value' => 'comma2', 'label' => esc_html__('-- Comma (,) --', 'w2dc')),
									 			array('value' => 'comma3', 'label' => esc_html__('-- Comma (,) --', 'w2dc')),
									 			array('value' => 'break1', 'label' => esc_html__('-- Line Break --', 'w2dc')),
									 			array('value' => 'break2', 'label' => esc_html__('-- Line Break --', 'w2dc')),
									 			array('value' => 'break3', 'label' => esc_html__('-- Line Break --', 'w2dc')),
									 		),
											'description' => esc_html__('Order address elements as you wish, commas and spaces help to build address line.'),
											'default' => get_option('w2dc_addresses_order'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_address_autocomplete_code',
											'label' => esc_html__('Restriction of address fields for one specific country (autocomplete submission and search fields)', 'w2dc'),
									 		'items' => $country_codes,
											'default' => get_option('w2dc_address_autocomplete_code'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_address_line_1',
											'label' => esc_html__('Enable address line 1 field', 'w2dc'),
											'default' => get_option('w2dc_enable_address_line_1'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_address_line_2',
											'label' => esc_html__('Enable address line 2 field', 'w2dc'),
											'default' => get_option('w2dc_enable_address_line_2'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_postal_index',
											'label' => esc_html__('Enable zip code', 'w2dc'),
											'default' => get_option('w2dc_enable_postal_index'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_additional_info',
											'label' => esc_html__('Enable additional info field', 'w2dc'),
											'default' => get_option('w2dc_enable_additional_info'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_manual_coords',
											'label' => esc_html__('Enable manual coordinates fields', 'w2dc'),
											'default' => get_option('w2dc_enable_manual_coords'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_zip_or_postal_text',
											'label' => esc_html__('Use Zip or Postal code label', 'w2dc'),
											'items' => array(
												array(
													'value' => 'zip',
													'label' =>esc_html__('Zip code', 'w2dc'),
												),
												array(
													'value' => 'postal',
													'label' =>esc_html__('Postal code', 'w2dc'),
												),
											),
											'default' => get_option('w2dc_zip_or_postal_text'),
										),
									),
								),
								'markers' => array(
									'type' => 'section',
									'title' => esc_html__('Map markers & InfoWindow settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_map_markers_type',
											'label' => esc_html__('Type of Map Markers', 'w2dc'),
											'items' => array(
												array(
													'value' => 'icons',
													'label' =>esc_html__('Font Awesome icons (recommended)', 'w2dc'),
												),
												array(
													'value' => 'images',
													'label' =>esc_html__('PNG images', 'w2dc'),
												),
											),
											'default' => array(
													get_option('w2dc_map_markers_type')
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_default_marker_color',
											'label' => esc_html__('Default Map Marker color', 'w2dc'),
											'default' => get_option('w2dc_default_marker_color'),
											'description' => esc_html__('For Font Awesome icons.', 'w2dc'),
											'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_icons_setting',
											),
										),
										array(
											'type' => 'fontawesome',
											'name' => 'w2dc_default_marker_icon',
											'label' => esc_html__('Default Map Marker icon'),
											'description' => esc_html__('For Font Awesome icons.', 'w2dc'),
											'default' => array(
												get_option('w2dc_default_marker_icon')
											),
											'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_icons_setting',
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_map_marker_size',
											'label' => esc_html__('Map marker size (in pixels)', 'w2dc'),
											'description' => esc_html__('For Font Awesome icons.', 'w2dc'),
											'default' => get_option('w2dc_map_marker_size'),
									 		'min' => 30,
									 		'max' => 70,
											'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_icons_setting',
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_map_marker_width',
											'label' => esc_html__('Map marker width (in pixels)', 'w2dc'),
											'description' => esc_html__('For PNG images.', 'w2dc'),
											'default' => get_option('w2dc_map_marker_width'),
									 		'min' => 10,
									 		'max' => 64,
											'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_images_setting',
											),
										),
									 	array(
											'type' => 'slider',
											'name' => 'w2dc_map_marker_height',
											'label' => esc_html__('Map marker height (in pixels)', 'w2dc'),
									 		'description' => esc_html__('For PNG images.', 'w2dc'),
											'default' => get_option('w2dc_map_marker_height'),
									 		'min' => 10,
									 		'max' => 64,
									 		'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_images_setting',
											),
										),
									 	array(
											'type' => 'slider',
											'name' => 'w2dc_map_marker_anchor_x',
											'label' => esc_html__('Map marker anchor horizontal position (in pixels)', 'w2dc'),
									 		'description' => esc_html__('For PNG images.', 'w2dc'),
											'default' => get_option('w2dc_map_marker_anchor_x'),
									 		'min' => 0,
									 		'max' => 64,
									 		'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_images_setting',
											),
										),
									 	array(
											'type' => 'slider',
											'name' => 'w2dc_map_marker_anchor_y',
											'label' => esc_html__('Map marker anchor vertical position (in pixels)', 'w2dc'),
									 		'description' => esc_html__('For PNG images.', 'w2dc'),
											'default' => get_option('w2dc_map_marker_anchor_y'),
									 		'min' => 0,
									 		'max' => 64,
									 		'dependency' => array(
												'field'    => 'w2dc_map_markers_type',
												'function' => 'w2dc_map_markers_images_setting',
											),
										),
									 	array(
											'type' => 'slider',
											'name' => 'w2dc_map_infowindow_width',
											'label' => esc_html__('Map InfoWindow width (in pixels)', 'w2dc'),
											'default' => get_option('w2dc_map_infowindow_width'),
									 		'min' => 100,
									 		'max' => 600,
									 		'step' => 10,
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_map_infowindow_offset',
											'label' => esc_html__('Map InfoWindow vertical position above marker (in pixels)', 'w2dc'),
											'default' => get_option('w2dc_map_infowindow_offset'),
									 		'min' => 30,
									 		'max' => 120,
											'dependency' => array(
												'field'    => 'w2dc_map_type',
												'function' => 'w2dc_google_type_setting',
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_map_infowindow_logo_width',
											'label' => esc_html__('Map InfoWindow logo width (in pixels)', 'w2dc'),
											'default' => get_option('w2dc_map_infowindow_logo_width'),
									 		'min' => 40,
									 		'max' => 300,
											'step' => 10,
										),
									),
								),
							),
						),
						'notifications' => array(
							'name' => 'notifications',
							'title' => esc_html__('Email notifications', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-envelope',
							'controls' => array(
								'notifications' => array(
									'type' => 'section',
									'title' => esc_html__('Email notifications', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'textbox',
											'name' => 'w2dc_admin_notifications_email',
											'label' => esc_html__('This email will be used for notifications to admin and in "From" field. Required to send emails.', 'w2dc'),
											'default' => get_option('w2dc_admin_notifications_email'),
										),
										array(
											'type' => 'textbox',
											'name' => 'w2dc_send_expiration_notification_days',
											'label' => esc_html__('Days before pre-expiration notification will be sent', 'w2dc'),
											'default' => get_option('w2dc_send_expiration_notification_days'),
										),
									 	array(
											'type' => 'textarea',
											'name' => 'w2dc_preexpiration_notification',
											'label' => esc_html__('Pre-expiration notification text', 'w2dc'),
											'default' => get_option('w2dc_preexpiration_notification'),
									 		'description' => esc_html__('Tags allowed: ', 'w2dc') . '[listing], [days], [link]',
										),
									 	array(
											'type' => 'textarea',
											'name' => 'w2dc_expiration_notification',
											'label' => esc_html__('Expiration notification text', 'w2dc'),
											'default' => get_option('w2dc_expiration_notification'),
									 		'description' => esc_html__('Tags allowed: ', 'w2dc') . '[listing], [link]',
										),
									),
								),
							),
						),
						'advanced' => array(
							'name' => 'advanced',
							'title' => esc_html__('Advanced settings', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-gear',
							'controls' => array(
								'js_css' => array(
									'type' => 'section',
									'title' => esc_html__('JavaScript & CSS', 'w2dc'),
									'description' => esc_html__('Do not touch these settings if you do not know what they mean. It may cause lots of problems.', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_force_include_js_css',
											'label' => esc_html__('Include directory JS and CSS files on all pages', 'w2dc'),
											'default' => get_option('w2dc_force_include_js_css'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_images_lightbox',
											'label' => esc_html__('Include lightbox slideshow library', 'w2dc'),
											'description' =>  esc_html__('Some themes and 3rd party plugins include own lightbox library - this may cause conflicts.', 'w2dc'),
											'default' => get_option('w2dc_images_lightbox'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_notinclude_jqueryui_css',
											'label' => esc_html__('Do not include jQuery UI CSS', 'w2dc'),
									 		'description' =>  esc_html__('Some themes and 3rd party plugins include own jQuery UI CSS - this may cause conflicts in styles.', 'w2dc'),
											'default' => get_option('w2dc_notinclude_jqueryui_css'),
										),
									),
								),
								'miscellaneous' => array(
									'type' => 'section',
									'title' => esc_html__('Miscellaneous', 'w2dc'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_imitate_mode',
											'label' => esc_html__('Enable imitation mode', 'w2dc'),
											'default' => get_option('w2dc_imitate_mode'),
									 		'description' => esc_html__("Some themes require imitation mode to get working listings/categories/locations/tags pages.", "w2dc"),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_overwrite_page_title',
											'label' => esc_html__('Overwrite WordPress page title by directory page title', 'w2dc'),
									 		'description' =>  esc_html__('Some themes do not allow this or may cause issues.', 'w2dc'),
											'default' => get_option('w2dc_overwrite_page_title'),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_prevent_users_see_other_media',
											'label' => esc_html__('Prevent users to see media items of another users', 'w2dc'),
											'default' => get_option('w2dc_prevent_users_see_other_media'),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_address_autocomplete',
											'label' => esc_html__('Enable autocomplete on addresses fields', 'w2dc'),
											'default' => get_option('w2dc_address_autocomplete'),
									 		'description' => esc_html__("Requires enabled maps", "w2dc"),
										),
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_address_geocode',
											'label' => esc_html__('Enable "Get my location" button on addresses fields', 'w2dc'),
											'default' => get_option('w2dc_address_geocode'),
									 		'description' => esc_html__("Requires https", "w2dc"),
										),
									),
								),
								'recaptcha' => array(
									'type' => 'section',
									'title' => esc_html__('reCaptcha settings', 'w2dc'),
									'fields' => array(
									 	array(
											'type' => 'toggle',
											'name' => 'w2dc_enable_recaptcha',
											'label' => esc_html__('Enable reCaptcha', 'w2dc'),
											'default' => get_option('w2dc_enable_recaptcha'),
										),
									 	array(
											'type' => 'radiobutton',
											'name' => 'w2dc_recaptcha_version',
											'label' => esc_html__('reCaptcha version', 'w2dc'),
											'default' => get_option('w2dc_recaptcha_version'),
									 		'items' => array(
												array('value' => 'v2', 'label' => esc_html__('reCaptcha v2', 'w2dc')),
												array('value' => 'v3', 'label' => esc_html__('reCaptcha v3', 'w2dc')),
											),
										),
									 	array(
											'type' => 'textbox',
											'name' => 'w2dc_recaptcha_public_key',
											'label' => esc_html__('reCaptcha site key', 'w2dc'),
											'description' => sprintf(wp_kses(__('get your reCAPTCHA API Keys <a href="%s" target="_blank">here</a>', 'w2dc'), 'post'), 'http://www.google.com/recaptcha'),
											'default' => get_option('w2dc_recaptcha_public_key'),
										),
									 	array(
											'type' => 'textbox',
											'name' => 'w2dc_recaptcha_private_key',
											'label' => esc_html__('reCaptcha secret key', 'w2dc'),
											'default' => get_option('w2dc_recaptcha_private_key'),
										),
									),
								),
							),
						),
						'customization' => array(
							'name' => 'customization',
							'title' => esc_html__('Customization', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-check',
							'controls' => array(
								'color_schemas' => array(
									'type' => 'section',
									'title' => esc_html__('Color palettes', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'toggle',
											'name' => 'w2dc_compare_palettes',
											'label' => esc_html__('Compare palettes at the frontend', 'w2dc'),
									 		'description' =>  esc_html__('Do not forget to switch off this setting when comparison will be completed.', 'w2dc'),
											'default' => get_option('w2dc_compare_palettes'),
										),
										array(
											'type' => 'select',
											'name' => 'w2dc_color_scheme',
											'label' => esc_html__('Color palette', 'w2dc'),
											'items' => array(
												array('value' => 'default', 'label' => esc_html__('Default', 'w2dc')),
												array('value' => 'orange', 'label' => esc_html__('Orange', 'w2dc')),
												array('value' => 'red', 'label' => esc_html__('Red', 'w2dc')),
												array('value' => 'yellow', 'label' => esc_html__('Yellow', 'w2dc')),
												array('value' => 'green', 'label' => esc_html__('Green', 'w2dc')),
												array('value' => 'gray', 'label' => esc_html__('Gray', 'w2dc')),
												array('value' => 'blue', 'label' => esc_html__('Blue', 'w2dc')),
											),
											'default' => array(get_option('w2dc_color_scheme')),
										),
										array(
											'type' => 'notebox',
											'description' => esc_html__("Don't forget to clear cache of your browser and on server (when used) after customization changes were made.", 'w2dc'),
											'status' => 'warning',
										),
									),
								),
								'main_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Main colors', 'w2dc'),
									'fields' => array(
										array(
												'type' => 'color',
												'name' => 'w2dc_primary_color',
												'label' => esc_html__('Primary color', 'w2dc'),
												'description' =>  esc_html__('The color of categories, tags labels, map info window caption, pagination elements', 'w2dc'),
												'default' => get_option('w2dc_primary_color'),
												'binding' => array(
														'field' => 'w2dc_color_scheme',
														'function' => 'w2dc_affect_setting_w2dc_primary_color'
												),
										),
										array(
												'type' => 'color',
												'name' => 'w2dc_secondary_color',
												'label' => esc_html__('Secondary color', 'w2dc'),
												'default' => get_option('w2dc_secondary_color'),
												'binding' => array(
														'field' => 'w2dc_color_scheme',
														'function' => 'w2dc_affect_setting_w2dc_secondary_color'
												),
										),
									),
								),
								'links_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Links & buttons', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'color',
											'name' => 'w2dc_links_color',
											'label' => esc_html__('Links color', 'w2dc'),
											'default' => get_option('w2dc_links_color'),
											'binding' => array(
												'field' => 'w2dc_color_scheme',
												'function' => 'w2dc_affect_setting_w2dc_links_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_links_hover_color',
											'label' => esc_html__('Links hover color', 'w2dc'),
											'default' => get_option('w2dc_links_hover_color'),
											'binding' => array(
												'field' => 'w2dc_color_scheme',
												'function' => 'w2dc_affect_setting_w2dc_links_hover_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_button_1_color',
											'label' => esc_html__('Button primary color', 'w2dc'),
											'default' => get_option('w2dc_button_1_color'),
											'binding' => array(
												'field' => 'w2dc_color_scheme',
												'function' => 'w2dc_affect_setting_w2dc_button_1_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_button_2_color',
											'label' => esc_html__('Button secondary color', 'w2dc'),
											'default' => get_option('w2dc_button_2_color'),
											'binding' => array(
												'field' => 'w2dc_color_scheme',
												'function' => 'w2dc_affect_setting_w2dc_button_2_color'
											),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_button_text_color',
											'label' => esc_html__('Button text color', 'w2dc'),
											'default' => get_option('w2dc_button_text_color'),
											'binding' => array(
												'field' => 'w2dc_color_scheme',
												'function' => 'w2dc_affect_setting_w2dc_button_text_color'
											),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_button_gradient',
											'label' => esc_html__('Use gradient on buttons', 'w2dc'),
											'description' => esc_html__('This will remove all icons from buttons'),
											'default' => get_option('w2dc_button_gradient'),
										),
									),
								),
								'terms_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Categories & Locations tables', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'color',
											'name' => 'w2dc_terms_links_color',
											'label' => esc_html__('Terms links color', 'w2dc'),
											'default' => get_option('w2dc_terms_links_color'),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_terms_links_hover_color',
											'label' => esc_html__('Terms links hover color', 'w2dc'),
											'default' => get_option('w2dc_terms_links_hover_color'),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_terms_bg_color',
											'label' => esc_html__('Terms background color', 'w2dc'),
											'default' => get_option('w2dc_terms_bg_color'),
										),
										array(
											'type' => 'color',
											'name' => 'w2dc_terms_heading_bg_color',
											'label' => esc_html__('Terms heading background color', 'w2dc'),
											'default' => get_option('w2dc_terms_heading_bg_color'),
										),
									),
								),
								'misc_colors' => array(
									'type' => 'section',
									'title' => esc_html__('Misc settings', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'select',
											'name' => 'w2dc_logo_animation_effect',
											'label' => esc_html__('Logo hover effect on excerpt pages', 'w2dc'),
											'items' => array(
													array(
															'value' => 0,
															'label' => esc_html__('Disabled', 'w2dc')
													),
													array(
															'value' => 1,
															'label' => esc_html__('Enabled', 'w2dc')
													),
											),
											'default' => array(get_option('w2dc_logo_animation_effect')),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_listings_bottom_margin',
											'label' => esc_html__('Bottom margin between listings (in pixels)', 'w2dc'),
											'min' => '0',
											'max' => '120',
											'default' => get_option('w2dc_listings_bottom_margin'),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_listing_title_font',
											'label' => esc_html__('Listing title font size (in pixels)', 'w2dc'),
											'min' => '7',
											'max' => '40',
											'default' => get_option('w2dc_listing_title_font'),
										),
										array(
											'type' => 'radioimage',
											'name' => 'w2dc_jquery_ui_schemas',
											'label' => esc_html__('jQuery UI Style', 'w2dc'),
									 		'description' =>  esc_html__('Controls the color of calendar, dialogs, search dropdowns and slider UI widgets', 'w2dc') . (get_option('w2dc_notinclude_jqueryui_css') ? ' <strong>' . esc_html__('Warning: You have enabled not to include jQuery UI CSS on Advanced settings tab. Selected style will not be applied.', 'w2dc') . '</strong>' : ''),
									 		'items' => array(
									 			array(
									 				'value' => 'blitzer',
									 				'label' => 'Blitzer',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/blitzer/thumb.png'
									 			),
									 			array(
									 				'value' => 'smoothness',
									 				'label' => 'Smoothness',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/smoothness/thumb.png'
									 			),
									 			array(
									 				'value' => 'redmond',
									 				'label' => 'Redmond',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/redmond/thumb.png'
									 			),
									 			array(
									 				'value' => 'ui-darkness',
									 				'label' => 'UI Darkness',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/ui-darkness/thumb.png'
									 			),
									 			array(
									 				'value' => 'ui-lightness',
									 				'label' => 'UI Lightness',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/ui-lightness/thumb.png'
									 			),
									 			array(
									 				'value' => 'trontastic',
									 				'label' => 'Trontastic',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/trontastic/thumb.png'
									 			),
									 			array(
									 				'value' => 'start',
									 				'label' => 'Start',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/start/thumb.png'
									 			),
									 			array(
									 				'value' => 'sunny',
									 				'label' => 'Sunny',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/sunny/thumb.png'
									 			),
									 			array(
									 				'value' => 'overcast',
									 				'label' => 'Overcast',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/overcast/thumb.png'
									 			),
									 			array(
									 				'value' => 'le-frog',
									 				'label' => 'Le Frog',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/le-frog/thumb.png'
									 			),
									 			array(
									 				'value' => 'hot-sneaks',
									 				'label' => 'Hot Sneaks',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/hot-sneaks/thumb.png'
									 			),
									 			array(
									 				'value' => 'excite-bike',
									 				'label' => 'Excite Bike',
									 				'img' => W2DC_RESOURCES_URL . 'css/jquery-ui/themes/excite-bike/thumb.png'
									 			),
									 		),
											'default' => array(get_option('w2dc_jquery_ui_schemas')),
											'binding' => array(
												'field' => 'w2dc_color_scheme',
												'function' => 'w2dc_affect_setting_w2dc_jquery_ui_schemas'
											),
										),
									),
								),
							),
						),
						'social_sharing' => array(
							'name' => 'social_sharing',
							'title' => esc_html__('Social Sharing', 'w2dc'),
							'icon' => 'font-awesome:w2dc-fa-facebook ',
							'controls' => array(
								'social_sharing' => array(
									'type' => 'section',
									'title' => esc_html__('Listings Social Sharing Buttons', 'w2dc'),
									'fields' => array(
										array(
											'type' => 'radioimage',
											'name' => 'w2dc_share_buttons_style',
											'label' => esc_html__('Buttons style', 'w2dc'),
									 		'items' => array(
									 			array(
									 				'value' => 'arbenta',
									 				'label' =>esc_html__('Arbenta', 'w2dc'),
									 				'img' => W2DC_RESOURCES_URL . 'images/social/arbenta/facebook.png'
									 			),
									 			array(
									 				'value' => 'flat',
													'label' =>esc_html__('Flat', 'w2dc'),
									 				'img' => W2DC_RESOURCES_URL . 'images/social/flat/facebook.png'
									 			),
									 			array(
									 				'value' => 'somacro',
													'label' =>esc_html__('Somacro', 'w2dc'),
									 				'img' => W2DC_RESOURCES_URL . 'images/social/somacro/facebook.png'
									 			),
									 		),
											'default' => array(get_option('w2dc_share_buttons_style')),
										),
										array(
											'type' => 'sorter',
											'name' => 'w2dc_share_buttons',
											'label' => esc_html__('Include and order buttons', 'w2dc'),
									 		'items' => $w2dc_social_services,
											'default' => get_option('w2dc_share_buttons'),
										),
										array(
											'type' => 'toggle',
											'name' => 'w2dc_share_counter',
											'label' => esc_html__('Enable counter', 'w2dc'),
											'default' => get_option('w2dc_share_counter'),
										),
										array(
											'type' => 'radiobutton',
											'name' => 'w2dc_share_buttons_place',
											'label' => esc_html__('Where to place buttons on a listing page', 'w2dc'),
											'items' => array(
												array(
													'value' => 'title',
													'label' =>esc_html__('After title', 'w2dc'),
												),
												array(
													'value' => 'before_content',
													'label' =>esc_html__('Before text content', 'w2dc'),
												),
												array(
													'value' => 'after_content',
													'label' =>esc_html__('After text content', 'w2dc'),
												),
											),
											'default' => array(
													get_option('w2dc_share_buttons_place')
											),
										),
										array(
											'type' => 'slider',
											'name' => 'w2dc_share_buttons_width',
											'label' => esc_html__('Social buttons width (in pixels)', 'w2dc'),
											'default' => get_option('w2dc_share_buttons_width'),
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
				'page_title' => esc_html__('Directory settings', 'w2dc'),
				'menu_label' => esc_html__('Directory settings', 'w2dc'),
		);
		
		// adapted for WPML /////////////////////////////////////////////////////////////////////////
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$theme_options['template']['menus']['advanced']['controls']['wpml'] = array(
				'type' => 'section',
				'title' => esc_html__('WPML Settings', 'w2dc'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'w2dc_map_language_from_wpml',
						'label' => esc_html__('Force WPML language on maps', 'w2dc'),
						'description' => esc_html__("Ignore the browser's language setting and force it to display information in a particular WPML language", 'w2dc'),
						'default' => get_option('w2dc_map_language_from_wpml'),
					),
				),
			);
		}
		
		$theme_options = apply_filters('w2dc_build_settings', $theme_options);

		$W2DC_VP_Option = new W2DC_VP_Option($theme_options);
	}

	public function save_option($opts, $old_opts, $status) {
		global $w2dc_wpml_dependent_options, $sitepress;

		if ($status) {
			foreach ($opts AS $option=>$value) {
				// adapted for WPML
				if (in_array($option, $w2dc_wpml_dependent_options)) {
					if (function_exists('wpml_object_id_filter') && $sitepress) {
						if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
							update_option($option.'_'.ICL_LANGUAGE_CODE, $value);
							continue;
						}
					}
				}

				if (
					$option == 'w2dc_google_api_key' ||
					$option == 'w2dc_google_api_key_server' ||
					$option == 'w2dc_mapbox_api_key'
				) {
					$value = trim($value);
				}
				update_option($option, $value);
			}
			
			w2dc_save_dynamic_css();
			flush_rewrite_rules();
		}
	}
}

function w2dc_save_dynamic_css() {
	$upload_dir = wp_upload_dir();
	$filename = trailingslashit($upload_dir['basedir']) . 'w2dc-plugin.css';
		
	ob_start();
	include W2DC_PATH . '/classes/customization/dynamic_css.php';
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
function w2dc_get_wpml_dependent_option_name($option) {
	global $w2dc_wpml_dependent_options, $sitepress;

	if (in_array($option, $w2dc_wpml_dependent_options))
		if (function_exists('wpml_object_id_filter') && $sitepress)
			if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE)
				if (get_option($option.'_'.ICL_LANGUAGE_CODE) !== false)
					return $option.'_'.ICL_LANGUAGE_CODE;

	return $option;
}
function w2dc_get_wpml_dependent_option($option) {
	return get_option(w2dc_get_wpml_dependent_option_name($option));
}
function w2dc_get_wpml_dependent_option_description() {
	global $sitepress;
	return ((function_exists('wpml_object_id_filter') && $sitepress) ? sprintf(esc_html__('%s This is multilingual option, each language may have own value.', 'w2dc'), '<br /><img src="'.W2DC_RESOURCES_URL . 'images/multilang.png" /><br />') : '');
}


function w2dc_google_type_setting($value) {
	if ($value == 'google') {
		return true;
	}
}
W2DC_VP_Security::instance()->whitelist_function('w2dc_google_type_setting');

function w2dc_mapbox_type_setting($value) {
	if ($value == 'mapbox') {
		return true;
	}
}
W2DC_VP_Security::instance()->whitelist_function('w2dc_mapbox_type_setting');

function w2dc_map_markers_icons_setting($value) {
	if ($value == 'icons') {
		return true;
	}
}
W2DC_VP_Security::instance()->whitelist_function('w2dc_map_markers_icons_setting');

function w2dc_map_markers_images_setting($value) {
	if ($value == 'images') {
		return true;
	}
}
W2DC_VP_Security::instance()->whitelist_function('w2dc_map_markers_images_setting');

?>