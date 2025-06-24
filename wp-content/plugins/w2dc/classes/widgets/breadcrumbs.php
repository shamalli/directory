<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_breadcrumbs_widget_params;
	$w2dc_breadcrumbs_widget_params = array(
			
	);
}, 0);

class w2dc_breadcrumbs_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_breadcrumbs_widget_params;

		parent::__construct(
				'w2dc_breadcrumbs_shortcode_widget',
				esc_html__('Directory widget - Breadcrumbs', 'w2dc')
		);

		$this->convertParams($w2dc_breadcrumbs_widget_params);
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
			echo '<div class="w2dc-content w2dc-widget w2dc-content-field-widget">';
			$controller = new w2dc_breadcrumbs_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}

?>