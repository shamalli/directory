<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_locations_sidebar_widget_params;
	$w2dc_locations_sidebar_widget_params = array(
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => esc_html__("Locations links will redirect to selected directory", "w2dc"),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'parent',
					'heading' => esc_html__('Parent location', 'w2dc'),
					'description' => esc_html__('ID of parent location (default 0 – this will build whole locations tree starting from the root)', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'depth',
					'value' => array('1', '2'),
					'heading' => esc_html__('locations nesting level', 'w2dc'),
					'description' => esc_html__('The max depth of locations tree. When set to 1 – only root locations will be listed.', 'w2dc'),
					'std' => get_option('w2dc_locations_nesting_level'),
				),
			array(
					'type' => 'textfield',
					'param_name' => 'sublocations',
					'heading' => esc_html__('Show sublocations items number', 'w2dc'),
					'description' => esc_html__('This is the number of sublocations those will be displayed in the table, when location item includes more than this number "View all sublocations ->" link appears at the bottom', 'w2dc'),
					'dependency' => array('element' => 'depth', 'value' => '2'),
					'std' => get_option('w2dc_sublocations_items'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'count',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show location listings count', 'w2dc'),
					'description' => esc_html__('Whether to show number of listings assigned with current location', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_empty',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide empty locations', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'icons',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show locations icons', 'w2dc'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					'heading' => esc_html__('locations', 'w2dc'),
					'description' => esc_html__('Comma separated string of locations slugs or IDs. Possible to display exact locations.', 'w2dc'),
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

class w2dc_locations_sidebar_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_locations_sidebar_widget_params;

		parent::__construct(
				'w2dc_locations_widget', // name for backward compatibility
				esc_html__('Directory widget - Sidebar locations', 'w2dc')
		);

		$this->convertParams($w2dc_locations_sidebar_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
			$instance['columns'] = 1;
			$instance['menu'] = 1;
			$instance['grid'] = 0;
			
			$title = apply_filters('widget_title', $instance['title']);
	
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-locations-sidebar-widget">';
			$controller = new w2dc_locations_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>