<?php

class w2rr_reviews_manager {
	
	public function __construct() {
		
		add_action('add_meta_boxes', array($this, 'addPostMetabox'));
		add_action('add_meta_boxes', array($this, 'addMediaMetabox'));
		add_action('add_meta_boxes', array($this, 'addRatingMetabox'));
		if (get_option('w2rr_enable_pros_cons')) {
			add_action('add_meta_boxes', array($this, 'addProsConsMetabox'), 8, 2);
		}
		
		add_filter('postbox_classes_' . W2RR_REVIEW_TYPE . '_w2rr_review_post', array($this, 'addMetaboxClasses'));
		
		add_filter('manage_'.W2RR_REVIEW_TYPE.'_posts_columns', array($this, 'add_reviews_table_columns'));
		add_filter('manage_'.W2RR_REVIEW_TYPE.'_posts_custom_column', array($this, 'manage_reviews_table_rows'), 10, 2);
		
		// do not allow Post Type Switcher plugin to break attachment post
		add_filter('pts_allowed_pages', array($this, 'avoid_post_type_switcher'));
		
		if ((isset($_POST['publish']) || isset($_POST['save'])) && (isset($_POST['post_type']) && $_POST['post_type'] == W2RR_REVIEW_TYPE)) {
			// the post with empty title will not call this filter!
			add_filter('wp_insert_post_data', array($this, 'validateReview'), 99, 2);

			add_action('save_post_' . W2RR_REVIEW_TYPE, array($this, 'saveReview'), 10, 3);
		}
			
		add_action('wp_ajax_w2rr_review_vote', array($this, 'review_vote'));
		add_action('wp_ajax_nopriv_w2rr_review_vote', array($this, 'review_vote'));
			
		add_action('w2rr_login_registration_pages', array($this, 'login_registration_pages'));
			
		add_action('transition_post_status', array($this, 'on_review_status_change'), 10, 3);
		add_action('transition_post_status', array($this, 'on_review_approval'), 10, 3);
		
		add_action('trashed_post', array($this, 'delete_review_ratings'));
		add_action('delete_post', array($this, 'delete_review_ratings'));
		add_action('untrashed_post', array($this, 'restore_review_ratings'));
		
		add_action('w2rr_reset_ratings', array($this, 'updatePostRatings'));
		
		add_filter('w2rr_get_edit_review_link', array($this, 'edit_review_link'), 10, 2);
		
		add_filter('w2rr_count_attachments', array($this, 'count_attachments'), 10, 2);
		
		add_filter('comments_open', array($this, 'disable_reviews_on_selected_pages'), 10, 2);
		
		// disable comments at the page template, render comments only in review template
		// 'w2dc_comments_open' filter in w2dc_hooks.php will pass true
		add_filter('comments_open', array($this, 'disable_comments_on_review_page_template'), 1000, 2);
		add_filter('get_comments_number', array($this, 'disable_comments_on_review_page_template'), 1000, 2);
		
		add_filter('request', array( $this, 'posts_filter'));
	}

	public function addMetaboxClasses($classes = array()) {
		$classes[] = 'w2rr-sidebar-metabox';
		
		return $classes;
	}
	
	public function addPostMetabox($post_type) {
		if ($post_type == W2RR_REVIEW_TYPE) {
			add_meta_box('w2rr_review_post',
			esc_html__('Review for a post', 'W2RR'),
			array($this, 'postMetabox'),
			W2RR_REVIEW_TYPE,
			'side',
			'core');
		}
	}
	
	public function addRatingMetabox($post_type) {
		if ($post_type == W2RR_REVIEW_TYPE) {
			if (w2rr_getMultiRatings()) {
				add_meta_box('w2rr_ratings_criterias',
				esc_html__('Review ratings', 'W2RR'),
				array($this, 'ratingsCriteriasMetabox'),
				W2RR_REVIEW_TYPE,
				'normal',
				'high');
			} else {
				add_meta_box('w2rr_rating',
				esc_html__('Review rating', 'W2RR'),
				array($this, 'ratingMetabox'),
				W2RR_REVIEW_TYPE,
				'normal',
				'high');
			}
		}
	}
	
	public function ratingMetabox($post) {
		$review = w2rr_getReview($post);
		
		w2rr_renderAvgRating($review->avg_rating, $review->post->ID, array('show_counter' => false));
	}
	
	public function addMediaMetabox($post_type) {
		global $w2rr_instance, $post;
		
		if ($post_type == W2RR_REVIEW_TYPE) {
			if (get_option("w2rr_reviews_images_number")) {
				$review = w2rr_getReview($post);
				$w2rr_instance->media_manager->load_media(array(
						'images' => $review->images,
				));
				$w2rr_instance->media_manager->load_params(array(
						'object_id' => $post->ID,
						'images_number' => get_option("w2rr_reviews_images_number"),
						'videos_number' => 0,
						'logo_enabled' => false,
				));
	
				add_action('admin_enqueue_scripts', array($w2rr_instance->media_manager, 'admin_enqueue_scripts_styles'));
					
				add_meta_box('w2rr_media_metabox',
				esc_html__('Review media', 'W2RR'),
				array($w2rr_instance->media_manager, 'mediaMetabox'),
				W2RR_REVIEW_TYPE,
				'normal',
				'high',
				array('target' => 'reviews'));
			}
		}
	}
	
	public function addProsConsMetabox($post_type, $post) {
		if ($post_type == W2RR_REVIEW_TYPE) {
			add_meta_box('w2rr_pros_cons',
			esc_html__('Pros and Cons', 'W2RR'),
			array($this, 'prosConsMetabox'),
			W2RR_REVIEW_TYPE,
			'normal',
			'high');
		}
	}
	
	public function prosConsMetabox($post) {
		$review = w2rr_getReview($post);
	
		w2rr_renderTemplate('ratings_reviews/pros_cons_metabox.tpl.php', array('review' => $review));
	}
	
	public function count_attachments($do_upload, $post_id) {
		if ($review = w2rr_getReview($post_id)) {
			$existed_images_count = count($review->images);
			
			if ($existed_images_count >= get_option("w2rr_reviews_images_number")) {
				$do_upload = false;
			}
		}
	
		return $do_upload;
	}
	
	public function postMetabox($post) {
		global $w2rr_instance;
		
		$posts = get_posts(
				array(
						'post_type'   => w2rr_getWorkingPostTypes(),
						'orderby'     => 'title',
						'order'       => 'ASC',
						'numberposts' => -1
				)
		);
	
		$post_id = false;
		$selected_post = false;
		if ($post_id = get_post_meta($post->ID, '_post_id', true)) {
			if (get_post($post_id)) {
				$selected_post = get_post($post_id);
			}
		} else {
			if ($post_id = w2rr_getValue($_GET, 'target_post_id')) {
				if ($post = get_post($post_id)) {
					$selected_post = $post;
				}
			}
		}
		
		w2rr_renderTemplate('ratings_reviews/review_post_metabox.tpl.php', array('posts' => $posts, 'selected_post_id' => $post_id, 'selected_post' => $selected_post));
	}
	
	public function getRatingsCriterias() {
		return w2rr_getMultiRatings();
	}
	
	public function ratingsCriteriasMetabox($post) {
		$review_ratings = get_post_meta($post->ID, '_review_ratings', true);
		
		$ratings_criterias = $this->getRatingsCriterias();
		
		w2rr_renderTemplate('ratings_reviews/review_ratings_metabox.tpl.php', array('review_ratings' => $review_ratings, 'ratings_criterias' => $ratings_criterias));
	}
	
	public function add_reviews_table_columns($columns) {
		global $w2rr_instance;
	
		$w2rr_columns['w2rr_rating'] = esc_html__('Rating', 'W2RR');
		$w2rr_columns['w2rr_post'] = esc_html__('Post', 'W2RR');

		return array_slice($columns, 0, 2, true) + $w2rr_columns + array_slice($columns, 2, count($columns)-2, true);
	}
	
	public function manage_reviews_table_rows($column, $post_id) {
		switch ($column) {
			case "w2rr_post":
				if ($target_post = w2rr_getTargetPost(get_post_meta($post_id, '_post_id', true))) {
					echo edit_post_link($target_post->title(), '', '', $target_post->post->ID);
				}
				break;
			case "w2rr_rating":
				$review = w2rr_getReview($post_id);
				//$review->renderStars();
				$review->renderAvgRating(array('active' => false, 'show_counter' => false, 'show_avg' => true, 'stars_size' => 20));
				break;
		}
	}
	
	public function validateReview($data, $postarr) {
		if ($data['post_type'] == W2RR_REVIEW_TYPE) {
			global $w2rr_instance, $post;
	
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
	
			$errors = array();
				
			if (empty($postarr['w2rr_post_id'])) {
				$errors[] = esc_html__('Select post for review!', 'W2RR');
			}
			
			if (empty($postarr['content']) && get_option('w2rr_enable_description')) {
				$errors[] = esc_html__('Review description field required!', 'W2RR');
			}
	
			if (get_option("w2rr_reviews_images_number")) {
				$w2rr_instance->media_manager->load_params(array(
						'object_id' => $post->ID,
						'images_number' => get_option("w2rr_reviews_images_number"),
						'videos_number' => 0,
						'logo_enabled' => false,
				));
				
				if ($validation_results = $w2rr_instance->media_manager->validateAttachments($errors)) {
					$w2rr_instance->media_manager->saveAttachments($validation_results);
				}
			}
	
			// only successfully validated reviews can be completed
			if ($errors) {
				foreach ($errors AS $error) {
					w2rr_addMessage($error, 'error');
				}
			} else {
				w2rr_addMessage(esc_html__('Review was saved successfully!', 'W2RR'));
			}
		}
		return $data;
	}
	
	public function getReviewsOfPost($post_id) {
		$args = array(
				'post_type' => W2RR_REVIEW_TYPE,
				'post_status' => 'publish',
				'meta_query' => array(
						array(
							'key' => '_post_id',
							'value' => $post_id
						)
				),
				'posts_per_page' => -1,
		);
		
		$reviews_posts = get_posts($args);
		
		return $reviews_posts;
	}
	
	public function saveReviewRatings($review_id) {
		if ($ratings_criterias = $this->getRatingsCriterias()) {
			$total_rating = 0;
			foreach ($ratings_criterias AS $key=>$criteria) {
				$rating = w2rr_getValue($_POST, 'w2rr_review_rating_' . $key, 9);
				$review_ratings[$key] = $rating;
				$total_rating += $rating;
			}
			$avg_rating = ($total_rating/count($ratings_criterias)+1)/2;
				
			update_post_meta($review_id, '_review_ratings', $review_ratings);
			update_post_meta($review_id, '_avg_rating', $avg_rating);
		} else {
			$rating = w2rr_getValue($_POST, 'w2rr-rating-noajax-' . $review_id, 5);
				
			update_post_meta($review_id, '_avg_rating', $rating);
		}
	}
	
	public function saveAllRatings($review_id) {
		global $w2rr_instance;
		
		$post_id = get_post_meta($review_id, '_post_id', true);
		
		if ($ratings_criterias = $this->getRatingsCriterias()) {
			$total_rating = 0;
			foreach ($ratings_criterias AS $key=>$criteria) {
				$rating = w2rr_getValue($_POST, 'w2rr_review_rating_' . $key, 9);
				//$review_ratings[$key] = $rating;
				$total_rating += $rating;
			}
			$avg_rating = ($total_rating/count($ratings_criterias)+1)/2;
			
			$w2rr_instance->ratings_manager->save_rating($post_id, $avg_rating, $review_id);
		} else {
			$rating = w2rr_getValue($_POST, 'w2rr-rating-noajax-' . $review_id, 5);
			
			$w2rr_instance->ratings_manager->save_rating($post_id, $rating, $review_id);
		}
		
		$this->saveReviewRatings($review_id);
		
		$this->updatePostRatings($post_id);
	}
	
	public function updatePostRatings($post_id) {
		global $w2rr_instance, $wpdb;
		
		// collect all active reviews of the target post
		$active_reviews_ids = array();
		if ($reviews_posts = $this->getReviewsOfPost($post_id)) {
			foreach ($reviews_posts AS $post) {
				$review = $post;
				$active_reviews_ids[] = $review->ID;
			}
		}
		
		// delete unnecessary reviews ratings from target post's meta
		$like = $wpdb->esc_like('_rating_review_');
		$results = $wpdb->get_results($wpdb->prepare("SELECT meta_id, meta_key FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key LIKE %s", $post_id, $like.'%'), ARRAY_A);
		foreach ($results AS $row) {
			$review_id = str_replace('_rating_review_', '', $row['meta_key']);
			
			if (!in_array($review_id, $active_reviews_ids)) {
				delete_post_meta($post_id, $row['meta_key']);
			}
		}
		
		// update average rating
		if ($active_reviews_ids) {
			foreach ($active_reviews_ids AS $review_id) {
				$avg_rating = get_post_meta($review_id, '_avg_rating', true);
				
				$w2rr_instance->ratings_manager->save_rating($post_id, $avg_rating, $review_id);
			}
		} else {
			delete_post_meta($post_id, '_avg_rating');
		}
	}
	
	public function delete_review_ratings($post_id) {
		if (get_post_type($post_id) == W2RR_REVIEW_TYPE) {
			$review = w2rr_getReview($post_id);
			$review_id = $review->post->ID;
			if ($review->target_post) {
				$post_id = $review->target_post->post->ID;
				
				delete_post_meta($post_id, '_rating_review_' . $review_id);
				
				$this->updatePostRatings($post_id);
			}
		}
	}
	
	public function restore_review_ratings($post_id) {
		if (get_post_type($post_id) == W2RR_REVIEW_TYPE) {
			$review = w2rr_getReview($post_id);
			$post_id = $review->target_post->post->ID;
			
			$this->updatePostRatings($post_id);
		}
	}
	
	public function saveReviewMeta($post_ID) {
		if (!get_post_meta($post_ID, '_review_created', true)) {
			add_post_meta($post_ID, '_review_created', true);
			add_post_meta($post_ID, '_order_date', time());
			add_post_meta($post_ID, '_votes_sum', 0);
		}
	}
	
	public function saveReview($post_ID, $post, $update) {
		if (!empty($_POST['w2rr_post_id'])) {
			$target_post_id = $_POST['w2rr_post_id'];
			
			update_post_meta($post_ID, '_post_id', $target_post_id);
		
			$this->saveAllRatings($post_ID);
			
			$this->saveReviewMeta($post_ID);
			
			update_post_meta($post->ID, '_pros', w2rr_getValue($_POST, 'pros'));
			update_post_meta($post->ID, '_cons', w2rr_getValue($_POST, 'cons'));
			
			do_action('w2rr_save_review', $post_ID);
		}
	}
	
	public function avoid_post_type_switcher($pages) {
		if (w2rr_getValue($_POST, 'post_type') == W2RR_REVIEW_TYPE) {
			return;
		}
		return $pages;
	}
	
	public function get_reviews_counter($target_post) {
		global $wpdb;
		
		$reviews_counter = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} AS p LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_ID WHERE p.post_type='" . W2RR_REVIEW_TYPE . "' AND p.post_status='publish' AND pm.meta_key='_post_id' AND pm.meta_value={$target_post->post->ID}");
		
		return $reviews_counter;
	}
	
	public function comments_label($label, $target_post) {
		$reviews_counter = $this->get_reviews_counter($target_post);
		
		return _n('Review', 'Reviews', $reviews_counter, 'W2RR') . ' (' . $reviews_counter . ')';
	}
	
	public function comments_reply_label($label, $target_post) {
		$reviews_counter = $this->get_reviews_counter($target_post);
		
		return $reviews_counter . ' ' . _n('review', 'reviews', $reviews_counter, 'W2RR');
	}
	
	public function login_registration_pages($pages) {
		global $wp_query;
		
		if ($wp_query && get_query_var("add-review") == 'add') {
			$pages[] = array('id' => get_the_ID());
		}
	
		return $pages;
	}
	
	public function setup_breadcrumbs(&$controller) {
		$target_post = $controller->getTargetPost();
			
		if ($target_post && get_option('w2rr_enable_breadcrumbs')) {
			$target_post_url = get_the_permalink($target_post->post->ID);
			$controller->addBreadCrumbs(new w2rr_breadcrumb($target_post->title(), rtrim($target_post_url, '/')));
		}
	
		return $target_post;
	}
	
	public function on_review_status_change($new_status, $old_status, $post) {
		if (
		$post->post_type == W2RR_REVIEW_TYPE &&
		($review = w2rr_getReview($post))
		) {
			$this->updatePostRatings($post->ID);
			
			do_action('w2rr_review_status_changed', $new_status, $old_status, $post);
		}
	}
	
	public function on_review_approval($new_status, $old_status, $post) {
		global $w2rr_instance;
		
		if (get_option('w2rr_approval_review_notification')) {
			if (
			$post->post_type == W2RR_REVIEW_TYPE &&
			'publish' == $new_status &&
			'pending' == $old_status &&
			($review = w2rr_getReview($post)) &&
			($author = get_userdata($review->post->post_author))
			) {
				update_post_meta($post->ID, '_review_approved', true);
	
				$subject = esc_html__('Approval of review', 'W2RR');
	
				$link = '';
				if ($w2rr_instance->dashboard_page_id) {
					$link = w2rr_dashboardUrl();
				}
					
				$body = str_replace('[author]', $author->display_name,
						str_replace('[review]', $review->title(),
						str_replace('[link]', $link,
						get_option('w2rr_approval_review_notification'))));
	
				w2rr_mail($author->user_email, $subject, $body);
			}
		}
	}
	
	public function review_vote() {
		$post_id = w2rr_getValue($_POST, 'post_id');
		$vote = w2rr_getValue($_POST, 'vote');
		$_wpnonce = wp_verify_nonce(w2rr_getValue($_POST, '_wpnonce'), 'review_vote');
	
		if (($post = get_post($post_id)) && ($vote == 'up' || $vote == 'down') && $_wpnonce) {
			$vote_num = ($vote == 'up') ? 1 : 0;
				
			$user_id = get_current_user_id();
			$ip = w2rr_ip_address();
	
			if (!$this->is_review_voted($post->ID)) {
				if ($user_id) {
					add_post_meta($post->ID, '_review_vote_' . $user_id, $vote_num);
				} elseif ($ip) {
					add_post_meta($post->ID, '_review_vote_' . $ip, $vote_num);
				}
	
				setcookie('_review_vote_' . $post->ID, $vote_num, time() + 31536000, '/');
			} else {
				// possible to change review vote
				if ($user_id) {
					update_post_meta($post->ID, '_review_vote_' . $user_id, $vote_num);
				} elseif ($ip) {
					update_post_meta($post->ID, '_review_vote_' . $ip, $vote_num);
				}
	
				setcookie('_review_vote_' . $post->ID, $vote_num, time() + 31536000, '/');
			}
				
			$review = new w2rr_review;
			$review->loadReviewFromPost($post);
			
			update_post_meta($post->ID, '_votes_sum', $review->votes_up - $review->votes_down);
			
			echo json_encode(array('votes_up' => $review->votes_up, 'votes_down' => $review->votes_down));
		}
		die();
	}
	
	public function is_review_voted($id) {
		if (!isset($_COOKIE['_review_vote_' . $id])) {
			if ($user_id = get_current_user_id()) {
				$meta = get_post_meta($id, '_review_vote_' . $user_id, true);
				if ($meta != '') {
					return true;
				}
			}
	
			if ($ip = w2rr_ip_address()) {
				$meta = get_post_meta($id, '_review_vote_' . $ip, true);
				if ($meta != '') {
					return true;
				}
			}
		} else {
			return true;
		}
	}
	
	public function edit_review_link($url, $post_id) {
		global $w2rr_instance;
	
		if (!is_admin() && isset($w2rr_instance->dashboard_page_id) && ($post = get_post($post_id)) && $post->post_type == W2RR_REVIEW_TYPE) {
			return w2rr_dashboardUrl(array('w2rr_action' => 'edit_review', 'review_id' => $post_id));
		}
	
		return $url;
	}
	
	public function disable_reviews_on_selected_pages($open, $post_id) {
		if (in_array($post_id, w2rr_getSelectedPages())) {
			$open = false;
		}
		
		return $open;
	}
	
	public function disable_comments_on_review_page_template($open, $post_id) {
		if (get_post_type($post_id) == W2RR_REVIEW_TYPE) {
			return false;
		}
		
		return $open;
	}
	
	public function posts_filter($vars) {
		
		if (!empty($_GET['w2rr_target_post'])) {
			
			$post_id = (int) $_GET['w2rr_target_post'];
			
			$vars = array_merge(
					$vars,
					array(
							'meta_query' => array(
									'relation' => 'AND',
									array(
											'key'     => '_post_id',
											'value'   => $post_id,
											'type'    => 'numeric',
									)
							)
					)
			);
		}
		
		return $vars;
	}
}

?>