<?php

class w2rr_admin {

	public function __construct() {
		global $w2rr_instance;

		add_action('admin_menu', array($this, 'menu'));

		$w2rr_instance->settings_manager = new w2rr_settings_manager;

		$w2rr_instance->media_manager = new w2rr_media_manager;

		$w2rr_instance->csv_manager = new w2rr_csv_manager;
		
		$w2rr_instance->demo_data_manager = new w2rr_demo_data_manager;
		
		add_action('admin_head-post-new.php', array($this, 'hidePreviewButton'));
		add_action('admin_head-post.php', array($this, 'hidePreviewButton'));
		
		add_action('show_user_profile', array( $this, 'create_avatar_field'));
		add_action('edit_user_profile', array( $this, 'create_avatar_field'));
		add_action('personal_options_update', array( $this, 'save_avatar'));
		add_action('edit_user_profile_update', array( $this, 'save_avatar'));

		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_styles'), 0);
		
		add_filter('admin_body_class', array($this, 'addBodyClasses'));

		add_action('wp_ajax_w2rr_generate_color_palette', array($this, 'generate_color_palette'));
		add_action('wp_ajax_nopriv_w2rr_generate_color_palette', array($this, 'generate_color_palette'));
		add_action('w2rr_vp_option_before_ajax_save', array($this, 'remove_colorpicker_cookie'));
		add_action('wp_footer', array($this, 'render_palette_picker'));
		
		add_image_size('user-picture-size', 100, 100, true);
		
		add_action('admin_notices', array($this, 'renderAdminMessages'));
	}
	
	public function renderAdminMessages() {
		global $pagenow;
	
		$post_types_array = w2rr_getWorkingPostTypes();
		$post_types_array[] = W2RR_REVIEW_TYPE;
		
		if ((($pagenow == 'edit.php' || $pagenow == 'post-new.php') && ($post_type = w2rr_getValue($_GET, 'post_type')) &&
				(in_array($post_type, $post_types_array))
		) ||
		($pagenow == 'post.php' && ($post_id = w2rr_getValue($_GET, 'post')) && ($post = get_post($post_id)) && w2rr_getValue($_GET, 'action') == 'edit' &&
				(in_array($post->post_type, $post_types_array))
		)) {
			w2rr_renderMessages();
		}
	}
	
	public function create_avatar_field($user) {
		if (is_admin() && current_user_can('upload_files')) {
			$upload_avatar = new w2rr_upload_image('user-avatar', get_user_meta($user->ID, '_w2rr_user_picture_id', true), 'user-picture-size');
			?>
			<script>
				w2rr_js_objects.media_dialog_title = '<?php esc_js(esc_html_e('Upload user picture', 'w2rr')); ?>';
				w2rr_js_objects.media_dialog_button_text = '<?php esc_js(esc_html_e('Insert', 'w2rr')); ?>';
			</script>
			<h2><?php esc_html_e('User picture upload', 'w2rr'); ?></h2>
			<table class="form-table">
				<tr>
					<th></th>
					<td class="w2rr-content">
						<?php $upload_avatar->display_form(); ?>
					</td>
				</tr>
			</table>
			<?php 
		}
	}
	
	public function save_avatar($user_id) {
		$upload_avatar = new w2rr_upload_image('user-avatar', get_user_meta($user_id, '_w2rr_user_picture_id', true), 'user-picture-size');
		
		$user_pic_id = $upload_avatar->get_attachment_id_from_post();
		if ($user_pic_id !== false) {
			update_user_meta($user_id, '_w2rr_user_picture_id', $user_pic_id);
		} else {
			update_user_meta($user_id, '_w2rr_user_picture_id', "");
		}
	}

	public function menu() {
		if (defined('W2RR_DEMO') && W2RR_DEMO) {
			$capability = 'publish_posts';
		} else {
			$capability = 'manage_options';
		}

		add_menu_page(
			esc_html__("Ratings & Reviews settings", "w2rr"),
			esc_html__('Ratings Admin', 'w2rr'),
			$capability,
			'w2rr_settings',
			'',
			W2RR_RESOURCES_URL . 'images/menuicon.png'
		);
		add_submenu_page(
			'w2rr_settings',
			esc_html__("Ratings & Reviews settings", "w2rr"),
			esc_html__("Ratings & Reviews settings", "w2rr"),
			$capability,
			'w2rr_settings'
		);

		add_submenu_page(
			'w2rr_debug',
			esc_html__("Ratings & Reviews Debug", "w2rr"),
			esc_html__("Ratings & Reviews Debug", "w2rr"),
			$capability,
			'w2rr_debug',
			array($this, 'debug')
		);
		add_submenu_page(
			'w2rr_reset',
			esc_html__("Ratings & Reviews Reset", "w2rr"),
			esc_html__("Ratings & Reviews Reset", "w2rr"),
			'manage_options',
			'w2rr_reset',
			array($this, 'reset')
		);
	}

	public function debug() {
		global $w2rr_instance, $wpdb;
		
		$settings = $wpdb->get_results($wpdb->prepare("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE %s", $wpdb->esc_like('w2rr_') . '%'), ARRAY_A);

		w2rr_renderTemplate('debug.tpl.php', array(
			'rewrite_rules' => get_option('rewrite_rules'),
			'settings' => $settings,
		));
	}

	public function reset() {
		global $w2rr_instance, $wpdb;
		
		if (isset($_GET['reset']) && ($_GET['reset'] == 'settings' || $_GET['reset'] == 'settings_tables')) {
			if ($wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s", $wpdb->esc_like('w2rr_') . '%')) !== false) {
				delete_option('vpt_option');
				w2rr_save_dynamic_css();
				w2rr_addMessage('All Ratings & Reviews settings were deleted!');
			}
		}
		if (isset($_GET['reset']) && $_GET['reset'] == 'settings_tables') {
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_content_fields_groups");
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_content_fields");
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_directories");
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_levels");
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_levels_relationships");
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_locations_levels");
			$wpdb->query("DROP TABLE IF EXISTS $wpdb->w2rr_locations_relationships");
			w2rr_addMessage('W2RR database tables were dropped!');
		}
		w2rr_renderTemplate('reset.tpl.php');
	}
	
	public function hideMetaBoxes() {
		global $post, $pagenow;

		if (($pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == W2RR_REVIEW_TYPE) || ($pagenow == 'post.php' && $post && $post->post_type == W2RR_REVIEW_TYPE)) {
			$user_id = get_current_user_id();
			update_user_meta($user_id, 'metaboxhidden_' . W2RR_REVIEW_TYPE, array('trackbacksdiv', 'commentstatusdiv', 'postcustom'));
		}
	}
	
	public function showAuthorMetaBox($hidden, $screen) {
		if ($screen->post_type == W2RR_REVIEW_TYPE) {
			if ($key = array_search('authordiv', $hidden)) {
				unset($hidden[$key]);
			}
		}
	
		return $hidden;
	}

	public function hidePreviewButton() {
		global $post_type;
		
    	if ($post_type == W2RR_REVIEW_TYPE) {
    		echo '<style type="text/css">#preview-action {display: none;}</style>';
    	}
	}

	public function removeQuickEdit($actions, $post) {
		if ($post->post_type == W2RR_REVIEW_TYPE) {
			unset($actions['inline hide-if-no-js']);
			unset($actions['view']);
		}
		return $actions;
	}
	
	public function addBodyClasses($classes) {
		return "$classes w2rr-body";
	}
	
	public function admin_enqueue_scripts_styles($hook) {
		global $w2rr_instance;
		
		// include admin.css, rtl.css, bootstrap, custom.css and datepicker files in admin,
		// also in customizer and required for VC plugin, SiteOrigin plugin and widgets
		if (
			w2rr_isRRPageInAdmin() ||
			is_customize_preview() ||
			get_post_meta(get_the_ID(), '_wpb_vc_js_status', true)
		) {
			if (is_customize_preview())
				$this->enqueue_global_vars();
			else
				add_action('admin_head', array($this, 'enqueue_global_vars'));
			
			wp_register_style('w2rr-bootstrap', W2RR_RESOURCES_URL . 'css/bootstrap.css', array(), W2RR_VERSION);
			wp_register_style('w2rr-admin', W2RR_RESOURCES_URL . 'css/admin.css', array(), W2RR_VERSION);
			if (function_exists('is_rtl') && is_rtl()) {
				wp_register_style('w2rr-admin-rtl', W2RR_RESOURCES_URL . 'css/admin-rtl.css', array(), W2RR_VERSION);
			}
			
			if ($admin_custom = w2rr_isResource('css/admin-custom.css')) {
				wp_register_style('w2rr-admin-custom', $admin_custom, array(), W2RR_VERSION);
			}
		}
		
		if (w2rr_isRRPageInAdmin()) {
			// some plugins decide to disable this thing
			wp_enqueue_script('jquery-migrate');

			wp_register_style('w2rr-font-awesome', W2RR_RESOURCES_URL . 'css/font-awesome.css', array(), W2RR_VERSION);
			wp_register_script('w2rr-js-functions', W2RR_RESOURCES_URL . 'js/js_functions.js', array('jquery'), false, true);
			
			wp_register_style('w2rr-media-styles', W2RR_RESOURCES_URL . 'lightbox/css/lightbox.min.css', array(), W2RR_VERSION);
			wp_register_script('w2rr-media-scripts-lightbox', W2RR_RESOURCES_URL . 'lightbox/js/lightbox.js', array('jquery'));
		}
		
		wp_enqueue_style('w2rr-bootstrap');
		wp_enqueue_style('w2rr-font-awesome');
		wp_enqueue_style('w2rr-admin');
		wp_enqueue_style('w2rr-admin-rtl');
		wp_enqueue_script('w2rr-js-functions');
		wp_enqueue_style('w2rr-admin-custom');
	}

	public function enqueue_global_vars() {
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$ajaxurl = admin_url('admin-ajax.php?lang=' .  $sitepress->get_current_language());
		} else {
			$ajaxurl = admin_url('admin-ajax.php');
		}

		echo '
<script>
';
		echo 'var w2rr_js_objects = ' . json_encode(
				array(
						'ajaxurl' => $ajaxurl,
						'is_rtl' => (int)is_rtl(),
						'lang' => (($sitepress && get_option('w2rr_map_language_from_wpml')) ? ICL_LANGUAGE_CODE : ''),
						'is_admin' => (int)is_admin(),
				)
		) . ';
';
		echo '</script>
';
	}

	public function generate_color_palette() {
		ob_start();
		include W2RR_PATH . '/classes/customization/dynamic_css.php';
		$dynamic_css = ob_get_contents();
		ob_get_clean();

		echo $dynamic_css;
		die();
	}
	
	public function remove_colorpicker_cookie($opt) {
		if (isset($_COOKIE['w2rr_compare_palettes'])) {
			unset($_COOKIE['w2rr_compare_palettes']);
			setcookie('w2rr_compare_palettes', null, -1, '/');
		}
	}

	public function render_palette_picker() {
		global $w2rr_instance;

		if (!empty($w2rr_instance->frontend_controllers)) {
			if ((get_option('w2rr_compare_palettes') && current_user_can('manage_options')) || (defined('W2RR_DEMO') && W2RR_DEMO)) {
				w2rr_renderTemplate('color_picker/color_picker_panel.tpl.php');
			}
		}
	}
}
?>