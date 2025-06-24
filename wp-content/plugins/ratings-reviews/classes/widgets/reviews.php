<?php

add_action('init', function() {
	global $w2rr_reviews_widget_params;
	$w2rr_reviews_widget_params = array(
			array(
					'type' => 'textfield',
					'param_name' => 'posts',
					'value' => '',
					'heading' => esc_html__('Comma separated string of posts IDs', 'w2rr'),
					'description' => esc_html__('Display reviews of specific post(s)', 'w2rr'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'name',
					'value' => '',
					'heading' => esc_html__('Exact review by post name', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'with_images',
					'value' => array(__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Show ONLY reviews wich have images', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'target_post',
					'value' => array(__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Show reviews of this post only', 'w2rr'),
			),
			array(
					'type' => 'post_type',
					'param_name' => 'target_post_type',
					'value' => 0,
					'heading' => esc_html__('All reviews of posts of certain post type', 'w2rr'),
					'dependency' => array('element' => 'target_post', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'onepage',
					'value' => array(__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Show all possible reviews on one page', 'w2rr'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'perpage',
					'value' => 10,
					'heading' => esc_html__('Number of reviews per page', 'w2rr'),
					'description' => esc_html__('Number of reviews to display per page. Set -1 to display all reviews without paginator', 'w2rr'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'reviews_ordering',
					'param_name' => 'reviews_order_by',
					'heading' => esc_html__('Order by', 'w2rr'),
					'value' => 'post_date',
					'description' => esc_html__('Order reviews by any of these parameter', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'reviews_order',
					'value' => array(esc_html__('Ascending', 'w2rr') => 'ASC', esc_html__('Descending', 'w2rr') => 'DESC'),
					'std' => 'DESC',
					'description' => esc_html__('Direction of sorting', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_order',
					'value' => array(esc_html__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Hide ordering links', 'w2rr'),
					'description' => esc_html__('Whether to hide ordering navigation links', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_paginator',
					'value' => array(esc_html__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Hide paginator', 'w2rr'),
					'description' => esc_html__('Whether to hide paginator or "Show More Reviews" button', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_images',
					'value' => array(esc_html__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Hide images', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'reviews_view_type',
					'value' => array(esc_html__('List', 'w2rr') => 'list', esc_html__('Grid', 'w2rr') => 'grid'),
					'heading' => esc_html__('Listings view by default', 'w2rr'),
					'description' => esc_html__('Do not forget that selected view will be stored in cookies', 'w2rr'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'reviews_view_grid_columns',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
					'heading' => esc_html__('Number of columns for listings Grid View', 'w2rr'),
					'std' => '2',
					'dependency' => array('element' => 'reviews_view_type', 'value' => 'grid'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'reviews_view_grid_masonry',
					'value' => array(esc_html__('No', 'w2rr') => '0', esc_html__('Yes', 'w2rr') => '1'),
					'heading' => esc_html__('Enable masonry for the Grid view', 'w2rr'),
					'dependency' => array('element' => 'reviews_view_type', 'value' => 'grid'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => esc_html__('Author', 'w2rr'),
					'description' => esc_html__('Enter exact ID of author or word "related" to get assigned reviews of current author (works only on review page or author page)', 'w2rr'),
					'dependency' => array('element' => 'target_post', 'value' => '0'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => esc_html__('Exact reviews', 'w2rr'),
					'description' => esc_html__('Comma separated string of reviews IDs. Possible to display exact reviews', 'w2rr'),
					'dependency' => array('element' => 'target_post', 'value' => '0'),
			),
			array(
					'type' => 'tax',
					'param_name' => 'tax',
					'heading' => esc_html__('Taxonomy', 'w2rr'),
					'description' => esc_html__('Select taxonomy', 'w2rr'),
					'dependency' => array('element' => 'target_post', 'value' => '0'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'terms',
					'heading' => esc_html__('Terms IDs list', 'w2rr'),
					'description' => esc_html__('Comma separated string of terms IDs', 'w2rr'),
					'dependency' => array('element' => 'target_post', 'value' => '0'),
			),
	);
}, 0);

class w2rr_reviews_widget extends w2rr_widget {

	public function __construct() {
		global $w2rr_instance, $w2rr_reviews_widget_params;

		parent::__construct(
				'w2rr_reviews_shortcode_widget',
				esc_html__('Reviews', 'w2rr')
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