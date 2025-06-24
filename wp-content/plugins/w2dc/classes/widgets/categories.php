<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_categories_widget_params;
	$w2dc_categories_widget_params = array(
			array(
					'type' => 'dropdown',
					'param_name' => 'custom_home',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Is it on custom home page?', 'w2dc'),
			),
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => esc_html__("Categories links will redirect to selected directory", "w2dc"),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'parent',
					'heading' => esc_html__('Parent category', 'w2dc'),
					'description' => esc_html__('ID of parent category (default 0 – this will build categories tree starting from the parent as root)', 'w2dc'),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'depth',
					'value' => array('1' => '1', '2' => '2'),
					'heading' => esc_html__('Categories nesting level', 'w2dc'),
					'description' => esc_html__('The max depth of categories tree. When set to 1 – only root categories will be listed', 'w2dc'),
				),
			array(
					'type' => 'textfield',
					'param_name' => 'subcats',
					'heading' => esc_html__('Show subcategories items number', 'w2dc'),
					'description' => esc_html__('This is the number of subcategories those will be displayed in the table, when category item includes more than this number "View all subcategories ->" link appears at the bottom', 'w2dc'),
					'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'columns',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
					'std' => '2',
					'heading' => esc_html__('Categories columns number', 'w2dc'),
					'description' => esc_html__('Categories list is divided by columns', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'count',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show category listings count', 'w2dc'),
					'description' => esc_html__('Whether to show number of listings assigned with current category', 'w2dc'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_empty',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide empty categories', 'w2dc'),
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
					'dependency' => array('element' => 'grid', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'icons',
					'value' => array(esc_html__('Yes', 'w2dc') => '1', esc_html__('No', 'w2dc') => '0'),
					'heading' => esc_html__('Show categories icons', 'w2dc'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					'heading' => esc_html__('Categories', 'w2dc'),
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

class w2dc_categories_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_categories_widget_params;

		parent::__construct(
				'w2dc_categories_shortcode_widget',
				esc_html__('Directory widget - Categories', 'w2dc')
		);

		$this->convertParams($w2dc_categories_widget_params);
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
			echo '<div class="w2dc-content w2dc-widget w2dc-categories-widget">';
			$controller = new w2dc_categories_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>