<?php 

/**
 *  [webrr-post-rating] shortcode
 *
 *
 */
class w2rr_post_rating_controller extends w2rr_frontend_controller {
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

		apply_filters('w2rr_post_rating_controller_construct', $this);
	}

	public function display() {
		if ($this->target_post) {
			return $this->target_post->renderStars(true) /* . " <span>" . $this->target_post->avg_rating->avg_value . "</span>" */;
		}
	}
}

?>