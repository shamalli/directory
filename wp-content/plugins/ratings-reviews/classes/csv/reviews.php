<?php

class w2rr_csv_import_export_reviews {
	public $csv_manager;
	public $collation_fields;
	public $export_rows_counter;
	public $total_rejected_lines;
	public $ratings_criterias;
	
	public function __construct($csv_manager) {
		$this->csv_manager = $csv_manager;
	}
	
	public function buildCollationColumns() {
		$this->csv_manager->collation_fields = array(
				'review_id' => esc_html__('Review ID* (existing review)', 'W2RR'),
				'post_id' => esc_html__('post ID*', 'W2RR'),
				'title' => esc_html__('Title*', 'W2RR'),
				'user' => esc_html__('Author', 'W2RR'),
				'content' => esc_html__('Description', 'W2RR'),
				'pros' => esc_html__('Pros', 'W2RR'),
				'cons' => esc_html__('Cons', 'W2RR'),
				'images' => esc_html__('Images files', 'W2RR'),
				'creation_date' => esc_html__('Creation date', 'W2RR'),
				'ratings' => esc_html__('Rating or multi-ratings', 'W2RR'),
				'votes' => esc_html__('Votes', 'W2RR'),
		);
		
		$this->csv_manager->collation_fields = apply_filters('w2rr_csv_collation_fields_list', $this->csv_manager->collation_fields);
		
		if ($this->csv_manager->import_type == 'create_reviews') {
			unset($this->csv_manager->collation_fields['review_id']);
		}
		
		return $this->csv_manager->collation_fields;
	}
	
	public function validateSettings($validation) {
		$validation->set_rules('author', esc_html__('Reviews author', 'W2RR'), 'required|numeric');
	}
	
	public function buildSettings($validation) {
		$this->csv_manager->selected_user = $validation->result_array('author');
	}
	
	public function addTemplateFields($template_fields) {
		return array_merge($template_fields, array(
				'author' => $this->csv_manager->selected_user,
		));
	}
	
	public function checkFields() {
		if ($this->csv_manager->import_type == 'update_reviews' && !in_array('review_id', $this->csv_manager->collated_fields)) {
			$this->csv_manager->log['errors'][] = esc_attr__("Post ID field wasn't collated", 'W2RR');
		}
		if ($this->csv_manager->import_type == 'create_reviews' && !in_array('title', $this->csv_manager->collated_fields)) {
			$this->csv_manager->log['errors'][] = esc_attr__("Title field wasn't collated", 'W2RR');
		}
		if ($this->csv_manager->import_type == 'create_reviews' && $this->csv_manager->selected_user != 0 && !get_userdata($this->csv_manager->selected_user)) {
			$this->csv_manager->log['errors'][] = esc_attr__("There isn't author user you selected", 'W2RR');
		}
		if ($this->csv_manager->import_type == 'create_reviews' && $this->csv_manager->selected_user == 0 && !in_array('user', $this->csv_manager->collated_fields)) {
			$this->csv_manager->log['errors'][] = esc_attr__("Author field wasn't collated and default author wasn't selected", 'W2RR');
		}
	}
	
	public function processCSVImport() {
		global $w2rr_instance;
		
		$this->ratings_criterias = w2rr_getMultiRatings();
		
		$this->total_rejected_lines = 0;
		foreach ($this->csv_manager->rows as $line=>$row) {
			$n = $line+1;
			printf(esc_html__('Importing line %d...', 'W2RR'), $n);
			echo "<br />";
			$error_on_line = false;
			$review_data = array();
			foreach ($this->csv_manager->collated_fields as $i=>$field) {
				$value = htmlspecialchars_decode(trim($row[$i])); // htmlspecialchars_decode() needed due to &amp; symbols in import files, ';' symbols can break import
		
				if ($field == 'review_id' && $this->csv_manager->import_type == 'update_reviews') {
					if (($post = get_post($value)) && ($review = w2rr_getReview($post))) {
						$review_data['existing_review'] = $review;
						$review_data['review_id'] = $value;
					} else {
						$error = sprintf(__('Error on line %d: ', 'W2RR') . esc_attr__("Review with ID \"%d\" doesn't exist", 'W2RR'), $n, $value);
						$error_on_line = $this->csv_manager->setErrorOnLine($error);
					}
				}
		
				if ($field == 'post_id') {
					if ($target_post = get_post($value)) {
						$review_data['post_id'] = $value;
					} else {
						$error = sprintf(__('Error on line %d: ', 'W2RR') . esc_attr__("Post with ID \"%d\" doesn't exist", 'W2RR'), $n, $value);
						$error_on_line = $this->csv_manager->setErrorOnLine($error);
					}
				} elseif ($field == 'title') {
					$review_data['title'] = $value;
					printf(esc_html__('Review title: %s', 'W2RR'), $value);
					echo "<br />";
				} elseif ($field == 'user') {
					if (!$this->csv_manager->selected_user) {
						$user_info = explode('>', $value);
						if (is_array($user_info) && !is_numeric($user_info[0]) && filter_var($user_info[1], FILTER_VALIDATE_EMAIL) && ($key = array_search($user_info[1], $this->csv_manager->users_emails)) !== FALSE) {
							// if it is existing user with format user_name>user@email.com
							$review_data['user_id'] = $this->csv_manager->users_ids[$key];
						} elseif ((($key = array_search($value, $this->csv_manager->users_logins)) !== FALSE) || (($key = array_search($value, $this->csv_manager->users_emails)) !== FALSE) || (($key = array_search($value, $this->csv_manager->users_ids))) !== FALSE) {
							// if it is existing user by login, email or ID
							$review_data['user_id'] = $this->csv_manager->users_ids[$key];
						} else {
							// it is new user
							if (!is_numeric($user_info[0]) && filter_var($user_info[1], FILTER_VALIDATE_EMAIL)) {
								$review_data['user_info'] = $user_info;
							} else {
								$error = sprintf(__('Error on line %d: ', 'W2RR') . esc_attr__("User \"%s\" doesn't exist and format does not allow to create new user", 'W2RR'), $n, $value);
								$error_on_line = $this->csv_manager->setErrorOnLine($error);
							}
						}
					} else {
						$review_data['user_id'] = $this->csv_manager->selected_user;
					}
				} elseif ($field == 'content') {
					$review_data['content'] = $value;
				} elseif ($field == 'images') {
					if ($this->csv_manager->images_dir) {
						$review_data['images'] = array_filter(array_map('trim', explode($this->csv_manager->values_separator, $value)));
					} else {
						$images_value = array_filter(array_map('trim', explode($this->csv_manager->values_separator, $value)));
						$validation = new w2rr_form_validation();
						$this_is_import_by_URL = false;
						foreach ($images_value AS $image_url) {
							if ($validation->valid_url($image_url, false)) {
								$review_data['images'][] = $image_url;
								$this_is_import_by_URL = true;
							} else {
								$error = sprintf(__('Error on line %d: ', 'W2RR') . sprintf(esc_attr__("Incorrect image URL %s", 'W2RR'), $image_url), $n);
								$error_on_line = $this->csv_manager->setErrorOnLine($error);
							}
						}
						if (!$this_is_import_by_URL) {
							$error = sprintf(__('Error on line %d: ', 'W2RR') . esc_attr__("Images column was specified, but ZIP archive wasn't upload", 'W2RR'), $n);
							$error_on_line = $this->csv_manager->setErrorOnLine($error);
						}
					}
				} elseif ($field == 'creation_date') {
					if (!($timestamp = strtotime($value))) {
						$error = sprintf(__('Error on line %d: ', 'W2RR') . esc_attr__("Creation date value is incorrect", 'W2RR'), $n);
						$error_on_line = $this->csv_manager->setErrorOnLine($error);
					} else
						$review_data['creation_date'] = $timestamp;
				} elseif ($field == 'ratings') {
					if (is_numeric($value)) {
						$review_data['avg_rating'] = $value;
					} else {
						if ($this->ratings_criterias) {
							$ratings = array_filter(array_map('trim', explode($this->csv_manager->values_separator, $value)));
							if ($ratings) {
								$review_data['ratings'] = $ratings;
							} else {
								$error = sprintf(__('Error on line %d: ', 'W2RR') . esc_attr__("Can not recognize ratings", 'W2RR'), $n);
								$error_on_line = $this->csv_manager->setErrorOnLine($error);
							}
						}
					}
				} elseif ($field == 'votes') {
					$review_data['votes'] = array_filter(array_map('trim', explode($this->csv_manager->values_separator, $value)));
				} elseif ($field == 'pros') {
					$review_data['pros'] = $value;
				} elseif ($field == 'cons') {
					$review_data['cons'] = $value;
				}
				
				$review_data = apply_filters('w2rr_csv_process_fields', $review_data, $field, $value);
			}
		
			if (!$error_on_line) {
				if (!$this->csv_manager->test_mode) {
					if ($this->csv_manager->import_type == 'create_reviews') {
						$new_post_args = array(
								'post_title' => $review_data['title'],
								'post_type' => W2RR_REVIEW_TYPE,
								'post_author' => $this->csv_manager->processUser($review_data, $n),
								'post_status' => 'publish',
								'post_content' => (isset($review_data['content']) ? $review_data['content'] : ''),
								'post_date' => (isset($review_data['creation_date']) ? date('Y-m-d H:i:s', $review_data['creation_date']) : ''),
						);
						$new_review_id = wp_insert_post($new_post_args);
						
						$w2rr_instance->reviews_manager->saveReviewMeta($new_review_id);
						
						if (isset($review_data['post_id'])) {
							add_post_meta($new_review_id, '_post_id', $review_data['post_id']);
						}
						if (isset($review_data['images'])) {
							$this->csv_manager->processImages($new_review_id, $review_data, $n);
						}
						if (isset($review_data['avg_rating'])) {
							add_post_meta($new_review_id, '_avg_rating', $review_data['avg_rating']);
						}
						if (isset($review_data['ratings'])) {
							$this->processRatings($new_review_id, $review_data, $n);
						}
						if (isset($review_data['votes'])) {
							$this->processVotes($new_review_id, $review_data, $n);
						}
						if (isset($review_data['pros'])) {
							add_post_meta($new_review_id, '_pros', $review_data['pros']);
						}
						if (isset($review_data['cons'])) {
							add_post_meta($new_review_id, '_cons', $review_data['cons']);
						}
		
						do_action('w2rr_csv_create_review', $new_review_id, $review_data);
					} elseif ($this->csv_manager->import_type == 'update_reviews') {
						// -------------------- Update existing review by ID ------------------------------------------------------------------------------------------------------------------
						$existing_review_id = $review_data['review_id'];
		
						$existing_post_args = array(
								'ID' => $existing_review_id,
						);
						if (isset($review_data['user_id']) || isset($review_data['user_info']) || $this->csv_manager->selected_user) {
							$existing_post_args['post_author'] = $this->csv_manager->processUser($review_data, $n);
						}
						if (isset($review_data['title'])) {
							$existing_post_args['post_title'] = $review_data['title'];
						}
						if (isset($review_data['content'])) {
							$existing_post_args['post_content'] = $review_data['content'];
						}
						if (isset($review_data['creation_date'])) {
							$existing_post_args['post_date'] = date('Y-m-d H:i:s', $review_data['creation_date']);
						}
						wp_update_post($existing_post_args);
		
						if (isset($review_data['post_id'])) {
							update_post_meta($existing_review_id, '_post_id', $review_data['post_id']);
						}
						if (isset($review_data['images'])) {
							wp_delete_attachment($existing_review_id);
							delete_post_meta($existing_review_id, '_attached_image');
		
							$this->csv_manager->processImages($existing_review_id, $review_data, $n);
						}
						if (isset($review_data['avg_rating'])) {
							update_post_meta($existing_review_id, '_avg_rating', $review_data['avg_rating']);
						}
						if (isset($review_data['ratings'])) {
							$this->processRatings($existing_review_id, $review_data, $n);
						}
						if (isset($review_data['votes'])) {
							$this->processVotes($existing_review_id, $review_data, $n);
						}
						if (isset($review_data['pros'])) {
							update_post_meta($existing_review_id, '_pros', $review_data['pros']);
						}
						if (isset($review_data['cons'])) {
							update_post_meta($existing_review_id, '_cons', $review_data['cons']);
						}
		
						do_action('w2rr_csv_update_review', $existing_review_id, $review_data);
					}
					wp_cache_flush();
				}
			} else {
				$this->total_rejected_lines++;
			}
		}
	}
	
	public function processRatings($review_id, &$review_data, $line_n) {
		global $w2rr_instance;

		$post_id = get_post_meta($review_id, '_post_id', true);
		
		if ($ratings_criterias = w2rr_getMultiRatings()) {
			$total_rating = 0;
			foreach ($ratings_criterias AS $key=>$criteria) {
				$rating = $review_data['ratings'][$key];
				$total_rating += $rating;
			}
			$avg_rating = ($total_rating/count($ratings_criterias)+1)/2;
				
			$w2rr_instance->ratings_manager->save_rating($post_id, $avg_rating, $review_id);
		} else {
			$rating = get_post_meta($review_id, '_avg_rating', true);
				
			$w2rr_instance->ratings_manager->save_rating($post_id, $rating, $review_id);
		}
		
		if ($ratings_criterias = w2rr_getMultiRatings()) {
			$total_rating = 0;
			foreach ($ratings_criterias AS $key=>$criteria) {
				$rating = $review_data['ratings'][$key];
				$review_ratings[$key] = $rating;
				$total_rating += $rating;
			}
			$avg_rating = ($total_rating/count($ratings_criterias)+1)/2;
				
			update_post_meta($review_id, '_review_ratings', $review_ratings);
			update_post_meta($review_id, '_avg_rating', $avg_rating);
		}
		
		$w2rr_instance->reviews_manager->updatePostRatings($post_id);
	}
	
	public function processVotes($review_id, &$review_data, $line_n) {
		global $wpdb;
		
		$like = $wpdb->esc_like('_review_vote_');
		$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key LIKE %s", $review_id, $like.'%'), ARRAY_A);
		
		$votes_up = 0;
		$votes_down = 0;
		foreach ($review_data['votes'] AS $vote) {
			$vote = explode('>', $vote);
			$vote_user = $vote[0];
			$vote_num = $vote[1];
			
			if ($vote_num == 1) {
				$votes_up++;
			} elseif ($vote_num == 0) {
				$votes_down++;
			}
			
			add_post_meta($review_id, '_review_vote_' . $vote_user, $vote_num);
		}
		update_post_meta($review_id, '_votes_sum', $votes_up - $votes_down);
	}
	
	public function csvExport($number, $offset) {
		global $wpdb, $w2rr_instance;
		
		$ratings_criterias = w2rr_getMultiRatings();
		
		$csv_columns = array(
				'review_id',
				'post_id',
				'title',
				'user',
				'description',
				'images',
				'date',
				'ratings',
				'votes',
		);
		
		$csv_output[] = $csv_columns;
		
		$args = array(
				'post_type' => W2RR_REVIEW_TYPE,
				'orderby' => 'ID',
				'order' => 'ASC',
				'post_status' => 'publish,private,draft,pending',
				'posts_per_page' => $number,
				'offset' => $offset,
		);
		
		$args = apply_filters("w2rr_csv_export_args", $args);
		
		$query = new WP_Query($args);
		$this->export_rows_counter = 0;
		while ($query->have_posts()) {
			$this->export_rows_counter++;
			$query->the_post();
			$post = get_post();
			$review = w2rr_getReview($post);
				
			$review_id = $review->post->ID;
			
			$ratings = array();
			if ($ratings_criterias) {
				$ratings = implode(';', get_post_meta($review_id, '_review_ratings', true));
			} else {
				$ratings = $review->avg_rating;
			}
			
			$votes = array();
			$like = $wpdb->esc_like('_review_vote_');
			$results = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key LIKE %s", $review_id, $like.'%'), ARRAY_A);
			foreach ($results AS $row) {
				$votes[] = str_replace('_review_vote_', '', $row['meta_key']) . '>' . $row['meta_value'];
			}
				
			$images = array();
			foreach ($review->images AS $attachment_id=>$image) {
				$image_src = wp_get_attachment_image_src($attachment_id, 'full');
				$image_item = basename($image_src[0]);
				if ($image['post_title']) {
					$image_item .= ">" . $image['post_title'];
				}
				$images[] = $image_item;
			}
		
			$row = array(
					$review_id,
					get_post_meta($review_id, '_post_id', true),
					$review->title(),
					$review->post->post_author,
					$review->post->post_content,
					implode(';', $images),
					date('d.m.Y H:i', mysql2date('U', $review->post->post_date)),
					$ratings,
					implode(';', $votes),
			);
		
			$csv_output[] = $row;
		}
		
		$csv_output = apply_filters("w2rr_csv_export_output", $csv_output);
		
		return $csv_output;
	}
	
	public function csvExportFileName() {
		return 'w2rr-reviews--' . date('Y-m-d_H_i_s') . '--' . $this->export_rows_counter . '.csv';
	}
}
?>