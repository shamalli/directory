<?php 

/**
 *  [webrr-post-reviews-counter] shortcode
 *
 *
 */
class w2rr_post_reviews_counter_controller extends w2rr_frontend_controller {
	public $target_post;

	public function init($args = array()) {
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'post' => '',
		), $args);
		
		$this->target_post = w2rr_getTargetPost($shortcode_atts['post']);

		// something went wrong, we can not find target post
		if (empty($this->target_post)) {
			return ;
		}

		apply_filters('w2rr_post_reviews_counter_controller_construct', $this);
	}

	public function display() {
		if ($this->target_post) {
			$reviews_controller = new w2rr_reviews_controller;
			$reviews_controller->init(array(
					'posts' => array($this->target_post->post->ID),
					'paged' => 1,
			));
			
			return '<div class="w2rr-content"><h3>' . $reviews_controller->query->found_posts . ' ' . _n('Review', 'Reviews', $reviews_controller->query->found_posts, 'w2rr') . '</h3></div>';
		}
	}
}

?>