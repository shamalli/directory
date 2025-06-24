<?php

/*
 * place shortcode [webdirectory-category-page] on a page, do not use widget, instead shortcode,
* then use category page widgets: listings, map, search
*
* */
add_action('init', function() {
	global $w2dc_category_page_widget_params;
	$w2dc_category_page_widget_params = array(
			array(
					'type' => 'textfield',
					'param_name' => 'category_id',
					'heading' => esc_html__("Enter specific category ID", "w2dc"),
			),
			array(
					'type' => 'formid',
					'param_name' => 'search_form_id',
					'heading' => esc_html__("Select search form for category page or leave default", "w2dc"),
			),
	);
}, 0);

?>