<?php

// @codingStandardsIgnoreFile

/*
 * place shortcode [webdirectory-listing-page] on a page, do not use widget, instead shortcode,
 * then use listing page widgets: map, header, gallery, e.t.c.
 * 
 * */

add_action('init', function() {
	global $w2dc_listing_page_widget_params;
	$w2dc_listing_page_widget_params = array(
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => esc_html__("Select directory", "w2dc"),
			),
	);
}, 0);

?>