<?php

add_action('vc_before_init', 'w2rr_vc_init');

function w2rr_vc_init() {
	global $w2rr_instance;
	
	add_action('admin_head', function() {
		echo '<style type="text/css">';
		echo '.vc_element-icon.w2rr-vc-star-icon { background-image: url("'.W2RR_RESOURCES_URL.'images/star.png"); }';
		echo '</style>';
	});

	if (!function_exists('w2rr_ordering_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('reviews_ordering', 'w2rr_ordering_param');
		function w2rr_ordering_param($settings, $value) {
			$ordering = w2rr_reviewsOrderingItems();

			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			foreach ($ordering AS $ordering_item) {
				$out .= '<option value="' . $ordering_item['value'] . '" ' . selected($value, $ordering_item['value'], false) . '>' . $ordering_item['label'] . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}
	
	if (!function_exists('w2rr_tax_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('tax', 'w2rr_tax_param');
		function w2rr_tax_param($settings, $value) {
			
			$taxes = array(0 => esc_html__("- No tax -", "W2RR"));
			
			$_taxes = get_taxonomies(array(), 'objects');
			
			foreach ($_taxes AS $tax) {
				$taxes[$tax->name] = $tax->label;
			}

			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			foreach ($taxes AS $tax_name=>$tax_label) {
				$out .= '<option value="' . $tax_name . '" ' . selected($value, $tax_name, false) . '>' . $tax_label . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}
	
	if (!function_exists('w2rr_post_type_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('tax', 'w2rr_post_type_param');
		function w2rr_post_type_param($settings, $value) {
			
			$post_types = array(0 => esc_html__("- All -", "W2RR"));
		
			$_post_types = w2rr_getWorkingPostTypes();
			
			foreach ($_post_types AS $post_type) {
				if ($post_type_obj = get_post_type_object($post_type)) {
					$post_types[$post_type_obj->name] = $post_type_obj->label;
				}
			}

			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			foreach ($post_types AS $post_type_name=>$post_type_label) {
				$out .= '<option value="' . $post_type_name . '" ' . selected($value, $post_type_name, false) . '>' . $post_type_label . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}

	global $w2rr_reviews_widget_params;
	$vc_reviews_widget_args = array(
			'name'                    => esc_html__('Ratings and Reviews', 'W2RR'),
			'description'             => esc_html__('Reviews widget', 'W2RR'),
			'base'                    => 'webrr-reviews',
			'icon'                    => 'w2rr-vc-star-icon',
			'show_settings_on_create' => true,
			'category'                => esc_html__('Ratings & Reviews Content', 'W2RR'),
			'params'                  => $w2rr_reviews_widget_params
	);
	vc_map($vc_reviews_widget_args);

}

?>