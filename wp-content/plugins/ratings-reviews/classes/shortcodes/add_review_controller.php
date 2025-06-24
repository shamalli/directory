<?php 

/**
 *  [webrr-add-review-page] shortcode
 *
 *
 */
class w2rr_add_review_controller extends w2rr_frontend_controller {
	
	public $request_by = 'add_review_controller';
	public $w2rr_user_contact_name;
	public $w2rr_user_contact_email;
	
	public function __construct() {
		global $w2rr_instance;
		
		$w2rr_instance->media_manager->admin_enqueue_scripts_styles();
	}
	
	public function saveInitialDraft($post_id, $target_post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;
	
		add_post_meta($post_id, '_post_id', $target_post->post->ID);
	}

	public function init($args = array()) {
		global $w2rr_instance;
		
		parent::init($args);
		
		$shortcode_atts = array_merge(array(
				'comments_template' => false,
		), $args);
	
		$target_post = $this->getTargetPost();
		
		// something went wrong, we can not find target post
		if (empty($target_post)) {
			return ;
		}
		
		// we do not need to place review on Add Review Page
		if ($w2rr_instance->add_review_page_id && $w2rr_instance->add_review_page_id == $target_post->post->ID) {
			return ;
		}
		
		$login_registrations = new w2rr_login_registrations;
		if ($login_registrations->is_action()) {
			$this->template = $login_registrations->process($this);
		} else {
			if (in_array(get_option('w2rr_reviews_allowed_users'), array('login', 'admins')) && !is_user_logged_in()) {
				if (w2rr_get_wpml_dependent_option('w2rr_submit_login_page') && w2rr_get_wpml_dependent_option('w2rr_submit_login_page') != get_the_ID()) {
					$url = get_permalink(w2rr_get_wpml_dependent_option('w2rr_submit_login_page'));
					$url = add_query_arg('redirect_to', urlencode(w2rr_get_add_review_link(get_the_ID())), $url);
					wp_redirect($url);
				} else {
					$this->template = $login_registrations->login_template();
				}
			} else {
				
				// Avoid infinite loop,
				// when submit shortcode was placed inside SiteOrigin panel - Yoast plugin forces infinite loop by his action
				remove_all_actions('wp_insert_post');
				
				$this->w2rr_user_contact_name = '';
				$this->w2rr_user_contact_email = '';
				if (w2rr_can_user_add_review($target_post->post->ID)) {
					
					$review = false;
					
					if (!isset($_POST['review_id']) || !isset($_POST['review_id_hash']) || !is_numeric($_POST['review_id']) || md5($_POST['review_id'] . wp_salt()) != $_POST['review_id_hash']) {
						// Create Auto-Draft
						$new_post_args = array(
								'post_title' => esc_html__('Auto Draft', 'w2rr'),
								'post_type' => W2RR_REVIEW_TYPE,
								'post_status' => 'auto-draft'
						);
						if ($new_post_id = wp_insert_post($new_post_args)) {
							$this->saveInitialDraft($new_post_id, $target_post);
			
							$review = w2rr_getReview($new_post_id);
			
							$w2rr_instance->media_manager->load_params(array(
									'object_id' => $review->post->ID,
									'images_number' => get_option("w2rr_reviews_images_number"),
									'videos_number' => 0,
									'logo_enabled' => false,
							));
						}
					} elseif (isset($_POST['submit']) && (isset($_POST['_submit_nonce']) && wp_verify_nonce($_POST['_submit_nonce'], 'w2rr_submit'))) {
						
						// This is existed Auto-Draft
						$review_id = $_POST['review_id'];
						$review = w2rr_getReview($review_id);
							
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
							
						$errors = array();
							
						if (!is_user_logged_in() && in_array(get_option('w2rr_reviews_allowed_users'), array('guests', 'required_contact_form'))) {
							if (get_option('w2rr_reviews_allowed_users') == 'required_contact_form') {
								$required = '|required';
							} else {
								$required = '';
							}
							
							$w2rr_form_validation = new w2rr_form_validation();
							$w2rr_form_validation->set_rules('w2rr_user_contact_name', esc_html__('Contact Name', 'w2rr'), $required);
							$w2rr_form_validation->set_rules('w2rr_user_contact_email', esc_html__('Contact Email', 'w2rr'), 'valid_email' . $required);
							if (!$w2rr_form_validation->run()) {
								$errors[] = $w2rr_form_validation->error_array();
							}
			
							$this->w2rr_user_contact_name = $w2rr_form_validation->result_array('w2rr_user_contact_name');
							$this->w2rr_user_contact_email = $w2rr_form_validation->result_array('w2rr_user_contact_email');
						}
							
						if (!isset($_POST['post_title']) || !trim($_POST['post_title']) || $_POST['post_title'] == esc_html__('Auto Draft', 'w2rr')) {
							$errors[] = esc_html__('Review title field required', 'w2rr');
							$post_title = esc_html__('Auto Draft', 'w2rr');
						} else {
							$post_title = trim($_POST['post_title']);
						}
						
						$post_content = '';
						if (empty($_POST['post_content']) && get_option('w2rr_enable_description')) {
							$errors[] = esc_html__('Review description field required!', 'w2rr');
						} elseif (!empty($_POST['post_content'])) {
							$post_content = $_POST['post_content'];
						}
							
						if (get_option("w2rr_reviews_images_number") > 0) {
							if ($validation_results = $w2rr_instance->media_manager->validateAttachments($errors)) {
								$w2rr_instance->media_manager->saveAttachments($validation_results);
							}
						}
							
						if (!w2rr_is_recaptcha_passed()) {
							$errors[] = esc_attr__("Anti-bot test wasn't passed!", 'w2rr');
						}
						
						// adapted for WPML
						global $sitepress;
						if (
						(
							(function_exists('wpml_object_id_filter') && $sitepress && $sitepress->get_default_language() != ICL_LANGUAGE_CODE && ($tos_page = get_option('w2rr_tospage_'.ICL_LANGUAGE_CODE)))
							||
							($tos_page = get_option('w2rr_tospage'))
						)
						&&
						(!isset($_POST['w2rr_tospage']) || !$_POST['w2rr_tospage'])
						) {
							$errors[] = esc_html__('Please check the box to agree the Terms of Services.', 'w2rr');
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
							if (!is_user_logged_in() && in_array(get_option('w2rr_reviews_allowed_users'), array('guests', 'required_contact_form'))) {
								if (email_exists($this->w2rr_user_contact_email)) {
									$user = get_user_by('email', $this->w2rr_user_contact_email);
									$post_author_id = $user->ID;
									$post_author_username = $user->user_login;
								} else {
									$user_contact_name = trim($this->w2rr_user_contact_name);
									if ($user_contact_name) {
										$display_author_name = $user_contact_name;
										if (get_user_by('login', $user_contact_name))
											$login_author_name = $user_contact_name . '_' . time();
										else
											$login_author_name = $user_contact_name;
									} else {
										$display_author_name = 'Author_' . time();
										$login_author_name = 'Author_' . time();
									}
									if ($this->w2rr_user_contact_email) {
										$author_email = $this->w2rr_user_contact_email;
									} else {
										$author_email = '';
									}
			
									$password = wp_generate_password(6, false);
									
									$user_options = array(
											'display_name' => $display_author_name,
											'user_login' => $login_author_name,
											'user_email' => $author_email,
											'user_pass' => $password
									);
									
									$user_options = apply_filters('w2rr_submit_review_user_options', $user_options);
			
									$post_author_id = wp_insert_user($user_options);
									$post_author_username = $login_author_name;
			
									if (!is_wp_error($post_author_id) && $author_email) {
										$do_auto_login = true;
										$do_auto_login = apply_filters('w2rr_do_auto_login', $do_auto_login);
										
										if ($do_auto_login) {
											// WP auto-login
											wp_set_current_user($post_author_id);
											wp_set_auth_cookie($post_author_id);
											do_action('wp_login', $post_author_username, get_userdata($post_author_id));
										}
			
										if (get_option('w2rr_newuser_notification')) {
											$subject = esc_html__('Registration notification', 'w2rr');
											$body = str_replace('[author]', $display_author_name,
													str_replace('[review]', $post_title,
													str_replace('[login]', $login_author_name,
													str_replace('[password]', $password,
											get_option('w2rr_newuser_notification')))));
			
											if (w2rr_mail($author_email, $subject, $body)) {
												w2rr_addMessage(esc_html__('New user was created and added to the site, login and password were sent to provided contact email.', 'w2rr'));
											}
										}
									}
								}
							} elseif (is_user_logged_in()) {
								$post_author_id = get_current_user_id();
							} else {
								$post_author_id = 0;
							}
			
							if (get_option('w2rr_reviews_moderation')) {
								$post_status = 'pending';
								$message = esc_attr__("Review was saved successfully! Now it's awaiting moderators approval.", 'w2rr');
								update_post_meta($review_id, '_requires_moderation', true);
							} else {
								$post_status = 'publish';
								$message = esc_html__('Review was saved successfully! Now you can manage it in your dashboard.', 'w2rr');
							}
			
							$postarr = array(
									'ID' => $review_id,
									'post_title' => apply_filters('w2rr_title_save_pre', $post_title, $review),
									'post_name' => apply_filters('w2rr_name_save_pre', '', $review),
									'post_content' => $post_content,
									'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
									'post_type' => W2RR_REVIEW_TYPE,
									'post_author' => $post_author_id,
									'post_status' => $post_status
							);
							$result = wp_update_post($postarr, true);
							
							if (is_wp_error($result)) {
								w2rr_addMessage($result->get_error_message(), 'error');
							} else {
								update_post_meta($review_id, '_pros', w2rr_getValue($_POST, 'pros'));
								update_post_meta($review_id, '_cons', w2rr_getValue($_POST, 'cons'));
								
								if ($post_status == 'publish') {
									$w2rr_instance->reviews_manager->saveAllRatings($review_id);
								}
								$w2rr_instance->reviews_manager->saveReviewMeta($review_id);
								
								do_action('w2rr_save_review', $review_id);
			
								w2rr_addMessage($message);
			
								if (get_option('w2rr_newreview_admin_notification')) {
									if ($author = get_userdata($review->post->post_author)) {
										$subject = esc_html__('Notification about new review creation (do not reply)', 'w2rr');
										$body = str_replace('[user]', $author->display_name,
												str_replace('[review]', $post_title,
														str_replace('[link]', admin_url('post.php?post='.$review->post->ID.'&action=edit'),
																get_option('w2rr_newreview_admin_notification'))));
				
										w2rr_mail(w2rr_getAdminNotificationEmail(), $subject, $body);
									}
								}
			
								apply_filters('w2rr_review_creation_front', $review);
			
								if ($w2rr_instance->dashboard_page_id) {
									$redirect_to = w2rr_dashboardUrl();
								} elseif ($post_status == 'publish') {
									// pass $result to get quite new post permalink
									$redirect_to = get_permalink($result);
								} else {
									$redirect_to = get_permalink($review->target_post->post);
								}
			
								$redirect_to = apply_filters('w2rr_redirect_after_review_submit', $redirect_to, $review);
								
								wp_redirect($redirect_to);
								die();
							}
						}
						
						// renew data inside $review object
						$review = w2rr_getReview($review_id);
					}
			
					if (get_current_user_id()) {
						$current_user = wp_get_current_user();
						$logout_link = "<a href='".wp_logout_url()."'>" . esc_html__('Log out', 'w2rr') . "</a>";
						
						w2rr_addMessage(sprintf(esc_html__("You are logged in as %s. %s or continue submission in this account.", "w2rr"), $current_user->display_name, $logout_link));
					} elseif (in_array(get_option('w2rr_reviews_allowed_users'), array('guests', 'required_contact_form'))) {
						$login_link = "<a href='".wp_login_url()."'>" . esc_html__('log in', 'w2rr') . "</a>";
						
						w2rr_addMessage(sprintf(esc_html__("Returning user? Please %s or register in this submission form.", "w2rr"), $login_link));
					}
					
					if (!empty($review->post)) {
						$this->add_template_args(array(
								'review' => $review,
								'target_post' => $target_post,
								'frontend_controller' => $this,
						));
				
						$this->template = 'ratings_reviews/review_add.tpl.php';
					}
			
					if (get_option("w2rr_reviews_images_number") > 0) {
						add_action('wp_enqueue_scripts', array($w2rr_instance->media_manager, 'admin_enqueue_scripts_styles'));
					}
				} else {
					$this->add_template_args(array(
							'target_post' => $target_post,
							'frontend_controller' => $this,
					));
						
					$this->template = 'ratings_reviews/review_add.tpl.php';
					
					if (!current_user_can('manage_options') && get_option('w2rr_reviews_allowed_users') == 'admin') {
						w2rr_addMessage(esc_html__("Only admins can post reviews.", "w2rr"));
					} elseif (get_option('w2rr_reviews_number_allowed') && w2rr_getReviewsCounterByAuthorByPost($target_post->post->ID) >= get_option('w2rr_reviews_number_allowed')) {
						w2rr_addMessage(sprintf(esc_html__("You are not allowed to create more than %d review(s) for one post.", "w2rr"), get_option('w2rr_reviews_number_allowed')));
					}
				}
			}
		}
		
		// this is reset is really required after the loop ends
		wp_reset_postdata();
		
		apply_filters('w2rr_add_review_controller_construct', $this);
	}
}

?>