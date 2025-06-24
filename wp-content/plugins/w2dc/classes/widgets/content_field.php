<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_content_field_widget_params;
	$w2dc_content_field_widget_params = array(
			array(
					'type' => 'contentfield',
					'param_name' => 'content_field_id',
					'heading' => esc_html__('Content field', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'listing',
					'heading' => esc_html__('Listing ID', 'w2dc'),
					'description' => esc_html__('Leave empty if you place it on single listing page', 'w2dc'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'classes',
					'heading' => esc_html__('CSS classes', 'w2dc'),
					'description' => esc_html__('CSS classes to add to content field wrapper', 'w2dc'),
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

class w2dc_content_field_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_content_field_widget_params;

		parent::__construct(
				'w2dc_content_field_shortcode_widget',
				esc_html__('Directory widget - Content field', 'w2dc')
		);

		$this->convertParams($w2dc_content_field_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		if (empty($instance['listing']) && !w2dc_isListing()) {
			return false;
		}
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
			if (isset($instance['title'])) {
				$title = apply_filters('widget_title', $instance['title']);
			}
			
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-breadcrumbs-widget">';
			$controller = new w2dc_content_field_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}

?>