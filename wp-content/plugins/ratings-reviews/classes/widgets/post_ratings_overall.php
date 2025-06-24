<?php

add_action('init', function() {
	global $w2rr_post_ratings_overall_widget_params;
	$w2rr_post_ratings_overall_widget_params = array(
			array(
					'type' => 'textfield',
					'param_name' => 'post',
					'value' => '',
					'heading' => esc_html__('Post ratings overall specific post', 'w2rr'),
					'description' => esc_html__('Leave empty to show ratings overall of target post', 'w2rr'),
			),
	);
}, 0);

class w2rr_post_ratings_overall_widget extends w2rr_widget {

	public function __construct() {
		global $w2rr_instance, $w2rr_post_ratings_overall_widget_params;

		parent::__construct(
				'w2rr_post_ratings_overall_shortcode_widget',
				esc_html__('Post ratings overall', 'w2rr')
		);

		$this->convertParams($w2rr_post_ratings_overall_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2rr_instance;
			
		$controller = new w2rr_post_ratings_overall_controller();
		$controller->init($instance);
			
		if ($controller->query->have_posts()) {
			if (isset($instance['title'])) {
				$title = apply_filters('widget_title', $instance['title']);
			}
		
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . esc_html($title) . $args['after_title'];
			}
			echo '<div class="w2rr-content w2rr-widget w2rr-post-ratings-overall-widget">';
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
		
		wp_reset_postdata();
	}
}
?>