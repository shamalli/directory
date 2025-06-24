<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_slider_widget_params;
	$w2dc_slider_widget_params = array(
			array(
					'type' => 'textfield',
					'param_name' => 'slides',
					'value' => 3,
					'heading' => esc_html__('Maximum number of slides', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'width',
					'value' => 0,
					'heading' => esc_html__('Width of slider in pixels', 'w2dc'),
					'description' => esc_html__('Set to 0 to fit full width', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'height',
					'value' => 0,
					'heading' => esc_html__('Height of slider in pixels', 'w2dc'),
					'description' => esc_html__('Set to 0 to fit full height', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'slide_width',
					'value' => 0,
					'heading' => esc_html__('Maximum width of one slide in pixels', 'w2dc'),
					'description' => esc_html__('Works when max slider greater than 1', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'max_slides',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'),
					'heading' => esc_html__('Maximum slides in viewport divided by slide width', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'captions',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Enable listing names', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'pager',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Enable thumbnails below', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'crop',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Do crop images gallery', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'auto_slides',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Enable automatic rotating slideshow', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'auto_slides_delay',
					'value' => 3000,
					'heading' => esc_html__('The delay in rotation (in ms)', 'w2dc'),
					'dependency' => array('element' => 'auto_slides', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show only sticky or/and featured listings', 'w2dc'),
					'description' => esc_html__('Whether to show only sticky or/and featured listings', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order_by_rand',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Order listings randomly', 'w2dc'),
			),
			array(
					'type' => 'ordering',
					'param_name' => 'order_by',
					'heading' => esc_html__('Order by', 'w2dc'),
					'description' => esc_html__('Order listings by any of these parameter', 'w2dc'),
					'dependency' => array('element' => 'order_by_rand', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order',
					'value' => array(esc_html__('Ascending', 'w2dc') => 'ASC', esc_html__('Descending', 'w2dc') => 'DESC'),
					'description' => esc_html__('Direction of sorting.', 'w2dc'),
					'dependency' => array('element' => 'order_by_rand', 'value' => '0'),
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
}, 0);

class w2dc_slider_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_slider_widget_params;

		parent::__construct(
				'w2dc_slider_widget',
				esc_html__('Directory widget - Slider', 'w2dc')
		);

		foreach ($w2dc_instance->content_fields->content_fields_array AS $filter_field) {
			if (method_exists($filter_field, 'getWidgetParams') && ($field_params = $filter_field->getWidgetParams())) {
				$w2dc_slider_widget_params = array_merge($w2dc_slider_widget_params, $field_params);
			}
		}

		$this->convertParams($w2dc_slider_widget_params);
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
			echo '<div class="w2dc-content w2dc-widget w2dc-slider-widget">';
			$controller = new w2dc_slider_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>