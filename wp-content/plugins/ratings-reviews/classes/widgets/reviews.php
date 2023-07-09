<?php

global $w2rr_reviews_widget_params;
$w2rr_reviews_widget_params = array(
		array(
				'type' => 'textfield',
				'param_name' => 'posts',
				'value' => '',
				'heading' => esc_html__('Comma separated string of posts IDs', 'W2RR'),
				'description' => esc_html__('Display reviews of specific post(s)', 'W2RR'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'name',
				'value' => '',
				'heading' => esc_html__('Exact review by post name', 'W2RR'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'with_images',
				'value' => array(__('No', 'W2RR') => '0', esc_html__('Yes', 'W2RR') => '1'),
				'heading' => esc_html__('Show ONLY reviews wich have images', 'W2RR'),
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

class w2rr_reviews_widget extends w2rr_widget {

	public function __construct() {
		global $w2rr_instance, $w2rr_reviews_widget_params;

		parent::__construct(
				'w2rr_reviews_shortcode_widget',
				esc_html__('Reviews', 'W2RR')
		);

		$this->convertParams($w2rr_reviews_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2rr_instance;
			
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
			echo '<div class="w2rr-content w2rr-widget w2rr-reviews-widget">';
			w2rr_renderTemplate('ratings_reviews/reviews_widget.tpl.php', array('frontend_controller' => $controller));
			echo '</div>';
			echo $args['after_widget'];
		}
		
		wp_reset_postdata();
	}
}
?>