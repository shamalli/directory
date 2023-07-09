<?php

function w2rr_dashboardUrl($path = '') {
	global $w2rr_instance;

	if ($w2rr_instance->dashboard_page_id) {
		$dashboard_page_url = get_permalink($w2rr_instance->dashboard_page_id);
		
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($sitepress->get_option('language_negotiation_type') == 3) {
				// remove any previous value.
				$dashboard_page_url = remove_query_arg('lang', $dashboard_page_url);
			}
		}

		if (!is_array($path)) {
			if ($path) {
				// found that on some instances of WP "native" trailing slashes may be missing
				$url = rtrim($dashboard_page_url, '/') . '/' . rtrim($path, '/') . '/';
			} else
				$url = $dashboard_page_url;
		} else
			$url = add_query_arg($path, $dashboard_page_url);

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$url = $sitepress->convert_url($url);
		}
	} else
		$url = home_url();

	return $url;
}

?>