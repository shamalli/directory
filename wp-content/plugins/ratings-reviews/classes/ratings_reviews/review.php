<?php

class w2rr_review extends w2rr_post {
	public $post;
	public $target_post;
	public $images = array();
	public $logo_image = false;
	public $avg_rating;
	public $ratings;
	public $votes = array();
	public $votes_up = 0;
	public $votes_down = 0;
	public $current_user_voted = false;
	public $pros = '';
	public $cons = '';
	
	public function loadReviewFromPost($post) {
		if (!$post) {
			return false;
		}
		
		if ($this->setPost($post)) {
			if ($this->post->post_type == W2RR_REVIEW_TYPE) {
				$this->setTargetPost();
				$this->setMedia();
				$this->setRatings();
				$this->setVotes();
				
				$this->pros = get_post_meta($this->post->ID, '_pros', true);
				$this->cons = get_post_meta($this->post->ID, '_cons', true);
					
				apply_filters('w2rr_review_loading', $this);
			
				return true;
			}
		}
	}
	
	public function setTargetPost() {
		$target_post_id = get_post_meta($this->post->ID, '_post_id', true);
		
		if ($this->target_post = w2rr_getTargetPost($target_post_id)) {
			return $this->target_post;
		}
	}
	
	public function setMedia() {
		if (get_option("w2rr_reviews_images_number")) {
			if ($images = get_post_meta($this->post->ID, '_attached_image')) {
				if ($images_order = explode(',', get_post_meta($this->post->ID, '_attached_images_order', true))) {
					$images = array_flip(array_replace(array_flip(array_unique(array_filter($images_order))), array_flip($images)));
				}
				foreach ($images AS $image_id) {
					// adapted for WPML
					global $sitepress;
					if (function_exists('wpml_object_id_filter') && $sitepress)
						$image_id = apply_filters('wpml_object_id', $image_id, 'attachment', true);
	
					if ($image_post = get_post($image_id, ARRAY_A)) {
						$this->images[$image_id] = $image_post;
					}
				}
	
				if (($logo_id = (int)get_post_meta($this->post->ID, '_attached_image_as_logo', true)) && in_array($logo_id, array_keys($this->images))) {
					$this->logo_image = $logo_id;
				} else {
					$images_keys = array_keys($this->images);
					$this->logo_image = array_shift($images_keys);
				}
			} else {
				$this->images = array();
			}
		}
	
		$this->images = apply_filters('w2rr_review_images', $this->images, $this);
	}
	
	public function setRatings() {
		if (!($avg_value = get_post_meta($this->post->ID, '_avg_rating', true))) {
			$avg_value = 5;
		}
		$this->avg_rating = new w2rr_avg_review_rating($avg_value);
		
		$this->ratings = get_post_meta($this->post->ID, '_review_ratings', true);
	}
	
	public function getAvgRating() {
		return $this->avg_rating->avg_value;
	}
	
	public function setVotes() {
		global $wpdb, $w2rr_instance;
		
		$like = $wpdb->esc_like('_review_vote_');
		
		$results = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key LIKE %s", $this->post->ID, $like.'%'), ARRAY_A);
		foreach ($results AS $row) {
			$this->votes[] = $row;
			if ($row['meta_value']) {
				$this->votes_up++;
			} else {
				$this->votes_down++;
			}
		}
		
		if ($w2rr_instance->reviews_manager->is_review_voted($this->post->ID)) {
			if ($user_id = get_current_user_id()) {
				$meta = get_post_meta($this->post->ID, '_review_vote_' . $user_id, true);
				if ($meta != '') {
					$this->current_user_voted = intval($meta);
					return ;
				}
			}
			if ($ip = w2rr_ip_address()) {
				$meta = get_post_meta($this->post->ID, '_review_vote_' . $ip, true);
				if ($meta != '') {
					$this->current_user_voted = intval($meta);
				}
			}
		}
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
	
	public function getUserPicURL($size = 'user-picture-size') {
		$attachment_id = get_user_meta($this->post->post_author, '_w2rr_user_picture_id', true);
		
		if ($attachment_id && ($img = wp_get_attachment_image_src($attachment_id, $size))) {
			return $img[0];
		}
	}
	
	public function renderUserPic($size = 'user-picture-size') {
		if ($url = $this->getUserPicURL($size)) {
			return '<img src="' . esc_url($url) . '" class="w2rr-review-user-picture" />';
		}
	}
	
	public function printMicrodata() {
		$data = array(
				'@context' => 'http://schema.org',
				'@type' => 'Review',
				'author' => get_the_author_meta('display_name', $this->post->post_author),
				'datePublished' => date('Y-m-d', strtotime($this->post->post_date)),
				'name' => $this->title(),
				'reviewBody' => $this->post->post_content,
				'reviewRating' => array(
						'@type' => 'Rating',
						'bestRating' => 5,
						'ratingValue' => $this->getAvgRating(),
						'worstRating' => 1,
				),
				'itemReviewed' => array(
						'@type' => 'Product',
						'image' => get_the_post_thumbnail_url($this->target_post->post),
						'name' => $this->target_post->post->post_title,
						'url' => get_permalink($this->target_post->post),
						"aggregateRating" => array(
							"@type" => "AggregateRating",
							"ratingValue" => $this->target_post->getAvgRating(),
							"reviewCount" => count($this->target_post->getReviewsIds()),
						),
						
				),
		);
		
		$data = apply_filters("w2rr_review_microdata", $data, $this);
		
		if ($data) {
			echo '<script type="application/ld+json">';
			echo json_encode($data);
			echo '</script>';
		}
	}
	
	public function renderImagesGallery() {
		$thumbs = array();
		$images = array();
		foreach ($this->images AS $attachment_id=>$image) {
			if (!get_option('w2rr_exclude_logo_from_listing') || $this->logo_image != $attachment_id) {
				$image_src = wp_get_attachment_image_src($attachment_id, 'full');
				$image_title = $image['post_title'];
				
				$image_tag = '<img src="' . $image_src[0] . '" alt="' . esc_attr($image_title) . '" title="' . esc_attr($image_title) . '" />';
				$thumbs[] = $image_tag;
				
				if (get_option('w2rr_enable_lightbox_gallery')) {
					$images[] = '<a href="' . $image_src[0] . '" data-w2rr_lightbox="review_images" title="' . esc_attr($image_title) . '">' . $image_tag . '</a>';
				} else {
					$images[] = $image_tag;
				}
			}
		}
		
		w2rr_renderTemplate('frontend/slider.tpl.php', array(
			'captions' => true,
			'pager' => true,
			'width' => (!get_option('w2rr_100_single_logo_width')) ? get_option('w2rr_single_logo_width') : false,
			'height' => (get_option('w2rr_single_logo_height')) ? get_option('w2rr_single_logo_height') : false,
			'images' => $images,
			'thumbs' => $thumbs,
			'crop' => (get_option('w2rr_big_slide_bg_mode') == 'contain') ? 0 : 1,
			'auto_slides' => get_option('w2rr_auto_slides_gallery'),
			'auto_slides_delay' => get_option('w2rr_auto_slides_gallery_delay'),
			'id' => w2rr_generateRandomVal(),
			'slide_width' => false,
			'max_slides' => false,
		));
	}
	
	public function display($frontend_controller, $is_single = false, $return = false) {
		if ($frontend_controller->args['reviews_view_type'] == 'grid') {
			$template = 'ratings_reviews/review_view_grid.tpl.php';
		} else {
			$template = 'ratings_reviews/review_view_list.tpl.php';
		}
	
		$template = apply_filters('w2rr_review_display_template', $template, $is_single, $this);
	
		return w2rr_renderTemplate($template, array('frontend_controller' => $frontend_controller, 'review' => $this, 'is_single' => $is_single), $return);
	}
}

?>