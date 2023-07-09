<?php

function w2dc_submitUrl($path = '') {
	global $w2dc_instance;

	$submit_page_url = '';

	if (!empty($path['directory'])) {
		if (($directory = $w2dc_instance->directories->getDirectoryById($path['directory'])) && isset($w2dc_instance->submit_pages_all[$directory->id])) {
			$submit_page_url = $w2dc_instance->submit_pages_all[$directory->id]['url'];
			unset($path['directory']);
		}
	} else {
		if (isset($w2dc_instance->submit_pages_all[$w2dc_instance->current_directory->id])) {
			$submit_page_url = $w2dc_instance->submit_pages_all[$w2dc_instance->current_directory->id]['url'];
		}
	}
	if (!$submit_page_url) {
		if (isset($w2dc_instance->submit_pages_all[$w2dc_instance->directories->getDefaultDirectory()->id])) {
			$submit_page_url = $w2dc_instance->submit_pages_all[$w2dc_instance->directories->getDefaultDirectory()->id]['url'];
		}
	}

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_option('language_negotiation_type') == 3) {
			// remove any previous value.
			$submit_page_url = remove_query_arg('lang', $submit_page_url);
		}
	}

	if (!is_array($path)) {
		if ($path) {
			// found that on some instances of WP "native" trailing slashes may be missing
			$url = rtrim($submit_page_url, '/') . '/' . rtrim($path, '/') . '/';
		} else {
			$url = $submit_page_url;
		}
	} else {
		$url = add_query_arg($path, $submit_page_url);
	}

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		$url = $sitepress->convert_url($url);
	}

	return $url;
}

function w2dc_dashboardUrl($path = '') {
	global $w2dc_instance;

	if ($w2dc_instance->dashboard_page_url) {
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($sitepress->get_option('language_negotiation_type') == 3) {
				// remove any previous value.
				$w2dc_instance->dashboard_page_url = remove_query_arg('lang', $w2dc_instance->dashboard_page_url);
			}
		}

		if (!is_array($path)) {
			if ($path) {
				// found that on some instances of WP "native" trailing slashes may be missing
				$url = rtrim($w2dc_instance->dashboard_page_url, '/') . '/' . rtrim($path, '/') . '/';
			} else {
				$url = $w2dc_instance->dashboard_page_url;
			}
		} else {
			$url = add_query_arg($path, $w2dc_instance->dashboard_page_url);
		}

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$url = $sitepress->convert_url($url);
		}
	} else {
		$url = w2dc_directoryUrl();
	}

	return $url;
}

?>