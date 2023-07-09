<?php

/**
 * calculates average rating of a target post and contains target post meta _rating_review_REVIEW_ID
 * 
 *
 */
class w2rr_target_post_avg_rating extends w2rr_avg_rating {
	public $ratings = array();
	public $avg_value = 0;
	public $ratings_count = 0;
	
	private $post_id;
	
	public function __construct($post_id) {
		global $wpdb;
		
		$this->post_id = $post_id;
	
		$like = $wpdb->esc_like('_rating_');
		
		$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key LIKE %s", $post_id, $like.'%'), ARRAY_A);
		foreach ($results AS $row) {
			$rating = new w2rr_target_post_single_rating($row);
			$this->ratings[] = $rating;
			$this->avg_value += $rating->value;
			$this->ratings_count++;
		}
		if ($this->ratings_count) {
			$this->avg_value = $this->avg_value/$this->ratings_count;
		}
		$this->avg_value = number_format(round($this->avg_value, 1), 1);
	}
	
	public function update_avg_rating() {
		update_post_meta($this->post_id, '_avg_rating', $this->avg_value);
	}
	
	public function get_percents_counts($counts) {
		if ($this->ratings) {
			return round($counts/$this->ratings_count*100);
		} else {
			return 0;
		}
	}
	
	public function calculateTotals() {
		$total_counts = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);
		foreach ($this->ratings AS $rating) {
			$total_counts[round($rating->value)]++;
		}
		krsort($total_counts);
		
		return $total_counts;
	}
	
	/**
	 * only ratings without reviews allowed to be deleted directly,
	 * other ratings should be deleted with their reviews
	 */
	public function delete_rating($rating_key) {
		global $wpdb;
		
		$result = $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key=%s", $this->post_id, $rating_key));
		$this->update_avg_rating();
		
		return $result;
	}
}

/**
 * used in w2rr_target_post_avg_rating class,
 * this is single post meta _rating_review_REVIEW_ID
 *
 */
class w2rr_target_post_single_rating {
	public $value;
	public $key;
	public $user;

	public function __construct($row) {
		$this->value = $row['meta_value'];
		$this->key = $row['meta_key'];
		
		$user_key = str_replace('_rating_', '', $this->key);
		if (is_numeric($user_key)) {
			// this is user ID
			if ($user = get_user_by('id', $user_key)) {
				$this->user = $user;
			} else {
				$this->user = 'N/A';
			}
		} elseif (strpos($user_key, 'review_') === false) {
			// this is IP
			$this->user = $user_key;
		}
	}
	
	/**
	 * is used in single_rating.tpl.php to render review rating stars
	 * 
	 * @param int $star_num
	 * @return string
	 */
	public function render_star($star_num) {
		$sub = $this->value - $star_num;
		if ($sub >= 0 || abs($sub) <= 0.25) {
			return 'w2rr-fa-star';
		} elseif (abs($sub) >= 0.25 && abs($sub) <= 0.75) {
			return 'w2rr-fa-star-half-o';
		} else {
			return 'w2rr-fa-star-o';
		}
	}
}

/**
 * parent class to render stars and average ratings
 * 
 * Used by:
 * w2rr_review -> w2rr_avg_review_rating
 * w2rr_target_post_avg_rating -> w2rr_target_post
 *
 */
class w2rr_avg_rating {
	public $avg_value = 0;
	
	public function render_star($star_num) {
		$sub = $this->avg_value - $star_num;
		if ($sub >= 0 || abs($sub) <= 0.25) {
			return 'w2rr-fa-star';
		} elseif (abs($sub) >= 0.25 && abs($sub) <= 0.75) {
			return 'w2rr-fa-star-half-o';
		} else {
			return 'w2rr-fa-star-o';
		}
	}
	
	/**
	 * render stars and optional avg rating circle
	 *
	 * @param int $post_id
	 * @param array $args - default values:
	 $noajax => true,
	 $meta_tags => false,
	 $active => true,
	 $show_avg => false
	 */
	public function render_avg_rating($post_id, $args = array(), $return = false) {
		$args = array_merge(
				array(
						'avg_rating' => $this,
						'post_id' => $post_id,
						'noajax' => true,
						'meta_tags' => false,
						'active' => true,
						'show_avg' => false,
						'stars_size' => w2rr_get_dynamic_option('w2rr_stars_size'),
						'show_counter' => true,
				),
				$args);
	
		return w2rr_renderTemplate('ratings_reviews/avg_rating.tpl.php', $args, $return);
	}
}

?>