<?php

class w2rr_target_post_manager {
	
	public function __construct() {
		
		// remove comments metabox when we are using comments mode, otherwise it will not save "Enable reviews on this page" checkbox in reviews metabox
		if (get_option('w2rr_display_mode') == 'comments') {
			add_action('add_meta_boxes', array($this, 'remove_comments_metabox'), 302, 2);
		}
		
		add_action('add_meta_boxes', array($this, 'addReviewsMetabox'), 301, 2);
		
		if ((isset($_POST['publish']) || isset($_POST['save'])) && (isset($_POST['post_type']) && in_array($_POST['post_type'], w2rr_getWorkingPostTypes()))) {
			foreach (w2rr_getWorkingPostTypes() AS $post_type) {
				add_action('save_post_' . $post_type, array($this, 'savePost'), 10, 3);
			}
		}
		
		add_filter('manage_posts_columns', array($this, 'add_reviews_table_columns'), 1, 2);
		add_filter('manage_pages_columns', array($this, 'add_reviews_table_columns'), 1, 2);
		add_action('manage_pages_custom_column', array($this, 'manage_reviews_table_rows'), 10, 2);
		add_action('manage_posts_custom_column', array($this, 'manage_reviews_table_rows'), 10, 2);
	}
	
	public function add_reviews_table_columns($columns, $post_type = 'page') {
		
		$w2rr_columns = array();
		
		if (in_array($post_type, w2rr_getWorkingPostTypes())) {
			$w2rr_columns["w2rr_reviews"] = esc_html__("Rating & Reviews", "w2rr");
		}
		
		return array_slice($columns, 0, 2, true) + $w2rr_columns + array_slice($columns, 2, count($columns)-2, true);
	}
	
	public function manage_reviews_table_rows($column, $post_id) {
		
		global $w2rr_instance;
		
		switch ($column) {
			case "w2rr_reviews":
				$target_post = w2rr_getTargetPost($post_id);
				echo $target_post->renderAvgRating(array('show_avg' => true, 'active' => false, 'noajax' => false, 'show_counter' => false, 'stars_size' => 20));
				echo '<br />';
				echo '<span class="w2rr-badge">';
				echo $target_post->getCommentStatus();
				echo '</span>';
				echo '<br />';
				
				$reviews_counter = $w2rr_instance->reviews_manager->get_reviews_counter($target_post);
				echo '<a href="' . admin_url('edit.php?post_type=w2rr_review&w2rr_target_post='.$post_id) . '">';
				echo $reviews_counter . ' ' . _n('review', 'reviews', $reviews_counter, 'w2rr');
				echo '</a>';
				
				break;
		}
	}

	/**
	 * remove comments metaboxes on target posts
	 * 
	 */
	public function remove_comments_metabox($type, $post) {
		
		$post_types = w2rr_getWorkingPostTypes();
	
		foreach ($post_types AS $post_type) {
			remove_meta_box('commentstatusdiv', $post_type, 'normal');
			remove_meta_box('commentsdiv', $post_type, 'normal');
		}
		
		
		if (is_object($post) && in_array($post->ID, w2rr_getSelectedPages())) {
			remove_meta_box('commentstatusdiv', $type, 'normal');
			remove_meta_box('commentsdiv', $type, 'normal');
		}
	}
	
	/**
	 * add reviews metabox on target posts
	 * 
	 * @param obj $post_type
	 */
	public function addReviewsMetabox($post_type, $post) {
		if (in_array($post_type, w2rr_getWorkingPostTypes()) && !in_array($post->ID, w2rr_getSelectedPages())) {
			add_meta_box('w2rrreviews',
			esc_html__('Reviews', 'w2rr'),
			array($this, 'targetPostReviewsMetabox'),
			$post_type,
			'normal',
			'high');
		}
	}
	
	public function targetPostReviewsMetabox($post) {
		$target_post = w2rr_getTargetPost($post);
		
		$args = array(
				'post_type' => W2RR_REVIEW_TYPE,
				'post_status' => 'any',
				'meta_query' => array(
						array(
								'key' => '_post_id',
								'value' => $target_post->post->ID
						)
				),
				'posts_per_page' => -1,
		);
		
		$reviews_posts = get_posts($args);
		
		$reviews = array();
		foreach ($reviews_posts AS $post) {
			$reviews[] = w2rr_getReview($post);
		}
		
		$avg_rating = new w2rr_target_post_avg_rating($target_post->post->ID);
	
		w2rr_renderTemplate('ratings_reviews/reviews_metabox.tpl.php', array('target_post' => $target_post, 'reviews' => $reviews, 'avg_rating' => $avg_rating));
	}
	
	public function savePost($post_ID, $post, $update) {
		if (get_option('w2rr_display_mode') == 'shortcodes') {
			if (w2rr_getValue($_POST, 'review_status')) {
				$status = 'open';
			} else {
				$status = 'close';
			}
			update_post_meta($post_ID, '_review_status', $status);
		}
	}
}

?>