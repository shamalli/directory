<?php 

/**
 *  [webrr-post-reviews] shortcode
 *
 *
 */
class w2rr_post_reviews_controller extends w2rr_frontend_controller {
	public $reviews_controller;

	public function init($args = array()) {
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'target_post' => 1,
		), $args);
		
		$this->reviews_controller = new w2rr_reviews_controller($shortcode_atts);

		apply_filters('w2rr_post_reviews_controller_construct', $this);
	}

	public function display() {
		$this->reviews_controller->display();
	}
}

?>