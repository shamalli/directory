<?php 

/**
 *  [webrr-review-votes] shortcode
 *
 *
 */
class w2rr_review_votes_controller extends w2rr_frontend_controller {
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

		apply_filters('w2rr_review_votes_controller_construct', $this);
	}

	public function display() {
		if ($this->review && get_option("w2rr_reviews_votes")) {
			ob_start();
			echo '<div class="w2rr-single-review-comments-votes">';
			echo '<div class="w2rr-single-review-votes">';
			w2rr_renderTemplate('ratings_reviews/single_parts/review_votes.tpl.php', array('review' => $this->review));
			echo '</div>';
			echo '</div>';
			
			$html = ob_get_contents();
			ob_end_clean();
			
			return $html;
		}
	}
}

?>