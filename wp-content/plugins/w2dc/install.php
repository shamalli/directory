<?php

// @codingStandardsIgnoreFile

function w2dc_install_directory() {
	global $wpdb;
	
	if (!get_option('w2dc_installed_directory')) {
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_content_fields_groups} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`on_tab` tinyint(1) NOT NULL DEFAULT '0',
					`hide_anonymous` tinyint(1) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields_groups} WHERE name = 'Contact Information'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields_groups} (`name`, `on_tab`, `hide_anonymous`) VALUES ('Contact Information', 0, 0)");
			do_action('Web 2.0 Directory', 'The name of content fields group #1', 'Contact Information');
		}

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_content_fields} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`is_core_field` tinyint(1) NOT NULL DEFAULT '0',
					`order_num` int(11) NOT NULL,
					`name` varchar(255) NOT NULL,
					`slug` varchar(255) NOT NULL,
					`description` text NOT NULL,
					`type` varchar(255) NOT NULL,
					`icon_image` varchar(255) NOT NULL,
					`is_required` tinyint(1) NOT NULL DEFAULT '0',
					`is_configuration_page` tinyint(1) NOT NULL DEFAULT '0',
					`is_ordered` tinyint(1) NOT NULL DEFAULT '0',
					`is_hide_name` tinyint(1) NOT NULL DEFAULT '0',
					`for_admin_only` tinyint(1) NOT NULL DEFAULT '0',
					`on_exerpt_page` tinyint(1) NOT NULL DEFAULT '0',
					`on_listing_page` tinyint(1) NOT NULL DEFAULT '0',
					`on_search_form` tinyint(1) NOT NULL DEFAULT '0',
					`on_map` tinyint(1) NOT NULL DEFAULT '0',
					`categories` text NOT NULL,
					`options` text NOT NULL,
					`group_id` int(11) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`),
					KEY `group_id` (`group_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'summary'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(1, 1, 'Summary', 'summary', '', 'excerpt', '', 0, 0, 0, 1, 0, 1, 0, 0, 0, '', '', '0');");
			do_action('Web 2.0 Directory', 'The name of content field #1', 'Summary');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'address'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(1, 2, 'Address', 'address', '', 'address', 'w2dc-fa-map-marker', 0, 0, 0, 0, 0, 1, 1, 0, 1, '', '', '0');");
			do_action('Web 2.0 Directory', 'The name of content field #2', 'Address');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'content'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(1, 3, 'Description', 'content', '', 'content', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, '', '', '0');");
			do_action('Web 2.0 Directory', 'The name of content field #3', 'Description');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'categories_list'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(1, 4, 'Categories', 'categories_list', '', 'categories', '', 0, 0, 0, 1, 0, 1, 1, 0, 0, '', '', '0');");
			do_action('Web 2.0 Directory', 'The name of content field #4', 'Categories');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'listing_tags'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(1, 5, 'Listing Tags', 'listing_tags', '', 'tags', '', 0, 0, 0, 1, 0, 0, 1, 0, 0, '', '', '0');");
			do_action('Web 2.0 Directory', 'The name of content field #5', 'Listing Tags');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'phone'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(0, 6, 'Phone', 'phone', '', 'phone', 'w2dc-fa-phone', 0, 1, 0, 0, 0, 1, 1, 0, 1, '', 'a:3:{s:10:\"max_length\";s:2:\"25\";s:5:\"regex\";s:0:\"\";s:10:\"phone_mode\";s:5:\"phone\";}', '1');");
			do_action('Web 2.0 Directory', 'The name of content field #6', 'Phone');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'website'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(0, 7, 'Website', 'website', '', 'website', 'w2dc-fa-globe', 0, 1, 0, 0, 0, 1, 1, 0, 1, '', 'a:5:{s:8:\"is_blank\";i:1;s:11:\"is_nofollow\";i:1;s:13:\"use_link_text\";i:1;s:17:\"default_link_text\";s:13:\"view our site\";s:21:\"use_default_link_text\";i:0;}', '1');");
			do_action('Web 2.0 Directory', 'The name of content field #7', 'Website');
		}
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_content_fields} WHERE slug = 'email'")) {
			$wpdb->query("INSERT INTO {$wpdb->w2dc_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_ordered`, `is_hide_name`, `for_admin_only`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `categories`, `options`, `group_id`) VALUES(0, 8, 'Email', 'email', '', 'email', 'w2dc-fa-envelope-o', 0, 0, 0, 0, 0, 1, 1, 0, 0, '', '', '1');");
			do_action('Web 2.0 Directory', 'The name of content field #8', 'Email');
		}

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_directories} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`single` varchar(255) NOT NULL,
					`plural` varchar(255) NOT NULL,
					`listing_slug` varchar(255) NOT NULL,
					`category_slug` varchar(255) NOT NULL,
					`location_slug` varchar(255) NOT NULL,
					`tag_slug` varchar(255) NOT NULL,
					`categories` text NOT NULL,
					`locations` text NOT NULL,
					`levels` text NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_directories} WHERE name = 'Listings'"))
			$wpdb->query("INSERT INTO {$wpdb->w2dc_directories} (`name`, `single`, `plural`, `listing_slug`, `category_slug`, `location_slug`, `tag_slug`, `categories`, `locations`, `levels`) VALUES ('Listings', 'listing', 'listings', 'business-listing', 'business-category', 'business-place', 'business-tag', '', '', '')");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_levels} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`order_num` int(11) NOT NULL,
					`name` varchar(255) NOT NULL,
					`description` text NOT NULL,
					`who_can_view` text NOT NULL,
					`who_can_submit` text NOT NULL,
					`active_interval` tinyint(1) NOT NULL,
					`active_period` varchar(255) NOT NULL,
					`eternal_active_period` tinyint(1) NOT NULL DEFAULT '1',
					`change_level_id` INT(11) NOT NULL DEFAULT '0',
					`listings_in_package` INT(11) NOT NULL DEFAULT '1',
					`raiseup_enabled` tinyint(1) NOT NULL,
					`sticky` tinyint(1) NOT NULL,
					`featured` tinyint(1) NOT NULL,
					`nofollow` tinyint(1) NOT NULL DEFAULT '0',
					`listings_own_page` tinyint(1) NOT NULL DEFAULT '1',
					`categories_number` int(11) NOT NULL,
					`unlimited_categories` tinyint(1) NOT NULL,
					`tags_number` int(11) NOT NULL DEFAULT '0',
					`unlimited_tags` tinyint(1) NOT NULL DEFAULT 1,
					`locations_number` int(11) NOT NULL,
					`map` tinyint(1) NOT NULL,
					`map_markers` tinyint(1) NOT NULL,
					`logo_enabled` tinyint(1) NOT NULL,
					`images_number` int(11) NOT NULL,
					`videos_number` int(11) NOT NULL,
					`categories` text NOT NULL,
					`locations` text NOT NULL,
					`content_fields` text NOT NULL,
					`upgrade_meta` text NOT NULL,
					PRIMARY KEY (`id`),
					KEY `order_num` (`order_num`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_levels} WHERE name = 'Standard'"))
			$wpdb->query("INSERT INTO {$wpdb->w2dc_levels} (`order_num`, `name`, `description`, `who_can_view`, `who_can_submit`, `active_interval`, `active_period`, `eternal_active_period`, `change_level_id`, `listings_in_package`, `raiseup_enabled`, `sticky`, `featured`, `nofollow`, `listings_own_page`, `categories_number`, `unlimited_categories`, `tags_number`, `unlimited_tags`, `locations_number`, `map`, `map_markers`, `logo_enabled`, `images_number`, `videos_number`, `categories`, `locations`, `content_fields`, `upgrade_meta`) VALUES (1, 'Standard', '', '', '', 0, '', 1, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 3, 1, 1, 1, 6, 3, '', '', '', '')");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_levels_relationships} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`post_id` int(11) NOT NULL,
					`level_id` int(11) NOT NULL,
					PRIMARY KEY (`id`),
					UNIQUE KEY `post_id` (`post_id`,`level_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_locations_levels} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`in_address_line` tinyint(1) NOT NULL,
					`allow_add_term` tinyint(1) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_locations_levels} WHERE name = 'Country'"))
			$wpdb->query("INSERT INTO {$wpdb->w2dc_locations_levels} (`name`, `in_address_line`, `allow_add_term`) VALUES ('Country', 1, 1);");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_locations_levels} WHERE name = 'State'"))
			$wpdb->query("INSERT INTO {$wpdb->w2dc_locations_levels} (`name`, `in_address_line`, `allow_add_term`) VALUES ('State', 1, 1);");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_locations_levels} WHERE name = 'City'"))
			$wpdb->query("INSERT INTO {$wpdb->w2dc_locations_levels} (`name`, `in_address_line`, `allow_add_term`) VALUES ('City', 1, 1);");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_locations_relationships} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`post_id` int(11) NOT NULL,
					`location_id` int(11) NOT NULL,
					`place_id` varchar(45) NOT NULL,
					`address_line_1` varchar(255) NOT NULL,
					`address_line_2` varchar(255) NOT NULL,
					`zip_or_postal_index` varchar(25) NOT NULL,
					`additional_info` text NOT NULL,
					`manual_coords` tinyint(1) NOT NULL,
					`map_coords_1` float(10,6) NOT NULL,
					`map_coords_2` float(10,6) NOT NULL,
					`map_icon_file` varchar(255) NOT NULL,
					PRIMARY KEY (`id`),
					KEY `location_id` (`location_id`),
					KEY `post_id` (`post_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	
		if (!is_array(get_terms(W2DC_LOCATIONS_TAX)) || !count(get_terms(W2DC_LOCATIONS_TAX))) {
			if (($parent_term = wp_insert_term('United States', W2DC_LOCATIONS_TAX)) && !is_a($parent_term, 'WP_Error')) {
				wp_insert_term('Alabama', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Alaska', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Arkansas', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Arizona', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('California', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Colorado', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Connecticut', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Delaware', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('District of Columbia', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Florida', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Georgia', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Hawaii', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Idaho', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Illinois', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Indiana', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Iowa', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Kansas', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Kentucky', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Louisiana', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Maine', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Maryland', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Massachusetts', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Michigan', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Minnesota', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Mississippi', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Missouri', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Montana', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Nebraska', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Nevada', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New Hampshire', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New Jersey', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New Mexico', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New York', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('North Carolina', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('North Dakota', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Ohio', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Oklahoma', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Oregon', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Pennsylvania', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Rhode Island', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('South Carolina', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('South Dakota', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Tennessee', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Texas', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Utah', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Vermont', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Virginia', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Washington state', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('West Virginia', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Wisconsin', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Wyoming', W2DC_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
			}
		}

		add_option('w2dc_enable_recaptcha');
		add_option('w2dc_recaptcha_version', 'v3');
		add_option('w2dc_recaptcha_public_key');
		add_option('w2dc_recaptcha_private_key');
		add_option('w2dc_show_categories_index', 1);
		add_option('w2dc_show_category_count', 1);
		add_option('w2dc_listings_number_index', 6);
		add_option('w2dc_listings_number_excerpt', 6);
		add_option('w2dc_map_on_index', 1);
		add_option('w2dc_map_on_excerpt', 1);
		add_option('w2dc_directory_title', 'Web 2.0 Directory');
		add_option('w2dc_categories_nesting_level', 1);
		add_option('w2dc_show_directions', 1);
		add_option('w2dc_send_expiration_notification_days', 1);
		add_option('w2dc_preexpiration_notification', 'Your listing "[listing]" will expire in [days] days. You can renew it here [link]');
		add_option('w2dc_expiration_notification', 'Your listing "[listing]" had expired. You can renew it here [link]');
		add_option('w2dc_listings_on_index', 1);
		add_option('w2dc_listing_contact_form', 1);
		add_option('w2dc_favourites_list', 1);
		add_option('w2dc_print_button', 1);
		add_option('w2dc_pdf_button', 1);
		add_option('w2dc_pdf_page_orientation', 'portrait');
		add_option('w2dc_default_map_zoom', 11);
		add_option('w2dc_categories_icons');
		add_option('w2dc_change_expiration_date', 0);
		add_option('w2dc_categories_columns', 2);
		add_option('w2dc_google_map_style', 'default');
		add_option('w2dc_hide_comments_number_on_index', 0);
		add_option('w2dc_hide_listings_creation_date', 1);
		add_option('w2dc_hide_author_link', 1);
		add_option('w2dc_enable_radius_search_circle', 0);
		add_option('w2dc_enable_clusters', 0);
		add_option('w2dc_color_scheme', 'default');
		add_option('w2dc_force_include_js_css', 0);
		add_option('w2dc_images_lightbox', 1);
		add_option('w2dc_listing_contact_form_7', '');
		add_option('w2dc_subcategories_items', 0);
		add_option('w2dc_default_geocoding_location', '');
		add_option('w2dc_show_orderby_links', 1);
		add_option('w2dc_orderby_date', 1);
		add_option('w2dc_orderby_title', 1);
		add_option('w2dc_default_orderby', 'post_date');
		add_option('w2dc_default_order', 'DESC');
		add_option('w2dc_notinclude_jqueryui_css', 0);
		add_option('w2dc_logo_animation_effect', 1);
		add_option('w2dc_views_switcher', 1);
		add_option('w2dc_views_switcher_default', 'list');
		add_option('w2dc_views_switcher_grid_columns', 2);
		add_option('w2dc_wrap_logo_list_view', 0);
		add_option('w2dc_miles_kilometers_in_search', 'miles');
		add_option('w2dc_orderby_distance', 1);
		add_option('w2dc_compare_palettes', 0);
		add_option('w2dc_links_color', '#428BCA');
		add_option('w2dc_links_hover_color', '#275379');
		add_option('w2dc_button_1_color', '#428BCA');
		add_option('w2dc_button_2_color', '#275379');
		add_option('w2dc_button_text_color', '#FFFFFF');
		add_option('w2dc_primary_color', '#428BCA');
		add_option('w2dc_secondary_color', '#275379');
		add_option('w2dc_listing_thumb_width', 300);
		add_option('w2dc_grid_view_logo_ratio', 56.25);
		add_option('w2dc_listings_bottom_margin', 60);
		add_option('w2dc_listing_title_font', 20);
		add_option('w2dc_default_map_height', 450);
		add_option('w2dc_jquery_ui_schemas', 'redmond');
		add_option('w2dc_addresses_order', array("line_1", "comma1", "line_2", "comma2", "location", "space1", "zip"));
		add_option('w2dc_orderby_exclude_null', 0);
		add_option('w2dc_map_marker_width', 48);
		add_option('w2dc_map_marker_height', 48);
		add_option('w2dc_map_marker_anchor_x', 24);
		add_option('w2dc_map_marker_anchor_y', 48);
		add_option('w2dc_map_infowindow_width', 350);
		add_option('w2dc_map_infowindow_offset', 50);
		add_option('w2dc_map_infowindow_logo_width', 110);
		add_option('w2dc_enable_nologo', 1);
		add_option('w2dc_nologo_url', W2DC_URL . 'resources/images/nologo.png');
		add_option('w2dc_excerpt_length', 25);
		add_option('w2dc_cropped_content_as_excerpt', 1);
		add_option('w2dc_strip_excerpt', 1);
		add_option('w2dc_orderby_sticky_featured', 0);
		add_option('w2dc_button_gradient', 0);
		add_option('w2dc_enable_description', 1);
		add_option('w2dc_enable_excerpt', 1);
		add_option('w2dc_share_buttons_style', 'arbenta');
		add_option('w2dc_share_buttons', array());
		add_option('w2dc_share_counter', 0);
		add_option('w2dc_share_buttons_place', 'title');
		add_option('w2dc_share_buttons_width', 40);
		add_option('w2dc_100_single_logo_width', 1);
		add_option('w2dc_single_logo_width', 270);
		add_option('w2dc_enable_address_line_1', 1);
		add_option('w2dc_enable_address_line_2', 1);
		add_option('w2dc_enable_postal_index', 1);
		add_option('w2dc_enable_additional_info', 1);
		add_option('w2dc_enable_manual_coords', 1);
		add_option('w2dc_big_slide_bg_mode', 'cover');
		add_option('w2dc_exclude_logo_from_listing', 0);
		add_option('w2dc_enable_lightbox_gallery', 1);
		add_option('w2dc_directions_functionality', 'builtin');
		add_option('w2dc_address_autocomplete', 1);
		add_option('w2dc_address_geocode', 0);
		add_option('w2dc_listings_comments_mode', 'wp_settings');
		add_option('w2dc_listings_tabs_order', array("addresses-tab", "comments-tab", "videos-tab", "contact-tab", "report-tab"));
		add_option('w2dc_permalinks_structure', 'postname');
		add_option('w2dc_google_api_key', '');
		add_option('w2dc_google_api_key_server', '');
		add_option('w2dc_show_locations_index', 0);
		add_option('w2dc_locations_nesting_level', 1);
		add_option('w2dc_locations_columns', 2);
		add_option('w2dc_sublocations_items', 0);
		add_option('w2dc_show_location_count', 1);
		add_option('w2dc_locations_icons');
		add_option('w2dc_enable_breadcrumbs', 1);
		add_option('w2dc_hide_home_link_breadcrumb', 0);
		add_option('w2dc_breadcrumbs_mode', 'title');
		add_option('w2dc_auto_slides_gallery', 0);
		add_option('w2dc_auto_slides_gallery_delay', 3000);
		add_option('w2dc_ajax_load', 1);
		add_option('w2dc_show_more_button', 1);
		add_option('w2dc_map_markers_type', 'icons');
		add_option('w2dc_default_marker_color', '#428bca');
		add_option('w2dc_default_marker_icon', '');
		add_option('w2dc_search_on_map', 0);
		add_option('w2dc_enable_stats', 1);
		add_option('w2dc_enable_draw_panel', 0);
		add_option('w2dc_map_markers_is_limit', 1);
		add_option('w2dc_address_autocomplete_code', "0");
		add_option('w2dc_show_listings_count', 1);
		add_option('w2dc_custom_contact_email', 1);
		add_option('w2dc_admin_notifications_email', get_option('admin_email'));
		add_option('w2dc_prevent_users_see_other_media', 1);
		add_option('w2dc_hide_empty_locations', 0);
		add_option('w2dc_hide_empty_categories', 0);
		add_option('w2dc_hide_views_counter', 1);
		add_option('w2dc_listing_logo_bg_mode', 'cover');
		add_option('w2dc_enable_geolocation', 0);
		add_option('w2dc_start_zoom', 0);
		add_option('w2dc_listing_title_mode', 'inside');
		add_option('w2dc_map_markers_required', 0);
		add_option('w2dc_map_type', 'none');
		add_option('w2dc_mapbox_map_style', 'mapbox://styles/mapbox/streets-v10');
		add_option('w2dc_mapbox_map_style_custom', '');
		add_option('w2dc_mapbox_api_key', '');
		add_option('w2dc_enable_full_screen', 1);
		add_option('w2dc_enable_wheel_zoom', 1);
		add_option('w2dc_enable_dragging_touchscreens', 1);
		add_option('w2dc_center_map_onclick', 0);
		add_option('w2dc_hide_search_on_map_mobile', 0);
		add_option('w2dc_mobile_listings_grid_columns', 1);
		add_option('w2dc_sticky_label', "Sticky");
		add_option('w2dc_featured_label', "Featured");
		add_option('w2dc_hide_anonymous_contact_form', 0);
		add_option('w2dc_report_form', 1);
		add_option('w2dc_map_marker_size', '40');
		add_option('w2dc_single_logo_height', 0);
		add_option('w2dc_map_on_single', 1);
		add_option('w2dc_enable_html_description', 1);
		add_option("w2dc_imitate_mode", 0);
		add_option('w2dc_hide_listing_title', 0);
		add_option('w2dc_categories_order', 'default');
		add_option('w2dc_locations_order', 'default');
		add_option("w2dc_search_form_id", '');
		add_option('w2dc_main_search', 0);
		add_option("w2dc_search_map_form_id", '');
		add_option("w2dc_terms_links_color", "#FFFFFF");
		add_option("w2dc_terms_links_hover_color", "#FFFFFF");
		add_option("w2dc_terms_heading_bg_color", "#979797");
		add_option("w2dc_terms_bg_color", "#cacaca");
		add_option("w2dc_zip_or_postal_text", "zip");
		add_option('w2dc_overwrite_page_title', 0);
		add_option('w2dc_map_min_zoom', 0);
		add_option('w2dc_map_max_zoom', 0);
		add_option('w2dc_images_submit_required', 0);
		
		w2dc_update_scheduled_events_time();
		
		w2dc_install_create_search_forms();
	
		add_option('w2dc_installed_directory', true);
		add_option(W2DC_INSTALLED_VERSION_SETTING_NAME, W2DC_VERSION_TAG);
		add_option('w2dc_installed_plugin_time', time());
	} elseif (get_option(W2DC_INSTALLED_VERSION_SETTING_NAME) != W2DC_VERSION_TAG) {
		$upgrades_list = array(
				'1.0.6',
				'1.0.7',
				'1.1.0',
				'1.1.2',
				'1.1.4',
				'1.1.5',
				'1.1.7',
				'1.2.0',
				'1.3.0',
				'1.3.2',
				'1.4.0',
				'1.4.2',
				'1.5.0',
				'1.5.4',
				'1.5.5',
				'1.5.7',
				'1.5.8',
				'1.6.0',
				'1.6.2',
				'1.7.0',
				'1.8.0',
				'1.8.1',
				'1.8.2',
				'1.8.3',
				'1.8.4',
				'1.8.6',
				'1.9.0',
				'1.9.1',
				'1.9.5',
				'1.9.6',
				'1.9.7',
				'1.9.9',
				'1.10.0',
				'1.11.0',
				'1.11.3',
				'1.11.5',
				'1.11.6',
				'1.11.7',
				'1.12.0',
				'1.12.4',
				'1.12.5',
				'1.12.7',
				'1.12.8',
				'1.14.0',
				'1.14.2',
				'1.14.3',
				'1.14.5',
				'1.14.7',
				'1.14.9',
				'1.14.10',
				'1.14.11',
				'1.14.15',
				'2.0.0',
				'2.0.5',
				'2.0.6',
				'2.0.8',
				'2.0.10',
				'2.0.15',
				'2.1.2',
				'2.1.3',
				'2.1.5',
				'2.2.1',
				'2.2.3',
				'2.2.4',
				'2.2.5',
				'2.2.6',
				'2.2.8',
				'2.3.0',
				'2.4.0',
				'2.5.0',
				'2.5.2',
				'2.5.7',
				'2.5.8',
				'2.5.9',
				'2.5.12',
				'2.5.13',
				'2.5.14',
				'2.5.19',
				'2.5.21',
				'2.6.0',
				'2.6.4',
				'2.6.7',
				'2.6.8',
				'2.6.9',
				'2.6.10',
				'2.6.11',
				'2.6.13',
				'2.7.1',
				'2.7.3',
				'2.7.5',
				'2.8.0',
				'2.8.2',
				'2.9.0',
				'2.9.4',
				'2.9.16',
				'2.9.17',
		);

		$old_version = get_option('w2dc_installed_directory_version');
		foreach ($upgrades_list AS $upgrade_version) {
			if (!$old_version || version_compare($old_version, $upgrade_version, '<')) {
				$upgrade_function_name = 'w2dc_upgrade_to_' . str_replace('.', '_', $upgrade_version);
				if (function_exists($upgrade_function_name)) {
					$upgrade_function_name();
				}
				do_action('w2dc_version_upgrade', $upgrade_version);
			}
		}

		w2dc_save_dynamic_css();

		update_option(W2DC_INSTALLED_VERSION_SETTING_NAME, W2DC_VERSION_TAG);
		
		if (!get_option('w2dc_installed_plugin_time')) {
			add_option('w2dc_installed_plugin_time', time());
		}
		
		echo '<script>location.reload();</script>';
		exit;
	}
	
	global $w2dc_instance;
	$w2dc_instance->loadClasses();
}

function w2dc_upgrade_to_1_0_6() {
}

function w2dc_upgrade_to_1_0_7() {
	add_option('w2dc-content_width', 60);
}

function w2dc_upgrade_to_1_1_0() {
	delete_option('w2dc_is_home_page');
	delete_option('w2dc-content_width');
}

function w2dc_upgrade_to_1_1_2() {
	add_option('w2dc_listings_on_index', 1);
	add_option('w2dc_listing_contact_form', 1);
}

function w2dc_upgrade_to_1_1_4() {
	add_option('w2dc_favourites_list', 1);
	add_option('w2dc_print_button', 1);
	add_option('w2dc_pdf_button', 1);
}

function w2dc_upgrade_to_1_1_5() {
	add_option('w2dc_default_map_zoom', 11);
}

function w2dc_upgrade_to_1_1_7() {
	add_option('w2dc_categories_icons');
}

function w2dc_upgrade_to_1_2_0() {
	add_option('w2dc_change_expiration_date', 0);
}

function w2dc_upgrade_to_1_3_0() {
	add_option('w2dc_categories_columns', 2);
	add_option('w2dc_google_map_style', 'default');
}

function w2dc_upgrade_to_1_3_2() {
	add_option('w2dc_main_search', 1);
	add_option('w2dc_hide_comments_number_on_index', 0);
	add_option('w2dc_hide_listings_creation_date', 1);
}

function w2dc_upgrade_to_1_4_0() {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->w2dc_content_fields} ADD `on_map` TINYINT( 1 ) NOT NULL AFTER `on_search_form`");

	add_option('w2dc_enable_radius_search_circle', 0);
	add_option('w2dc_enable_clusters', 0);
	add_option('w2dc_show_location_count_in_search', 1);
}

function w2dc_upgrade_to_1_4_2() {
	add_option('w2dc_color_scheme', 'default');
}

function w2dc_upgrade_to_1_5_0() {
	add_option('w2dc_images_lightbox', 1);
}

function w2dc_upgrade_to_1_5_4() {
	add_option('w2dc_listing_contact_form_7', '');
}

function w2dc_upgrade_to_1_5_5() {
	if (($widgets_array = get_option('widget_w2dc_search_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['visibility'] = 1;
				$widget['search_visibility'] = 1;
			}
		}
		update_option('widget_w2dc_search_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_w2dc_categories_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title']))
				$widget['visibility'] = 1;
		}
		update_option('widget_w2dc_categories_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_w2dc_listings_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title']))
				$widget['visibility'] = 1;
		}
		update_option('widget_w2dc_listings_widget', $widgets_array);
	}
	
	if (($widgets_array = get_option('widget_w2dc_social_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title']))
				$widget['visibility'] = 1;
		}
		update_option('widget_w2dc_social_widget', $widgets_array);
	}
}

function w2dc_upgrade_to_1_5_7() {
	add_option('w2dc_show_keywords_search', 1);
	add_option('w2dc_show_locations_search', 1);
	add_option('w2dc_show_address_search', 1);

	add_option('w2dc_subcategories_items', 0);
	
	if (($widgets_array = get_option('widget_w2dc_categories_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title']))
				$widget['subcats'] = 0;
		}
		update_option('widget_w2dc_categories_widget', $widgets_array);
	}
}

function w2dc_upgrade_to_1_5_8() {
	add_option('w2dc_default_geocoding_location', '');
	add_option('w2dc_show_orderby_links', 1);
	add_option('w2dc_orderby_date', 1);
	add_option('w2dc_orderby_title', 1);
	add_option('w2dc_default_orderby', 'post_date');
	add_option('w2dc_default_order', 'DESC');
}

function w2dc_upgrade_to_1_6_0() {
	global $wpdb;
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `upgrade_meta` TEXT NOT NULL"); 
}

function w2dc_upgrade_to_1_6_2() {
	$args = array(
		'post_type' => W2DC_POST_TYPE,
		'post_status' => 'any',
		'nopaging' => true
	);
	$query = new WP_Query($args);
	while ($query->have_posts()) {
		$query->the_post();

		$listing = new w2dc_listing;
		$listing->loadListingFromPost(get_post());

		if ($listing->logo_image)
			update_post_meta($listing->post->ID, '_thumbnail_id', $listing->logo_image);
	}
	// this is reset is really required after the loop ends
	wp_reset_postdata();

	global $w2dc_instance, $wpdb;
	foreach ($w2dc_instance->content_fields->content_fields_array AS $content_field) {
		if ($content_field->type == 'select' || $content_field->type == 'checkbox' || $content_field->type == 'radio') {
			foreach ($content_field->selection_items AS $key=>$item)
				$wpdb->update($wpdb->postmeta, array('meta_value' => $key), array('meta_key' => '_content_field_' . $content_field->id, 'meta_value' => $item));
		}
	}
	
	add_option('w2dc_enable_automatic_translations', 0);
}

function w2dc_upgrade_to_1_7_0() {
	if (get_option('w2dc_miles_kilometers_in_search', null) === null) {
		add_option('w2dc_show_category_count_in_search', 1);
		add_option('w2dc_miles_kilometers_in_search', 'miles');
		add_option('w2dc_radius_search_min', 0);
		add_option('w2dc_radius_search_max', 10);
		add_option('w2dc_show_categories_search', 1);
		add_option('w2dc_show_radius_search', 1);
		add_option('w2dc_radius_search_default', 10);
		add_option('w2dc_orderby_distance', 1);
	}
}

function w2dc_upgrade_to_1_8_0() {
	global $wpdb;

	add_option('w2dc_compare_palettes', 0);
	add_option('w2dc_links_color', '#428bca');
	add_option('w2dc_links_hover_color', '#2a6496');
	add_option('w2dc_button_1_color', '#428bca');
	add_option('w2dc_button_2_color', '#428BCA');
	add_option('w2dc_button_text_color', '#FFFFFF');
	add_option('w2dc_search_bg_color', '#6bc8c8');
	add_option('w2dc_search_text_color', '#FFFFFF');
	add_option('w2dc_primary_color', '#428bca');
	add_option('w2dc_listing_thumb_width', 300);
	add_option('w2dc_listings_bottom_margin', 60);
	add_option('w2dc_listing_title_font', 20);
	add_option('w2dc_default_map_height', 450);
	add_option('w2dc_jquery_ui_schemas', 'redmond');
	add_option('w2dc_addresses_order', array("line_1", "comma1", "line_2", "comma2", "location", "space1", "zip"));
	add_option('w2dc_orderby_exclude_null', 0);
	delete_option('w2dc_images_on_tab');
	delete_option('w2dc_listings_own_page');

	add_option('w2dc_enable_nologo', 1);
	add_option('w2dc_nologo_url', W2DC_RESOURCES_URL . 'images/nologo.png');

	add_option('w2dc_map_marker_width', 48);
	add_option('w2dc_map_marker_height', 48);
	add_option('w2dc_map_marker_anchor_x', 24);
	add_option('w2dc_map_marker_anchor_y', 48);
	add_option('w2dc_map_infowindow_width', 350);
	add_option('w2dc_map_infowindow_offset', 50);
	add_option('w2dc_map_infowindow_logo_width', 110);
	
	add_option('w2dc_excerpt_length', 25);
	add_option('w2dc_cropped_content_as_excerpt', 1);
	add_option('w2dc_strip_excerpt', 1);

	$wpdb->query("ALTER TABLE {$wpdb->w2dc_locations_relationships} ADD `additional_info` TEXT NOT NULL AFTER `zip_or_postal_index`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `content_fields` TEXT NOT NULL AFTER `categories`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `nofollow` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `featured`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `listings_own_page` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `nofollow`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} DROP `logo_size`");

	$levels_row = $wpdb->get_row("SELECT * FROM {$wpdb->w2dc_levels}");
	if (!isset($levels_row->upgrade_meta))
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `upgrade_meta` TEXT NOT NULL");
	
	w2dc_renewMapIcons();
}
function w2dc_renewMapIcons() {
	$old_folders = scandir(W2DC_MAP_ICONS_PATH . 'icons');
	$old_files = array();
	foreach ($old_folders AS $old_folder) {
		if ($old_folder != '.' && $old_folder != '..' && $old_folder != '_new') {
			$old_folders_files = scandir(W2DC_MAP_ICONS_PATH . 'icons/'.$old_folder);
			foreach ($old_folders_files AS $file) {
				if ($file != '.' && $file != '..') {
					$old_files[$old_folder][] = $file;
				}
			}
				
		}
	}

	$new_files = scandir(W2DC_MAP_ICONS_PATH . 'icons/_new');
	unset($new_files[array_search('.', $new_files)]);
	unset($new_files[array_search('..', $new_files)]);

	$result = array();
	foreach ($old_files AS $old_folder_name=>$old_folder) {
		foreach ($old_folder AS $old_file) {
			$found = false;
			foreach ($new_files AS $new_file) {
				if (strtolower($old_file) == strtolower($new_file)) {
					$result[] = array('old' => $old_folder_name.'/'.$old_file, 'new' => '_new/'.$new_file);
					$found = true;
					continue 2;
				}
			}
			if (!$found)
				$result[] = array('old' => $old_folder_name.'/'.$old_file, 'new' => '_new/'.$new_files[array_rand($new_files)]);
		}
	}

	global $wpdb;
	foreach ($result AS $rewrite)
		$wpdb->update($wpdb->w2dc_locations_relationships, array('map_icon_file' => $rewrite['new']), array('map_icon_file' => $rewrite['old']));

	add_option('w2dc_map_markers_update_backup', $result);
}

function w2dc_upgrade_to_1_8_1() {
	add_option('w2dc_orderby_sticky_featured', 0);
}

function w2dc_upgrade_to_1_8_2() {
	add_option('w2dc_button_gradient', 0);
}

function w2dc_upgrade_to_1_8_3() {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->w2dc_content_fields} ADD `group_id` INT NOT NULL DEFAULT '0', ADD INDEX ( `group_id` )");
	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_content_fields_groups} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`on_tab` tinyint(1) NOT NULL DEFAULT '0',
					`hide_anonymous` tinyint(1) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	
	add_option('w2dc_enable_description', 1);
	add_option('w2dc_enable_excerpt', 1);

	add_option('w2dc_share_buttons_style', 'arbenta');
	add_option('w2dc_share_buttons', array());
	add_option('w2dc_share_counter', 0);
	add_option('w2dc_share_buttons_place', 'title');
	add_option('w2dc_share_buttons_width', 40);

	add_option('w2dc_100_single_logo_width', 1);
	add_option('w2dc_single_logo_width', 270);
}

function w2dc_upgrade_to_1_8_4() {
	add_option('w2dc_notinclude_jqueryui_css', 0);
	add_option('w2dc_logo_animation_effect', 1);
	add_option('w2dc_views_switcher', 1);
	add_option('w2dc_views_switcher_default', 'list');
	add_option('w2dc_views_switcher_grid_columns', 2);
	add_option('w2dc_wrap_logo_list_view', 0);
}

function w2dc_upgrade_to_1_8_6() {
	add_option('w2dc_enable_address_line_1', 1);
	add_option('w2dc_enable_address_line_2', 1);
	add_option('w2dc_enable_postal_index', 1);
	add_option('w2dc_enable_additional_info', 1);
	add_option('w2dc_enable_manual_coords', 1);

	add_option('w2dc_big_slide_bg_mode', 'cover');
}

function w2dc_upgrade_to_1_9_0() {
	global $wpdb;

	add_option('w2dc_directions_functionality', 'builtin');
	add_option('w2dc_address_autocomplete', 1);
	add_option('w2dc_address_geocode', 0);
	add_option('w2dc_listings_comments_mode', 'wp_settings');
	add_option('w2dc_listings_tabs_order', array("addresses-tab", "comments-tab", "videos-tab", "contact-tab"));

	add_option('w2dc_listing_slug', 'business-listing');
	add_option('w2dc_location_slug', 'business-place');
	add_option('w2dc_permalinks_structure', 'postname');

	add_option('w2dc_google_api_key', '');

	add_option('w2dc_show_locations_index', 0);
	add_option('w2dc_locations_nesting_level', 1);
	add_option('w2dc_locations_columns', 2);
	add_option('w2dc_sublocations_items', 0);
	add_option('w2dc_show_location_count', 1);
	
	add_option('w2dc_locations_icons');
	
	if (($widgets_array = get_option('widget_w2dc_categories_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title']))
				$widget['parent'] = 0;
		}
		update_option('widget_w2dc_categories_widget', $widgets_array);
	}
	
	$wpdb->query("UPDATE {$wpdb->w2dc_content_fields} SET `is_configuration_page`=1 WHERE `type`='hours'");

	add_option('w2dc_enable_breadcrumbs', 1);
	add_option('w2dc_hide_home_link_breadcrumb', 0);
	add_option('w2dc_breadcrumbs_mode', 'title');
}

function w2dc_upgrade_to_1_9_1() {
	add_option('w2dc_grid_view_logo_ratio', 56.25);
}

function w2dc_upgrade_to_1_9_5() {
	global $wpdb;

	add_option('w2dc_google_api_key', get_option('w2dc_google_maps_api_key'));

	add_option('w2dc_enable_lightbox_gallery', 1);
	
	$wpdb->query("UPDATE {$wpdb->w2dc_content_fields} SET `is_configuration_page`=1 WHERE `type`='string' OR `type`='textarea'");
}

function w2dc_upgrade_to_1_9_6() {
	add_option('w2dc_exclude_logo_from_listing', 0);
}

function w2dc_upgrade_to_1_9_9() {
	add_option('w2dc_auto_slides_gallery', 0);
	add_option('w2dc_auto_slides_gallery_delay', 3000);
}

function w2dc_upgrade_to_1_10_0() {
	add_option('w2dc_ajax_load', 1);
	add_option('w2dc_ajax_initial_load', 0);
	add_option('w2dc_show_more_button', 1);
}

function w2dc_upgrade_to_1_11_0() {
	add_option('w2dc_map_markers_type', 'images');
	add_option('w2dc_default_marker_color', '#428bca');
	add_option('w2dc_default_marker_icon', '');
	add_option('w2dc_search_on_map', 0);
}

function w2dc_upgrade_to_1_11_3() {
	add_option('w2dc_enable_stats', 1);

	// these settings were missed in standard installation of previous version
	add_option('w2dc_map_marker_width', 48);
	add_option('w2dc_map_marker_height', 48);
	add_option('w2dc_map_marker_anchor_x', 24);
	add_option('w2dc_map_marker_anchor_y', 48);
}

function w2dc_upgrade_to_1_11_5() {
	global $wpdb;

	$wpdb->query("UPDATE {$wpdb->w2dc_content_fields} SET `slug`='categories_list' WHERE `slug`='categories'");
}

function w2dc_upgrade_to_1_11_6() {
	if (($widgets_array = get_option('widget_w2dc_search_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['uid'] = '';
			}
		}
		update_option('widget_w2dc_search_widget', $widgets_array);
	}
	
	add_option('w2dc_hide_author_link', 1);
	
	add_option('w2dc_enable_full_screen', 1);
	add_option('w2dc_enable_wheel_zoom', 1);
	add_option('w2dc_enable_dragging_touchscreens', 1);
	add_option('w2dc_center_map_onclick', 0);
	add_option('w2dc_hide_search_on_map_mobile', 0);
}

function w2dc_upgrade_to_1_11_7() {
	add_option('w2dc_map_language_from_wpml', 0);
}

function w2dc_upgrade_to_1_12_0() {
	add_option('w2dc_enable_draw_panel', 0);
}

function w2dc_upgrade_to_1_12_4() {
	if (($widgets_array = get_option('widget_w2dc_categories_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['related_subcats'] = 0;
			}
		}
		update_option('widget_w2dc_categories_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_w2dc_locations_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['related_sublocations'] = 0;
			}
		}
		update_option('widget_w2dc_locations_widget', $widgets_array);
	}
	
	add_option('w2dc_map_markers_required', 0);
}

function w2dc_upgrade_to_1_12_5() {
	add_option('w2dc_map_markers_is_limit', 1);
}

function w2dc_upgrade_to_1_12_7() {
	add_option('w2dc_address_autocomplete_code', "0");
	add_option('w2dc_show_listings_count', 1);
	add_option('w2dc_custom_contact_email', 1);
	
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->w2dc_locations_relationships}", ARRAY_A);
	foreach ($results AS $row) {
		foreach ($row AS $key=>$value) {
			if ($key != 'post_id' && $key != 'id') {
				$wpdb->insert($wpdb->postmeta, array(
						'post_id' => $row['post_id'],
						'meta_key' => '_'.$key,
						'meta_value' => $value
				));
			}
		}
	}
}

function w2dc_upgrade_to_1_12_8() {
	wp_clear_scheduled_hook('sheduled_events');

	if (!get_option('w2dc_admin_notifications_email'))
		add_option('w2dc_admin_notifications_email', get_option('admin_email'));
}

function w2dc_upgrade_to_1_14_0() {
	global $wpdb;

	add_option('w2dc_force_include_js_css', 0);
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->w2dc_directories} (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`single` varchar(255) NOT NULL,
				`plural` varchar(255) NOT NULL,
				`listing_slug` varchar(255) NOT NULL,
				`category_slug` varchar(255) NOT NULL,
				`location_slug` varchar(255) NOT NULL,
				`tag_slug` varchar(255) NOT NULL,
				`categories` text NOT NULL,
				`locations` text NOT NULL,
				`levels` text NOT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		
	if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_directories} WHERE name = 'Listings'")) {
		$listing_slug = get_option('w2dc_listing_slug');
		$category_slug = get_option('w2dc_category_slug');
		$location_slug = get_option('w2dc_location_slug');
		$tag_slug = get_option('w2dc_tag_slug');

		$wpdb->query("INSERT INTO {$wpdb->w2dc_directories} (`name`, `single`, `plural`, `listing_slug`, `category_slug`, `location_slug`, `tag_slug`, `categories`, `locations`, `levels`) VALUES ('Listings', 'listing', 'listings', $listing_slug, $category_slug, $location_slug, $tag_slug, '', '', '')");
	}
}

function w2dc_upgrade_to_1_14_2() {
	global $wpdb;

	if (!$wpdb->get_var("SELECT id FROM {$wpdb->w2dc_directories} WHERE name = 'Listings'"))
		$wpdb->query("INSERT INTO {$wpdb->w2dc_directories} (`name`, `single`, `plural`, `listing_slug`, `category_slug`, `location_slug`, `tag_slug`, `categories`, `locations`, `levels`) VALUES ('Listings', 'listing', 'listings', 'business-listing', 'business-category', 'business-place', 'business-tag', '', '', '')");
}

function w2dc_upgrade_to_1_14_3() {
	global $wpdb;

	if (($widgets_array = get_option('widget_w2dc_search_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['directory'] = 0;
			}
		}
		update_option('widget_w2dc_search_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_w2dc_categories_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['directory'] = 0;
			}
		}
		update_option('widget_w2dc_categories_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_w2dc_locations_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['directory'] = 0;
			}
		}
		update_option('widget_w2dc_locations_widget', $widgets_array);
	}
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `locations` TEXT NOT NULL AFTER `categories`");
}

function w2dc_upgrade_to_1_14_5() {
	add_option('w2dc_overwrite_page_title', 0);
}

function w2dc_upgrade_to_1_14_7() {
	add_option('w2dc_prevent_users_see_other_media', 1);
	add_option('w2dc_hide_empty_locations', 0);
	add_option('w2dc_hide_empty_categories', 0);
}

function w2dc_upgrade_to_1_14_9() {
	add_option('w2dc_hide_views_counter', 1);
	
	global $w2dc_instance, $wpdb;
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `active_interval` tinyint(1) NOT NULL AFTER `description`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `active_period` varchar(255) NOT NULL AFTER `active_interval`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `eternal_active_period` tinyint(1) NOT NULL AFTER `active_period`");
	
	$array = $wpdb->get_results("SELECT * FROM {$wpdb->w2dc_levels} ORDER BY order_num", ARRAY_A);
	foreach ($array AS $row) {
		$id = w2dc_getValue($row, 'id');
		$active_years = w2dc_getValue($row, 'active_years');
		$active_months = w2dc_getValue($row, 'active_months');
		$active_days = w2dc_getValue($row, 'active_days');
		
		$interval = '';
		$period = '';
		$eternal = 1;
		if ($active_years || $active_months || $active_days) {
			$eternal = 0;

			if ($active_years) {
				$interval = ($active_years > 6) ? 6: $active_years;
				$period = 'year';
			} elseif ($active_months) {
				$interval = ($active_months > 6) ? 6: $active_months;
				$period = 'month';
			} elseif ($active_days) {
				if ($active_days == 7) {
					$interval = 1;
					$period = 'week';
				} else {
					$interval = ($active_days > 6) ? 6: $active_days;
					$period = 'day';
				}
			}
		}

		$wpdb->query($wpdb->prepare("UPDATE {$wpdb->w2dc_levels} SET `active_interval`=%d, `active_period`=%d, `eternal_active_period`=%d WHERE `id`=%d", $interval, $period, $eternal, $id));
	}
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} DROP `active_years`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} DROP `active_months`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} DROP `active_days`");
}

function w2dc_upgrade_to_1_14_11() {
	add_option('w2dc_listing_logo_bg_mode', 'cover');
	add_option('w2dc_search_bg_opacity', 100);
	add_option('w2dc_search_overlay', 1);
	
	global $wpdb;
	$locations_field = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'locations'", ARRAY_A);
	if (empty($locations_field)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `locations` TEXT NOT NULL AFTER `categories`");
	}
}

function w2dc_upgrade_to_1_14_15() {
	global $wpdb;

	$listings = $wpdb->get_results("
			SELECT ID FROM {$wpdb->posts} AS wp_posts
			LEFT JOIN {$wpdb->postmeta} AS mt1 ON (wp_posts.ID = mt1.post_id AND mt1.meta_key = '_directory_id' )
			WHERE
			wp_posts.post_type = 'w2dc_listing' AND
			mt1.post_id IS NULL
	", ARRAY_A);
	
	foreach ($listings AS $row) {
		add_post_meta($row['ID'], '_directory_id', 1);
	}
}

function w2dc_upgrade_to_2_0_0() {
	global $wpdb;

	add_option('w2dc_categories_search_nesting_level', 1);
	add_option('w2dc_locations_search_nesting_level', 2);
	add_option('w2dc_search_bg_color', get_option('w2dc_search_1_color'));
	add_option('w2dc_secondary_color', '#428BCA');
	update_option('w2dc_logo_animation_effect', 1);
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `listings_in_package` INT(11) NOT NULL DEFAULT '1' AFTER `eternal_active_period`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `change_level_id` INT(11) NOT NULL DEFAULT '0' AFTER `eternal_active_period`");
	
	add_option('w2dc_enable_geolocation', 0);
	add_option('w2dc_start_zoom', 0);
	
	if (get_option('w2dc_fsubmit_default_status') == 1 || get_option('w2dc_fsubmit_default_status') == 2) {
		update_option('w2dc_fsubmit_moderation', 1);
	}
	if (get_option('w2dc_fsubmit_default_status') == 3) {
		update_option('w2dc_fsubmit_moderation', 0);
	}

	if (get_option('w2dc_fsubmit_edit_status') == 1 || get_option('w2dc_fsubmit_edit_status') == 2) {
		update_option('w2dc_fsubmit_edit_moderation', 1);
	}
	if (get_option('w2dc_fsubmit_edit_status') == 3) {
		update_option('w2dc_fsubmit_edit_moderation', 0);
	}
}

function w2dc_upgrade_to_2_0_5() {
	global $wpdb;

	$posts_ids = $wpdb->get_col("
				SELECT
					wp_pm.post_id
				FROM
					{$wpdb->postmeta} AS wp_pm
				WHERE
					wp_pm.meta_key = '_listing_status' AND
					wp_pm.meta_value != 'active'
			");

	foreach ($posts_ids AS $listing_id) {
		wp_update_post(array('ID' => $listing_id, 'post_status' => 'pending'));
	}
}

function w2dc_upgrade_to_2_0_6() {
	global $wpdb;
	
	$listings_in_package = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'listings_in_package'", ARRAY_A);
	if (empty($listings_in_package)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `listings_in_package` INT(11) NOT NULL DEFAULT '1' AFTER `eternal_active_period`");
	}
	
	$change_level_id = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'change_level_id'", ARRAY_A);
	if (empty($change_level_id)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `change_level_id` INT(11) NOT NULL DEFAULT '0' AFTER `eternal_active_period`");
	}
}

function w2dc_upgrade_to_2_0_8() {
	add_option('w2dc_listing_title_mode', 'inside');
}

function w2dc_upgrade_to_2_0_10() {
	add_option('w2dc_listing_title_mode', 'inside');
}

function w2dc_upgrade_to_2_0_15() {
	add_option('w2dc_keywords_ajax_search', 1);
	add_option('w2dc_keywords_search_examples', 'sport, business');
}

function w2dc_upgrade_to_2_1_2() {
	add_option('w2dc_map_markers_required', get_option('w2dc_google_maps_required', 0));
}

function w2dc_upgrade_to_2_1_3() {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} CHANGE `google_map` `map` TINYINT(1) NOT NULL, CHANGE `google_map_markers` `map_markers` TINYINT(1) NOT NULL;");
}

function w2dc_upgrade_to_2_1_5() {
	add_option('w2dc_map_type', 'none');
	add_option('w2dc_google_map_style', get_option('w2dc_map_style'));
	add_option('w2dc_mapbox_map_style', 'mapbox://styles/mapbox/streets-v10');
	add_option('w2dc_mapbox_api_key', '');
}

function w2dc_upgrade_to_2_2_1() {
	global $w2dc_instance, $wpdb;
	foreach ($w2dc_instance->content_fields->content_fields_array AS $content_field) {
		if ($content_field->type == 'datetime') {
			$dates = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE `meta_key` = '_content_field_{$content_field->id}_date'", ARRAY_A);
			foreach ($dates AS $date_row) {
				$wpdb->update($wpdb->postmeta, array('meta_key' => '_content_field_' . $content_field->id . '_date_start'), array('meta_id' => $date_row['meta_id']));
				$wpdb->insert($wpdb->postmeta, array('post_id' => $date_row['post_id'], 'meta_key' => '_content_field_' . $content_field->id . '_date_end', 'meta_value' => $date_row['meta_value']));
			}
		}
	}
}

function w2dc_upgrade_to_2_2_3() {
	add_option('w2dc_mapbox_map_style_custom', '');
	
	update_option('w2dc_mapbox_map_style', 'mapbox://styles/mapbox/' . str_replace('mapbox://styles/mapbox/', '', get_option('w2dc_mapbox_map_style')));
	
	update_option('w2dc_ajax_initial_load', 0);
}

function w2dc_upgrade_to_2_2_4() {
	add_option('w2dc_mobile_listings_grid_columns', 1);
}

function w2dc_upgrade_to_2_2_5() {
	global $wpdb;

	$for_admin_only = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_content_fields} LIKE 'for_admin_only'", ARRAY_A);
	if (empty($for_admin_only)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_content_fields} ADD `for_admin_only` TINYINT(1) NOT NULL AFTER `is_hide_name`");
	}
}

function w2dc_upgrade_to_2_2_6() {
	add_option('w2dc_sticky_label', "Sticky");
	add_option('w2dc_featured_label', "Featured");
}

function w2dc_upgrade_to_2_2_8() {
	add_option('w2dc_hide_anonymous_contact_form', 0);
}

function w2dc_upgrade_to_2_3_0() {
	add_option('w2dc_report_form', 1);
	
	$listings_tabs = get_option('w2dc_listings_tabs_order');
	$listings_tabs[] = 'report-tab';
	update_option('w2dc_listings_tabs_order', $listings_tabs);
	
	$vpt_option = get_option('vpt_option');
	$vpt_option['w2dc_listings_tabs_order'][] = 'report-tab';
	update_option('vpt_option', $vpt_option);
}

function w2dc_upgrade_to_2_5_0() {
	global $w2dc_instance, $wpdb;
	
	foreach ($w2dc_instance->content_fields->content_fields_array AS $content_field) {
		if ($content_field->type == 'string') {
			if (!empty($content_field->options['is_phone'])) {
				unset($content_field->options['is_phone']);
				$content_field->options['phone_mode'] = 'phone';
				$wpdb->update($wpdb->w2dc_content_fields, array('type' => 'phone', 'options' => $content_field->options), array('id' => $content_field->id));
			}
		}
	}
	
	add_option('w2dc_pdf_page_orientation', 'portrait');
}

function w2dc_upgrade_to_2_5_2() {
	if (get_option('w2dc_enable_lighbox_gallery')) {
		add_option('w2dc_enable_lightbox_gallery', get_option('w2dc_enable_lighbox_gallery'));
	}
}

function w2dc_upgrade_to_2_5_7() {
	update_option('w2dc_payments_free_for_admins', 0);
}

function w2dc_upgrade_to_2_5_8() {
	add_option('w2dc_map_marker_size', '40');
}

function w2dc_upgrade_to_2_5_12() {
	add_option('w2dc_single_logo_height', 0);
}

function w2dc_upgrade_to_2_5_13() {
	add_option('w2dc_map_on_single', 1);
}

function w2dc_upgrade_to_2_5_14() {
	add_option('w2dc_hide_listing_title', 0);
}

function w2dc_upgrade_to_2_5_19() {
	global $wpdb;
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `tags_number` int(11) NOT NULL DEFAULT '0' AFTER `unlimited_categories`");
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `unlimited_tags` tinyint(1) NOT NULL DEFAULT 1 AFTER `tags_number`");
}

function w2dc_upgrade_to_2_6_0() {
	global $wpdb;
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `user_roles` text NOT NULL AFTER `description`");
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_locations_levels} ADD `allow_add_term` tinyint(1) NOT NULL DEFAULT 1 AFTER `in_address_line`");
}

function w2dc_upgrade_to_2_6_4() {
	add_action('init', 'w2dc_updateAllTermsCount');
}

function w2dc_upgrade_to_2_6_7() {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} CHANGE `user_roles` `who_can_view` text");
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `who_can_submit` text NOT NULL AFTER `who_can_view`");
}

function w2dc_upgrade_to_2_6_8() {
	add_option('w2dc_enable_html_description', 1);
}

function w2dc_upgrade_to_2_6_9() {
	add_action('init', 'w2dc_updateAllTermsCount');
}

function w2dc_upgrade_to_2_6_10() {
	add_option('w2dc_recaptcha_version', 'v3');
}

function w2dc_upgrade_to_2_6_11() {
	global $wpdb;
	
	$who_can_view = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'who_can_view'", ARRAY_A);
	if (empty($who_can_view)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `who_can_view` text NOT NULL AFTER `description`");
	}
	
	$who_can_submit = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'who_can_submit'", ARRAY_A);
	if (empty($who_can_submit)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `who_can_submit` text NOT NULL AFTER `who_can_view`");
	}
	
	$tags_number = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'tags_number'", ARRAY_A);
	if (empty($tags_number)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `tags_number` int(11) NOT NULL DEFAULT '0' AFTER `unlimited_categories`");
	}
	
	$unlimited_tags = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->w2dc_levels} LIKE 'unlimited_tags'", ARRAY_A);
	if (empty($unlimited_tags)) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `unlimited_tags` tinyint(1) NOT NULL DEFAULT 1 AFTER `tags_number`");
	}
	
	add_action('init', 'w2dc_updateAllTermsCount');
}

function w2dc_upgrade_to_2_6_13() {
	if (get_option("w2dc_woocommerce_produts_created")) {
		add_option("w2dc_woocommerce_products_created", true);
	}
}

function w2dc_upgrade_to_2_7_1() {
	flush_rewrite_rules();
}

function w2dc_upgrade_to_2_7_3() {
	add_option("w2dc_hide_search_button", 0);
	add_option("w2dc_auto_scroll_on_search", 1);
}

function w2dc_upgrade_to_2_7_5() {
	update_option("w2dc_hide_search_button", 0);
	
	if (get_option('w2dc_installed_plugin_time') < strtotime('10-03-2021')) {
		$default_mode = 1;
	} else {
		$default_mode = 0;
	}
	
	update_option("w2dc_imitate_mode", $default_mode);
	
	$vpt_option = get_option('vpt_option');
	$vpt_option['w2dc_imitate_mode'] = $default_mode;
	update_option('vpt_option', $vpt_option);
}


function w2dc_install_create_search_forms() {
	
	// create default search form
	$post_id = wp_insert_post(array(
			'post_type' => WCSEARCH_FORM_TYPE,
			'post_title' => "Default",
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
	));
	$default_form = array(
			'_model' => '{\"placeholders\":[{\"columns\":1,\"rows\":1,\"input\":{\"type\":\"tax\",\"slug\":\"categories\",\"tax\":\"w2dc-category\",\"placeholder\":\"Categories search\",\"dependency_visibility\":1,\"values\":\"\",\"dependency_tax\":0,\"exact_terms\":\"\",\"counter\":1,\"hide_empty\":1,\"order\":\"ASC\",\"orderby\":\"menu_order\",\"use_pointer\":0,\"text_close\":\"hide\",\"text_open\":\"show all\",\"how_to_limit\":\"show_more_less\",\"height_limit\":222,\"columns\":3,\"open_on_click\":1,\"depth\":2,\"relation\":\"OR\",\"mode\":\"dropdown_keywords\",\"visible_status\":\"always_opened\",\"title\":\"\",\"used_by\":\"w2dc\"}},{\"columns\":1,\"rows\":1,\"input\":{\"type\":\"tax\",\"slug\":\"locations\",\"tax\":\"w2dc-location\",\"placeholder\":\"Locations search\",\"title\":\"\",\"visible_status\":\"always_opened\",\"mode\":\"dropdown_address\",\"relation\":\"OR\",\"depth\":2,\"open_on_click\":1,\"columns\":2,\"height_limit\":280,\"how_to_limit\":\"show_more_less\",\"text_open\":\"show all\",\"text_close\":\"hide\",\"use_pointer\":0,\"orderby\":\"menu_order\",\"order\":\"ASC\",\"hide_empty\":0,\"counter\":1,\"is_exact_terms\":0,\"dependency_tax\":0,\"dependency_visibility\":1,\"values\":\"\",\"used_by\":\"w2dc\"}},{\"columns\":2,\"rows\":1,\"input\":{\"type\":\"radius\",\"slug\":\"radius\",\"dependency_visibility\":1,\"title\":\"\",\"visible_status\":\"always_opened\",\"show_scale\":\"string\",\"min_max_options\":\"0-30\",\"dependency_tax\":0,\"tax\":\"\",\"values\":\"10\",\"used_by\":\"w2dc\",\"odd_even_labels\":\"odd\"}},{\"columns\":1,\"rows\":1,\"input\":\"\"},{\"columns\":1,\"rows\":1,\"input\":{\"type\":\"button\",\"slug\":\"submit\",\"used_by\":\"w2dc\",\"values\":\"\",\"tax\":\"\",\"text\":\"Search\"}}]}',
			'_columns_num' => '2',
			'_bg_color' => (get_option("w2dc_search_bg_color") ? get_option("w2dc_search_bg_color") : ""),
			'_bg_transparency' => (get_option("w2dc_search_bg_opacity") ? get_option("w2dc_search_bg_opacity") : "100"),
			'_text_color' => (get_option("w2dc_search_text_color") ? get_option("w2dc_search_text_color") : "#666666"),
			'_elements_color' => '#428BCA',
			'_elements_color_secondary' => '#275379',
			'_use_overlay' => (get_option("w2dc_search_overlay") ? 1 : 0),
			'_on_shop_page' => '',
			'_auto_submit' => '1',
			'_use_border' => '0',
			'_scroll_to' => (get_option("w2dc_auto_scroll_on_search") ? 'products' : ''),
			'_sticky_scroll' => '',
			'_sticky_scroll_toppadding' => '',
			'_use_ajax' => '1',
			'_target_url' => '',
			'_used_by' => 'w2dc',
	);
	foreach ($default_form AS $field_name=>$field_value) {
		update_post_meta($post_id, $field_name, $field_value);
	}
	add_option("w2dc_search_form_id", $post_id);
	add_option('w2dc_main_search', 1);
	$vpt_option = get_option('vpt_option');
	$vpt_option['w2dc_search_form_id'] = $post_id;
	$vpt_option['w2dc_main_search'] = 1;
	update_option('vpt_option', $vpt_option);
	
	// create default search form on Map
	$post_id_map = wp_insert_post(array(
			'post_type' => WCSEARCH_FORM_TYPE,
			'post_title' => "Default Map",
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
	));
	$default_map_form = array(
			'_model' => '{\"placeholders\":[{\"columns\":2,\"rows\":1,\"input\":{\"type\":\"tax\",\"slug\":\"categories\",\"tax\":\"w2dc-category\",\"placeholder\":\"Categories search\",\"used_by\":\"w2dc\",\"title\":\"\",\"visible_status\":\"always_opened\",\"mode\":\"dropdown_keywords\",\"relation\":\"OR\",\"depth\":2,\"open_on_click\":1,\"columns\":3,\"height_limit\":222,\"how_to_limit\":\"show_more_less\",\"text_open\":\"show all\",\"text_close\":\"hide\",\"use_pointer\":0,\"orderby\":\"menu_order\",\"order\":\"ASC\",\"hide_empty\":1,\"counter\":1,\"exact_terms\":\"\",\"dependency_tax\":0,\"values\":\"\",\"dependency_visibility\":1}},{\"columns\":2,\"rows\":2,\"input\":{\"type\":\"tax\",\"slug\":\"locations\",\"tax\":\"w2dc-location\",\"placeholder\":\"Locations search\",\"used_by\":\"w2dc\",\"values\":\"\",\"dependency_visibility\":1,\"dependency_tax\":0,\"is_exact_terms\":0,\"counter\":1,\"hide_empty\":0,\"order\":\"ASC\",\"orderby\":\"menu_order\",\"use_pointer\":0,\"text_close\":\"hide\",\"text_open\":\"show all\",\"how_to_limit\":\"show_more_less\",\"height_limit\":280,\"columns\":2,\"open_on_click\":1,\"depth\":2,\"relation\":\"OR\",\"mode\":\"dropdown_address\",\"visible_status\":\"always_opened\",\"title\":\"\"}},{\"columns\":2,\"rows\":1,\"input\":{\"type\":\"radius\",\"slug\":\"radius\",\"odd_even_labels\":\"odd\",\"used_by\":\"w2dc\",\"values\":\"10\",\"tax\":\"\",\"dependency_tax\":0,\"min_max_options\":\"0-30\",\"show_scale\":\"string\",\"visible_status\":\"always_opened\",\"title\":\"\",\"dependency_visibility\":1}},{\"columns\":1,\"rows\":1,\"input\":{\"type\":\"button\",\"slug\":\"submit\",\"used_by\":\"w2dc\",\"text\":\"Search\",\"title\":\"Search button\"}},{\"columns\":1,\"rows\":1,\"input\":{\"type\":\"reset\",\"slug\":\"reset\",\"used_by\":\"w2dc\",\"text\":\"Reset\",\"title\":\"Reset button\"}}]}',
			'_columns_num' => '2',
			'_bg_color' => '',
			'_bg_transparency' => '100',
			'_text_color' => '#666666',
			'_elements_color' => '#428BCA',
			'_elements_color_secondary' => '#275379',
			'_use_overlay' => '',
			'_on_shop_page' => '',
			'_auto_submit' => '1',
			'_use_border' => '',
			'_scroll_to' => '',
			'_sticky_scroll' => '',
			'_sticky_scroll_toppadding' => '',
			'_use_ajax' => '1',
			'_target_url' => '',
			'_used_by' => 'w2dc',
	);
	foreach ($default_map_form AS $field_name=>$field_value) {
		update_post_meta($post_id_map, $field_name, $field_value);
	}
	add_option("w2dc_search_map_form_id", $post_id_map);
	$vpt_option = get_option('vpt_option');
	$vpt_option['w2dc_search_map_form_id'] = $post_id_map;
	update_option('vpt_option', $vpt_option);
}

function w2dc_upgrade_to_2_8_0() {
	global $wpdb;
	
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_locations_relationships} ADD `place_id` varchar(45) NOT NULL AFTER `location_id`, ADD INDEX (`place_id`)");
	
	w2dc_install_create_search_forms();
	
	add_option('w2dc_hide_listing_title', 0);
	
	add_option('w2dc_categories_order', 'default');
	add_option('w2dc_locations_order', 'default');
}

function w2dc_upgrade_to_2_8_2() {
	add_option("w2dc_terms_links_color", "#FFFFFF");
	add_option("w2dc_terms_links_hover_color", "#FFFFFF");
	add_option("w2dc_terms_heading_bg_color", "#979797");
	add_option("w2dc_terms_bg_color", "#cacaca");
}

function w2dc_upgrade_to_2_9_0() {
	global $wpdb;
	
	$search_fields = w2dc_get_search_fields();
	
	$hours_fields = array();
	foreach ($search_fields AS $search_field) {
		if ($search_field->content_field->type == 'hours') {
			$hours_fields[] = $search_field->content_field;
		}
	}
	
	foreach ($hours_fields AS $hours_field) {
		$results = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE `meta_key` = '_content_field_{$hours_field->id}'", ARRAY_A);
	
		foreach ($results AS $row) {
			$wpdb->delete($wpdb->postmeta, array('meta_id' => $row['meta_id']));
			
			if ($row['meta_value']) {
				$meta_value = unserialize($row['meta_value']);
				foreach ($meta_value AS $key=>$value) {
					add_post_meta($row['post_id'], $row['meta_key'], array($key => $value));
				}
			}
		}
	}
	
	add_option("w2dc_zip_or_postal_text", "zip");
}

function w2dc_upgrade_to_2_9_4() {
	w2dc_update_scheduled_events_time();
}

function w2dc_upgrade_to_2_9_16() {
	add_option('w2dc_map_min_zoom', 0);
	add_option('w2dc_map_max_zoom', 0);
}

function w2dc_upgrade_to_2_9_17() {
	add_option('w2dc_images_submit_required', 0);
}

?>