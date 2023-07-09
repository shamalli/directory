<?php 

/**
 *  [webrr-post-ratings-overall] shortcode
 *
 *
 */
class w2rr_post_ratings_overall_controller extends w2rr_frontend_controller {
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
		
		$this->add_template_args(array(
				'target_post' => $this->target_post
		));
		$this->template = 'ratings_reviews/reviews_block_header.tpl.php';

		apply_filters('w2rr_post_ratings_overall_controller_construct', $this);
	}
}

?>