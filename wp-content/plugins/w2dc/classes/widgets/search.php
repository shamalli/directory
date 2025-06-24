<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_search_widget_params;
	$w2dc_search_widget_params = array(
			array(
					'type' => 'dropdown',
					'param_name' => 'custom_home',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Is it on custom home page?', 'w2dc'),
			),
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => esc_html__("Search by directory", "w2dc"),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'heading' => esc_html__("uID", "w2dc"),
					'description' => esc_html__("Enter unique string to connect search form with another elements on the page", "w2dc"),
					'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
					'type' => 'formid',
					'param_name' => 'form_id',
					'heading' => esc_html__("Select search form", "w2dc"),
			),
	);
}, 0);

class w2dc_search_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_search_widget_params;

		parent::__construct(
				'w2dc_search_widget',
				esc_html__('Directory widget - Search', 'w2dc')
		);

		$this->convertParams($w2dc_search_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
			// when search_visibility enabled - show only when main search form wasn't displayed
			if (!empty($instance['search_visibility']) && !empty($w2dc_instance->frontend_controllers)) {
				foreach ($w2dc_instance->frontend_controllers AS $shortcode_controllers) {
					foreach ($shortcode_controllers AS $controller) {
						if (is_object($controller) && !empty($controller->search_form)) {
							return false;
						}
					}
				}
			}
				
			$title = apply_filters('widget_title', $instance['title']);
				
			// it is auto selection - take current directory
			if ($instance['directory'] == 0) {
				// probably we are on single listing page - it could be found only after frontend controllers were loaded, so we have to repeat setting
				$w2dc_instance->setCurrentDirectory();
		
				$instance['directory'] = $w2dc_instance->current_directory->id;
			}
			
			if (empty($instance['form_id'])) {
				$instance['columns'] = 1;
			}

			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-search-widget">';
			$controller = new w2dc_search_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>