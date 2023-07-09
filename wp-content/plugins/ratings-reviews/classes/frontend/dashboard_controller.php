<?php 

class w2rr_dashboard_controller extends w2rr_frontend_controller {
	
	public $referer;
	public $active_tab;
	public $subtemplate;

	public function init($args = array()) {
		global $w2rr_instance, $sitepress;
		
		parent::init($args);
		
		$shortcode_atts = array_merge(array(
				'post_info' => 1,
				'use_wrapper' => 1,
		), $args);
		
		$this->args = $shortcode_atts;
		
		$this->add_template_args($this->args);
		
		$login_registrations = new w2rr_login_registrations;
		if ($login_registrations->is_action()) {
			$this->template = $login_registrations->process($this);
		} elseif (!is_user_logged_in()) {
			if (w2rr_get_wpml_dependent_option('w2rr_submit_login_page') && w2rr_get_wpml_dependent_option('w2rr_submit_login_page') != get_the_ID()) {
				$url = get_permalink(w2rr_get_wpml_dependent_option('w2rr_submit_login_page'));
				$url = add_query_arg('redirect_to', urlencode(get_permalink()), $url);
				wp_redirect($url);
			} else {
				$this->template = $login_registrations->login_template();
			}
		} else {
			if (isset($_POST['referer'])) {
				$this->referer = $_POST['referer'];
			} else {
				$this->referer = wp_get_referer();
			}
			if (isset($_POST['cancel']) && isset($_POST['referer'])) {
				wp_redirect($_POST['referer']);
				die();
			}

			if (!$w2rr_instance->action) {
				if (get_query_var('page'))
					$paged = get_query_var('page');
				elseif (get_query_var('paged'))
					$paged = get_query_var('paged');
				else
					$paged = 1;
			} else {
				$paged = -1;
			}
			
			$review_id = w2rr_getValue($_GET, 'review_id');

			if (!$w2rr_instance->action) {
				$current_user = wp_get_current_user();
				
				$reviews_controller = new w2rr_reviews_controller;
				$args = array(
						'author' => $current_user->ID,
						'status' => 'publish, pending, draft', // Any status
						'perpage' => 10,
				);
				$reviews_controller->init($args);
				
				$this->reviews = array();
				while ($reviews_controller->query->have_posts()) {
					$reviews_controller->query->the_post();
				
					$review = w2rr_getReview(get_the_ID());
					$this->reviews[get_the_ID()] = $review;
				}
				// this is reset is really required after the loop ends
				wp_reset_postdata();
				
				$this->template = 'dashboard/dashboard.tpl.php';
				$this->subtemplate = 'dashboard/reviews.tpl.php';
				$this->active_tab = 'reviews';
				
				$this->add_template_args(array('reviews_controller' => $reviews_controller));
			} elseif ($w2rr_instance->action == 'edit_review' && $review_id) {
				if ($review = w2rr_getReview($review_id)) {
					if (w2rr_current_user_can_edit_review($review->post->ID)) {
						if (get_option("w2rr_reviews_images_number") > 0) {
							$w2rr_instance->media_manager->load_media(array(
									'images' => $review->images,
							));
							$w2rr_instance->media_manager->load_params(array(
									'object_id' => $review_id,
									'images_number' => get_option("w2rr_reviews_images_number"),
									'videos_number' => 0,
									'logo_enabled' => false,
							));
						}
							
						if (isset($_POST['submit'])) {
							$errors = array();
							
							if (!isset($_POST['post_title']) || !trim($_POST['post_title']) || $_POST['post_title'] == esc_html__('Auto Draft', 'W2RR')) {
								$errors[] = esc_html__('Review title field required', 'W2RR');
								$post_title = esc_html__('Auto Draft', 'W2RR');
							} else {
								$post_title = trim($_POST['post_title']);
							}
							
							if (empty($_POST['post_content']) && get_option('w2rr_enable_description')) {
								$errors[] = esc_html__('Review description field required!', 'W2RR');
								$post_content = '';
							} else {
								$post_content = $_POST['post_content'];
							}
							
							if (get_option("w2rr_reviews_images_number") > 0) {
								if ($validation_results = $w2rr_instance->media_manager->validateAttachments($errors)) {
									$w2rr_instance->media_manager->saveAttachments($validation_results);
								}
							}
							
							$w2rr_instance->reviews_manager->saveReviewRatings($review_id);
							
							if ($errors) {
								$postarr = array(
										'ID' => $review_id,
										'post_title' => apply_filters('w2rr_title_save_pre', $post_title, $review),
										'post_name' => apply_filters('w2rr_name_save_pre', '', $review),
										'post_content' => $post_content,
										'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
										'post_type' => W2RR_REVIEW_TYPE,
								);
								$result = wp_update_post($postarr, true);
								if (is_wp_error($result)) {
									$errors[] = $result->get_error_message();
								} else {
									do_action('w2rr_save_review', $review_id);
								}
									
								foreach ($errors AS $error) {
									w2rr_addMessage($error, 'error');
								}
							} else {
								update_post_meta($review_id, '_pros', w2rr_getValue($_POST, 'pros'));
								update_post_meta($review_id, '_cons', w2rr_getValue($_POST, 'cons'));
								
								if ($review->post->post_status == 'publish') {
									if (get_option('w2rr_edit_reviews_moderation')) {
										$post_status = 'pending';
										update_post_meta($review_id, '_requires_moderation', true);
									} else {
										$post_status = 'publish';
									}
								}
								if (get_option('w2rr_edit_reviews_moderation')) {
									$message = esc_attr__("Review was saved successfully! Now it's awaiting moderators approval.", 'W2RR');
								} else {
									$message = esc_html__('Review was saved successfully! Now you can manage it in your dashboard.', 'W2RR');
								}
							
								$postarr = array(
										'ID' => $review_id,
										'post_title' => apply_filters('w2rr_title_save_pre', $post_title, $review),
										'post_name' => apply_filters('w2rr_name_save_pre', '', $review),
										'post_content' => $post_content,
										'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
								);
								if (isset($post_status)) {
									$postarr['post_status'] = $post_status;
								}
							
								$result = wp_update_post($postarr, true);
								if (is_wp_error($result)) {
									w2rr_addMessage($result->get_error_message(), 'error');
								} else {
									$w2rr_instance->reviews_manager->saveAllRatings($review_id);
									
									do_action('w2rr_save_review', $review_id);
									
									w2rr_addMessage($message);
							
									if (get_option('w2rr_editreview_admin_notification')) {
										// When review was published and became pending after modification
										if ($review->post->post_status == 'publish' && $post_status == 'pending') {
											$author = wp_get_current_user();
							
											$subject = esc_html__('Notification about review modification (do not reply)', 'W2RR');
											$body = str_replace('[user]', $author->display_name,
													str_replace('[review]', $review->title(),
													str_replace('[link]', admin_url('post.php?post='.$review->post->ID.'&action=edit'),
													get_option('w2rr_editreview_admin_notification'))));
													
											w2rr_mail(w2rr_getAdminNotificationEmail(), $subject, $body);
										}
									}
									
									if ($post_title != $review->title()) {
										$url = get_the_permalink($review_id);
									} elseif ($this->referer) {
										$url = $this->referer;
									} else {
										$url = w2rr_dashboardUrl(array('w2rr_action' => 'reviews'));
									}
									
									wp_redirect($url);
									die();
								}
							}
							
							// renew data inside $review object
							$review = w2rr_getReview($review_id);
						}
					} else {
						wp_die('You are not able to manage this review', 'W2RR');
					}
					
					if (get_option("w2rr_reviews_images_number") > 0) {
						add_action('wp_enqueue_scripts', array($w2rr_instance->media_manager, 'admin_enqueue_scripts_styles'));
					}
	
					$this->add_template_args(array('review' => $review, 'info_template' => 'dashboard/info_metabox.tpl.php'));
					$this->template = 'dashboard/dashboard.tpl.php';
					$this->subtemplate = 'dashboard/edit_review.tpl.php';
					$this->active_tab = 'reviews';
				}
			} elseif ($w2rr_instance->action == 'delete_review' && $review_id) {
				if (w2rr_current_user_can_edit_review($review_id) && ($review = w2rr_getReview($review_id))) {
					if (isset($_GET['delete_action']) && $_GET['delete_action'] == 'delete') {
						$delete = apply_filters('w2rr_delete_or_trash_review', true, $review_id); // true - delete, false - move to trash
						if ($delete) {
							if (wp_delete_post($review_id, true) !== FALSE) {
								w2rr_addMessage(esc_html__('Review was deleted successfully!', 'W2RR'));
								wp_redirect(w2rr_dashboardUrl());
								die();
							} else {
								w2rr_addMessage(esc_html__('An error has occurred and review was not deleted', 'W2RR'), 'error');
							}
						} else {
							if (wp_trash_post($review_id) !== FALSE) {
								w2rr_addMessage(esc_html__('Review was moved to trash!', 'W2RR'));
								wp_redirect(w2rr_dashboardUrl());
								die();
							} else {
								w2rr_addMessage(esc_html__('An error has occurred and review was not moved to trash', 'W2RR'), 'error');
							}
						}
					}
					$this->add_template_args(array('review' => $review));
					$this->template = 'dashboard/dashboard.tpl.php';
					$this->subtemplate = 'dashboard/delete.tpl.php';
					$this->active_tab = 'reviews';
				} else {
					wp_die('You are not able to manage this review', 'W2RR');
				}
			} elseif ($w2rr_instance->action == 'view_review_stats' && $review_id) {
				if (get_option('w2rr_enable_stats') && w2rr_current_user_can_edit_review($review_id) && ($review = w2rr_getReview($review_id))) {
					add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
					$this->add_template_args(array('object' => $review, 'info_template' => 'dashboard/info_metabox.tpl.php'));
					$this->template = 'dashboard/dashboard.tpl.php';
					$this->subtemplate = 'dashboard/view_stats.tpl.php';
					$this->active_tab = 'reviews';
				} else {
					wp_die('You are not able to manage this review', 'W2RR');
				}
			} elseif ($w2rr_instance->action == 'profile') {
				if (get_option('w2rr_allow_edit_profile')) {
					$user_id = get_current_user_id();
					$current_user = wp_get_current_user();
					
					$upload_avatar = new w2rr_upload_image('user-avatar', get_user_meta($user_id, '_w2rr_user_picture_id', true), 'user-picture-size');
					$this->add_template_args(array('upload_avatar' => $upload_avatar));
	
					include_once ABSPATH . 'wp-admin/includes/user.php';
	
					if (isset($_POST['user_id']) && (!defined('W2RR_DEMO') || !W2RR_DEMO)) {
						if ($_POST['user_id'] == $user_id) {
							global $wpdb;
		
							$user = get_userdata($user_id);
							
							// Update the email address in signups, if present.
							if ($user->user_login && isset($_POST['email']) && is_email($_POST['email']) && $wpdb->get_var($wpdb->prepare("SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $user->user_login))) {
								$wpdb->query($wpdb->prepare("UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $_POST['email'], $user->user_login));
							}
							
							// We must delete the user from the current blog if WP added them after editing.
							$delete_role = false;
							$blog_prefix = $wpdb->get_blog_prefix();
							if ($user_id != $current_user->ID) {
								$cap = $wpdb->get_var("SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = '{$user_id}' AND meta_key = '{$blog_prefix}capabilities' AND meta_value = 'a:0:{}'");
								if (!is_network_admin() && null == $cap && $_POST['role'] == '') {
									$_POST['role'] = 'contributor';
									$delete_role = true;
								}
							}
							if (!isset($errors) || (isset($errors) && is_object($errors) && false == $errors->get_error_codes())) {
								$errors = edit_user($user_id);
							}
							if ($delete_role) { // stops users being added to current blog when they are edited
								delete_user_meta($user_id, $blog_prefix . 'capabilities');
							}
							
							$user_pic_id = $upload_avatar->get_attachment_id_from_post();
							if ($user_pic_id !== false) {
								update_user_meta($user_id, '_w2rr_user_picture_id', $user_pic_id);
							} else {
								update_user_meta($user_id, '_w2rr_user_picture_id', "");
							}
							
							if (!is_wp_error($errors)) {
								w2rr_addMessage(esc_html__('Your profile was successfully updated!', 'W2RR'));
								wp_redirect(w2rr_dashboardUrl(array('w2rr_action' => 'profile')));
								die();
							}
						} else {
							wp_die('You are not able to manage profile', 'W2RR');
						}
					}
	
					$this->user = get_user_to_edit($user_id);
	
					wp_enqueue_script('password-strength-meter');
					wp_enqueue_script('user-profile');
					
					$public_display = array();
					$public_display['display_username']  = $this->user->user_login;
					$public_display['display_nickname']  = $this->user->nickname;
					if (!empty($profileuser->first_name)) {
						$public_display['display_firstname'] = $this->user->first_name;
					}
					
					if (!empty($profileuser->last_name)) {
						$public_display['display_lastname'] = $this->user->last_name;
					}
					
					if (!empty($profileuser->first_name) && !empty($profileuser->last_name)) {
						$public_display['display_firstlast'] = $this->user->first_name . ' ' . $this->user->last_name;
						$public_display['display_lastfirst'] = $this->user->last_name . ' ' . $this->user->first_name;
					}
					
					if (!in_array($this->user->display_name, $public_display)) { // Only add this if it isn't duplicated elsewhere
						$public_display = array('display_displayname' => $this->user->display_name) + $public_display;
					}
					
					$public_display = array_map('trim', $public_display);
					$public_display = array_unique($public_display);
					$this->add_template_args(array('public_display' => $public_display));
					
					$this->template = 'dashboard/dashboard.tpl.php';
					$this->subtemplate = 'dashboard/profile.tpl.php';
					$this->active_tab = 'profile';
				} else {
					wp_die('You are not able to manage profile', 'W2RR');
				}
			// adapted for WPML
			}  elseif (function_exists('wpml_object_id_filter') && $sitepress && get_option('w2rr_enable_frontend_translations') && $w2rr_instance->action == 'add_translation' && isset($_GET['review_id']) && isset($_GET['to_lang'])) {
				$master_post_id = $_GET['review_id'];
				$lang_code = $_GET['to_lang'];

				global $iclTranslationManagement;

				require_once( ICL_PLUGIN_PATH . '/inc/translation-management/translation-management.class.php' );
				if (!isset($iclTranslationManagement))
					$iclTranslationManagement = new TranslationManagement;
				
				$post_type = get_post_type($master_post_id);
				if ($sitepress->is_translated_post_type($post_type)) {
					// WPML has special option sync_post_status, that controls post_status duplication
					if ($new_review_id = $iclTranslationManagement->make_duplicate($master_post_id, $lang_code)) {
						$iclTranslationManagement->reset_duplicate_flag($new_review_id);
						w2rr_addMessage(esc_html__('Translation was successfully created!', 'W2RR'));
						do_action('wpml_switch_language', $lang_code);
						wp_redirect(add_query_arg(array('w2rr_action' => 'edit_review', 'review_id' => $new_review_id), get_permalink(apply_filters('wpml_object_id', $w2rr_instance->dashboard_page_id, 'page', true, $lang_code))));
					} else {
						w2rr_addMessage(esc_html__('Translation was not created!', 'W2RR'), 'error');
						wp_redirect(w2rr_dashboardUrl());
					}
					die();
				}
			}
		}

		apply_filters('w2rr_dashboard_controller_construct', $this);
	}
	
	public function display() {
	
		if ($this->args['use_wrapper'] || !$this->subtemplate) {
			$output =  w2rr_renderTemplate($this->template, $this->template_args, true);
		} else {
			$output = '<div class="w2rr-content w2rr-dashboard">';
			$output .=  w2rr_renderTemplate($this->subtemplate, $this->template_args, true);
			$output .= '</div>';
		}
		wp_reset_postdata();
	
		return $output;
	}
	
	public function enqueue_scripts_styles() {
		wp_register_script('w2rr_stats', W2RR_RESOURCES_URL . 'js/chart.min.js');
		wp_enqueue_script('w2rr_stats');
	}
}

?>