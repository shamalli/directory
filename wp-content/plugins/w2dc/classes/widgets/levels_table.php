<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_levels_table_widget_params;
	$w2dc_levels_table_widget_params = array(
			array(
					'type' => 'levels',
					'param_name' => 'levels',
					'heading' => esc_html__('Listings levels', 'w2dc'),
					'description' => esc_html__('Choose exact levels to display', 'w2dc'),
					'value' => '',
			),
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => esc_html__("Specific directory", "w2dc"),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'columns',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
					'std' => '3',
					'heading' => esc_html__('Columns', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'columns_same_height',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Show negative parameters', 'w2dc'),
					'description' => esc_html__('Show parameters those have negation. For example, such row in the table will be shown: Featured Listings - No. In other case this row will be hidden.', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_period',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show level active period on choose level page', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_sticky',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show is level sticky on choose level page', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_featured',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show is level featured on choose level page', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_categories',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__("Show level's categories number on choose level page", 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_locations',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__("Show level's locations number on choose level page", 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_maps',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show is level supports maps on choose level page', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_images',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__("Show level's images number on choose level page", 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_videos',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__("Show level's videos number on choose level page", 'w2dc'),
			),
			array(
					'type' => 'textarea',
					'param_name' => 'options',
					'heading' => esc_html__("Options", "w2dc"),
					'description' => esc_html__("Example: 1=option=no;2=option=yes;", "w2dc"),
			),
	);
}, 0);

class w2dc_levels_table_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_levels_table_widget_params;

		parent::__construct(
				'w2dc_levels_table_widget',
				esc_html__('Directory widget - Listings levels', 'w2dc')
		);

		$this->convertParams($w2dc_levels_table_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		$title = apply_filters('widget_title', $instance['title']);
	
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="w2dc-content w2dc-widget w2dc-levels-table-widget">';
		$controller = new w2dc_levels_table_controller();
		$controller->init($instance);
		echo $controller->display();
		echo '</div>';
		echo $args['after_widget'];
	}
}
?>