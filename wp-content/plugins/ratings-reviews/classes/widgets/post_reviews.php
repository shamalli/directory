<?php

global $w2rr_post_reviews_widget_params, $w2rr_reviews_widget_params;
$w2rr_post_reviews_widget_params = array(
		array(
				'type' => 'dropdown',
				'param_name' => 'onepage',
				'value' => array(__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Show all possible reviews on one page', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'perpage',
				'value' => 10,
				'heading' => esc_html__('Number of reviews per page', 'W2RR'),
				'description' => esc_html__('Number of reviews to display per page. Set -1 to display all reviews without paginator', 'W2RR'),
				'dependency' => array('element' => 'onepage', 'value' => '0'),
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
				'param_name' => 'hide_order',
				'value' => array(esc_html__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Hide ordering links', 'W2RR'),
				'description' => esc_html__('Whether to hide ordering navigation links', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'hide_paginator',
				'value' => array(esc_html__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Hide paginator', 'W2RR'),
				'description' => esc_html__('Whether to hide paginator or "Show More Reviews" button', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'hide_images',
				'value' => array(esc_html__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Hide images', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'reviews_view_type',
				'value' => array(esc_html__('List', 'W2RR') => 'list', esc_html__('Grid', 'W2RR') => 'grid'),
				'heading' => esc_html__('Listings view by default', 'W2RR'),
				'description' => esc_html__('Do not forget that selected view will be stored in cookies', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'reviews_view_grid_columns',
				'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
				'heading' => esc_html__('Number of columns for listings Grid View', 'W2RR'),
				'std' => '2',
				'dependency' => array('element' => 'reviews_view_type', 'value' => 'grid'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'reviews_view_grid_masonry',
				'value' => array(esc_html__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Enable masonry for the Grid view', 'W2RR'),
				'dependency' => array('element' => 'reviews_view_type', 'value' => 'grid'),
		),
);

class w2rr_post_reviews_widget extends w2rr_widget {

	public function __construct() {
		global $w2rr_instance, $w2rr_post_reviews_widget_params;

		parent::__construct(
				'w2rr_post_reviews_shortcode_widget',
				esc_html__('Post reviews', 'W2RR')
		);

		$this->convertParams($w2rr_post_reviews_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2rr_instance;
		
		$instance['target_post'] = 1;
			
		$controller = new w2rr_reviews_controller();
		$controller->init($instance);
			
		if ($controller->query->have_posts()) {
			if (isset($instance['title'])) {
				$title = apply_filters('widget_title', $instance['title']);
			}
		
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . esc_html($title) . $args['after_title'];
			}
			echo '<div class="w2rr-content w2rr-widget w2rr-post-reviews-widget">';
			w2rr_renderTemplate('ratings_reviews/post_reviews_widget.tpl.php', array('frontend_controller' => $controller));
			echo '</div>';
			echo $args['after_widget'];
		}
		
		wp_reset_postdata();
	}
}
?>