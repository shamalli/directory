<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_listings_widget_params;
	$w2dc_listings_widget_params = array(
			array(
					'type' => 'directories',
					'param_name' => 'directories',
					'heading' => esc_html__("Listings of these directories", "w2dc"),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'value' => '',
					'heading' => esc_html__('uID. Enter unique string to connect this shortcode with another shortcodes', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'onepage',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show all possible listings on one page', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'perpage',
					'value' => 10,
					'heading' => esc_html__('Number of listing per page', 'w2dc'),
					'description' => esc_html__('Number of listings to display per page. Set -1 to display all listings without paginator', 'w2dc'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_listings',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide listings', 'w2dc'),
					'description' => esc_html__('Hide listings by default, they will appear after search.', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_paginator',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide paginator', 'w2dc'),
					'description' => esc_html__('When paginator is hidden - it will display only exact number of listings', 'w2dc'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scrolling_paginator',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Load next set of listing on scroll', 'w2dc'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
					'description' => esc_html__('Works when "Show More Listings" button enabled', 'w2dc')
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show only sticky or/and featured listings', 'w2dc'),
					'description' => esc_html__('Whether to show only sticky or/and featured listings', 'w2dc'),
			),
			array(
					'type' => 'ordering',
					'param_name' => 'order_by',
					'heading' => esc_html__('Order by', 'w2dc'),
					'description' => esc_html__('Order listings by any of these parameter', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order',
					'heading' => esc_html__('Order by direction', 'w2dc'),
					'value' => array(esc_html__('Ascending', 'w2dc') => 'ASC', esc_html__('Descending', 'w2dc') => 'DESC'),
					'std' => 'DESC',
					'description' => esc_html__('Direction of sorting.', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_order',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide ordering links', 'w2dc'),
					'description' => esc_html__('Whether to hide ordering navigation links', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_count',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide number of listings', 'w2dc'),
					'description' => esc_html__('Whether to hide number of found listings', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_views_switcher',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show listings views switcher', 'w2dc'),
					'description' => esc_html__('Whether to show listings views switcher', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_type',
					'value' => array(
							esc_html__('- Default -', 'w2dc') => 'default',
							esc_html__('List', 'w2dc') => 'list',
							esc_html__('Grid', 'w2dc') => 'grid'
					),
					'heading' => esc_html__('Listings view by default', 'w2dc'),
					'description' => esc_html__('Do not forget that selected view will be stored in cookies', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_grid_columns',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
					'heading' => esc_html__('Number of columns for listings Grid View', 'w2dc'),
					'std' => '2',
					'dependency' => array('element' => 'listings_view_type', 'value' => 'grid'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'listing_thumb_width',
					'heading' => esc_html__('Listing thumbnail logo width in List View', 'w2dc'),
					'value' => 300,
					'description' => esc_html__('in pixels', 'w2dc'),
					'dependency' => array('element' => 'listings_view_type', 'value' => 'list'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'wrap_logo_list_view',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Wrap logo image by text content in List View', 'w2dc'),
					'dependency' => array('element' => 'listings_view_type', 'value' => 'list'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'grid_view_logo_ratio',
					'value' => array(
							esc_html__('1:1 (square)', 'w2dc') => '100',
							esc_html__('4:3', 'w2dc') => '75',
							esc_html__('16:9', 'w2dc') => '56.25',
							esc_html__('2:1', 'w2dc') => '50'
					),
					'heading' => esc_html__('Aspect ratio of logo in Grid View', 'w2dc'),
					'std' => '75',
					'dependency' => array('element' => 'listings_view_type', 'value' => 'grid'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'logo_animation_effect',
					'value' => array(
							esc_html__('- Default -', 'w2dc') => 'default',
							esc_html__('Disabled', 'w2dc') => '0',
							esc_html__('Enabled', 'w2dc') => '1'
					),
					'heading' => esc_html__('Thumbnail animation hover effect', 'w2dc'),
					'std' => 'default',
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_content',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide content fields data', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'rating_stars',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show rating stars', 'w2dc'),
					'description' => esc_html__('When ratings addon enabled', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'summary_on_logo_hover',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Summary text on logo hover', 'w2dc'),
					'dependency' => array('element' => 'hide_content', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'carousel',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Carousel slider', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'carousel_show_slides',
					'value' => 4,
					'heading' => esc_html__('Slides to show', 'w2dc'),
					'dependency' => array('element' => 'carousel', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'carousel_slide_width',
					'value' => 250,
					'heading' => esc_html__('Slide width, in pixels', 'w2dc'),
					'dependency' => array('element' => 'carousel', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'carousel_slide_height',
					'value' => 300,
					'heading' => esc_html__('Slide height, in pixels', 'w2dc'),
					'dependency' => array('element' => 'carousel', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'carousel_full_width',
					'heading' => esc_html__('Carousel width, in pixels. With empty field carousel will take all possible width.', 'w2dc'),
					'dependency' => array('element' => 'carousel', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'address',
					'heading' => esc_html__('Address', 'w2dc'),
					'description' => esc_html__('Display listings near this address, recommended to set default radius', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'radius',
					'heading' => esc_html__('Radius', 'w2dc'),
					'description' => esc_html__('Display listings near provided address within this radius in miles or kilometers', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => esc_html__('Author', 'w2dc'),
					'description' => esc_html__('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_categories',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Use related categories', 'w2dc'),
					'description' => esc_html__('Parameter works only on listings and categories pages', 'w2dc'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					'heading' => esc_html__('Select certain categories', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_locations',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Use related locations', 'w2dc'),
					'description' => esc_html__('Parameter works only on listings and locations pages', 'w2dc'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					'heading' => esc_html__('Select certain locations', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_tags',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Use related tags', 'w2dc'),
					'description' => esc_html__('Parameter works only on listings and tags pages', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'include_categories_children',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Include children of selected categories and locations', 'w2dc'),
					'description' => esc_html__('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'levels',
					'param_name' => 'levels',
					'heading' => esc_html__('Listings levels', 'w2dc'),
					'description' => esc_html__('Categories may be dependent from listings levels', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => esc_html__('Exact listings', 'w2dc'),
					'description' => esc_html__('Comma separated string of listings IDs. Possible to display exact listings.', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'start_listings',
					'heading' => esc_html__('Start listings', 'w2dc'),
					'description' => esc_html__('Comma separated string of listings IDs. Display these listings by default, then directory searches as usual.', 'w2dc'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'visibility',
					'heading' => esc_html__("Show only on directory pages", "w2dc"),
					'value' => 0,
					'description' => esc_html__("Otherwise it will load plugin's files on all pages", "w2dc"),
			),
	);
}, -1); // -1 priority, init before directory params, as it needs in classes/widgets/directory.php

class w2dc_listings_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_listings_widget_params;

		parent::__construct(
				'w2dc_listings_shortcode_widget',
				esc_html__('Directory widget - Listings', 'w2dc')
		);

		foreach ($w2dc_instance->content_fields->content_fields_array AS $filter_field) {
			if (method_exists($filter_field, 'getWidgetParams') && ($field_params = $filter_field->getWidgetParams())) {
				$w2dc_listings_widget_params = array_merge($w2dc_listings_widget_params, $field_params);
			}
		}

		$this->convertParams($w2dc_listings_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
			if (isset($instance['title'])) {
				$title = apply_filters('widget_title', $instance['title']);
			}
			
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-listings-widget">';
			$controller = new w2dc_listings_controller();
			$controller->init($instance);
			
			// add frontend controller to get compatibility by uID parameter with maps controller
			$w2dc_instance->frontend_controllers['webdirectory-listings'][] = $controller;
			
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>