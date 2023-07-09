<?php

/**
 * return content of the listing page built by Elementor
 *
 */
add_action('w2rr_the_content_review_page', 'w2rr_elementor_review_page_the_content');
function w2rr_elementor_review_page_the_content($page_content) {
	if (!defined('ELEMENTOR_VERSION')) {
		return $page_content;
	}

	global $w2rr_instance;

	$elementor_content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($w2rr_instance->review_page_id);

	if (empty($elementor_content) && $page_content) {
		return $page_content;
	} else {
		return $elementor_content;
	}
}

/**
 * detect is page contains any of single review page Elementor widget
 */
add_filter('w2rr_is_review_elements_on_page', 'w2rr_is_review_elements_on_page');
function w2rr_is_review_elements_on_page($is_on_page) {

	if (!defined('ELEMENTOR_VERSION')) {
		return $is_on_page;
	}
	
	global $w2rr_instance;
	
	$elementor_data = get_post_meta($w2rr_instance->review_page_id, '_elementor_data' ,true);

	if (is_string($elementor_data) && !empty($elementor_data)) {
		$elementor_data = json_decode($elementor_data, true);
	}

	if ($elementor_data) {

		$elements_list = array(
				'review_header',
				'review_content',
				'review_title',
				'review_comments',
				'review_gallery',
				'review_rating',
				'review_ratings_overall',
				'review_votes',
		);
			
		array_map(
				function($item) use ($elements_list) { return w2rr_elementor_find_review_elem($item, $elements_list); },
				$elementor_data
		);
			
		global $w2rr_elementor_review_element_widget;
			
		if ($w2rr_elementor_review_element_widget) {
			$is_on_page = true;
		}
	}

	return $is_on_page;
}

function w2rr_elementor_find_review_elem($item, $elements_list) {
	global $w2rr_elementor_review_element_widget;

	if (is_array($item)) {
		if (!isset($item['widgetType']) || !in_array($item['widgetType'], $elements_list)) {
			array_map(
					function($item) use ($elements_list) { return w2rr_elementor_find_review_elem($item, $elements_list); },
					$item
			);
		} else {
			$w2rr_elementor_review_element_widget = $item;
		}
	}
}

?>