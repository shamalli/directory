<?php 

$w2rr_color_schemes = array(
		'default' => array(
				'w2rr_primary_color' => '#2393ba',
				'w2rr_stars_color' => '#FFB300',
				'w2rr_links_color' => '#2393ba',
				'w2rr_links_hover_color' => '#2a6496',
				'w2rr_button_1_color' => '#2393ba',
				'w2rr_button_2_color' => '#1f82a5',
				'w2rr_button_text_color' => '#FFFFFF',
		),
		'blue' => array(
				'w2rr_primary_color' => '#194df2',
				'w2rr_stars_color' => '#8895a2',
				'w2rr_links_color' => '#96a1ad',
				'w2rr_links_hover_color' => '#2a6496',
				'w2rr_button_1_color' => '#96a1ad',
				'w2rr_button_2_color' => '#8895a2',
				'w2rr_button_text_color' => '#FFFFFF',
		),
		'gray' => array(
				'w2rr_primary_color' => '#acc7a6',
				'w2rr_stars_color' => '#2d8ab7',
				'w2rr_links_color' => '#3299cb',
				'w2rr_links_hover_color' => '#236b8e',
				'w2rr_button_1_color' => '#3299cb',
				'w2rr_button_2_color' => '#2d8ab7',
				'w2rr_button_text_color' => '#FFFFFF',
		),
		'green' => array(
				'w2rr_primary_color' => '#6cc150',
				'w2rr_stars_color' => '#64933d',
				'w2rr_links_color' => '#5b9d30',
				'w2rr_links_hover_color' => '#64933d',
				'w2rr_button_1_color' => '#5b9d30',
				'w2rr_button_2_color' => '#64933d',
				'w2rr_button_text_color' => '#FFFFFF',
		),
		'orange' => array(
				'w2rr_primary_color' => '#ff6600',
				'w2rr_stars_color' => '#ff6600',
				'w2rr_links_color' => '#4d4d4d',
				'w2rr_links_hover_color' => '#000000',
				'w2rr_button_1_color' => '#4d4d4d',
				'w2rr_button_2_color' => '#404040',
				'w2rr_button_text_color' => '#FFFFFF',
		),
		'yellow' => array(
				'w2rr_primary_color' => '#a99d1a',
				'w2rr_stars_color' => '#868600',
				'w2rr_links_color' => '#b8b900',
				'w2rr_links_hover_color' => '#868600',
				'w2rr_button_1_color' => '#b8b900',
				'w2rr_button_2_color' => '#868600',
				'w2rr_button_text_color' => '#FFFFFF',
		),
		'red' => array(
				'w2rr_primary_color' => '#679acd',
				'w2rr_stars_color' => '#cb4862',
				'w2rr_links_color' => '#ed4e6e',
				'w2rr_links_hover_color' => '#cb4862',
				'w2rr_button_1_color' => '#ed4e6e',
				'w2rr_button_2_color' => '#cb4862',
				'w2rr_button_text_color' => '#FFFFFF',
		),
);
global $w2rr_color_schemes;

function w2rr_affect_setting_w2rr_links_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_links_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_links_color');

function w2rr_affect_setting_w2rr_links_hover_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_links_hover_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_links_hover_color');

function w2rr_affect_setting_w2rr_button_1_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_button_1_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_button_1_color');

function w2rr_affect_setting_w2rr_button_2_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_button_2_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_button_2_color');

function w2rr_affect_setting_w2rr_button_text_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_button_text_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_button_text_color');

function w2rr_affect_setting_w2rr_stars_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_stars_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_stars_color');

function w2rr_affect_setting_w2rr_primary_color($scheme) {
	global $w2rr_color_schemes;
	return $w2rr_color_schemes[$scheme]['w2rr_primary_color'];
}
W2RR_VP_Security::instance()->whitelist_function('w2rr_affect_setting_w2rr_primary_color');

function w2rr_get_dynamic_option($option_name) {
	global $w2rr_color_schemes;

	if (isset($_COOKIE['w2rr_compare_palettes']) && $_COOKIE['w2rr_compare_palettes']) {
		$scheme = $_COOKIE['w2rr_compare_palettes'];
		if (isset($w2rr_color_schemes[$scheme][$option_name]))
			return $w2rr_color_schemes[$scheme][$option_name];
		else 
			return get_option($option_name);
	} else
		return get_option($option_name);
}

?>