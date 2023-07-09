<?php

function w2dc_getPluginID() {
	return 6463373;
}
function w2dc_getPluginName() {
	return 'Web 2.0 Directory plugin';
}
function w2dc_getEnvatoSlug() {
	return 'web-20-directory-plugin-for-wordpress';
}
function w2dc_getUpdateDocsLink() {
	return 'https://www.salephpscripts.com/wordpress_directory/demo/documentation/update/';
}
function w2dc_getVersionLink() {
	return 'license-version-check?product=w2dc';
}
function w2dc_getUpdateSupportLink() {
	return 'https://salephpscripts.com/support-renew/';
}
function w2dc_getPurchaseLink() {
	return 'https://salephpscripts.com/license-purchase?product=w2dc';
}
function w2dc_getVerifyServers() {
	return array(
			'https://salephpscripts.com/',
			'https://webdev-cdn.com/',
	);
}
function w2dc_connectToVerifyServer($path) {
	
	$servers = w2dc_getVerifyServers();
	
	foreach ($servers AS $host) {
		
		$url = trim($host, '/') . '/' . trim($path, '/');
		
		$request = wp_remote_get($url);
		
		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
			$body = wp_remote_retrieve_body($request);
			
			$stop_phrases = array(
					"imunify360",
					"captcha",
					"We have noticed an unusual activity from your IP",
					"Please wait while your request is being verified",
			);
			
			foreach ($stop_phrases AS $stop_phrase) {
				if (strpos($body, $stop_phrase) !== false) {
					continue 2;
				}
			}
			
			return $body;
			break;
		}
	}
}

class w2dc_updater {
	private $slug; // plugin slug
	private $plugin_file; // __FILE__ of our plugin
	private $envato_res;
	private $salephpscripts_res;
	
	private $plugin_data;

	private $purchase_code;
	
	public function __construct($plugin_file, $purchase_code) {
		add_filter("pre_set_site_transient_update_plugins", array($this, "setTransient"));
		add_filter("plugins_api", array($this, "setPluginInfo"), 10, 3);
		
		add_filter("upgrader_package_options", array($this, "setUpdatePackage"));
		add_filter("upgrader_pre_download", array($this, "updateErrorMessage"), 10, 3);

		$this->plugin_file = $plugin_file;
		$this->slug = plugin_basename($this->plugin_file);
		
		add_action('in_plugin_update_message-' . $this->slug, array($this, 'showUpgradeMessage'), 10, 2);

		$this->purchase_code = trim($purchase_code);
		
		add_action('wp_ajax_w2dc_license_support_checker', array($this, 'license_support_checker'));
		add_action('wp_ajax_nopriv_w2dc_license_support_checker', array($this, 'license_support_checker'));
	}
	
	public function license_support_checker() {
		
		check_ajax_referer('w2dc_license_support_checker_nonce', 'security');
		
		if ($this->purchase_code) {
			
			$thirty_minutes = 30*60;
			
			if (
				!get_option("w2dc_license_support_check_last_time") ||
				(get_option("w2dc_license_support_check_last_time") + $thirty_minutes) <= time()
			) {
				$salephpscripts_res_date = w2dc_connectToVerifyServer("license-support-check?purchase_code=" . $this->purchase_code);
					
				if (!empty($salephpscripts_res_date)) {
					
					update_option("w2dc_license_support_check_last_time", time());
					update_option("w2dc_license_support_until_date", $salephpscripts_res_date);
					
					echo $this->support_checker_response($salephpscripts_res_date);
				} else {
					echo $this->support_checker_response(false);
				}
			} elseif (get_option("w2dc_license_support_until_date")) {
				echo $this->support_checker_response(get_option("w2dc_license_support_until_date"));
			}
		}
		
		die();
	}
	
	public function support_checker_response($date) {
		
		if ($date === false) {
			return '<p class="w2dc-license-support-checker-expired">' . esc_html__("No purchase associated with purchase code.", "W2DC") . ' ' . esc_html__("Please follow the link", "W2DC") . ' ' . '<a href="' . w2dc_getPurchaseLink() . '" target="_blank">' . esc_html__("to buy a license", "W2DC") . '</a></p>';
		}
		
		if (!is_numeric($date)) {
			return false;
		}
		
		if ($date > time()) {
			return '<p class="w2dc-license-support-checker-active">' . esc_html__("Your support is active till ", "W2DC") . date_i18n(get_option('date_format'), intval($date)) . '. ' . esc_html__("Please follow the link if you wish", "W2DC") . ' ' . '<a href="' . w2dc_getUpdateSupportLink() . '" target="_blank">' . esc_html__("to renew", "W2DC") . '</a></p>';
		} else {
			return '<p class="w2dc-license-support-checker-expired">' . esc_html__("Your support has expired since ", "W2DC") . date_i18n(get_option('date_format'), intval($date)) . '. ' . esc_html__("Please follow the link", "W2DC") . ' ' . '<a href="' . w2dc_getUpdateSupportLink() . '" target="_blank">' . esc_html__("to renew", "W2DC") . '</a></p>';
		}
	}
	
	public function getDownload_url($debug = false) {
		
		if ($this->purchase_code) {
			
			$host = site_url();
			
			$this->salephpscripts_res = w2dc_connectToVerifyServer("license-get-download-url?purchase_code=" . $this->purchase_code . "&host=" . $host);
			
			if ($debug) {
				var_dump($this->salephpscripts_res);
			}
			
			if (!empty($this->salephpscripts_res)) {
				return $this->salephpscripts_res;
			}
		}
	}
	
	function updateErrorMessage($reply, $package, $upgrader) {
		// Don't override a reply that was set already.
		if ($reply !== false) {
			return $reply;
		}
		
		if (isset($this->envato_res->error)) {
			$error_message = esc_html__("response from Codecanyon - ", "W2DC") . $this->envato_res->error . (!empty($this->envato_res->description) ? ' (' .  $this->envato_res->description . ')' : '');
			
			return new WP_Error('no_package', $error_message);
		}
		
		return $reply;
	}
	
	public function getRemote_version() {
		if ($version = w2dc_connectToVerifyServer(w2dc_getVersionLink())) {
			return $version;
		}
		
		return false;
	}
	
	public function setUpdatePackage($options) {
		$package = $options['package'];
		if ($package === $this->slug) {
			$options['package'] = $this->getDownload_url();
		}
		
		return $options;
	}
	
	// Push in plugin version information to get the update notification
	public function setTransient($transient) {
		// If we have checked the plugin data before, don't re-check
		if (empty($transient->checked)) {
			return $transient;
		}

		// Get plugin & version information
		$remote_version = $this->getRemote_version();

		// If a newer version is available, add the update
		if (version_compare(W2DC_VERSION, $remote_version, '<')) {
			$plugin_data = get_plugin_data($this->plugin_file);
			
			$obj = new stdClass();
			$obj->slug = str_replace('.php', '', $this->slug);
			$obj->new_version = $remote_version;
			$obj->package = $this->slug;
			$obj->url = $plugin_data["PluginURI"];
			$obj->name = w2dc_getPluginName();
			$transient->response[$this->slug] = $obj;
		}
		
		return $transient;
	}
	
	public function showUpgradeMessage($plugin_data, $response) {
		if (empty($response->package)) {
			echo sprintf(__('Correct Envato access token required. You have to download the latest version from <a href="%s" target="_blank">Codecanyon</a> and follow <a href="%s" target="_blank">update instructions</a>.', 'W2DC'), 'https://codecanyon.net/downloads', w2dc_getUpdateDocsLink());
		}
	}
	
	// Push in plugin version information to display in the details lightbox
	public function setPluginInfo($false, $action, $response) {
		if (empty($response->slug) || $response->slug != str_replace('.php', '', $this->slug)) {
			return $false;
		}
		
		if ($action == 'plugin_information') {
			$remote_version = $this->getRemote_version();

			$plugin_data = get_plugin_data($this->plugin_file);
			
			if ($envatoRes = w2dc_get_plugin_info($this->purchase_code)) {
				$response = new stdClass();
				$response->last_updated = $envatoRes->item->updated_at;
				$response->slug = $this->slug;
				$response->name  = $this->pluginData["Name"];
				$response->plugin_name  = $plugin_data["Name"];
				$response->version = $remote_version;
				$response->author = $plugin_data["AuthorName"];
				$response->homepage = $plugin_data["PluginURI"];
	
				if (isset($envatoRes->item->description)) {
					$response->sections = array(
							'description' => $envatoRes->item->description,
					);
				}
				return $response;
			}
		}
	}
}

function w2dc_getAccessToken() { return 'R0qSjwSjti1fvlnVB7Kt1rNKgz2cdAYE'; } add_action('vp_w2dc_option_before_ajax_save', 'w2dc_verify_license_on_setting', 1); function w2dc_verify_license_on_setting($opts) { global $w2dc_instance, $w2dc_license_verify_error; $q = "hexdec"; if (!get_option("w2dc_v{$q("0x14")}Qd10fG041L01")) { if (!empty($opts['w2dc_purchase_code'])) { $w2dc_purchase_code = trim($opts['w2dc_purchase_code']); update_option('w2dc_purchase_code', $w2dc_purchase_code); update_option('vpt_option', array( 'w2dc_purchase_code' => $w2dc_purchase_code ) ); if (w2dc_verify_license($w2dc_purchase_code)) { update_option("w2dc_v{$q("0x14")}Qd10fG041L01", 1); if (ob_get_length()) ob_clean(); header('Content-type: application/json'); echo json_encode(array( 'status' => true, 'message' => 'License verification passed successfully!' )); die(); } } remove_action('vp_w2dc_option_after_ajax_save', array($w2dc_instance->settings_manager, 'save_option'), 10); if (ob_get_length()) ob_clean(); header('Content-type: application/json'); echo json_encode(array( 'status' => false, 'message' => 'License verification did not pass!<br />' . $w2dc_license_verify_error )); die(); } } function w2dc_get_plugin_info($purchase_code) { if ($purchase_code) { $host = site_url(); $salephpscripts_res = w2dc_connectToVerifyServer("license-activate?purchase_code=" . $purchase_code . "&host=" . $host); if ($salephpscripts_res) { return $salephpscripts_res; } } if ($purchase_code) { $url = "https://api.envato.com/v3/market/author/sale?code=".$purchase_code; $curl = curl_init($url); $header = array(); $header[] = 'Authorization: Bearer '.w2dc_getAccessToken(); $header[] = 'User-Agent: Purchase code verification on ' . get_bloginfo(); $header[] = 'timeout: 20'; curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); curl_setopt($curl, CURLOPT_HTTPHEADER,$header); curl_setopt($curl, CURLOPT_REFERER, $_SERVER["HTTP_HOST"]); curl_setopt($curl, CURLOPT_HEADER, 0); curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8'); curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); if (($envatoRes = curl_exec($curl)) !== false) { curl_close($curl); return json_decode($envatoRes); } else { global $w2dc_license_verify_error; $w2dc_license_verify_error = "cURL error: " . curl_error($curl); curl_close($curl); } } } function w2dc_verify_license($purchase_code) { $res = w2dc_get_plugin_info($purchase_code); if (is_numeric($res)) { return true; } if (isset($res->item->id) && $res->item->id == w2dc_getPluginID()) { return true; } elseif (isset($res->error)) { global $w2dc_license_verify_error; error_log($res->error . ' ' . $res->description); $w2dc_license_verify_error = "Envato: " . $res->error . ' ' . $res->description; } elseif (isset($res->message)) { global $w2dc_license_verify_error; $w2dc_license_verify_error = "Envato: " . $res->message; } elseif (isset($res->Message)) { global $w2dc_license_verify_error; $w2dc_license_verify_error = "Envato: " . $res->Message; } } function w2dc_directories_manager_init($directories_manager) { $xxx = 'directories'; $yyy = 'manager'; add_action('admin_menu', array(${$xxx . '_' . $yyy}, 'menu')); } add_filter('w2dc_build_settings', 'w2dc_verify_license_settings', 100); function w2dc_verify_license_settings($options) { $options['template']['menus']['general']['controls'] = array_merge( array('license' => array( 'type' => 'section', 'title' => __('License information', 'w2dc'), 'fields' => array( array( 'type' => 'textbox', 'name' => 'w2dc_purchase_code', 'label' => __('Purchase code*', 'W2DC'), 'description' => __('You should receive purchase (license) code after purchase <div class="w2dc-license-support-checker" data-nonce="' . wp_create_nonce('w2dc_license_support_checker_nonce') . '"></div>', 'W2DC'), 'default' => get_option('w2dc_purchase_code'), ), ), )), $options['template']['menus']['general']['controls'] ); return $options; } add_action('w2dc_settings_panel_top', 'w2dc_settings_panel_top'); function w2dc_settings_panel_top() { $q = "hexdec"; if (!get_option("w2dc_v{$q("0x14")}Qd10fG041L01")) { echo '<div class="error">'; echo '<p>' . sprintf('Your installation of %s was not verified. Any changes in the settings below will not be saved. To verify license information take purchase code from purchase email.', w2dc_getPluginName()) . '</p>'; echo '</div>'; } } 

?>