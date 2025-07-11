<?php

add_filter('breadcrumb_trail_items', 'wdt_directory_breadcrumbs', 10, 2);
function wdt_directory_breadcrumbs($items, $args) {
	global $w2dc_instance;

	if (
		$w2dc_instance &&
		(
				($directory_controller = $w2dc_instance->getShortcodeProperty(W2DC_MAIN_SHORTCODE)) ||
				($directory_controller = $w2dc_instance->getShortcodeProperty(W2DC_LISTING_SHORTCODE)) ||
				($directory_controller = $w2dc_instance->getShortcodeProperty(W2DC_CATEGORY_PAGE_SHORTCODE)) ||
				($directory_controller = $w2dc_instance->getShortcodeProperty(W2DC_LOCATION_PAGE_SHORTCODE)) ||
				($directory_controller = $w2dc_instance->getShortcodeProperty(W2DC_TAG_PAGE_SHORTCODE)) ||
				($directory_controller = apply_filters('w2dc_get_shortcode_controller', false))
		) &&
		!empty($directory_controller->breadcrumbs)
	) {
		$items = $directory_controller->getBreadCrumbsLinks();
	}
	return $items;
}

?>