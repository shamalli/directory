<?php

add_action('init', function() {
	global $w2rr_review_gallery_widget_params;
	$w2rr_review_gallery_widget_params = array(
			array(
					'type' => 'textfield',
					'param_name' => 'review',
					'heading' => esc_html__('Review ID', 'w2rr'),
					'description' => esc_html__('Leave empty if you place it on single review page', 'w2rr'),
			),
	);
}, 0);

class w2rr_review_gallery_widget extends w2rr_widget {

	public function __construct() {
		global $w2rr_instance, $w2rr_review_gallery_widget_params;

		parent::__construct(
				'w2rr_review_gallery_shortcode_widget',
				esc_html__('Review gallery', 'w2rr')
		);

		$this->convertParams($w2rr_review_gallery_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2rr_instance;
			
		$controller = new w2rr_review_gallery_controller();
		$controller->init($instance);
			
		if ($controller->query->have_posts()) {
			if (isset($instance['title'])) {
				$title = apply_filters('widget_title', $instance['title']);
			}
		
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . esc_html($title) . $args['after_title'];
			}
			echo '<div class="w2rr-content w2rr-widget w2rr-review-gallery-widget">';
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
		
		wp_reset_postdata();
	}
}
?>