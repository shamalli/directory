<?php

// @codingStandardsIgnoreFile

global $wcsearch_model_options;
$wcsearch_model_options = array(
		'keywords' => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => esc_html__("Keywords", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "placeholder",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => esc_html__("Enter keywords", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "string",
						"name" => "try_to_search_text",
						"title" => esc_html__("Try to search text", "wcsearch"),
						"value" => esc_html__("Try to search", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "keywords_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "sport,business,event",
				),
				array(
						"type" => "select",
						"name" => "autocomplete",
						"title" => esc_html__("Autocomplete field", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
				),
				array(
						"type" => "select",
						"name" => "order",
						"title" => esc_html__("Order direction", "wcsearch"),
						"options" => array(
								"ASC" => esc_html__("ASC", "wcsearch"),
								"DESC" => esc_html__("DESC", "wcsearch"),
						),
						"value" => "ASC",
						"dependency" => array(
								'autocomplete' => 1,
								'orderby' => 'price'
						),
				),
				array(
						"type" => "select",
						"name" => "do_links",
						"title" => esc_html__("Links to products in autocomplete suggestion", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array('autocomplete' => 1),
				),
				array(
						"type" => "select",
						"name" => "do_links_blank",
						"title" => esc_html__("How to open links", "wcsearch"),
						"options" => array(
								"blank" => esc_html__("Open in new window", "wcsearch"),
								"self" => esc_html__("Open in same window", "wcsearch"),
						),
						"value" => "blank",
						"dependency" => array('autocomplete' => 1, 'do_links' => '1'),
				),
		),
		'string' => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => "",
				),
				array(
						"type" => "string",
						"name" => "placeholder",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => esc_html__("Enter keywords", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "string",
						"name" => "try_to_search_text",
						"title" => esc_html__("Try to search text", "wcsearch"),
						"value" => esc_html__("Try to search", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "keywords_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "sport,business,event",
				),
		),
		'address' => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => "",
				),
				array(
						"type" => "string",
						"name" => "placeholder",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => esc_html__("Enter address", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "string",
						"name" => "try_to_search_text",
						"title" => esc_html__("Try to search text", "wcsearch"),
						"value" => esc_html__("Try to search", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "address_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "Los Angeles, US Capitol, Central Park NY",
				),
		),
		"price" => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => "Price",
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "select",
						"name" => "mode",
						"title" => esc_html__("Search mode", "wcsearch"),
						"options" => array(
								"range" => esc_html__("Range slider", "wcsearch"),
								"single_slider" => esc_html__("Single slider", "wcsearch"),
								"min_max_one_dropdown" => esc_html__("Min-max options in one dropdown", "wcsearch"),
								"min_max_two_dropdowns" => esc_html__("Min-max options in two dropdowns", "wcsearch"),
								"radios" => esc_html__("Min-max options in radios", "wcsearch"),
								"inputs" => esc_html__("Two inputs", "wcsearch"),
						),
						"value" => "range",
				),
				array(
						"type" => "string",
						"name" => "placeholder_single_dropdown",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => esc_html__("Select price range", "wcsearch"),
						"dependency" => array('mode' => 'min_max_one_dropdown'),
				),
				array(
						"type" => "string",
						"name" => "placeholder_min",
						"title" => esc_html__("Placeholder min", "wcsearch"),
						"value" => esc_html__("Select min price", "wcsearch"),
						"dependency" => array('mode' => 'min_max_two_dropdowns,inputs'),
				),
				array(
						"type" => "string",
						"name" => "placeholder_max",
						"title" => esc_html__("Placeholder max", "wcsearch"),
						"value" => esc_html__("Select max price", "wcsearch"),
						"dependency" => array('mode' => 'min_max_two_dropdowns,inputs'),
				),
				array(
						"type" => "select",
						"name" => "show_scale",
						"title" => esc_html__("Show scale", "wcsearch"),
						"options" => array(
								"scale" => esc_html__("Show scale", "wcsearch"),
								"string" => esc_html__("Show as string", "wcsearch"),
						),
						"value" => "string",
						"dependency" => array('mode' => 'range,single_slider'),
				),
				array(
						"type" => "select",
						"name" => "odd_even_labels",
						"title" => esc_html__("Scale labels", "wcsearch"),
						"options" => array(
								"odd_even" => esc_html__("Odd and even labels", "wcsearch"),
								"odd" => esc_html__("Only odd labels", "wcsearch"),
						),
						"value" => "odd",
						"dependency" => array('show_scale' => 'scale'),
				),
				array(
						"type" => "select",
						"name" => "columns",
						"title" => esc_html__("Radios columns", "wcsearch"),
						"description" => esc_html__("When radio buttons is used in search mode", "wcsearch"),
						"options" => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
						),
						"value" => 2,
						"dependency" => array('mode' => 'radios'),
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array('mode' => 'radios'),
				),
				array(
						"type" => "string",
						"name" => "min_max_options",
						"title" => esc_html__("Min-Max options", "wcsearch"),
						"description" => "Example: 1,5,10,15,20 or 1-20",
						"value" => "",
						// example: "value" => "min, 1, 10, 50, 100, 500, 1000, max",
						"dependency" => array('mode' => 'range,single_slider,min_max_one_dropdown,min_max_two_dropdowns,radios'),
				),
				array(
						"type" => "dependency",
						"name" => "dependency_tax",
						"title" => esc_html__("Dependency", "wcsearch"),
						"description" => esc_html__("The field will be dependent from selected tax", "wcsearch"),
						"options" => array(
								0 => esc_html__("No dependency", "wcsearch"),
						),
				),
				array(
						"type" => "select",
						"name" => "dependency_visibility",
						"title" => esc_html__("Dependency visibility", "wcsearch"),
						"options" => array(
								"0" => esc_html__("Hidden", "wcsearch"),
								"1" => esc_html__("Shaded", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array("dependency_tax" => ""),
				),
		),
		"number" => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => "Number",
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "select",
						"name" => "mode",
						"title" => esc_html__("Search mode", "wcsearch"),
						"options" => array(
								"range" => esc_html__("Range slider", "wcsearch"),
								"single_slider" => esc_html__("Single slider", "wcsearch"),
								"min_max_one_dropdown" => esc_html__("Min-max options in one dropdown", "wcsearch"),
								"min_max_two_dropdowns" => esc_html__("Min-max options in two dropdowns", "wcsearch"),
								"radios" => esc_html__("Min-max options in radios", "wcsearch"),
								"inputs" => esc_html__("Two inputs", "wcsearch"),
						),
						"value" => "range",
				),
				array(
						"type" => "string",
						"name" => "placeholder_single_dropdown",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => esc_html__("Select range", "wcsearch"),
						"dependency" => array('mode' => 'min_max_one_dropdown'),
				),
				array(
						"type" => "string",
						"name" => "placeholder_min",
						"title" => esc_html__("Placeholder min", "wcsearch"),
						"value" => esc_html__("Select min", "wcsearch"),
						"dependency" => array('mode' => 'min_max_two_dropdowns,inputs'),
				),
				array(
						"type" => "string",
						"name" => "placeholder_max",
						"title" => esc_html__("Placeholder max", "wcsearch"),
						"value" => esc_html__("Select max", "wcsearch"),
						"dependency" => array('mode' => 'min_max_two_dropdowns,inputs'),
				),
				array(
						"type" => "select",
						"name" => "show_scale",
						"title" => esc_html__("Show scale", "wcsearch"),
						"options" => array(
								"scale" => esc_html__("Show scale", "wcsearch"),
								"string" => esc_html__("Show as string", "wcsearch"),
						),
						"value" => "string",
						"dependency" => array('mode' => 'range'),
				),
				array(
						"type" => "select",
						"name" => "odd_even_labels",
						"title" => esc_html__("Scale labels", "wcsearch"),
						"options" => array(
								"odd_even" => esc_html__("Odd and even labels", "wcsearch"),
								"odd" => esc_html__("Only odd labels", "wcsearch"),
						),
						"value" => "odd",
						"dependency" => array('mode' => 'range', 'show_scale' => 'scale'),
				),
				array(
						"type" => "select",
						"name" => "columns",
						"title" => esc_html__("Radios columns", "wcsearch"),
						"description" => esc_html__("When radio buttons is used in search mode", "wcsearch"),
						"options" => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
						),
						"value" => 2,
						"dependency" => array('mode' => 'radios'),
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array('mode' => 'radios'),
				),
				array(
						"type" => "string",
						"name" => "min_max_options",
						"title" => esc_html__("Min-Max options", "wcsearch"),
						"description" => "Example: 1,5,10,15,20 or 1-20",
						"value" => "",
						// example: "value" => "min, 1, 10, 50, 100, 500, 1000, max",
				),
				array(
						"type" => "dependency",
						"name" => "dependency_tax",
						"title" => esc_html__("Dependency", "wcsearch"),
						"description" => esc_html__("The field will be dependent from selected tax", "wcsearch"),
						"options" => array(
								0 => esc_html__("No dependency", "wcsearch"),
						),
				),
				array(
						"type" => "select",
						"name" => "dependency_visibility",
						"title" => esc_html__("Dependency visibility", "wcsearch"),
						"options" => array(
								"0" => esc_html__("Hidden", "wcsearch"),
								"1" => esc_html__("Shaded", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array("dependency_tax" => ""),
				),
		),
		"date" => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => "Date",
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "string",
						"name" => "placeholder_start",
						"title" => esc_html__("Placeholder start", "wcsearch"),
						"value" => esc_html__("Select start date", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "placeholder_end",
						"title" => esc_html__("Placeholder end", "wcsearch"),
						"value" => esc_html__("Select end date", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "reset_label_text",
						"title" => esc_html__("Reset text", "wcsearch"),
						"value" => esc_html__("reset", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "view",
						"title" => esc_html__("Show fields", "wcsearch"),
						"options" => array(
								"vertically" => esc_html__("Vertically", "wcsearch"),
								"horizontally" => esc_html__("Horizontally", "wcsearch"),
						),
						"value" => "vertically",
				),
				array(
						"type" => "dependency",
						"name" => "dependency_tax",
						"title" => esc_html__("Dependency", "wcsearch"),
						"description" => esc_html__("The field will be dependent from selected tax", "wcsearch"),
						"options" => array(
								0 => esc_html__("No dependency", "wcsearch"),
						),
				),
				array(
						"type" => "select",
						"name" => "dependency_visibility",
						"title" => esc_html__("Dependency visibility", "wcsearch"),
						"options" => array(
								"0" => esc_html__("Hidden", "wcsearch"),
								"1" => esc_html__("Shaded", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array("dependency_tax" => ""),
				),
		),
		"radius" => array(
				// default radius
				array(
						"type" => "hidden",
						"name" => "values",
						"value" => "10",
				),
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => "Radius",
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "select",
						"name" => "mode",
						"title" => esc_html__("Search mode", "wcsearch"),
						"options" => array(
								"slider" => esc_html__("Slider", "wcsearch"),
								"selectbox" => esc_html__("Selectbox", "wcsearch"),
						),
						"value" => "slider",
				),
				array(
						"type" => "select",
						"name" => "show_scale",
						"title" => esc_html__("Show scale", "wcsearch"),
						"options" => array(
								"scale" => esc_html__("Show scale", "wcsearch"),
								"string" => esc_html__("Show as string", "wcsearch"),
						),
						"value" => "string",
						"dependency" => array('mode' => 'slider'),
				),
				array(
						"type" => "select",
						"name" => "odd_even_labels",
						"title" => esc_html__("Scale labels", "wcsearch"),
						"options" => array(
								"odd_even" => esc_html__("Odd and even labels", "wcsearch"),
								"odd" => esc_html__("Only odd labels", "wcsearch"),
						),
						"value" => "odd",
						"dependency" => array('show_scale' => 'scale', 'mode' => 'slider'),
				),
				array(
						"type" => "string",
						"name" => "string_label",
						"title" => esc_html__("Label", "wcsearch"),
						"description" => "Example: Search in radius",
						"value" => "Search in radius",
						"dependency" => array('mode' => 'slider'),
				),
				array(
						"type" => "string",
						"name" => "min_max_options",
						"title" => esc_html__("Min-Max options", "wcsearch"),
						"description" => "Example: 1,5,10,15,20 or 0-20",
						"value" => "0-30",
				),
				array(
						"type" => "dependency",
						"name" => "dependency_tax",
						"title" => esc_html__("Dependency", "wcsearch"),
						"description" => esc_html__("The field will be dependent from selected tax", "wcsearch"),
						"options" => array(
								0 => esc_html__("No dependency", "wcsearch"),
						),
				),
				array(
						"type" => "select",
						"name" => "dependency_visibility",
						"title" => esc_html__("Dependency visibility", "wcsearch"),
						"options" => array(
								"0" => esc_html__("Hidden", "wcsearch"),
								"1" => esc_html__("Shaded", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array("dependency_tax" => ""),
				),
		),
		"button" => array(
				array(
						"type" => "string",
						"name" => "text",
						"title" => esc_html__("Button text", "wcsearch"),
						"value" => esc_html__("Search", "wcsearch"),
				),
		),
		"reset" => array(
				array(
						"type" => "string",
						"name" => "text",
						"title" => esc_html__("Reset text", "wcsearch"),
						"value" => esc_html__("Reset", "wcsearch"),
				),
		),
		"more_filters" => array(
				array(
						"type" => "string",
						"name" => "text",
						"title" => esc_html__("Text", "wcsearch"),
						"value" => esc_html__("More filters", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "open_by_default",
						"title" => esc_html__("Opened by default", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
		),
		"tax" => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => esc_html__("Title", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "select",
						"name" => "mode",
						"title" => esc_html__("Search mode", "wcsearch"),
						"options" => array(
								"dropdown" => esc_html__("Single dropdown", "wcsearch"),
								"dropdown_keywords" => esc_html__("Single dropdown + keywords", "wcsearch"),
								"hierarhical_dropdown" => esc_html__("Heirarhical dropdown", "wcsearch"),
								"multi_dropdown" => esc_html__("Multi dropdown", "wcsearch"),
								"radios" => esc_html__("Radios", "wcsearch"),
								"radios_buttons" => esc_html__("Radio buttons", "wcsearch"),
								"checkboxes" => esc_html__("Checkboxes", "wcsearch"),
								"checkboxes_buttons" => esc_html__("Checkboxes buttons", "wcsearch"),
								"range" => esc_html__("Range slider", "wcsearch"),
								"single_slider" => esc_html__("Single slider", "wcsearch"),
						),
						"value" => "dropdown",
				),
				array(
						"type" => "string",
						"name" => "placeholder",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => "",
						"dependency" => array('mode' => 'dropdown,dropdown_keywords,dropdown_address,multi_dropdown'),
				),
				array(
						"type" => "string",
						"name" => "placeholders",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"dependency" => array('mode' => 'hierarhical_dropdown'),
				),
				array(
						"type" => "string",
						"name" => "try_to_search_text",
						"title" => esc_html__("Try to search text", "wcsearch"),
						"value" => esc_html__("Try to search", "wcsearch"),
						"dependency" => array('mode' => 'dropdown_address,dropdown_keywords'),
				),
				array(
						"type" => "string",
						"name" => "address_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "Los Angeles, US Capitol, Central Park NY",
						"dependency" => array('mode' => 'dropdown_address'),
				),
				array(
						"type" => "string",
						"name" => "keywords_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "sport,business,event",
						"dependency" => array('mode' => 'dropdown_keywords'),
				),
				array(
						"type" => "select",
						"name" => "do_links",
						"title" => esc_html__("Links to products in autocomplete suggestion", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array('mode' => 'dropdown_keywords'),
				),
				array(
						"type" => "select",
						"name" => "do_links_blank",
						"title" => esc_html__("How to open links", "wcsearch"),
						"options" => array(
								"blank" => esc_html__("Open in new window", "wcsearch"),
								"self" => esc_html__("Open in same window", "wcsearch"),
						),
						"value" => "blank",
						"dependency" => array('mode' => 'dropdown_keywords', 'do_links' => '1'),
				),
				array(
						"type" => "select",
						"name" => "relation",
						"title" => esc_html__("Relation", "wcsearch"),
						"options" => array(
								"OR" => "OR",
								"AND" => "AND",
						),
						"value" => "OR",
						"dependency" => array('mode' => 'multi_dropdown,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "depth",
						"title" => esc_html__("Max depth level", "wcsearch"),
						"options" => array(
								"1" => "1",
								"2" => "2",
								"3" => "3",
								"4" => "4",
						),
						"value" => 1,
						"dependency" => array('mode' => 'dropdown,dropdown_address,dropdown_keywords,multi_dropdown,radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "open_on_click",
						"title" => esc_html__("Open on click", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => 1,
						"dependency" => array('mode' => 'dropdown,dropdown_address,dropdown_keywords'),
				),
				array(
						"type" => "select",
						"name" => "columns",
						"title" => esc_html__("Columns", "wcsearch"),
						"options" => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
						),
						"value" => 2,
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "string",
						"name" => "height_limit",
						"title" => esc_html__("Cut long-list items by height (in pixels)", "wcsearch"),
						"value" => 280,
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "how_to_limit",
						"title" => esc_html__("How to cut long-list items", "wcsearch"),
						"options" => array(
								"show_more_less" => esc_html__("Show all/hide and scroll", "wcsearch"),
								"use_scroll" => esc_html__("Use only scroll", "wcsearch"),
						),
						"value" => "show_more_less",
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "string",
						"name" => "text_open",
						"title" => esc_html__("Text to open new items", "wcsearch"),
						"value" => esc_html__("show all"),
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons', 'how_to_limit' => 'show_more_less'),
				),
				array(
						"type" => "string",
						"name" => "text_close",
						"title" => esc_html__("Text to hide", "wcsearch"),
						"value" => esc_html__("hide"),
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons', 'how_to_limit' => 'show_more_less'),
				),
				array(
						"type" => "select",
						"name" => "use_pointer",
						"title" => esc_html__("Use floating pointer", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "orderby",
						"title" => esc_html__("Order terms", "wcsearch"),
						"options" => array(
								"menu_order" => esc_html__("By default", "wcsearch"),
								"name" => esc_html__("By name", "wcsearch"),
								"count" => esc_html__("By count", "wcsearch"),
						),
						"value" => "menu_order",
						"dependency" => array('mode' => 'dropdown,dropdown_address,dropdown_keywords,hierarhical_dropdown,multi_dropdown,radios,radios_buttons,checkboxes,checkboxes_buttons,range,single_slider'),
				),
				array(
						"type" => "select",
						"name" => "order",
						"title" => esc_html__("Order direction", "wcsearch"),
						"options" => array(
								"ASC" => esc_html__("ASC", "wcsearch"),
								"DESC" => esc_html__("DESC", "wcsearch"),
						),
						"value" => "ASC",
						"dependency" => array(
								'mode' => 'dropdown,dropdown_address,dropdown_keywords,hierarhical_dropdown,multi_dropdown,radios,radios_buttons,checkboxes,checkboxes_buttons,range,single_slider',
								'orderby' => 'name,count',
						),
				),
				array(
						"type" => "select",
						"name" => "hide_empty",
						"title" => esc_html__("Hide empty", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array('mode' => 'dropdown,dropdown_address,dropdown_keywords,hierarhical_dropdown,multi_dropdown,radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "exact_terms",
						"name" => "is_exact_terms",
						"title" => esc_html__("Set specific terms", "wcsearch"),
						"description" => esc_html__("Show all terms or select specific (dependent on max depth level)", "wcsearch"),
						"options" => array(
								0 => esc_html__("All terms", "wcsearch"),
								1 => esc_html__("Specific terms", "wcsearch"),
						),
				),
				array(
						"type" => "dependency",
						"name" => "dependency_tax",
						"title" => esc_html__("Dependency", "wcsearch"),
						"description" => esc_html__("The field will be dependent from selected tax", "wcsearch"),
						"options" => array(
								0 => esc_html__("No dependency", "wcsearch"),
						),
				),
				array(
						"type" => "select",
						"name" => "dependency_visibility",
						"title" => esc_html__("Dependency visibility", "wcsearch"),
						"options" => array(
								"0" => esc_html__("Hidden", "wcsearch"),
								"1" => esc_html__("Shaded", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array("dependency_tax" => ""),
				),
				array(
						"type" => "hidden",
						"name" => "terms_options",
						"value" => "",
				),
		),
		"select" => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Title", "wcsearch"),
						"value" => esc_html__("Title", "wcsearch"),
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "select",
						"name" => "mode",
						"title" => esc_html__("Search mode", "wcsearch"),
						"options" => array(
								"dropdown" => esc_html__("Single dropdown", "wcsearch"),
								"dropdown_keywords" => esc_html__("Single dropdown + keywords", "wcsearch"),
								"multi_dropdown" => esc_html__("Multi dropdown", "wcsearch"),
								"radios" => esc_html__("Radios", "wcsearch"),
								"radios_buttons" => esc_html__("Radio buttons", "wcsearch"),
								"checkboxes" => esc_html__("Checkboxes", "wcsearch"),
								"checkboxes_buttons" => esc_html__("Checkboxes buttons", "wcsearch"),
								"range" => esc_html__("Range slider", "wcsearch"),
								"single_slider" => esc_html__("Single slider", "wcsearch"),
						),
						"value" => "dropdown",
				),
				array(
						"type" => "string",
						"name" => "try_to_search_text",
						"title" => esc_html__("Try to search text", "wcsearch"),
						"value" => esc_html__("Try to search", "wcsearch"),
				),
				array(
						"type" => "string",
						"name" => "placeholder",
						"title" => esc_html__("Placeholder", "wcsearch"),
						"value" => "",
						"dependency" => array('mode' => 'dropdown,dropdown_keywords,dropdown_address,hierarhical_dropdown,multi_dropdown'),
				),
				array(
						"type" => "string",
						"name" => "address_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "Los Angeles, US Capitol, Central Park NY",
						"dependency" => array('mode' => 'dropdown_address'),
				),
				array(
						"type" => "string",
						"name" => "keywords_suggestions",
						"title" => esc_html__("Try to search", "wcsearch"),
						"description" => esc_html__("Comma-separated list of suggestions to try to search", "wcsearch"),
						"value" => "sport,business,event",
						"dependency" => array('mode' => 'dropdown_keywords'),
				),
				array(
						"type" => "select",
						"name" => "relation",
						"title" => esc_html__("Relation", "wcsearch"),
						"options" => array(
								"OR" => "OR",
								"AND" => "AND",
						),
						"value" => "OR",
						"dependency" => array('mode' => 'multi_dropdown,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "open_on_click",
						"title" => esc_html__("Open on click", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => 1,
						"dependency" => array('mode' => 'dropdown,dropdown_address,dropdown_keywords'),
				),
				array(
						"type" => "select",
						"name" => "columns",
						"title" => esc_html__("Columns", "wcsearch"),
						"options" => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
						),
						"value" => 2,
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "string",
						"name" => "height_limit",
						"title" => esc_html__("Cut long-list items by height (in pixels)", "wcsearch"),
						"value" => 280,
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "how_to_limit",
						"title" => esc_html__("How to cut long-list items", "wcsearch"),
						"options" => array(
								"show_more_less" => esc_html__("Show all/hide and scroll", "wcsearch"),
								"use_scroll" => esc_html__("Use only scroll", "wcsearch"),
						),
						"value" => "show_more_less",
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "string",
						"name" => "text_open",
						"title" => esc_html__("Text to open new items", "wcsearch"),
						"value" => esc_html__("show all"),
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons', 'how_to_limit' => 'show_more_less'),
				),
				array(
						"type" => "string",
						"name" => "text_close",
						"title" => esc_html__("Text to hide", "wcsearch"),
						"value" => esc_html__("hide"),
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons', 'how_to_limit' => 'show_more_less'),
				),
				array(
						"type" => "select",
						"name" => "use_pointer",
						"title" => esc_html__("Use floating pointer", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
						"dependency" => array('mode' => 'radios,radios_buttons,checkboxes,checkboxes_buttons'),
				),
				array(
						"type" => "select",
						"name" => "orderby",
						"title" => esc_html__("Order terms", "wcsearch"),
						"options" => array(
								"menu_order" => esc_html__("By default", "wcsearch"),
								"name" => esc_html__("By name", "wcsearch"),
								"count" => esc_html__("By count", "wcsearch"),
						),
						"value" => "menu_order",
						"dependency" => array('mode' => 'dropdown,dropdown_keywords,multi_dropdown,radios,radios_buttons,checkboxes,checkboxes_buttons,range,single_slider'),
				),
				array(
						"type" => "select",
						"name" => "order",
						"title" => esc_html__("Order direction", "wcsearch"),
						"options" => array(
								"ASC" => esc_html__("ASC", "wcsearch"),
								"DESC" => esc_html__("DESC", "wcsearch"),
						),
						"value" => "ASC",
						"dependency" => array(
								'mode' => 'dropdown,dropdown_keywords,multi_dropdown,radios,radios_buttons,checkboxes,checkboxes_buttons,range,single_slider',
								'orderby' => 'name,count',
						),
				),
				array(
						"type" => "select",
						"name" => "hide_empty",
						"title" => esc_html__("Hide empty", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "1",
				),
				array(
						"type" => "exact_terms",
						"name" => "is_exact_terms",
						"title" => esc_html__("Set specific terms", "wcsearch"),
						"description" => esc_html__("Show all terms or select specific (dependent on max depth level)", "wcsearch"),
						"options" => array(
								0 => esc_html__("All terms", "wcsearch"),
								1 => esc_html__("Specific terms", "wcsearch"),
						),
				),
				array(
						"type" => "dependency",
						"name" => "dependency_tax",
						"title" => esc_html__("Dependency", "wcsearch"),
						"description" => esc_html__("The field will be dependent from selected tax", "wcsearch"),
						"options" => array(
								0 => esc_html__("No dependency", "wcsearch"),
						),
				),
				array(
						"type" => "select",
						"name" => "dependency_visibility",
						"title" => esc_html__("Dependency visibility", "wcsearch"),
						"options" => array(
								"0" => esc_html__("Hidden", "wcsearch"),
								"1" => esc_html__("Shaded", "wcsearch"),
						),
						"value" => "1",
						"dependency" => array("dependency_tax" => ""),
				),
		),
		"featured" => array(
				array(
						"type" => "string",
						"name" => "label",
						"title" => esc_html__("Label text", "wcsearch"),
						"value" => esc_html__("featured"),
				),
				array(
						"type" => "select",
						"name" => "align",
						"title" => esc_html__("Align", "wcsearch"),
						"options" => array(
								"left" => esc_html__("Left", "wcsearch"),
								"center" => esc_html__("Center", "wcsearch"),
								"right" => esc_html__("Right", "wcsearch"),
						),
						"value" => "left",
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
		),
		"instock" => array(
				array(
						"type" => "string",
						"name" => "label",
						"title" => esc_html__("Label text", "wcsearch"),
						"value" => esc_html__("in stock"),
				),
				array(
						"type" => "select",
						"name" => "align",
						"title" => esc_html__("Align", "wcsearch"),
						"options" => array(
								"left" => esc_html__("Left", "wcsearch"),
								"center" => esc_html__("Center", "wcsearch"),
								"right" => esc_html__("Right", "wcsearch"),
						),
						"value" => "left",
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
		),
		"onsale" => array(
				array(
						"type" => "string",
						"name" => "label",
						"title" => esc_html__("Label text", "wcsearch"),
						"value" => esc_html__("on sale"),
				),
				array(
						"type" => "select",
						"name" => "align",
						"title" => esc_html__("Align", "wcsearch"),
						"options" => array(
								"left" => esc_html__("Left", "wcsearch"),
								"center" => esc_html__("Center", "wcsearch"),
								"right" => esc_html__("Right", "wcsearch"),
						),
						"value" => "left",
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
		),
		"ratings" => array(
				array(
						"type" => "string",
						"name" => "title",
						"title" => esc_html__("Label text", "wcsearch"),
						"value" => esc_html__("By ratings"),
				),
				array(
						"type" => "select",
						"name" => "visible_status",
						"title" => esc_html__("Visible", "wcsearch"),
						"options" => array(
								"always_opened" => esc_html__("Always opened", "wcsearch"),
								"opened" => esc_html__("Opened", "wcsearch"),
								"closed" => esc_html__("Closed", "wcsearch"),
								"always_closed" => esc_html__("Always closed", "wcsearch"),
								"more_filters" => esc_html__("In 'more filters' section", "wcsearch"),
						),
						"value" => "always_opened",
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
				array(
						"type" => "color",
						"name" => "stars_color",
						"title" => esc_html__("Stars color", "wcsearch"),
						"value" => "#FFB300",
				),
		),
		"hours" => array(
				array(
						"type" => "string",
						"name" => "label",
						"title" => esc_html__("Label text", "wcsearch"),
						"value" => esc_html__("open now"),
				),
				array(
						"type" => "select",
						"name" => "display",
						"title" => esc_html__("Display as", "wcsearch"),
						"options" => array(
								"checkbox" => esc_html__("Checkbox", "wcsearch"),
								"button" => esc_html__("Button", "wcsearch"),
						),
						"value" => "checkbox",
				),
				array(
						"type" => "select",
						"name" => "align",
						"title" => esc_html__("Align", "wcsearch"),
						"options" => array(
								"left" => esc_html__("Left", "wcsearch"),
								"center" => esc_html__("Center", "wcsearch"),
								"right" => esc_html__("Right", "wcsearch"),
						),
						"value" => "left",
						"dependency" => array("display" => "checkbox"),
				),
				array(
						"type" => "select",
						"name" => "counter",
						"title" => esc_html__("Show counter", "wcsearch"),
						"options" => array(
								"0" => esc_html__("No", "wcsearch"),
								"1" => esc_html__("Yes", "wcsearch"),
						),
						"value" => "0",
				),
		),
);


add_filter("init", "wcsearch_set_default_model_settings", 1);
add_filter("admin_init", "wcsearch_set_default_model_settings", 1);
function wcsearch_set_default_model_settings() {
	global $wcsearch_default_model_settings;
	
	$wcsearch_default_model_settings = array(
			'model' => array(
					'placeholders' => array(
							array(
									"columns" => 1,
									"rows" => 1,
									"input" => "",
							),
					),
			),
			'columns_num' => 1,
			'bg_color' => "",
			'bg_transparency' => 100,
			'text_color' => "#666666",
			'elements_color' => "#428BCA",
			'elements_color_secondary' => "#275379",
			'use_overlay' => 0,
			'on_shop_page' => 0,
			'auto_submit' => 0,
			'use_border' => 1,
			'scroll_to' => '', // products
			'sticky_scroll' => 0,
			'sticky_scroll_toppadding' => 0,
			'use_ajax' => 1,
			'target_url' => '',
			'used_by' => wcsearch_get_default_used_by(), // wc, w2dc, w2gm, w2mb
		
	);
}

add_filter("admin_init", "wcsearch_filter_model_options");
function wcsearch_filter_model_options() {
	global $wcsearch_model_options;

	$taxes = wcsearch_get_all_taxonomies();
	$tax_names = wcsearch_get_all_taxonomies_names();

	foreach ($wcsearch_model_options AS $type=>$options) {

		// add taxonomies in dependency fields
		//
		// "categories" instead of "w2dc-category",
		// "locations" instead of "w2dc-location",
		// "tags" instead of "w2dc-tag"
		foreach ($options AS $key=>$option) {
			if ($option['type'] == 'dependency') {
				foreach ($taxes AS $tax_slug=>$tax_name) {
					$wcsearch_model_options[$type][$key]['options'][$tax_name] = $tax_names[$tax_slug];
				}
			}
		}

		// add "Single dropdown + address" option in mode
		if (wcsearch_geocode_functions()) {
			if ($type == 'tax') {
				foreach ($options AS $key=>$option) {
					if ($option['name'] == 'mode') {
						$arr = $wcsearch_model_options[$type][$key]["options"];
						
						$arr = array_slice($arr, 0, 2, true) +
						array("dropdown_address" => esc_html__("Single dropdown + address", "wcsearch")) +
						array_slice($arr, 2, count($arr)-2, true);

						$wcsearch_model_options[$type][$key]["options"] = $arr;
					}
				}
			}
		}
	}
}

class wcsearch_search_forms_manager {
	
	public function __construct() {
		add_action('add_meta_boxes', array($this, 'addSearchFormMetabox'));
		
		add_filter('manage_'.WCSEARCH_FORM_TYPE.'_posts_columns', array($this, 'add_wcsearch_table_columns'));
		add_filter('manage_'.WCSEARCH_FORM_TYPE.'_posts_custom_column', array($this, 'manage_wcsearch_table_rows'), 10, 2);
		
		add_filter('post_row_actions', array($this, 'duplicate_form_link'), 10, 2);
		add_action('admin_action_wcsearch_duplicate_form', array($this, 'duplicate_form'));
		
		add_action('wp_ajax_wcsearch_tax_dropdowns_hook', 'wcsearch_tax_dropdowns_updateterms');
		add_action('wp_ajax_nopriv_wcsearch_tax_dropdowns_hook', 'wcsearch_tax_dropdowns_updateterms');
		
		if (isset($_POST['submit']) && isset($_POST['post_type']) && $_POST['post_type'] == WCSEARCH_FORM_TYPE) {
			add_action('save_post_' . WCSEARCH_FORM_TYPE, array($this, 'saveForm'), 10, 3);
		}
	}
	
	public function duplicate_form_link($actions, $post) {
		if ($post->post_type == WCSEARCH_FORM_TYPE) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=wcsearch_duplicate_form&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="' . esc_attr__("Make duplicate", "w2dc") . '">' . esc_html__("Make duplicate", "w2dc") . '</a>';
		}
	
		return $actions;
	}
	
	public function duplicate_form() {
		global $wpdb;
	
		if (empty($_GET['post'])) {
			wp_die('No post to duplicate has been supplied!');
		}
	
		if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__))) {
			return;
		}
	
		$post_id = sanitize_text_field($_GET['post']);
		$post = get_post($post_id);
	
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
	
		if (isset($post) && $post != null) {
			$args = array(
					'comment_status' => $post->comment_status,
					'ping_status'    => $post->ping_status,
					'post_author'    => $new_post_author,
					'post_content'   => $post->post_content,
					'post_excerpt'   => $post->post_excerpt,
					'post_name'      => $post->post_name . "-duplicate",
					'post_parent'    => $post->post_parent,
					'post_password'  => $post->post_password,
					'post_status'    => 'publish',
					'post_title'     => $post->post_title . " (duplicate)",
					'post_type'      => $post->post_type,
					'to_ping'        => $post->to_ping,
					'menu_order'     => $post->menu_order
			);
			$new_post_id = wp_insert_post( $args );
				
			$post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d", $post_id));
			if (count($post_meta_infos)) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if ($meta_key == '_wp_old_slug') {
						continue;
					}
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
				
			wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
			die();
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}
	
	public function addSearchFormMetabox($post_type) {
		if ($post_type == WCSEARCH_FORM_TYPE) {
			remove_meta_box('submitdiv', WCSEARCH_FORM_TYPE, 'side');
			
			add_meta_box('wcsearch_form',
			esc_html__('Search Form', 'wcsearch'),
			array($this, 'searchFormMetabox'),
			WCSEARCH_FORM_TYPE,
			'normal',
			'high');
		}
	}
	
	public function searchFormMetabox($post) {
		global $wcsearch_default_model_settings;
	
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
		
		$model = get_post_meta($post->ID, '_model', true);
		
		$search_form_data = array();
		if (!$model) {
			// default model
			foreach ($wcsearch_default_model_settings AS $setting=>$value) {
				$search_form_data[$setting] = $value;
			}
			
			$model = $search_form_data['model'];
		} else {
			$model = json_decode($model, true);
			
			foreach ($wcsearch_default_model_settings AS $setting=>$value) {
				if (metadata_exists('post', $post->ID, '_'.$setting)) {
					$search_form_data[$setting] = get_post_meta($post->ID, '_'.$setting, true);
				} else {
					$search_form_data[$setting] = $wcsearch_default_model_settings[$setting];
				}
			}
		}
		
		if (wcsearch_getValue($_GET, 'export')) {
			$width = '100%';
			$height = '500px';
			
			echo '<textarea style="width: ' . $width . '; height: ' . $height . ';">';
			echo "{";
			$key_value_pair = array();
			foreach ($search_form_data AS $setting=>$val) {
				$key_value_pair[] = '"'.esc_attr($setting).'":"'.addslashes($val).'"';
			}
			echo implode(",", $key_value_pair);
			echo "}";
			echo '</textarea>';
		}
		
		$search_form_model = new wcsearch_search_form_model($model['placeholders'], $search_form_data['used_by']);
		
		wcsearch_renderTemplate('search_form_model.tpl.php',
			array(
				'wcsearch_model' => $model,
				'search_form_model' => $search_form_model,
				'search_form_data' => $search_form_data,
			)
		);
	}
	
	public function saveForm($post_ID, $post, $update) {
		global $wcsearch_default_model_settings;
		
		foreach ($wcsearch_default_model_settings AS $setting=>$value) {
			update_post_meta($post_ID, '_'.$setting, wcsearch_getValue($_POST, $setting));
		}
	}
	
	public function add_wcsearch_table_columns($columns) {
		global $wcsearch_instance;
	
		$wcsearch_columns['wcsearch_shortcode'] = esc_html__('Shortcode', 'wcsearch');
	
		return array_slice($columns, 0, 2, true) + $wcsearch_columns + array_slice($columns, 2, count($columns)-2, true);
	}
	
	public function manage_wcsearch_table_rows($column, $post_id) {
		switch ($column) {
			case "wcsearch_shortcode":
				echo '['.WCSEARCH_MAIN_SHORTCODE.' id=' . esc_attr($post_id) . ']';
			break;
		}
	}
}

?>