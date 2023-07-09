<?php 

/**
 *  [webrr-review-comments] shortcode
 *
 *
 */
class w2rr_review_comments_controller extends w2rr_frontend_controller {
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

		apply_filters('w2rr_review_comments_controller_construct', $this);
	}

	public function display() {
		if ($this->review && w2rr_comments_open()) {
			ob_start();
			echo '<div class="w2rr-single-review-comments">';
			echo '<div class="w2rr-single-review-comments-label">';
			echo $this->review->post->comment_count . ' ';
			echo _n('Comment', 'Comments', $this->review->post->comment_count, 'W2RR');
			echo '</div>';
			w2rr_renderTemplate('ratings_reviews/single_parts/comments.tpl.php', array('post' => $this->review->post));
			echo '</div>';
			
			$html = ob_get_contents();
			ob_end_clean();
			
			return $html;
		}
	}
}

?>