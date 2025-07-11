<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	
	global $w2dc_directory_widget_params, $w2dc_listings_widget_params;
	
	$w2dc_directory_widget_params = $w2dc_listings_widget_params;
	
	foreach ($w2dc_directory_widget_params AS $key=>$param) {
		if (
			$param['param_name'] == 'directories' ||
			$param['param_name'] == 'directory' ||
			$param['param_name'] == 'uid'
		) {
			unset($w2dc_directory_widget_params[$key]);
		}
	}
	
	array_unshift($w2dc_directory_widget_params,
		array(
				'type' => 'directory',
				'param_name' => 'directories',
				'heading' => esc_html__("Directory", "w2dc"),
		)
	);
	array_unshift($w2dc_directory_widget_params,
		array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
				'heading' => esc_html__('Is it on custom home page?', 'w2dc'),
				'description' => esc_html__('When set to Yes - the widget displays only listings', 'w2dc'),
		)
	);
}, 0);

class w2dc_directory_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_directory_widget_params;

		parent::__construct(
				'w2dc_directory_shortcode_widget',
				esc_html__('Directory', 'w2dc')
		);

		foreach ($w2dc_instance->content_fields->content_fields_array AS $filter_field) {
			if (method_exists($filter_field, 'getWidgetParams') && ($field_params = $filter_field->getWidgetParams())) {
				$w2dc_directory_widget_params = array_merge($w2dc_directory_widget_params, $field_params);
			}
		}

		$this->convertParams($w2dc_directory_widget_params);
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
			echo '<div class="w2dc-content w2dc-widget w2dc-directory-widget">';
			
			if ($controllers = w2dc_getFrontendControllers(W2DC_MAIN_SHORTCODE)) {
				$controller = $controllers[0];
			} else {
				$controller = new w2dc_directory_controller();
				$controller->init($instance);
				
				// add frontend controller to get compatibility by uID parameter with maps controller
				w2dc_setFrontendController(W2DC_MAIN_SHORTCODE, $controller);
			}
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>