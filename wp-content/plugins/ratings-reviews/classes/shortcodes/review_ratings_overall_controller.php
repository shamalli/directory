<?php 

/**
 *  [webrr-review-ratings-overall] shortcode
 *
 *
 */
class w2rr_review_ratings_overall_controller extends w2rr_frontend_controller {
	public $review;

	public function init($args = array()) {
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'review' => '',
		), $args);

		$this->args = $shortcode_atts;

		if ($this->args['review']) {
			$this->review = w2rr_getReview($this->args['review']);
		} else {
			$this->review = w2rr_isReview();
		}

		apply_filters('w2rr_review_ratings_overall_controller_construct', $this);
	}

	public function display() {
		if ($this->review) {
			if ($ratings_criterias = w2rr_getMultiRatings()) {
				return w2rr_renderTemplate('ratings_reviews/single_parts/ratings_criterias_overall.tpl.php', array('ratings_criterias' => $ratings_criterias, 'values' => $this->review->ratings), true);
			}
		}
	}
}

?>