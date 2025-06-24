<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_locations_widget_params;
	$w2dc_locations_widget_params = array(
			array(
					'type' => 'dropdown',
					'param_name' => 'custom_home',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Is it on custom home page?', 'w2dc'),
			),
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => esc_html__("Locations links will redirect to selected directory", "w2dc"),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'parent',
					'heading' => esc_html__('Parent location', 'w2dc'),
					'description' => esc_html__('ID of parent location (default 0 – this will build locations tree starting from the parent as root)', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'depth',
					'value' => array('1' => '1', '2' => '2'),
					'heading' => esc_html__('locations nesting level', 'w2dc'),
					'description' => esc_html__('The max depth of locations tree. When set to 1 – only root locations will be listed', 'w2dc'),
				),
			array(
					'type' => 'textfield',
					'param_name' => 'sublocations',
					'heading' => esc_html__('Show sublocations items number', 'w2dc'),
					'description' => esc_html__('This is the number of sublocations those will be displayed in the table, when location item includes more than this number "View all sublocations ->" link appears at the bottom', 'w2dc'),
					'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'columns',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
					'std' => '2',
					'heading' => esc_html__('locations columns number', 'w2dc'),
					'description' => esc_html__('locations list is divided by columns', 'w2dc'),
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
					'param_name' => 'grid',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Enable grid view', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'grid_view',
					'value' => array(
							esc_html__('Standard', 'w2dc') => '0',
							esc_html__('Left Side Grid', 'w2dc') => '1',
							esc_html__('Right Side Grid', 'w2dc') => '2',
							esc_html__('Center Grid', 'w2dc') => '3',
					),
					'heading' => esc_html__('Grid view', 'w2dc'),
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
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
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

class w2dc_locations_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_locations_widget_params;

		parent::__construct(
				'w2dc_locations_shortcode_widget',
				esc_html__('Directory widget - Locations', 'w2dc')
		);

		$this->convertParams($w2dc_locations_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
			$instance['menu'] = 0;
			
			$title = apply_filters('widget_title', $instance['title']);
	
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-locations-widget">';
			$controller = new w2dc_locations_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>