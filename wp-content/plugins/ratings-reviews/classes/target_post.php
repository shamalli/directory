<?php 

class w2rr_targetPost {
	public $post;
	public $avg_rating;
	public $avg_rating_criterias;

	public function __construct($post = null) {
		if (!$post) {
			global $post;
		}
		if (is_object($post)) {
			$this->post = $post;
		} elseif (is_numeric($post)) {
			$this->post = get_post($post);
		}
		
		$this->setRatings();
	}
	
	public function setRatings() {
		if ($this->post) {
			$this->avg_rating = new w2rr_target_post_avg_rating($this->post->ID);
			
			$this->avg_rating_criterias = new w2rr_avg_review_multiratings($this->post->ID);
		}
	}
	
	public function getAvgRating() {
		return $this->avg_rating->avg_value;
	}
	
	public function renderStars($return = false) {
		if ($this->avg_rating) {
			return w2rr_renderTemplate('ratings_reviews/single_rating.tpl.php', array('rating' => $this->avg_rating), $return);
		}
	}
	
	public function renderAvgRating($args = array(), $return = false) {
		if ($this->avg_rating) {
			return w2rr_renderAvgRating($this->avg_rating, $this->post->ID, $args, $return);
		}
	}
	
	public function title() {
		return $this->post->post_title;
	}
	
	public function getReviewsIds() {
		global $wpdb;
		
		$reviews_ids = array_unique($wpdb->get_col("SELECT p.ID FROM {$wpdb->postmeta} AS pm LEFT JOIN {$wpdb->posts} AS p ON p.ID = pm.post_id WHERE pm.meta_key = '_post_id' AND pm.meta_value=" . $this->post->ID . " AND p.post_status = 'publish'"));
		
		return $reviews_ids;
	}
	
	public function getCommentStatus() {
		
		$comment_status = $this->post->comment_status;
		
		$comment_status = apply_filters('w2rr_comment_status', $comment_status, $this);
		
		return $comment_status;
	}
}

?>