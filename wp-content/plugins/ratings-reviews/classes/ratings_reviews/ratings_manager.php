<?php

class w2rr_ratings_manager {

	public function __construct() {
		add_action('wp_ajax_w2rr_save_rating', array($this, 'ajax_save_rating'));
		add_action('wp_ajax_nopriv_w2rr_save_rating', array($this, 'ajax_save_rating'));
		
		add_action('wp_ajax_w2rr_delete_single_rating', array($this, 'delete_single_rating'));
		add_action('wp_ajax_nopriv_w2rr_delete_single_rating', array($this, 'delete_single_rating'));
	}
	
	public function delete_single_rating() {
		$post_id = w2rr_getValue($_POST, 'post_id');
		$rating_key = w2rr_getValue($_POST, 'rating_key');
		$_wpnonce = wp_verify_nonce(w2rr_getValue($_POST, '_wpnonce'), 'delete_rating');
		
		if ($_wpnonce) {
			$avg_rating = new w2rr_target_post_avg_rating($post_id);
			if ($result = $avg_rating->delete_rating($rating_key)) {
				wp_send_json_success();
			}
		}
		
		die();
	}
	
	public function ajax_save_rating() {
		$post_id = w2rr_getValue($_POST, 'post_id');
		$rating = w2rr_getValue($_POST, 'rating');
		$_wpnonce = wp_verify_nonce(w2rr_getValue($_POST, '_wpnonce'), 'save_rating');
		
		if ($_wpnonce) {
			if ($this->save_rating($post_id, $rating)) {
				$target_post = w2rr_getTargetPost($post_id);
				
				$out = w2rr_renderAvgRating(
						$target_post->avg_rating,
						$target_post->post->ID,
						array(
								'meta_tags' => false,
								'active' => true,
								'noajax' => false,
								'show_avg' => true,
								'stars_size' => w2rr_get_dynamic_option('w2rr_stars_size'),
						),
				true);
				
				echo json_encode(array('html' => $out));
			}
		}
		
		die();
	}
	
	public function save_rating($post_id, $rating, $review_id = null) {
		
		if (($post = get_post($post_id)) && $rating && ($rating >= 1 && $rating <= 5)) {
			// called from AJAX request
			if (!$review_id) {
				$user_id = get_current_user_id();
				$ip = w2rr_ip_address();
				
				$do_save = true;
				$do_save = apply_filters('w2rr_save_rating', $do_save);
				
				if (!$do_save) {
					return false;
				}
	
				if (!$this->is_post_rated($post->ID)) {
					if ($user_id) {
						add_post_meta($post->ID, '_rating_' . $user_id, $rating);
					} elseif ($ip) {
						add_post_meta($post->ID, '_rating_' . $ip, $rating);
					}
	
					setcookie('_rating_' . $post->ID, $rating, time() + 31536000, '/');
	
					$avg_rating = new w2rr_target_post_avg_rating($post->ID);
					$avg_rating->update_avg_rating();
				} else {
					// possible to change user rating
					if ($user_id) {
						update_post_meta($post->ID, '_rating_' . $user_id, $rating);
					} elseif ($ip) {
						update_post_meta($post->ID, '_rating_' . $ip, $rating);
					}
					
					setcookie('_rating_' . $post->ID, $rating, time() + 31536000, '/');
					
					$avg_rating = new w2rr_target_post_avg_rating($post->ID);
					$avg_rating->update_avg_rating();
				}
			} else {
				// save rating from review
				update_post_meta($post->ID, '_rating_review_' . $review_id, $rating);
				
				$avg_rating = new w2rr_target_post_avg_rating($post->ID);
				$avg_rating->update_avg_rating();
			}
			
			return true;
		}
	}
	
	public function is_post_rated($id) {
		if (!isset($_COOKIE['_rating_' . $id])) {
			if ($user_id = get_current_user_id()) {
				if (get_post_meta($id, '_rating_' . $user_id, true)) {
					return true;
				}
			}
			if ($ip = w2rr_ip_address()) {
				if (get_post_meta($id, '_rating_' . $ip, true)) {
					return true;
				}
			}
		} else {
			return true;
		}
	}
}

?>
