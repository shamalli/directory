<?php

define('W2DC_FSUBMIT_PATH', plugin_dir_path(__FILE__));

function w2dc_fsubmit_loadPaths() {
	define('W2DC_FSUBMIT_TEMPLATES_PATH', W2DC_FSUBMIT_PATH . 'templates/');
	define('W2DC_FSUBMIT_RESOURCES_PATH', W2DC_FSUBMIT_PATH . 'resources/');
	define('W2DC_FSUBMIT_RESOURCES_URL', plugins_url('/', __FILE__) . 'resources/');
}
add_action('init', 'w2dc_fsubmit_loadPaths', 0);

define('W2DC_FSUBMIT_SHORTCODE', 'webdirectory-submit');
define('W2DC_DASHBOARD_SHORTCODE', 'webdirectory-dashboard');
define('W2DC_LEVELS_TABLE_SHORTCODE', 'webdirectory-levels-table');

include_once W2DC_FSUBMIT_PATH . 'classes/dashboard_controller.php';
include_once W2DC_FSUBMIT_PATH . 'classes/submit_controller.php';
include_once W2DC_FSUBMIT_PATH . 'classes/levels_table_controller.php';
include_once W2DC_FSUBMIT_PATH . 'classes/wc/wc.php';
include_once W2DC_FSUBMIT_PATH . 'classes/functions.php';
include_once W2DC_FSUBMIT_PATH . 'classes/login_registrations.php';

global $w2dc_wpml_dependent_options;
$w2dc_wpml_dependent_options[] = 'w2dc_tospage';
$w2dc_wpml_dependent_options[] = 'w2dc_submit_login_page';

class w2dc_fsubmit_plugin {

	public function init() {
		global $w2dc_instance, $w2dc_shortcodes, $w2dc_shortcodes_init;
		
		if (!get_option('w2dc_installed_fsubmit'))
			//w2dc_install_fsubmit();
			add_action('init', 'w2dc_install_fsubmit', 0);
		add_action('w2dc_version_upgrade', 'w2dc_upgrade_fsubmit');

		add_filter('w2dc_build_settings', array($this, 'plugin_settings'));

		// add new shortcodes for frontend submission and dashboard
		$w2dc_shortcodes[W2DC_FSUBMIT_SHORTCODE] = 'w2dc_submit_controller';
		$w2dc_shortcodes[W2DC_DASHBOARD_SHORTCODE] = 'w2dc_dashboard_controller';
		$w2dc_shortcodes[W2DC_LEVELS_TABLE_SHORTCODE] = 'w2dc_levels_table_controller';
		
		$w2dc_shortcodes_init[W2DC_FSUBMIT_SHORTCODE] = 'w2dc_submit_controller';
		$w2dc_shortcodes_init[W2DC_DASHBOARD_SHORTCODE] = 'w2dc_dashboard_controller';
		$w2dc_shortcodes_init[W2DC_LEVELS_TABLE_SHORTCODE] = 'w2dc_levels_table_controller';

		add_shortcode(W2DC_FSUBMIT_SHORTCODE, array($w2dc_instance, 'renderShortcode'));
		add_shortcode(W2DC_DASHBOARD_SHORTCODE, array($w2dc_instance, 'renderShortcode'));
		add_shortcode(W2DC_LEVELS_TABLE_SHORTCODE, array($w2dc_instance, 'renderShortcode'));
		
		add_action('init', array($this, 'getSubmitPage'), 0);
		add_action('init', array($this, 'getDasboardPage'), 0);

		add_filter('w2dc_get_edit_listing_link', array($this, 'edit_listings_links'), 10, 2);

		add_action('w2dc_directory_frontpanel', array($this, 'add_submit_button'), 10);
		add_action('w2dc_directory_frontpanel', array($this, 'add_claim_button'), 11);
		
		add_action('w2dc_directory_frontpanel', array($this, 'add_logout_button'), 12);

		add_action('init', array($this, 'remove_admin_bar'));
		
		if (get_option('w2dc_payments_addon')) {
			add_action('show_user_profile', array($this, 'add_user_profile_fields'));
			add_action('edit_user_profile', array($this, 'add_user_profile_fields'));
			add_action('personal_options_update', array($this, 'save_user_profile_fields'));
			add_action('edit_user_profile_update', array($this, 'save_user_profile_fields'));
		}

		add_action('transition_post_status', array($this, 'on_listing_approval'), 10, 3);
		add_action('w2dc_post_status_on_activation', array($this, 'post_status_on_activation'), 10, 2);
		
		add_filter('no_texturize_shortcodes', array($this, 'w2dc_no_texturize'));

		add_action('w2dc_render_template', array($this, 'check_custom_template'), 10, 2);
	}
	
	public function w2dc_no_texturize($shortcodes) {
		$shortcodes[] = 'webdirectory-submit';
		$shortcodes[] = 'webdirectory-dashboard';

		return $shortcodes;
	}
	
	/**
	 * check is there template in one of these paths:
	 * - themes/theme/w2dc-plugin/templates/w2dc_fsubmit/
	 * - plugins/w2dc/templates/w2dc_fsubmit/
	 * 
	 */
	public function check_custom_template($template, $args) {
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
			
			if ($template_path == W2DC_FSUBMIT_TEMPLATES_PATH && ($fsubmit_template = w2dc_isTemplate('w2dc_fsubmit/' . $template_file))) {
				return $fsubmit_template;
			}
		}
		return $template;
	}

	public function plugin_settings($options) {
		global $sitepress; // adapted for WPML

		$pages = get_pages();
		$all_pages[] = array('value' => 0, 'label' => __('- Select page -', 'W2DC'));
		foreach ($pages AS $page)
			$all_pages[] = array('value' => $page->ID, 'label' => $page->post_title);
		
		$options['template']['menus']['general']['controls']['fsubmit'] = array(
			'type' => 'section',
			'title' => __('Frontend submission and dashboard', 'W2DC'),
			'fields' => array(
				array(
					'type' => 'radiobutton',
					'name' => 'w2dc_fsubmit_login_mode',
					'label' => __('Frontend submission login mode', 'W2DC'),
					'items' => array(
						array(
							'value' => 1,
							'label' => __('login required', 'W2DC'),
						),
						array(
							'value' => 2,
							'label' => __('necessary to fill in user info form', 'W2DC'),
						),
						array(
							'value' => 3,
							'label' => __('not necessary to fill in user info form', 'W2DC'),
						),
						array(
							'value' => 4,
							'label' => __('do not show show user info form', 'W2DC'),
						),
					),
					'default' => array(
						get_option('w2dc_fsubmit_login_mode'),
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_fsubmit_moderation',
					'label' => __('Enable pre-moderation of listings', 'W2DC'),
					'default' => get_option('w2dc_fsubmit_moderation'),
					'description' => __('Moderation will be required for all listings even after payment', 'W2DC'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_fsubmit_edit_moderation',
					'label' => __('Enable moderation after a listing was modified', 'W2DC'),
					'default' => get_option('w2dc_fsubmit_edit_moderation'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_hide_choose_level_page',
					'label' => __('Hide choose level page', 'W2DC'),
					'default' => get_option('w2dc_hide_choose_level_page'),
					'description' => __('When all levels are similar and all has packages of listings, user do not need to choose level to submit when he already has a package.', 'W2DC'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_fsubmit_button',
					'label' => __('Enable submit listing button', 'W2DC'),
					'default' => get_option('w2dc_fsubmit_button'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_hide_admin_bar',
					'label' => __('Hide top admin bar at the frontend for regular users', 'W2DC'),
					'default' => get_option('w2dc_hide_admin_bar'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_allow_edit_profile',
					'label' => __('Allow users to manage own profile at the frontend dashboard', 'W2DC'),
					'default' => get_option('w2dc_allow_edit_profile'),
				),
				array(
					'type' => 'select',
					'name' => w2dc_get_wpml_dependent_option_name('w2dc_tospage'), // adapted for WPML
					'label' => __('Require Terms of Services on submission page?', 'W2DC'),
					'description' => __('If yes, create a WordPress page containing your TOS agreement and assign it using the dropdown above.', 'W2DC') . w2dc_get_wpml_dependent_option_description(),
					'items' => $all_pages,
					'default' => (w2dc_get_wpml_dependent_option('w2dc_tospage') ? array(w2dc_get_wpml_dependent_option('w2dc_tospage')) : array(0)), // adapted for WPML
				),
				array(
					'type' => 'select',
					'name' => w2dc_get_wpml_dependent_option_name('w2dc_submit_login_page'), // adapted for WPML
					'label' => __('Use custom login page for listings submission process', 'W2DC'),
					'description' => __('You may use any 3rd party plugin to make custom login page and assign it with submission process using the dropdown above.', 'W2DC') . w2dc_get_wpml_dependent_option_description(),
					'items' => $all_pages,
					'default' => (w2dc_get_wpml_dependent_option('w2dc_submit_login_page') ? array(w2dc_get_wpml_dependent_option('w2dc_submit_login_page')) : array(0)), // adapted for WPML
				),
			),
		);
		$options['template']['menus']['general']['controls']['claim'] = array(
			'type' => 'section',
			'title' => __('Claim functionality', 'W2DC'),
			'fields' => array(
				array(
					'type' => 'toggle',
					'name' => 'w2dc_claim_functionality',
					'label' => __('Enable claim functionality', 'W2DC'),
					'default' => get_option('w2dc_claim_functionality'),
					'description' => __('Each listing will get new option "allow claim". Claim button appears on single listings pages only when user is not logged in as current listing owner and a page [webdirectory-dashboard] shortcode exists.', 'W2DC'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_claim_approval',
					'label' => __('Approval of claim required', 'W2DC'),
					'description' => __('In other case claim will be processed immediately without any notifications', 'W2DC'),
					'default' => get_option('w2dc_claim_approval'),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'w2dc_after_claim',
					'label' => __('What will be with listing status after successful approval?', 'W2DC'),
					'description' => __('When set to expired - renewal may be payment option', 'W2DC'),
					'items' => array(
						array(
							'value' => 'active',
							'label' =>__('just approval', 'W2DC'),
						),
						array(
							'value' => 'expired',
							'label' =>__('expired status', 'W2DC'),
						),
					),
					'default' => array(
							get_option('w2dc_after_claim')
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_hide_claim_contact_form',
					'label' => __('Hide contact form on claimable listings', 'W2DC'),
					'default' => get_option('w2dc_hide_claim_contact_form'),
				),
				array(
					'type' => 'toggle',
					'name' => 'w2dc_hide_claim_metabox',
					'label' => __('Hide claim metabox at the frontend dashboard', 'W2DC'),
					'default' => get_option('w2dc_hide_claim_metabox'),
				),
			),
		);
		
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$options['template']['menus']['advanced']['controls']['wpml']['fields'][] = array(
				'type' => 'toggle',
				'name' => 'w2dc_enable_frontend_translations',
				'label' => __('Enable frontend translations management', 'W2DC'),
				'default' => get_option('w2dc_enable_frontend_translations'),
			);
		}
		
		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_newuser_notification',
			'label' => __('Registration of new user notification', 'W2DC'),
			'default' => get_option('w2dc_newuser_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[author], [listing], [login], [password]',
		);

		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_newlisting_admin_notification',
			'label' => __('Notification to admin about new listing creation', 'W2DC'),
			'default' => get_option('w2dc_newlisting_admin_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[user], [listing], [link]',
		);

		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_editlisting_admin_notification',
			'label' => __('Notification to admin about listing modification and pending status', 'W2DC'),
			'default' => get_option('w2dc_editlisting_admin_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[user], [listing], [link]',
		);

		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_approval_notification',
			'label' => __('Notification to author about successful listing approval', 'W2DC'),
			'default' => get_option('w2dc_approval_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[author], [listing], [link]',
		);

		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_claim_notification',
			'label' => __('Notification of claim to current listing owner', 'W2DC'),
			'default' => get_option('w2dc_claim_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[author], [listing], [claimer], [link], [message]',
		);
		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_claim_approval_notification',
			'label' => __('Notification of successful approval of claim', 'W2DC'),
			'default' => get_option('w2dc_claim_approval_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[claimer], [listing], [link]',
		);
		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
			'type' => 'textarea',
			'name' => 'w2dc_claim_decline_notification',
			'label' => __('Notification of claim decline', 'W2DC'),
			'default' => get_option('w2dc_claim_decline_notification'),
			'description' => __('Tags allowed: ', 'W2DC') . '[claimer], [listing]',
		);
		
		return $options;
	}

	public function getSubmitPage() {
		global $w2dc_instance, $wpdb;
		
		$w2dc_instance->submit_pages_all = array();

		if ($pages = $wpdb->get_results("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . W2DC_FSUBMIT_SHORTCODE . "%') AND post_status = 'publish' AND post_type = 'page'", ARRAY_A)) {

			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				foreach ($pages AS $key=>&$cpage) {
					if ($tpage = apply_filters('wpml_object_id', $cpage['id'], 'page')) {
						$cpage['id'] = $tpage;
						$cpage['slug'] = get_post($cpage['id'])->post_name;
					} else {
						unset($pages[$key]);
					}
				}
			}
			
			$pages = array_unique($pages, SORT_REGULAR);
			
			$submit_pages = array();
			
			$shortcodes = array(W2DC_FSUBMIT_SHORTCODE);
			foreach ($pages AS $page_id) {
				$page_id = $page_id['id'];
				$pattern = get_shortcode_regex($shortcodes);
				if (preg_match_all('/'.$pattern.'/s', get_post($page_id)->post_content, $matches) && array_key_exists(2, $matches)) {
					foreach ($matches[2] AS $key=>$shortcode) {
						if (in_array($shortcode, $shortcodes)) {
							if (($attrs = shortcode_parse_atts($matches[3][$key]))) {
								if (isset($attrs['directory']) && is_numeric($attrs['directory']) && ($directory = $w2dc_instance->directories->getDirectoryById($attrs['directory']))) {
									$submit_pages[$directory->id]['id'] = $page_id;
									break;
								} elseif (!isset($attrs['id'])) {
									$submit_pages[$w2dc_instance->directories->getDefaultDirectory()->id]['id'] = $page_id;
									break;
								}
							} else {
								$submit_pages[$w2dc_instance->directories->getDefaultDirectory()->id]['id'] = $page_id;
								break;
							}
						}
					}
				}
			}

			foreach ($submit_pages AS &$page) {
				$page_id = $page['id'];
				$page['url'] = get_permalink($page_id);
				$page['slug'] = get_post($page_id)->post_name;
			}
			
			$w2dc_instance->submit_pages_all = $submit_pages;
		}

		if (get_option('w2dc_fsubmit_button') && empty($w2dc_instance->submit_pages_all) && is_admin()) {
			
			$title = esc_html__("Submit new listing", "W2DC");
			$content = '['.W2DC_FSUBMIT_SHORTCODE.']';
			$post_id = wp_insert_post(array(
					'post_type' => 'page',
					'post_title' => $title,
					'post_content' => $content,
					'post_status' => 'publish',
					'post_author' => get_current_user_id(),
			));
		}
	}

	public function getDasboardPage() {
		global $w2dc_instance, $wpdb, $wp_rewrite;
		
		$w2dc_instance->dashboard_page_url = '';
		$w2dc_instance->dashboard_page_slug = '';
		$w2dc_instance->dashboard_page_id = 0;

		if ($dashboard_page = $wpdb->get_row("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE post_content LIKE '%[" . W2DC_DASHBOARD_SHORTCODE . "%' AND post_status = 'publish' AND post_type = 'page' LIMIT 1", ARRAY_A)) {
			$w2dc_instance->dashboard_page_id = $dashboard_page['id'];
			$w2dc_instance->dashboard_page_slug = $dashboard_page['slug'];

			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				if ($tpage = apply_filters('wpml_object_id', $w2dc_instance->dashboard_page_id, 'page')) {
					$w2dc_instance->dashboard_page_id = $tpage;
					$w2dc_instance->dashboard_page_slug = get_post($w2dc_instance->dashboard_page_id)->post_name;
				}
			}
			
			if ($wp_rewrite->using_permalinks())
				$w2dc_instance->dashboard_page_url = get_permalink($w2dc_instance->dashboard_page_id);
			else
				$w2dc_instance->dashboard_page_url = add_query_arg('page_id', $w2dc_instance->dashboard_page_id, home_url('/'));
		}
	}
	
	public function add_submit_button($frontpanel_buttons) {
		global $w2dc_instance;

		if ($frontpanel_buttons->isButton('submit') && get_option('w2dc_fsubmit_button') && !empty($w2dc_instance->submit_pages_all)) {
			$page_id = get_the_ID();
			
			$submit_pages = array();
			foreach ($w2dc_instance->submit_pages_all AS $page) {
				$submit_pages[] = $page['id'];
			}

			$directories = $frontpanel_buttons->getDirectories();

			foreach ($directories AS $directory) {
				$href = w2dc_submitUrl(array('directory' => $directory->id));
					
				$href = apply_filters('w2dc_submit_button_href', $href, $directory, $frontpanel_buttons);
					
				echo '<a class="w2dc-submit-listing-link w2dc-btn w2dc-btn-primary" href="' . $href . '" rel="nofollow" ' . $frontpanel_buttons->tooltipMeta(sprintf(__('Submit new %s', 'W2DC'), $directory->single), true) . '><span class="w2dc-glyphicon w2dc-glyphicon-plus"></span> ' . ((!$frontpanel_buttons->hide_button_text) ? sprintf(__('Submit new %s', 'W2DC'), $directory->single) : "") . '</a> ';
			}
		}
	}

	public function add_claim_button($frontpanel_buttons) {
		global $w2dc_instance;
		
		if ($frontpanel_buttons->isButton('claim')) {
			if ($listing = w2dc_getListing($frontpanel_buttons->getListingId())) {
				if ($listing && $listing->is_claimable && $w2dc_instance->dashboard_page_url && get_option('w2dc_claim_functionality') && $listing->post->post_author != get_current_user_id()) {
					$href = w2dc_dashboardUrl(array('listing_id' => $listing->post->ID, 'w2dc_action' => 'claim_listing'));
					
					$href = apply_filters('w2dc_claim_button_href', $href, $frontpanel_buttons);
					
					echo '<a class="w2dc-claim-listing-link w2dc-btn w2dc-btn-primary" href="' . $href . '" rel="nofollow" ' . $frontpanel_buttons->tooltipMeta(__('Is this your ad?', 'W2DC'), true) . '><span class="w2dc-glyphicon w2dc-glyphicon-flag"></span> ' . ((!$frontpanel_buttons->hide_button_text) ? __('Is this your ad?', 'W2DC') : "") . '</a> ';
				}
			}
		}
	}

	public function add_logout_button($frontpanel_buttons) {
		if ($frontpanel_buttons->isButton('logout')) {
			echo '<a class="w2dc-logout-link w2dc-btn w2dc-btn-primary" href="' . wp_logout_url(w2dc_directoryUrl()) . '" rel="nofollow" ' . $frontpanel_buttons->tooltipMeta(__('Log out', 'W2DC'), true) . '><span class="w2dc-glyphicon w2dc-glyphicon-log-out"></span> ' . ((!$frontpanel_buttons->hide_button_text) ? __('Log out', 'W2DC') : "") . '</a>';
		}
	}
	
	public function remove_admin_bar() {
		if (get_option('w2dc_hide_admin_bar') && !current_user_can('manage_options') && !current_user_can('editor') && !is_admin()) {
			show_admin_bar(false);
			add_filter('show_admin_bar', '__return_false', 99999);
		}
	}

	public function edit_listings_links($url, $post_id) {
		global $w2dc_instance;

		if (!is_admin() && $w2dc_instance->dashboard_page_url && ($post = get_post($post_id)) && $post->post_type == W2DC_POST_TYPE)
			return w2dc_dashboardUrl(array('w2dc_action' => 'edit_listing', 'listing_id' => $post_id));
	
		return $url;
	}

	public function add_user_profile_fields($user) { ?>
		<h3><?php _e('Directory billing information', 'W2DC'); ?></h3>
	
		<table class="form-table">
			<tr>
				<th><label for="w2dc_billing_name"><?php _e('Full name', 'W2DC'); ?></label></th>
				<td>
					<input type="text" name="w2dc_billing_name" id="w2dc_billing_name" value="<?php echo esc_attr(get_the_author_meta('w2dc_billing_name', $user->ID)); ?>" class="regular-text" /><br />
				</td>
			</tr>
			<tr>
				<th><label for="w2dc_billing_address"><?php _e('Full address', 'W2DC'); ?></label></th>
				<td>
					<textarea name="w2dc_billing_address" id="w2dc_billing_address" cols="30" rows="3"><?php echo esc_textarea(get_the_author_meta('w2dc_billing_address', $user->ID)); ?></textarea>
				</td>
			</tr>
		</table>
<?php }

	public function save_user_profile_fields($user_id) {
		if (!current_user_can('edit_user', $user_id))
			return false;

		update_user_meta($user_id, 'w2dc_billing_name', $_POST['w2dc_billing_name']);
		update_user_meta($user_id, 'w2dc_billing_address', $_POST['w2dc_billing_address']);
	}

	public function on_listing_approval($new_status, $old_status, $post) {
		if (get_option('w2dc_approval_notification')) {
			if (
				$post->post_type == W2DC_POST_TYPE &&
				'publish' == $new_status &&
				'pending' == $old_status &&
				($listing = w2dc_getListing($post)) &&
				($author = get_userdata($listing->post->post_author))
			) {
				update_post_meta($post->ID, '_listing_approved', true);

				$subject = __('Approval of listing', 'W2DC');
					
				$body = str_replace('[author]', $author->display_name,
						str_replace('[listing]', $listing->post->post_title,
						str_replace('[link]', w2dc_dashboardUrl(),
				get_option('w2dc_approval_notification'))));

				w2dc_mail($author->user_email, $subject, $body);
			}
		}
	}
	
	public function post_status_on_activation($status, $listing) {
		$is_moderation = get_post_meta($listing->post->ID, '_requires_moderation', true);
		$is_approved = get_post_meta($listing->post->ID, '_listing_approved', true);
		if (!$is_moderation || ($is_moderation && $is_approved)) {
			return 'publish';
		} elseif ($is_moderation && !$is_approved) {
			return 'pending';
		}
		return $status;
	}

	public function enqueue_login_scripts_styles() {
		global $action;
		$action = 'login';
		do_action('login_enqueue_scripts');
		do_action('login_head');
	}
}

function w2dc_install_fsubmit() {
	w2dc_upgrade_fsubmit('1.5.0');
	w2dc_upgrade_fsubmit('1.5.4');
	w2dc_upgrade_fsubmit('1.6.2');
	w2dc_upgrade_fsubmit('1.8.3');
	w2dc_upgrade_fsubmit('1.8.4');
	w2dc_upgrade_fsubmit('1.9.0');
	w2dc_upgrade_fsubmit('1.9.7');
	w2dc_upgrade_fsubmit('1.10.0');
	w2dc_upgrade_fsubmit('1.12.7');
	w2dc_upgrade_fsubmit('1.13.0');
	w2dc_upgrade_fsubmit('1.14.0');
	w2dc_upgrade_fsubmit('2.0.0');
	
	if (
		get_option('w2dc_newuser_notification') &&
		get_option('w2dc_claim_notification') &&
		get_option('w2dc_claim_approval_notification') &&
		get_option('w2dc_newlisting_admin_notification') &&
		get_option('w2dc_approval_notification') &&
		get_option('w2dc_claim_decline_notification') &&
		get_option('w2dc_editlisting_admin_notification')
	) {
		update_option('w2dc_installed_fsubmit', 1);
	}
}

function w2dc_upgrade_fsubmit($new_version) {
	if ($new_version == '1.5.0') {
		update_option('w2dc_fsubmit_login_mode', 1);
		update_option('w2dc_fsubmit_button', 1);
		update_option('w2dc_hide_admin_bar', 0);
		update_option('w2dc_newuser_notification', 'Hello [author],

your listing "[listing]" was successfully submitted.

You may manage your listing using following credentials:
login: [login]
password: [password]');
	}
	
	if ($new_version == '1.5.4')
		update_option('w2dc_allow_edit_profile', 1);

	if ($new_version == '1.6.2')
		update_option('w2dc_enable_frontend_translations', 1);

	if ($new_version == '1.8.3') {
		update_option('w2dc_claim_functionality', 0);
		update_option('w2dc_claim_approval', 1);
		update_option('w2dc_after_claim', 'active');
		update_option('w2dc_hide_claim_contact_form', 0);
		update_option('w2dc_claim_notification', 'Hello [author],

your listing "[listing]" was claimed by [claimer].

You may approve or reject this claim at
[link]

[message]');
		update_option('w2dc_claim_approval_notification', 'Hello [claimer],

congratulations, your claim for listing "[listing]" was successfully approved.

Now you may manage your listing at the dashboard
[link]');
		update_option('w2dc_newlisting_admin_notification', 'Hello,

user [user] created new listing "[listing]".

You may manage this listing at
[link]');
	}

	if ($new_version == '1.9.0') {
		update_option('w2dc_tospage', "0");
	}

	if ($new_version == '1.9.7') {
		update_option('w2dc_hide_claim_metabox', 0);
	}

	if ($new_version == '1.10.0') {
		update_option('w2dc_submit_login_page', "0");
	}

	if ($new_version == '1.12.7') {
		update_option('w2dc_approval_notification', 'Hello [author],

your listing "[listing]" was successfully approved.
				
Now you may manage your listing at the dashboard
[link]');
		update_option('w2dc_claim_decline_notification', 'Hello [claimer],

your claim for listing "[listing]" was declined.');
	}
	
	if ($new_version == '1.13.0') {
		update_option('w2dc_woocommerce_functionality', 0);
	}

	if ($new_version == '1.14.0') {
		update_option('w2dc_editlisting_admin_notification', 'Hello,

user [user] modified listing "[listing]". Now it is pending review.

You may manage this listing at
[link]');
	}
	
	if ($new_version == '2.0.0') {
		update_option('w2dc_hide_choose_level_page', 0);
		update_option('w2dc_fsubmit_moderation', 0);
		update_option('w2dc_fsubmit_edit_moderation', 0);
	}
}

global $w2dc_fsubmit_instance;

$w2dc_fsubmit_instance = new w2dc_fsubmit_plugin();
$w2dc_fsubmit_instance->init();

?>