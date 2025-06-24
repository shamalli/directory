<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_map_widget_params;
	$w2dc_map_widget_params = array(
			array(
					'type' => 'dropdown',
					'param_name' => 'custom_home',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Is it on custom home page?', 'w2dc'),
			),
			array(
					'type' => 'directories',
					'param_name' => 'directories',
					'heading' => esc_html__("Listings of these directories", "w2dc"),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'map_markers_is_limit',
					'value' => array(esc_html__('The only map markers of visible listings will be displayed (when listings shortcode is connected with map by unique string)', 'w2dc') => '1', esc_html__('Display all map markers', 'w2dc') => '0'),
					'heading' => esc_html__('How many map markers to display on the map', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'value' => '',
					'heading' => esc_html__('uID. Enter unique string to connect this shortcode with another shortcodes', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'draw_panel',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Enable Draw Panel', 'w2dc'),
					'description' => esc_html__('Very important: MySQL version must be 5.6.1 and higher or MySQL server variable "thread stack" must be 256K and higher. Ask your hoster about it if "Draw Area" does not work.', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'num',
					'value' => 10,
					'heading' => esc_html__('Number of markers', 'w2dc'),
					'description' => esc_html__('Number of markers to display on map (-1 gives all markers)', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'width',
					'heading' => esc_html__('Width', 'w2dc'),
					'description' => esc_html__('Set map width in pixels. With empty field the map will take all possible width.', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'height',
					'value' => 400,
					'heading' => esc_html__('Height', 'w2dc'),
					'description' => esc_html__('Set map height in pixels, also possible to set 100% value', 'w2dc'),
			),
			array(
					'type' => 'mapstyle',
					'param_name' => 'map_style',
					'heading' => esc_html__('Maps style', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_scroll',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Make map to be sticky on scroll', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'sticky_scroll_toppadding',
					'value' => 0,
					'heading' => esc_html__('Sticky scroll top padding', 'w2dc'),
					'description' => esc_html__('Top padding in pixels', 'w2dc'),
					'dependency' => array('element' => 'sticky_scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_summary_button',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show summary button', 'w2dc'),
					'description' => esc_html__('Show summary button in InfoWindow', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_readmore_button',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show readmore button', 'w2dc'),
					'description' => esc_html__('Show read more button in InfoWindow', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'geolocation',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('GeoLocation', 'w2dc'),
					'description' => esc_html__('Geolocate user and center map', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'ajax_map_loading',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('AJAX loading', 'w2dc'),
					'description' => esc_html__('When map contains lots of markers - this may slow down map markers loading. Select AJAX to speed up loading. Requires Starting Address or Starting Point coordinates Latitude and Longitude.', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'ajax_markers_loading',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Maps info window AJAX loading', 'w2dc'),
					'description' => esc_html__('This may additionaly speed up loading', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'start_address',
					'heading' => esc_html__('Starting Address', 'w2dc'),
					'description' => esc_html__('When map markers load by AJAX - it should have starting point and starting zoom. Enter start address or select latitude and longitude (recommended). Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'start_latitude',
					'heading' => esc_html__('Starting Point Latitude', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'start_longitude',
					'heading' => esc_html__('Starting Point Longitude', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'start_zoom',
					'heading' => esc_html__('Default zoom', 'w2dc'),
					'value' => array(esc_html__("Auto", "w2dc") => '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'),
					'std' => '0',
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'min_zoom',
					'heading' => esc_html__('Min zoom', 'w2dc'),
					'value' => array(esc_html__("Auto", "w2dc") => '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'),
					'std' => '0',
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'max_zoom',
					'heading' => esc_html__('Max zoom', 'w2dc'),
					'value' => array(esc_html__("Auto", "w2dc") => '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'),
					'std' => '0',
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show markers only of sticky or/and featured listings', 'w2dc'),
					'description' => esc_html__('Whether to show markers only of sticky or/and featured listings', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'search_on_map',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show search form and listings sidebar on the map', 'w2dc'),
			),
			array(
					'type' => 'formid',
					'param_name' => 'search_on_map_id',
					'heading' => esc_html__('Select search form', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'search_on_map_open',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Search form open by default', 'w2dc'),
					'dependency' => array('element' => 'search_on_map', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'search_on_map_right',
					'value' => array(esc_html__('Left', 'w2dc') => '0', esc_html__('Right', 'w2dc') => '1'),
					'heading' => esc_html__('Show search form at the sidebar', 'w2dc'),
					'dependency' => array('element' => 'search_on_map', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'search_on_map_listings',
					'value' => array(
							esc_html__('In sidebar', 'w2dc') => 'sidebar',
							esc_html__('At the bottom', 'w2dc') => 'bottom',
					),
					'heading' => esc_html__('Show listings', 'w2dc'),
					'dependency' => array('element' => 'search_on_map', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'radius_circle',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show radius circle', 'w2dc'),
					'description' => esc_html__('Display radius circle on map when radius filter provided', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'clusters',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Group map markers in clusters', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'enable_full_screen',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Enable full screen button', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'enable_wheel_zoom',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Enable zoom by mouse wheel', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'enable_dragging_touchscreens',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Enable map dragging on touch screen devices', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'center_map_onclick',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Center map on marker click', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => esc_html__('Author', 'w2dc'),
					'description' => esc_html__('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_categories',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Use related categories', 'w2dc'),
					'description' => esc_html__('Parameter works only on listings and categories pages', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					'heading' => esc_html__('Select listings categories to display on map', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_locations',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Use related locations.', 'w2dc'),
					'description' => esc_html__('Parameter works only on listings and locations pages', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					'heading' => esc_html__('Select listings locations to display on map', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_tags',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Use related tags', 'w2dc'),
					'description' => esc_html__('Parameter works only on listings and tags pages', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
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
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => esc_html__('Exact listings', 'w2dc'),
					'description' => esc_html__('Comma separated string of listings IDs. Possible to display exact listings.', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
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
}, 0);

class w2dc_map_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_map_widget_params;

		parent::__construct(
				'w2dc_map_widget',
				esc_html__('Directory widget - Map', 'w2dc')
		);

		foreach ($w2dc_instance->content_fields->content_fields_array AS $filter_field) {
			if (method_exists($filter_field, 'getWidgetParams') && ($field_params = $filter_field->getWidgetParams())) {
				$w2dc_map_widget_params = array_merge($w2dc_map_widget_params, $field_params);
			}
		}

		$this->convertParams($w2dc_map_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
	
			$title = apply_filters('widget_title', $instance['title']);
	
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-map-widget">';
			$controller = new w2dc_map_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>