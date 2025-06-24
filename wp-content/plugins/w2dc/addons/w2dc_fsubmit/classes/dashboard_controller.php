<?php 

// @codingStandardsIgnoreFile

class w2dc_dashboard_controller extends w2dc_frontend_controller {
	
	public $referer;
	public $listings_count;
	public $active_tab;
	public $subtemplate;
	
	public $user;
	
	public $invoices;
	public $invoices_query;
	public $invoice;
	public $paypal;
	public $paypal_subscription;
	public $bank_transfer;
	public $stripe;
	

	public function init($args = array()) {
		global $w2dc_instance;
		global $w2dc_fsubmit_instance;
		global $sitepress;
		
		parent::init($args);
		
		$shortcode_atts = array_merge(array(
				'listing_info' => 1,
				'use_wrapper' => 1,
				'directories' => '',
				'categories' => array(), // exact categories to display in select list
		), $args);
		
		$this->args = $shortcode_atts;
		
		$this->add_template_args(array('listing_info' => $this->args['listing_info']));
		
		$this->add_template_args(array('categories' => $this->args['categories']));
		
		if ($this->args['directories']) {
			$this->add_template_args(array('directories' => wp_parse_id_list($this->args['directories'])));
		}
		
		$preview = w2dc_getValue($_POST, 'w2dc_preview');
		
		$login_registrations = new w2dc_login_registrations;
		if ($login_registrations->is_action()) {
			$this->template = $login_registrations->process($this);
		} elseif (!is_user_logged_in()) {
			if (w2dc_get_wpml_dependent_option('w2dc_submit_login_page') && w2dc_get_wpml_dependent_option('w2dc_submit_login_page') != get_the_ID()) {
				$url = get_permalink(w2dc_get_wpml_dependent_option('w2dc_submit_login_page'));
				$url = add_query_arg('redirect_to', urlencode(get_permalink()), $url);
				wp_redirect($url);
			} else {
				$this->template = $login_registrations->login_template();
			}
		} else {
			if (isset($_POST['referer']))
				$this->referer = $_POST['referer'];
			else
				$this->referer = wp_get_referer();
			if (isset($_POST['cancel']) && isset($_POST['referer'])) {
				wp_redirect($_POST['referer']);
				die();
			}

			if (!$w2dc_instance->action) {
				if (get_query_var('page'))
					$paged = get_query_var('page');
				elseif (get_query_var('paged'))
					$paged = get_query_var('paged');
				else
					$paged = 1;
			} else
				$paged = -1;
			
			$args = array(
					'post_type' => W2DC_POST_TYPE,
					'paged' => $paged,
					'posts_per_page' => 20,
					'post_status' => 'any'
			);
			
			if ($this->args['directories']) {
				if ($directories_ids = wp_parse_id_list($this->args['directories'])) {
					$args = w2dc_set_directory_args($args, $directories_ids);
				}
			}
			
			add_filter('posts_where', array($this, 'add_claimed_listings_where'));
			$this->query = new WP_Query($args);
			remove_filter('posts_where', array($this, 'add_claimed_listings_where'));
			wp_reset_postdata();
			
			$this->listings_count = $this->query->found_posts;
			
			$this->active_tab = 'listings';
			
			$listing_id = w2dc_getValue($_GET, 'listing_id');

			if (!$w2dc_instance->action) {
				$this->processQuery();
				
				if (get_current_user_id()) {
					$current_user = wp_get_current_user();
					
					foreach ($w2dc_instance->levels->levels_array AS $level) {
						if ($package_message = $w2dc_instance->listings_packages->submitlisting_level_message($level)) {
							w2dc_addMessage('<strong>' . $level->name . ':</strong>' . $package_message);
						}
					}
				}

				$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
				$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'listings.tpl.php');
			} elseif ($w2dc_instance->action == 'edit_listing' && $listing_id) {
				if (w2dc_current_user_can_edit_listing($listing_id)) {
					$listing = w2dc_getListing($listing_id);
					$w2dc_instance->current_listing = $listing;
					$w2dc_instance->listings_manager->current_listing = $listing;
					
					$w2dc_instance->media_manager->load_media(array(
							'images' => $listing->images,
							'videos' => $listing->videos,
							'logo_image' => $listing->logo_image,
					));
					$w2dc_instance->media_manager->load_params(array(
							'object_id' => $listing->post->ID,
							'images_number' => $listing->level->images_number,
							'videos_number' => $listing->level->videos_number,
							'logo_enabled' => $listing->level->logo_enabled,
					));
					
					if (isset($_POST['submit'])) {
						// resave listing level each time we save the listing
						$w2dc_instance->listings_manager->saveLevel();
						
						$errors = array();

						if (!isset($_POST['post_title']) || !trim($_POST['post_title']) || $_POST['post_title'] == esc_html__('Auto Draft', 'w2dc')) {
							$errors[] = esc_html__('Listing title field required', 'w2dc');
							$post_title = esc_html__('Auto Draft', 'w2dc');
						} else
							$post_title = trim($_POST['post_title']);

						$post_categories_ids = array();
						if ($listing->level->categories_number > 0 || $listing->level->unlimited_categories) {
							if ($post_categories_ids = $w2dc_instance->categories_manager->validateCategories($listing->level, $_POST, $errors)) {
								foreach ($post_categories_ids AS $key=>$id) {
									$post_categories_ids[$key] = intval($id);
								}
							}
							wp_set_object_terms($listing->post->ID, $post_categories_ids, W2DC_CATEGORIES_TAX);
						}

						if ($listing->level->tags_number > 0 || $listing->level->unlimited_tags) {
							if ($post_tags_ids = $w2dc_instance->categories_manager->validateTags($listing->level, $_POST, $errors)) {
								foreach ($post_tags_ids AS $key=>$id) {
									$post_tags_ids[$key] = intval($id);
								}
							}
							wp_set_object_terms($listing->post->ID, $post_tags_ids, W2DC_TAGS_TAX);
						}
						
						$w2dc_instance->content_fields->saveValues($listing->post->ID, $post_categories_ids, $listing->level->id, $errors, $_POST);
						
						if ($listing->level->locations_number) {
							if ($validation_results = $w2dc_instance->locations_manager->validateLocations($listing->level, $errors)) {
								$w2dc_instance->locations_manager->saveLocations($listing->level, $listing->post->ID, $validation_results);
							}
						}
						
						if ($listing->level->images_number || $listing->level->videos_number) {
							if ($validation_results = $w2dc_instance->media_manager->validateAttachments($errors))
								$w2dc_instance->media_manager->saveAttachments($validation_results);
						}
						
						if (get_option('w2dc_listing_contact_form') && get_option('w2dc_custom_contact_email')) {
							$w2dc_form_validation = new w2dc_form_validation();
							$w2dc_form_validation->set_rules('contact_email', esc_html__('Contact email', 'w2dc'), 'valid_email');
						
							if (!$w2dc_form_validation->run()) {
								$errors[] = $w2dc_form_validation->error_array();
							} else {
								update_post_meta($listing->post->ID, '_contact_email', $w2dc_form_validation->result_array('contact_email'));
							}
						}

						if ($errors) {
							$postarr = array(
									'ID' => $listing_id,
									'post_title' => apply_filters('w2dc_title_save_pre', $post_title, $listing),
									'post_name' => apply_filters('w2dc_name_save_pre', '', $listing),
									'post_content' => (isset($_POST['post_content']) ? $_POST['post_content'] : ''),
									'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : '')
							);
							$result = wp_update_post($postarr, true);
							if (is_wp_error($result))
								$errors[] = $result->get_error_message();

							foreach ($errors AS $error)
								w2dc_addMessage($error, 'error');
							$listing = w2dc_getListing($listing_id);
						} else {
							if (!$listing->level->eternal_active_period && $listing->status != 'expired') {
								if (get_option('w2dc_change_expiration_date') || current_user_can('manage_options')) {
									$w2dc_instance->listings_manager->changeExpirationDate();
								}
							}

							if (get_option('w2dc_claim_functionality') && !get_option('w2dc_hide_claim_metabox')) {
								if (isset($_POST['is_claimable'])) {
									update_post_meta($listing->post->ID, '_is_claimable', true);
								} else {
									update_post_meta($listing->post->ID, '_is_claimable', false);
								}
							}

							if ($listing->post->post_status == 'publish') {
								if (get_option('w2dc_fsubmit_edit_moderation')) {
									$post_status = 'pending';
									update_post_meta($listing_id, '_listing_approved', false);
									update_post_meta($listing_id, '_requires_moderation', true);
								} else {
									$post_status = 'publish';
								}
							}
							if (get_option('w2dc_fsubmit_edit_moderation')) {
								$success_message = esc_html__("Listing was saved successfully! Now it's awaiting moderators approval.", 'w2dc');
							} else {
								$success_message = esc_html__('Listing was saved successfully!', 'w2dc');
							}

							$postarr = array(
									'ID' => $listing_id,
									'post_title' => apply_filters('w2dc_title_save_pre', $post_title, $listing),
									'post_name' => apply_filters('w2dc_name_save_pre', '', $listing),
									'post_content' => (isset($_POST['post_content']) ? $_POST['post_content'] : ''),
									'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : '')
							);
							if (isset($post_status)) {
								$postarr['post_status'] = $post_status;
							}

							$result = wp_update_post($postarr, true);
							if (is_wp_error($result)) {
								w2dc_addMessage($result->get_error_message(), 'error');
							} else {
								
								if (get_option('w2dc_editlisting_admin_notification')) {
									// When listing was published and became pending after modification
									if ($listing->post->post_status == 'publish' && $post_status == 'pending') {
										$author = wp_get_current_user();
	
										$subject = esc_html__('Notification about listing modification (do not reply)', 'w2dc');
										$body = str_replace('[user]', $author->display_name,
												str_replace('[listing]', $listing->title(),
												str_replace('[link]', admin_url('post.php?post='.$listing->post->ID.'&action=edit'),
										get_option('w2dc_editlisting_admin_notification'))));
			
										w2dc_mail(w2dc_getAdminNotificationEmail(), $subject, $body);
									}
								}	
								
								if ($preview) {
									$preview_message = sprintf(esc_html__('The listing is in preview mode. Continue edition or save the listing in dashboard.', 'w2dc'), add_query_arg(array('w2dc_preview' => true, 'referer' => $this->referer), w2dc_get_edit_listing_link($listing->post->ID)));
									w2dc_addMessage($preview_message);
									
									$listing_link = get_permalink($listing->post->ID);
									$listing_link = add_query_arg(array('w2dc_preview' => true, 'referer' => $this->referer), $listing_link);
									
									wp_redirect($listing_link);
								} else {
									w2dc_addMessage($success_message);
									
									if (!$this->referer || (isset($post_status) && $post_status != 'publish')) {
										$this->referer = w2dc_dashboardUrl();
									}
									// 2 ways to redirect: listing single page and dashboard
									if (strpos($this->referer, w2dc_dashboardUrl()) !== false) {
										wp_redirect($this->referer);
									} else {
										// the slug could be changed and we will get 404
										wp_redirect(get_permalink($listing->post->ID));
									}
								}
								
								die();
							}
						}
						
						// renew data inside $listing object
						$listing = w2dc_getListing($listing_id);
						$w2dc_instance->current_listing = $listing;
						$w2dc_instance->listings_manager->current_listing = $listing;
					}
					
					$editor_options = array('media_buttons' => false, 'editor_class' => 'w2dc-editor-class');
					if (!get_option('w2dc_enable_html_description')) {
						$editor_options['quicktags'] = false;
						$editor_options['tinymce'] = false;
					}
					$editor_options = apply_filters('w2dc_editor_options', $editor_options);
					$this->add_template_args(array('editor_options' => $editor_options));

					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'edit_listing.tpl.php');
					$this->add_template_args(array('info_template' => array(W2DC_FSUBMIT_TEMPLATES_PATH, 'info_metabox.tpl.php')));
					if ($listing->level->categories_number > 0 || $listing->level->unlimited_categories) {
						add_action('wp_enqueue_scripts', array($w2dc_instance->categories_manager, 'admin_enqueue_scripts_styles'));
					}
					
					if ($listing->level->locations_number > 0) {
						add_action('wp_enqueue_scripts', array($w2dc_instance->locations_manager, 'admin_enqueue_scripts_styles'));
					}
	
					if ($listing->level->images_number > 0 || $listing->level->videos_number > 0) {
						add_action('wp_enqueue_scripts', array($w2dc_instance->media_manager, 'admin_enqueue_scripts_styles'));
					}
				}
			} elseif ($w2dc_instance->action == 'raiseup_listing' && $listing_id) {
				if (w2dc_current_user_can_edit_listing($listing_id) && ($listing = w2dc_getListing($listing_id)) && $listing->status == 'active') {
					$this->action = 'show';
					if (isset($_GET['raiseup_action']) && $_GET['raiseup_action'] == 'raiseup') {
						if ($listing->processRaiseUp())
							w2dc_addMessage(esc_html__('Listing was raised up successfully!', 'w2dc'));
						$this->action = $_GET['raiseup_action'];
						$this->referer = $_GET['referer'];
					}
					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'raise_up.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'w2dc');
			} elseif ($w2dc_instance->action == 'renew_listing' && $listing_id) {
				if (w2dc_current_user_can_edit_listing($listing_id) && ($listing = w2dc_getListing($listing_id))) {
					$this->action = 'show';
					if (isset($_GET['renew_action']) && $_GET['renew_action'] == 'renew') {
						if ($listing->processActivate(true, false))
							w2dc_addMessage(esc_html__('Listing was renewed successfully!', 'w2dc'));
						$this->action = $_GET['renew_action'];
						$this->referer = $_GET['referer'];
					}
					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'renew.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'w2dc');
			} elseif ($w2dc_instance->action == 'delete_listing' && $listing_id) {
				if (w2dc_current_user_can_delete_listing($listing_id) && ($listing = w2dc_getListing($listing_id))) {
					if (isset($_GET['delete_action']) && $_GET['delete_action'] == 'delete') {
						$delete = apply_filters('w2dc_delete_or_trash_listing', true, $listing_id); // true - delete, false - move to trash
						if ($delete) {
							if (wp_delete_post($listing_id, true) !== FALSE) {
								$w2dc_instance->listings_manager->delete_listing_data($listing_id);
	
								w2dc_addMessage(esc_html__('Listing was deleted successfully!', 'w2dc'));
								wp_redirect(w2dc_dashboardUrl());
								die();
							} else {
								w2dc_addMessage(esc_html__('An error has occurred and listing was not deleted', 'w2dc'), 'error');
							}
						} else {
							if (wp_trash_post($listing_id) !== FALSE) {
								w2dc_addMessage(esc_html__('Listing was moved to trash!', 'w2dc'));
								wp_redirect(w2dc_dashboardUrl());
								die();
							} else {
								w2dc_addMessage(esc_html__('An error has occurred and listing was not moved to trash', 'w2dc'), 'error');
							}
						}
					}
					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'delete.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'w2dc');
			} elseif ($w2dc_instance->action == 'upgrade_listing' && $listing_id) {
				if (w2dc_current_user_can_edit_listing($listing_id) && ($listing = w2dc_getListing($listing_id))) {
					$this->action = 'show';
					if (isset($_GET['upgrade_action']) && $_GET['upgrade_action'] == 'upgrade') {
						$w2dc_form_validation = new w2dc_form_validation();
						$w2dc_form_validation->set_rules('new_level_id', esc_html__('New level ID', 'w2dc'), 'required|integer');

						if ($w2dc_form_validation->run()) {
							if ($listing->changeLevel($w2dc_form_validation->result_array('new_level_id')))
								w2dc_addMessage(esc_html__('Listing level was changed successfully!', 'w2dc'));
							$this->action = $_GET['upgrade_action'];
						} else
							w2dc_addMessage(esc_html__('New level must be selected!', 'w2dc'), 'error');

						$this->referer = $_GET['referer'];
					}
					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'upgrade.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'w2dc');
			} elseif ($w2dc_instance->action == 'view_stats' && $listing_id) {
				if (get_option('w2dc_enable_stats') && w2dc_current_user_can_edit_listing($listing_id) && ($listing = w2dc_getListing($listing_id))) {
					add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
					$this->add_template_args(array('object' => $listing, 'info_template' => array(W2DC_FSUBMIT_TEMPLATES_PATH, 'info_metabox.tpl.php')));
					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'view_stats.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'w2dc');
			} elseif ($w2dc_instance->action == 'profile') {
				if (get_option('w2dc_allow_edit_profile')) {
					$user_id = get_current_user_id();
					$current_user = wp_get_current_user();
	
					include_once ABSPATH . 'wp-admin/includes/user.php';
	
					if (isset($_POST['user_id']) && (!defined('W2DC_DEMO') || !W2DC_DEMO)) {
						if ($_POST['user_id'] == $user_id) {
							global $wpdb;
		
							if (!is_multisite()) {
								$errors = edit_user($user_id);
								update_user_meta($user_id, 'w2dc_billing_name', $_POST['w2dc_billing_name']);
								update_user_meta($user_id, 'w2dc_billing_address', $_POST['w2dc_billing_address']);
							} else {
								$user = get_userdata($user_id);
							
								// Update the email address in signups, if present.
								if ($user->user_login && isset($_POST['email']) && is_email($_POST['email']) && $wpdb->get_var($wpdb->prepare("SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $user->user_login))) // phpcs:ignore WordPress.DB.DirectDatabaseQuery
									$wpdb->query($wpdb->prepare("UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $_POST['email'], $user->user_login));
									$wpdb->update(
											$wpdb->signups,
											array('user_email' => $_POST['email']),
											array('user_login' => $user->user_login)
									);
							
								// We must delete the user from the current blog if WP added them after editing.
								$delete_role = false;
								$blog_prefix = $wpdb->get_blog_prefix();
								if ($user_id != $current_user->ID) {
									$cap = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = '{$blog_prefix}capabilities' AND meta_value = 'a:0:{}'", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
									if (!is_network_admin() && null == $cap && $_POST['role'] == '') {
										$_POST['role'] = 'contributor';
										$delete_role = true;
									}
								}
								if (!isset($errors) || (isset($errors) && is_object($errors) && false == $errors->get_error_codes()))
									$errors = edit_user($user_id);
								if ( $delete_role ) // stops users being added to current blog when they are edited
									delete_user_meta($user_id, $blog_prefix . 'capabilities');
							}
							
							if (!is_wp_error($errors)) {
								w2dc_addMessage(esc_html__('Your profile was successfully updated!', 'w2dc'));
								wp_redirect(w2dc_dashboardUrl(array('w2dc_action' => 'profile')));
								die();
							}
						} else
							wp_die('You are not able to manage profile', 'w2dc');
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
					
					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'profile.tpl.php');
					$this->active_tab = 'profile';
				} else
					wp_die('You are not able to manage profile', 'w2dc');
			} elseif ($w2dc_instance->action == 'claim_listing' && $listing_id) {
				if (($listing = w2dc_getListing($listing_id)) && $listing->is_claimable) {
					$claimer_id = get_current_user_id();
					if ($listing->post->post_author != $claimer_id) {
						$this->action = 'show';
						if (isset($_GET['claim_action']) && $_GET['claim_action'] == 'claim') {
							if (isset($_POST['claim_message']) && $_POST['claim_message'])
								$claimer_message = esc_html($_POST['claim_message']);
							else
								$claimer_message = '';
							if ($listing->claim->updateRecord($claimer_id, $claimer_message, 'pending')) {
								update_post_meta($listing->post->ID, '_is_claimable', false);
								if (get_option('w2dc_claim_approval')) {
									if (get_option('w2dc_claim_notification')) {
										$author = get_userdata($listing->post->post_author);
										$claimer = get_userdata($claimer_id);

										$subject = esc_html__('Claim notification', 'w2dc');
		
										$body = str_replace('[author]', $author->display_name,
												str_replace('[listing]', $listing->post->post_title,
												str_replace('[claimer]', $claimer->display_name,
												str_replace('[link]', w2dc_dashboardUrl(array('listing_id' => $listing->post->ID, 'w2dc_action' => 'process_claim')),
												str_replace('[message]', $claimer_message,
										get_option('w2dc_claim_notification'))))));
										
										$claim_email = apply_filters('w2dc_claim_email', $author->user_email, $listing);
		
										w2dc_mail($claim_email, $subject, $body);
									}
									w2dc_addMessage(esc_html__('Listing was claimed successfully!', 'w2dc'));
									
									wp_redirect($listing->url());
									die();
								} else {
									// Automatically process claim without approval
									$listing->claim->approve();
									w2dc_addMessage(esc_html__('Listing claim was approved successfully!', 'w2dc'));
								}
							}

							$this->action = $_GET['claim_action'];
						}
						
						if ($this->action == 'show') {
							if (get_option('w2dc_claim_approval')) {
								w2dc_addMessage(esc_html__('The notification about claim for this listing will be sent to the current listing owner.', 'w2dc'));
								w2dc_addMessage(esc_html__("After approval you will become owner of this listing, you'll receive email notification.", 'w2dc'));
							}
							if (get_option('w2dc_after_claim') == 'expired') {
								w2dc_addMessage(esc_html__('After approval listing status become expired.', 'w2dc') . ((get_option('w2dc_payments_addon')) ? apply_filters('w2dc_renew_option', esc_html__(' The price for renewal', 'w2dc'), $w2dc_instance->current_listing) : ''));
							}
						}
						
						$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
						$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'claim.tpl.php');
					} else
						wp_die('This is your own listing', 'w2dc');
				}
			} elseif ($w2dc_instance->action == 'process_claim' && $listing_id) {
				if (w2dc_current_user_can_edit_listing($listing_id) && ($listing = w2dc_getListing($listing_id)) && $listing->claim->isClaimed()) {
					$this->action = 'show';
					if (isset($_GET['claim_action']) && ($_GET['claim_action'] == 'approve' || $_GET['claim_action'] == 'decline')) {
						if ($_GET['claim_action'] == 'approve') {
							$listing->claim->approve();
							if (get_option('w2dc_claim_approval_notification')) {
								$claimer = get_userdata($listing->claim->claimer_id);

								$subject = esc_html__('Approval of claim notification', 'w2dc');
							
								$body = str_replace('[claimer]', $claimer->display_name,
										str_replace('[listing]', $listing->post->post_title,
										str_replace('[link]', w2dc_dashboardUrl(),
								get_option('w2dc_claim_approval_notification'))));
							
								w2dc_mail($claimer->user_email, $subject, $body);
							}
							w2dc_addMessage(esc_html__('Listing claim was approved successfully!', 'w2dc'));
						} elseif ($_GET['claim_action'] == 'decline') {
							$listing->claim->deleteRecord();
							if (get_option('w2dc_claim_decline_notification')) {
								$claimer = get_userdata($listing->claim->claimer_id);

								$subject = esc_html__('Claim decline notification', 'w2dc');
									
								$body = str_replace('[claimer]', $claimer->display_name,
										str_replace('[listing]', $listing->post->post_title,
										get_option('w2dc_claim_decline_notification')));
									
								w2dc_mail($claimer->user_email, $subject, $body);
							}
							update_post_meta($listing->post->ID, '_is_claimable', true);
							w2dc_addMessage(esc_html__('Listing claim was declined!', 'w2dc'));
						}
						$this->action = 'processed';
						$this->referer = $_GET['referer'];
					}

					$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'claim_process.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'w2dc');
			// adapted for WPML
			}  elseif (function_exists('wpml_object_id_filter') && $sitepress && get_option('w2dc_enable_frontend_translations') && $w2dc_instance->action == 'add_translation' && isset($_GET['listing_id']) && isset($_GET['to_lang'])) {
				$master_post_id = $_GET['listing_id'];
				$lang_code = $_GET['to_lang'];

				global $iclTranslationManagement;

				require_once( ICL_PLUGIN_PATH . '/inc/translation-management/translation-management.class.php' );
				if (!isset($iclTranslationManagement))
					$iclTranslationManagement = new TranslationManagement;
				
				$post_type = get_post_type($master_post_id);
				if ($sitepress->is_translated_post_type($post_type)) {
					// WPML has special option sync_post_status, that controls post_status duplication
					if ($new_listing_id = $iclTranslationManagement->make_duplicate($master_post_id, $lang_code)) {
						$iclTranslationManagement->reset_duplicate_flag($new_listing_id);
						w2dc_addMessage(esc_html__('Translation was successfully created!', 'w2dc'));
						do_action('wpml_switch_language', $lang_code);
						wp_redirect(add_query_arg(array('w2dc_action' => 'edit_listing', 'listing_id' => $new_listing_id), get_permalink(apply_filters('wpml_object_id', $w2dc_instance->dashboard_page_id, 'page', true, $lang_code))));
					} else {
						w2dc_addMessage(esc_html__('Translation was not created!', 'w2dc'), 'error');
						wp_redirect(w2dc_dashboardUrl());
					}
					die();
				}
			}
			
			$w2dc_instance->listings_manager->loadCurrentListing($listing_id);
		}

		apply_filters('w2dc_dashboard_controller_construct', $this);
	}

	public function display() {
		
		if ($this->args['use_wrapper'] || !$this->subtemplate) {
			$output =  w2dc_renderTemplate($this->template, $this->template_args, true);
		} else {
			$output = '<div class="w2dc-content w2dc-dashboard">';
			$output .=  w2dc_renderTemplate($this->subtemplate, $this->template_args, true);
			$output .= '</div>';
		}
		wp_reset_postdata();

		return $output;
	}

	public function add_claimed_listings_where($where = '') {
		global $wpdb;
		
		$claimed_posts = '';
		$claimed_posts_ids = array();

		$results = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_claimer_id' AND meta_value=%d", get_current_user_id()), ARRAY_A); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		foreach ($results AS $row)
			$claimed_posts_ids[] = $row['post_id'];
		if ($claimed_posts_ids)
			$claimed_posts = " OR {$wpdb->posts}.ID IN (".implode(',', $claimed_posts_ids).") ";
		$where .= " AND ({$wpdb->posts}.post_author IN (".get_current_user_id().")" . $claimed_posts . ")";
		
		return $where;
	}
	
	public function enqueue_scripts_styles() {
		wp_register_script('w2dc-stats', W2DC_RESOURCES_URL . 'js/chart.min.js');
		wp_enqueue_script('w2dc-stats');
	}
}

?>