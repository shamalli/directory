<?php

global $w2rr_slider_widget_params;
$w2rr_slider_widget_params = array(
		array(
				'type' => 'textfield',
				'param_name' => 'slides',
				'value' => '5',
				'heading' => esc_html__('Number of slides to display', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'target_post',
				'value' => array(__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Show reviews of this post only', 'W2RR'),
		),
		array(
				'type' => 'post_type',
				'param_name' => 'target_post_type',
				'value' => 0,
				'heading' => esc_html__('All reviews of posts of certain post type', 'W2RR'),
				'dependency' => array('element' => 'target_post', 'value' => '0'),
		),
		array(
				'type' => 'reviews_ordering',
				'param_name' => 'reviews_order_by',
				'heading' => esc_html__('Order by', 'W2RR'),
				'value' => 'post_date',
				'description' => esc_html__('Order reviews by any of these parameter', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'reviews_order',
				'value' => array(esc_html__('Ascending', 'W2RR') => 'ASC', esc_html__('Descending', 'W2RR') => 'DESC'),
				'std' => 'DESC',
				'description' => esc_html__('Direction of sorting', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'captions',
				'value' => array(esc_html__('Yes', 'W2RR') => '1', esc_html__('No', 'W2RR') => '0'),
				'heading' => esc_html__('Show captions on each slide', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'pager',
				'value' => array(esc_html__('Yes', 'W2RR') => '1', esc_html__('No', 'W2RR') => '0'),
				'heading' => esc_html__('Show thumbnails slides', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'crop',
				'value' => array(esc_html__('Yes', 'W2RR') => '1', esc_html__('No', 'W2RR') => '0'),
				'heading' => esc_html__('Do crop images', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'width',
				'value' => '',
				'heading' => esc_html__('Width', 'W2RR'),
				'description' => esc_html__('Leave empty to fit all possible width (in pixels)', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'height',
				'value' => '',
				'heading' => esc_html__('Height', 'W2RR'),
				'description' => esc_html__('Set fixed height of the slider (in pixels). Otherwise it will adapt height for each slide.', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'max_slides',
				'value' => '1',
				'heading' => esc_html__('Multi-slides', 'W2RR'),
				'description' => esc_html__('Show multiple slides on main slide area. Enter number of slides. Slide width required.', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'slide_width',
				'value' => '0',
				'heading' => esc_html__('Slide width', 'W2RR'),
				'description' => esc_html__('Set fixed width of main slide (in pixels)', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'order_by_rand',
				'value' => array(esc_html__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Get random slides', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'auto_slides',
				'value' => array(esc_html__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Enable auto rotation', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'auto_slides_delay',
				'value' => '3000',
				'heading' => esc_html__('Delay in rotation (in milliseconds)', 'W2RR'),
				'dependency' => array('element' => 'auto_slides', 'value' => '1'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'author',
				'heading' => esc_html__('Author', 'W2RR'),
				'description' => esc_html__('Enter exact ID of author or word "related" to get assigned reviews of current author (works only on review page or author page)', 'W2RR'),
				'dependency' => array('element' => 'target_post', 'value' => '0'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'post__in',
				'heading' => esc_html__('Exact reviews', 'W2RR'),
				'description' => esc_html__('Comma separated string of reviews IDs. Possible to display exact reviews', 'W2RR'),
				'dependency' => array('element' => 'target_post', 'value' => '0'),
		),
		array(
				'type' => 'tax',
				'param_name' => 'tax',
				'heading' => esc_html__('Taxonomy', 'W2RR'),
				'description' => esc_html__('Select taxonomy', 'W2RR'),
				'dependency' => array('element' => 'target_post', 'value' => '0'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'terms',
				'heading' => esc_html__('Terms IDs list', 'W2RR'),
				'description' => esc_html__('Comma separated string of terms IDs', 'W2RR'),
				'dependency' => array('element' => 'target_post', 'value' => '0'),
		),
);

class w2rr_slider_widget extends w2rr_widget {

	public function __construct() {
		global $w2rr_instance, $w2rr_slider_widget_params;

		parent::__construct(
				'w2rr_slider_shortcode_widget',
				esc_html__('Reviews slider', 'W2RR')
		);

		$this->convertParams($w2rr_slider_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2rr_instance;
			
		$controller = new w2rr_slider_controller();
		$controller->init($instance);
			
		if ($controller->query->have_posts()) {
			if (isset($instance['title'])) {
				$title = apply_filters('widget_title', $instance['title']);
			}
		
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . esc_html($title) . $args['after_title'];
			}
			echo '<div class="w2rr-content w2rr-widget w2rr-slider-widget">';
			w2rr_renderTemplate('ratings_reviews/reviews_widget.tpl.php', array('frontend_controller' => $controller));
			echo '</div>';
			echo $args['after_widget'];
		}
		
		wp_reset_postdata();
	}
}
?>