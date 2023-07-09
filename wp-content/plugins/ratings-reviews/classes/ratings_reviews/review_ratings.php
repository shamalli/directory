<?php

/**
 * calculates average values of all multi-ratings criterias from a review
 *
 */
class w2rr_avg_review_multiratings {
	public $ratings = array();
	public $ratings_count = 0;
	public $avg_value = 0;
	public $avg_values = array();
	
	private $target_post_id;
	
	public function __construct($target_post_id) {
		global $wpdb;
	
		$this->target_post_id = $target_post_id;
	
		$results = $wpdb->get_results($wpdb->prepare("
				SELECT pm1.meta_value FROM {$wpdb->postmeta} AS pm1
				LEFT JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id=pm2.post_id
				LEFT JOIN {$wpdb->posts} AS posts ON pm2.post_id=posts.ID
				WHERE
				pm1.meta_key='_review_ratings' AND
				pm2.meta_key='_post_id' AND
				pm2.meta_value=%d AND
				posts.post_status='publish'
		", $target_post_id), ARRAY_A);
		
		$totals = array();
		foreach ($results AS $row) {
			$ratings = unserialize($row['meta_value']);
			$this->ratings[] = $ratings;
			$this->ratings_count++;
			foreach ($ratings AS $key=>$rating) {
				if (empty($totals[$key])) {
					$totals[$key] = $rating;
				} else {
					$totals[$key] += $rating;
				}
			}
		}
		
		foreach ($totals AS $key=>$total) {
			$this->avg_values[$key] = $total/$this->ratings_count;
		}
	}
}

/**
 * contains review post meta _avg_rating
 *
 */
class w2rr_avg_review_rating extends w2rr_avg_rating {

	public function __construct($avg_value) {
		$this->avg_value = $avg_value;
		
		$this->avg_value = number_format(round($this->avg_value, 1), 1);
	}
}

?>