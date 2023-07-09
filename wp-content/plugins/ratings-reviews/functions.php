<?php 

if (!function_exists('w2rr_getValue')) {
	function w2rr_getValue($target, $key, $default = false) {
		$target = is_object($target) ? (array) $target : $target;
	
		if (is_array($target) && isset($target[$key])) {
			$value = $target[$key];
		} else {
			$value = $default;
		}
	
		$value = apply_filters('w2rr_get_value', $value, $target, $key, $default);
		return $value;
	}
}

add_filter('wp_redirect', 'w2rr_redirect_with_messages');
function w2rr_redirect_with_messages($location) {
	global $w2rr_messages;
	
	if ($w2rr_messages) {
		$messages = $w2rr_messages;
		
		$location = remove_query_arg('w2rr_messages', $location);
		
		$r_messages = array();
		foreach ($messages AS $type=>$messages_array) {
			foreach ($messages[$type] AS $key=>$message) {
				// do not take messages containing any HTML
				if ($message == strip_tags($message)) {
					$r_messages[$type][$key] = urlencode($message);
				}
			}
		}
		
		// empty array gives Too many redirects error with empty parameter & in URL
		if ($r_messages) {
			$location = add_query_arg(array('w2rr_messages' => $r_messages), $location);
		}
	}
	
	return $location;
}

if (!function_exists('w2rr_addMessage')) {
	function w2rr_addMessage($message, $type = 'updated') {
		global $w2rr_messages;
		
		if (is_array($message)) {
			foreach ($message AS $m) {
				w2rr_addMessage($m, $type);
			}
			return ;
		}
	
		if (!isset($w2rr_messages[$type]) || (isset($w2rr_messages[$type]) && !in_array($message, $w2rr_messages[$type]))) {
			$w2rr_messages[$type][] = $message;
		}
	}
}

if (!function_exists('w2rr_renderMessages')) {
	function w2rr_renderMessages($message = false, $type = false) {
		global $w2rr_messages;
	
		if (!$message) {
			$messages = array();
			
			if (!empty($_GET['w2rr_messages']) && is_array($_GET['w2rr_messages'])) {
				foreach ($_GET['w2rr_messages'] AS $type=>$messages_array) {
					foreach ($_GET['w2rr_messages'][$type] AS $message) {
						$messages[$type][] = esc_html($message);
					}
				}
			}
			
			if (isset($w2rr_messages) && is_array($w2rr_messages) && $w2rr_messages) {
				foreach ($w2rr_messages AS $type=>$messages_array) {
					foreach ($w2rr_messages[$type] AS $message) {
						$messages[$type][] = $message;
					}
				}
			}
		} else {
			$messages[$type][] = $message;
		}
		
		$messages = w2rr_superUnique($messages);
	
		foreach ($messages AS $type=>$messages_array) {
			$message_class = (is_admin()) ? $type : "w2rr-" . $type;

			echo '<div class="' . $message_class . '">';
			foreach ($messages_array AS $message) {
				echo '<p>' . trim(preg_replace("/<p>(.*?)<\/p>/", "$1", $message)) . '</p>';
			}
			echo '</div>';
		}
	}
	function w2rr_superUnique($array) {
		$result = array_map("unserialize", array_unique(array_map("serialize", $array)));
		foreach ($result as $key => $value)
			if (is_array($value))
				$result[$key] = w2rr_superUnique($value);
		return $result;
	}
}

/**
 * Workaround the last day of month quirk in PHP's strtotime function.
 *
 * Adding +1 month to the last day of the month can yield unexpected results with strtotime().
 * For example:
 * - 30 Jan 2013 + 1 month = 3rd March 2013
 * - 28 Feb 2013 + 1 month = 28th March 2013
 *
 * What humans usually want is for the date to continue on the last day of the month.
 *
 * @param int $from_timestamp A Unix timestamp to add the months too.
 * @param int $months_to_add The number of months to add to the timestamp.
 */
function w2rr_addMonths($from_timestamp, $months_to_add) {
	$first_day_of_month = date('Y-m', $from_timestamp) . '-1';
	$days_in_next_month = date('t', strtotime("+ {$months_to_add} month", strtotime($first_day_of_month)));
	
	// Payment is on the last day of the month OR number of days in next billing month is less than the the day of this month (i.e. current billing date is 30th January, next billing date can't be 30th February)
	if (date('d m Y', $from_timestamp) === date('t m Y', $from_timestamp) || date('d', $from_timestamp) > $days_in_next_month) {
		for ($i = 1; $i <= $months_to_add; $i++) {
			$next_month = strtotime('+3 days', $from_timestamp); // Add 3 days to make sure we get to the next month, even when it's the 29th day of a month with 31 days
			$next_timestamp = $from_timestamp = strtotime(date('Y-m-t H:i:s', $next_month));
		}
	} else { // Safe to just add a month
		$next_timestamp = strtotime("+ {$months_to_add} month", $from_timestamp);
	}
	
	return $next_timestamp;
}

function w2rr_isResource($resource) {
	if (is_file(get_stylesheet_directory() . '/w2rr-plugin/resources/' . $resource)) {
		return get_stylesheet_directory_uri() . '/w2rr-plugin/resources/' . $resource;
	} elseif (is_file(W2RR_RESOURCES_PATH . $resource)) {
		return W2RR_RESOURCES_URL . $resource;
	}
	
	return false;
}

function w2rr_isCustomResourceDir($dir) {
	if (is_dir(get_stylesheet_directory() . '/w2rr-plugin/resources/' . $dir)) {
		return get_stylesheet_directory() . '/w2rr-plugin/resources/' . $dir;
	}
	
	return false;
}

function w2rr_getCustomResourceDirURL($dir) {
	if (is_dir(get_stylesheet_directory() . '/w2rr-plugin/resources/' . $dir)) {
		return get_stylesheet_directory_uri() . '/w2rr-plugin/resources/' . $dir;
	}
	
	return false;
}

/**
 * possible variants of templates and their paths:
 * - themes/theme/w2rr-plugin/templates/template-custom.tpl.php
 * - themes/theme/w2rr-plugin/templates/template.tpl.php
 * - plugins/w2rr/templates/template-custom.tpl.php
 * - plugins/w2rr/templates/template.tpl.php
 * 
 */
function w2rr_isTemplate($template) {
	if ($template) {
		$custom_template = str_replace('.tpl.php', '', $template) . '-custom.tpl.php';
		$templates = array(
				$custom_template,
				$template
		);
	
		foreach ($templates AS $template_to_check) {
			// check if it is exact path in $template
			if (is_file($template_to_check)) {
				return $template_to_check;
			} elseif (is_file(get_stylesheet_directory() . '/w2rr-plugin/templates/' . $template_to_check)) { // theme or child theme templates folder
				return get_stylesheet_directory() . '/w2rr-plugin/templates/' . $template_to_check;
			} elseif (is_file(W2RR_TEMPLATES_PATH . $template_to_check)) { // native plugin's templates folder
				return W2RR_TEMPLATES_PATH . $template_to_check;
			}
		}
	}

	return false;
}

if (!function_exists('w2rr_renderTemplate')) {
	/**
	 * @param string|array $template
	 * @param array $args
	 * @param bool $return
	 * @return string
	 */
	function w2rr_renderTemplate($template, $args = array(), $return = false) {
		global $w2rr_instance;
	
		if ($args) {
			extract($args);
		}
		
		$template = apply_filters('w2rr_render_template', $template, $args);
		
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
			$template = $template_path . $template_file;
		}
		
		$template = w2rr_isTemplate($template);

		if ($template) {
			if ($return) {
				ob_start();
			}
		
			include($template);
			
			if ($return) {
				$output = ob_get_contents();
				ob_end_clean();
				return $output;
			}
		}
	}
}

function w2rr_getTemplatePage($shortcode) {
	global $wpdb, $wp_rewrite;

	if (!($template_page = $wpdb->get_row("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE post_content LIKE '%[" . $shortcode . "]%' AND post_status = 'publish' AND post_type = 'page' LIMIT 1", ARRAY_A)))
		$template_page = array('slug' => '', 'id' => 0, 'url' => '');
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($tpage = apply_filters('wpml_object_id', $template_page['id'], 'page')) {
			$template_page['id'] = $tpage;
			$template_page['slug'] = get_post($template_page['id'])->post_name;
		} else 
			$template_page = array('slug' => '', 'id' => 0, 'url' => '');
	}

	if ($template_page['id']) {
		if ($wp_rewrite->using_permalinks())
			$template_page['url'] = get_permalink($template_page['id']);
		else
			// found that on some instances of WP "native" trailing slashes may be missing
			$template_page['url'] = add_query_arg('page_id', $template_page['id'], home_url('/'));
	}

	return $template_page;
}

function w2rr_templatePageUri($slug_array, $page_url) {
	global $w2rr_instance;
	
	if (!$page_url) {
		$page_url = $w2rr_instance->index_page_url;
	}
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_option('language_negotiation_type') == 3) {
			// remove any previous value.
			$page_url = remove_query_arg('lang', $page_url);
		}
	}

	$template_url = add_query_arg($slug_array, $page_url);

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		$template_url = $sitepress->convert_url($template_url);
	}
	
	$template_url = w2rr_add_homepage_id($template_url);

	return utf8_uri_encode($template_url);
}

function w2rr_add_homepage_id($url) {
	global $w2rr_instance, $wp_rewrite;
	
	$homepage = null;
	if (wp_doing_ajax() && isset($base_url['homepage'])) {
		if ($base_url = wp_parse_args($_REQUEST['base_url']))
			$homepage = $base_url['homepage'];
	} else {
		$homepage = get_queried_object_id();
	}
	if (!$wp_rewrite->using_permalinks() && $homepage && count($w2rr_instance->index_pages_all) > 1) {
		foreach ($w2rr_instance->index_pages_all AS $page) {
			if ($page['id'] == $homepage) {
				$url = add_query_arg('homepage', $homepage, $url);
				break;
			}
		}
	}
	return $url;
}

function w2rr_getDatePickerFormat() {
	$wp_date_format = get_option('date_format');
	return str_replace(
			array('S',  'd', 'j',  'l',  'm', 'n',  'F',  'Y'),
			array('',  'dd', 'd', 'DD', 'mm', 'm', 'MM', 'yy'),
		$wp_date_format);
}

function w2rr_getDatePickerLangFile($locale) {
	if ($locale) {
		$_locale = explode('-', str_replace('_', '-', $locale));
		$lang_code = array_shift($_locale);
		if (is_file(W2RR_RESOURCES_PATH . 'js/i18n/datepicker-'.$locale.'.js'))
			return W2RR_RESOURCES_URL . 'js/i18n/datepicker-'.$locale.'.js';
		elseif (is_file(W2RR_RESOURCES_PATH . 'js/i18n/datepicker-'.$lang_code.'.js'))
			return W2RR_RESOURCES_URL . 'js/i18n/datepicker-'.$lang_code.'.js';
	}
}

function w2rr_getDatePickerLangCode($locale) {
	if ($locale) {
		$_locale = explode('-', str_replace('_', '-', $locale));
		$lang_code = array_shift($_locale);
		if (is_file(W2RR_RESOURCES_PATH . 'js/i18n/datepicker-'.$locale.'.js'))
			return $locale;
		elseif (is_file(W2RR_RESOURCES_PATH . 'js/i18n/datepicker-'.$lang_code.'.js'))
			return $lang_code;
	}
}

function w2rr_generateRandomVal($val = null) {
	if (!$val)
		return rand(1, 10000);
	else
		return $val;
}

/**
 * Fetch the IP Address
 *
 * @return	string
 */
function w2rr_ip_address()
{
	if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	elseif (isset($_SERVER['REMOTE_ADDR']))
		$ip_address = $_SERVER['REMOTE_ADDR'];
	elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
		return false;

	if (strstr($ip_address, ',')) {
		$x = explode(',', $ip_address);
		$ip_address = trim(end($x));
	}

	$validation = new w2rr_form_validation();
	if (!$validation->valid_ip($ip_address))
		return false;

	return $ip_address;
}

function w2rr_crop_content($post_id, $limit = 35, $strip_html = true, $has_link = true, $nofollow = false, $readmore_text = false) {
	if (has_excerpt($post_id)) {
		$raw_content = apply_filters('the_excerpt', get_the_excerpt($post_id));
	} elseif (get_option('w2rr_cropped_content_as_excerpt') && get_post($post_id)->post_content !== '') {
		global $w2rr_do_listing_content;
		$w2rr_do_listing_content = true;
		$raw_content = apply_filters('the_content', get_post($post_id)->post_content);
		$w2rr_do_listing_content = false;
	} else {
		return ;
	}
	
	if (!$readmore_text) {
		$readmore_text = esc_html__('&#91;...&#93;', 'W2RR');
	}

	$raw_content = str_replace(']]>', ']]&gt;', $raw_content);
	if ($strip_html) {
		$raw_content = strip_tags($raw_content);
		$pattern = get_shortcode_regex();
		// Remove shortcodes from excerpt
		$raw_content = preg_replace_callback("/$pattern/s", 'w2rr_remove_shortcodes', $raw_content);
	}

	if (!$limit) {
		return $raw_content;
	}
	
	if ($has_link) {
		$readmore = ' <a href="'.get_permalink($post_id).'" '.(($nofollow) ? 'rel="nofollow"' : '').' class="w2rr-excerpt-link" onClick="w2rr_show_review(' . esc_attr($post_id) . ', \"' . esc_attr(get_the_title($post_id)) . '\")">'.$readmore_text.'</a>';
	} else {
		$readmore = ' ' . $readmore_text;
	}

	$content = explode(' ', $raw_content, $limit);
	if (count($content) >= $limit) {
		array_pop($content);
		$content = implode(" ", $content) . $readmore;
	} else {
		$content = $raw_content;
	}

	return $content;
}

// Remove shortcodes from excerpt
function w2rr_remove_shortcodes($m) {
	if (function_exists('su_cmpt') && su_cmpt() !== false)
	if ($m[2] == su_cmpt() . 'dropcap' || $m[2] == su_cmpt() . 'highlight' || $m[2] == su_cmpt() . 'tooltip')
		return $m[0];

	// allow [[foo]] syntax for escaping a tag
	if ($m[1] == '[' && $m[6] == ']')
		return substr($m[0], 1, -1);

	return $m[1] . $m[6];
}

function w2rr_is_anyone_in_taxonomy($tax) {
	//global $wpdb;
	//return $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->term_taxonomy . ' WHERE `taxonomy`="' . $tax . '"');
	
	return count(get_categories(array('taxonomy' => $tax, 'hide_empty' => false, 'parent' => 0, 'number' => 1)));
}

function w2rr_comments_open() {
	if (get_option('w2rr_reviews_comments')) {
		$comments_open = true;
	} else { 
		$comments_open = false;
	}
	
	$comments_open = apply_filters('w2rr_comments_open', $comments_open);
	
	return $comments_open;
}

function w2rr_comments_label($post) {
	$label =  _n('Comment', 'Comments', $post->post->comment_count, 'W2RR') . ' (' . $post->post->comment_count . ')';
	
	$label = apply_filters('w2rr_comments_label', $label, $post);
	
	return $label;
}

function w2rr_comments_reply_label($post) {
	$label =  sprintf(_n('%d reply', '%d replies', $post->post->comment_count, 'W2RR'), $post->post->comment_count);
	
	$label = apply_filters('w2rr_comments_reply_label', $label, $post);
	
	return $label;
}

function w2rr_get_fa_icons_names() {
	$icons[] = 'w2rr-fa-adjust';
	$icons[] = 'w2rr-fa-adn';
	$icons[] = 'w2rr-fa-align-center';
	$icons[] = 'w2rr-fa-align-justify';
	$icons[] = 'w2rr-fa-align-left';
	$icons[] = 'w2rr-fa-align-right';
	$icons[] = 'w2rr-fa-ambulance';
	$icons[] = 'w2rr-fa-anchor';
	$icons[] = 'w2rr-fa-android';
	$icons[] = 'w2rr-fa-angellist';
	$icons[] = 'w2rr-fa-angle-double-down';
	$icons[] = 'w2rr-fa-angle-double-left';
	$icons[] = 'w2rr-fa-angle-double-right';
	$icons[] = 'w2rr-fa-angle-double-up';
	$icons[] = 'w2rr-fa-angle-down';
	$icons[] = 'w2rr-fa-angle-left';
	$icons[] = 'w2rr-fa-angle-right';
	$icons[] = 'w2rr-fa-angle-up';
	$icons[] = 'w2rr-fa-apple';
	$icons[] = 'w2rr-fa-archive';
	$icons[] = 'w2rr-fa-area-chart';
	$icons[] = 'w2rr-fa-arrow-circle-down';
	$icons[] = 'w2rr-fa-arrow-circle-left';
	$icons[] = 'w2rr-fa-arrow-circle-o-down';
	$icons[] = 'w2rr-fa-arrow-circle-o-left';
	$icons[] = 'w2rr-fa-arrow-circle-o-right';
	$icons[] = 'w2rr-fa-arrow-circle-o-up';
	$icons[] = 'w2rr-fa-arrow-circle-right';
	$icons[] = 'w2rr-fa-arrow-circle-up';
	$icons[] = 'w2rr-fa-arrow-down';
	$icons[] = 'w2rr-fa-arrow-left';
	$icons[] = 'w2rr-fa-arrow-right';
	$icons[] = 'w2rr-fa-arrow-up';
	$icons[] = 'w2rr-fa-arrows';
	$icons[] = 'w2rr-fa-arrows-alt';
	$icons[] = 'w2rr-fa-arrows-h';
	$icons[] = 'w2rr-fa-arrows-v';
	$icons[] = 'w2rr-fa-asterisk';
	$icons[] = 'w2rr-fa-at';
	$icons[] = 'w2rr-fa-automobile';
	$icons[] = 'w2rr-fa-backward';
	$icons[] = 'w2rr-fa-ban';
	$icons[] = 'w2rr-fa-bank';
	$icons[] = 'w2rr-fa-bar-chart';
	$icons[] = 'w2rr-fa-bar-chart-o';
	$icons[] = 'w2rr-fa-barcode';
	$icons[] = 'w2rr-fa-bars';
	$icons[] = 'w2rr-fa-bed';
	$icons[] = 'w2rr-fa-beer';
	$icons[] = 'w2rr-fa-behance';
	$icons[] = 'w2rr-fa-behance-square';
	$icons[] = 'w2rr-fa-bell';
	$icons[] = 'w2rr-fa-bell-o';
	$icons[] = 'w2rr-fa-bell-slash';
	$icons[] = 'w2rr-fa-bell-slash-o';
	$icons[] = 'w2rr-fa-bicycle';
	$icons[] = 'w2rr-fa-binoculars';
	$icons[] = 'w2rr-fa-birthday-cake';
	$icons[] = 'w2rr-fa-bitbucket';
	$icons[] = 'w2rr-fa-bitbucket-square';
	$icons[] = 'w2rr-fa-bitcoin';
	$icons[] = 'w2rr-fa-bold';
	$icons[] = 'w2rr-fa-bolt';
	$icons[] = 'w2rr-fa-bomb';
	$icons[] = 'w2rr-fa-book';
	$icons[] = 'w2rr-fa-bookmark';
	$icons[] = 'w2rr-fa-bookmark-o';
	$icons[] = 'w2rr-fa-briefcase';
	$icons[] = 'w2rr-fa-btc';
	$icons[] = 'w2rr-fa-bug';
	$icons[] = 'w2rr-fa-building';
	$icons[] = 'w2rr-fa-building-o';
	$icons[] = 'w2rr-fa-bullhorn';
	$icons[] = 'w2rr-fa-bullseye';
	$icons[] = 'w2rr-fa-bus';
	$icons[] = 'w2rr-fa-buysellads';
	$icons[] = 'w2rr-fa-cab';
	$icons[] = 'w2rr-fa-calculator';
	$icons[] = 'w2rr-fa-calendar';
	$icons[] = 'w2rr-fa-calendar-o';
	$icons[] = 'w2rr-fa-camera';
	$icons[] = 'w2rr-fa-camera-retro';
	$icons[] = 'w2rr-fa-car';
	$icons[] = 'w2rr-fa-caret-down';
	$icons[] = 'w2rr-fa-caret-left';
	$icons[] = 'w2rr-fa-caret-right';
	$icons[] = 'w2rr-fa-caret-square-o-down';
	$icons[] = 'w2rr-fa-caret-square-o-left';
	$icons[] = 'w2rr-fa-caret-square-o-right';
	$icons[] = 'w2rr-fa-caret-square-o-up';
	$icons[] = 'w2rr-fa-caret-up';
	$icons[] = 'w2rr-fa-cart-arrow-down';
	$icons[] = 'w2rr-fa-cart-plus';
	$icons[] = 'w2rr-fa-cc';
	$icons[] = 'w2rr-fa-cc-amex';
	$icons[] = 'w2rr-fa-cc-discover';
	$icons[] = 'w2rr-fa-cc-mastercard';
	$icons[] = 'w2rr-fa-cc-paypal';
	$icons[] = 'w2rr-fa-cc-stripe';
	$icons[] = 'w2rr-fa-cc-visa';
	$icons[] = 'w2rr-fa-certificate';
	$icons[] = 'w2rr-fa-chain';
	$icons[] = 'w2rr-fa-chain-broken';
	$icons[] = 'w2rr-fa-check';
	$icons[] = 'w2rr-fa-check-circle';
	$icons[] = 'w2rr-fa-check-circle-o';
	$icons[] = 'w2rr-fa-check-square';
	$icons[] = 'w2rr-fa-check-square-o';
	$icons[] = 'w2rr-fa-chevron-circle-down';
	$icons[] = 'w2rr-fa-chevron-circle-left';
	$icons[] = 'w2rr-fa-chevron-circle-right';
	$icons[] = 'w2rr-fa-chevron-circle-up';
	$icons[] = 'w2rr-fa-chevron-down';
	$icons[] = 'w2rr-fa-chevron-left';
	$icons[] = 'w2rr-fa-chevron-right';
	$icons[] = 'w2rr-fa-chevron-up';
	$icons[] = 'w2rr-fa-child';
	$icons[] = 'w2rr-fa-circle';
	$icons[] = 'w2rr-fa-circle-o';
	$icons[] = 'w2rr-fa-circle-o-notch';
	$icons[] = 'w2rr-fa-circle-thin';
	$icons[] = 'w2rr-fa-clipboard';
	$icons[] = 'w2rr-fa-clock-o';
	$icons[] = 'w2rr-fa-close';
	$icons[] = 'w2rr-fa-cloud';
	$icons[] = 'w2rr-fa-cloud-download';
	$icons[] = 'w2rr-fa-cloud-upload';
	$icons[] = 'w2rr-fa-cny';
	$icons[] = 'w2rr-fa-code';
	$icons[] = 'w2rr-fa-code-fork';
	$icons[] = 'w2rr-fa-codepen';
	$icons[] = 'w2rr-fa-coffee';
	$icons[] = 'w2rr-fa-cog';
	$icons[] = 'w2rr-fa-cogs';
	$icons[] = 'w2rr-fa-columns';
	$icons[] = 'w2rr-fa-comment';
	$icons[] = 'w2rr-fa-comment-o';
	$icons[] = 'w2rr-fa-comments';
	$icons[] = 'w2rr-fa-comments-o';
	$icons[] = 'w2rr-fa-compass';
	$icons[] = 'w2rr-fa-compress';
	$icons[] = 'w2rr-fa-connectdevelop';
	$icons[] = 'w2rr-fa-copy';
	$icons[] = 'w2rr-fa-copyright';
	$icons[] = 'w2rr-fa-credit-card';
	$icons[] = 'w2rr-fa-crop';
	$icons[] = 'w2rr-fa-crosshairs';
	$icons[] = 'w2rr-fa-css3';
	$icons[] = 'w2rr-fa-cube';
	$icons[] = 'w2rr-fa-cubes';
	$icons[] = 'w2rr-fa-cut';
	$icons[] = 'w2rr-fa-cutlery';
	$icons[] = 'w2rr-fa-dashboard';
	$icons[] = 'w2rr-fa-dashcube';
	$icons[] = 'w2rr-fa-database';
	$icons[] = 'w2rr-fa-dedent';
	$icons[] = 'w2rr-fa-delicious';
	$icons[] = 'w2rr-fa-desktop';
	$icons[] = 'w2rr-fa-deviantart';
	$icons[] = 'w2rr-fa-diamond';
	$icons[] = 'w2rr-fa-digg';
	$icons[] = 'w2rr-fa-dollar';
	$icons[] = 'w2rr-fa-dot-circle-o';
	$icons[] = 'w2rr-fa-download';
	$icons[] = 'w2rr-fa-dribbble';
	$icons[] = 'w2rr-fa-dropbox';
	$icons[] = 'w2rr-fa-drupal';
	$icons[] = 'w2rr-fa-edit';
	$icons[] = 'w2rr-fa-eject';
	$icons[] = 'w2rr-fa-ellipsis-h';
	$icons[] = 'w2rr-fa-ellipsis-v';
	$icons[] = 'w2rr-fa-empire';
	$icons[] = 'w2rr-fa-envelope';
	$icons[] = 'w2rr-fa-envelope-o';
	$icons[] = 'w2rr-fa-envelope-square';
	$icons[] = 'w2rr-fa-eraser';
	$icons[] = 'w2rr-fa-eur';
	$icons[] = 'w2rr-fa-euro';
	$icons[] = 'w2rr-fa-exchange';
	$icons[] = 'w2rr-fa-exclamation';
	$icons[] = 'w2rr-fa-exclamation-circle';
	$icons[] = 'w2rr-fa-exclamation-triangle';
	$icons[] = 'w2rr-fa-expand';
	$icons[] = 'w2rr-fa-external-link';
	$icons[] = 'w2rr-fa-external-link-square';
	$icons[] = 'w2rr-fa-eye';
	$icons[] = 'w2rr-fa-eye-slash';
	$icons[] = 'w2rr-fa-eyedropper';
	$icons[] = 'w2rr-fa-facebook';
	$icons[] = 'w2rr-fa-facebook-f';
	$icons[] = 'w2rr-fa-facebook-official';
	$icons[] = 'w2rr-fa-facebook-square';
	$icons[] = 'w2rr-fa-fast-backward';
	$icons[] = 'w2rr-fa-fast-forward';
	$icons[] = 'w2rr-fa-fax';
	$icons[] = 'w2rr-fa-female';
	$icons[] = 'w2rr-fa-fighter-jet';
	$icons[] = 'w2rr-fa-file';
	$icons[] = 'w2rr-fa-file-archive-o';
	$icons[] = 'w2rr-fa-file-audio-o';
	$icons[] = 'w2rr-fa-file-code-o';
	$icons[] = 'w2rr-fa-file-excel-o';
	$icons[] = 'w2rr-fa-file-image-o';
	$icons[] = 'w2rr-fa-file-movie-o';
	$icons[] = 'w2rr-fa-file-o';
	$icons[] = 'w2rr-fa-file-pdf-o';
	$icons[] = 'w2rr-fa-file-photo-o';
	$icons[] = 'w2rr-fa-file-picture-o';
	$icons[] = 'w2rr-fa-file-powerpoint-o';
	$icons[] = 'w2rr-fa-file-sound-o';
	$icons[] = 'w2rr-fa-file-text';
	$icons[] = 'w2rr-fa-file-text-o';
	$icons[] = 'w2rr-fa-file-video-o';
	$icons[] = 'w2rr-fa-file-word-o';
	$icons[] = 'w2rr-fa-file-zip-o';
	$icons[] = 'w2rr-fa-files-o';
	$icons[] = 'w2rr-fa-film';
	$icons[] = 'w2rr-fa-filter';
	$icons[] = 'w2rr-fa-fire';
	$icons[] = 'w2rr-fa-fire-extinguisher';
	$icons[] = 'w2rr-fa-flag';
	$icons[] = 'w2rr-fa-flag-checkered';
	$icons[] = 'w2rr-fa-flag-o';
	$icons[] = 'w2rr-fa-flash';
	$icons[] = 'w2rr-fa-flask';
	$icons[] = 'w2rr-fa-flickr';
	$icons[] = 'w2rr-fa-floppy-o';
	$icons[] = 'w2rr-fa-folder';
	$icons[] = 'w2rr-fa-folder-o';
	$icons[] = 'w2rr-fa-folder-open';
	$icons[] = 'w2rr-fa-folder-open-o';
	$icons[] = 'w2rr-fa-font';
	$icons[] = 'w2rr-fa-forumbee';
	$icons[] = 'w2rr-fa-forward';
	$icons[] = 'w2rr-fa-foursquare';
	$icons[] = 'w2rr-fa-frown-o';
	$icons[] = 'w2rr-fa-futbol-o';
	$icons[] = 'w2rr-fa-gamepad';
	$icons[] = 'w2rr-fa-gavel';
	$icons[] = 'w2rr-fa-gbp';
	$icons[] = 'w2rr-fa-ge';
	$icons[] = 'w2rr-fa-gear';
	$icons[] = 'w2rr-fa-gears';
	$icons[] = 'w2rr-fa-genderless';
	$icons[] = 'w2rr-fa-gift';
	$icons[] = 'w2rr-fa-git';
	$icons[] = 'w2rr-fa-git-square';
	$icons[] = 'w2rr-fa-github';
	$icons[] = 'w2rr-fa-github-alt';
	$icons[] = 'w2rr-fa-github-square';
	$icons[] = 'w2rr-fa-gittip';
	$icons[] = 'w2rr-fa-glass';
	$icons[] = 'w2rr-fa-globe';
	$icons[] = 'w2rr-fa-google';
	$icons[] = 'w2rr-fa-google-plus';
	$icons[] = 'w2rr-fa-google-plus-square';
	$icons[] = 'w2rr-fa-google-wallet';
	$icons[] = 'w2rr-fa-graduation-cap';
	$icons[] = 'w2rr-fa-gratipay';
	$icons[] = 'w2rr-fa-group';
	$icons[] = 'w2rr-fa-h-square';
	$icons[] = 'w2rr-fa-hacker-news';
	$icons[] = 'w2rr-fa-hand-o-down';
	$icons[] = 'w2rr-fa-hand-o-left';
	$icons[] = 'w2rr-fa-hand-o-right';
	$icons[] = 'w2rr-fa-hand-o-up';
	$icons[] = 'w2rr-fa-hdd-o';
	$icons[] = 'w2rr-fa-header';
	$icons[] = 'w2rr-fa-headphones';
	$icons[] = 'w2rr-fa-heart';
	$icons[] = 'w2rr-fa-heart-o';
	$icons[] = 'w2rr-fa-heartbeat';
	$icons[] = 'w2rr-fa-history';
	$icons[] = 'w2rr-fa-home';
	$icons[] = 'w2rr-fa-hospital-o';
	$icons[] = 'w2rr-fa-hotel';
	$icons[] = 'w2rr-fa-html5';
	$icons[] = 'w2rr-fa-ils';
	$icons[] = 'w2rr-fa-image';
	$icons[] = 'w2rr-fa-inbox';
	$icons[] = 'w2rr-fa-indent';
	$icons[] = 'w2rr-fa-info';
	$icons[] = 'w2rr-fa-info-circle';
	$icons[] = 'w2rr-fa-inr';
	$icons[] = 'w2rr-fa-instagram';
	$icons[] = 'w2rr-fa-institution';
	$icons[] = 'w2rr-fa-ioxhost';
	$icons[] = 'w2rr-fa-italic';
	$icons[] = 'w2rr-fa-joomla';
	$icons[] = 'w2rr-fa-jpy';
	$icons[] = 'w2rr-fa-jsfiddle';
	$icons[] = 'w2rr-fa-key';
	$icons[] = 'w2rr-fa-keyboard-o';
	$icons[] = 'w2rr-fa-krw';
	$icons[] = 'w2rr-fa-language';
	$icons[] = 'w2rr-fa-laptop';
	$icons[] = 'w2rr-fa-lastfm';
	$icons[] = 'w2rr-fa-lastfm-square';
	$icons[] = 'w2rr-fa-leaf';
	$icons[] = 'w2rr-fa-leanpub';
	$icons[] = 'w2rr-fa-legal';
	$icons[] = 'w2rr-fa-lemon-o';
	$icons[] = 'w2rr-fa-level-down';
	$icons[] = 'w2rr-fa-level-up';
	$icons[] = 'w2rr-fa-life-bouy';
	$icons[] = 'w2rr-fa-life-ring';
	$icons[] = 'w2rr-fa-life-saver';
	$icons[] = 'w2rr-fa-lightbulb-o';
	$icons[] = 'w2rr-fa-line-chart';
	$icons[] = 'w2rr-fa-link';
	$icons[] = 'w2rr-fa-linkedin';
	$icons[] = 'w2rr-fa-linkedin-square';
	$icons[] = 'w2rr-fa-linux';
	$icons[] = 'w2rr-fa-list';
	$icons[] = 'w2rr-fa-list-alt';
	$icons[] = 'w2rr-fa-list-ol';
	$icons[] = 'w2rr-fa-list-ul';
	$icons[] = 'w2rr-fa-location-arrow';
	$icons[] = 'w2rr-fa-lock';
	$icons[] = 'w2rr-fa-long-arrow-down';
	$icons[] = 'w2rr-fa-long-arrow-left';
	$icons[] = 'w2rr-fa-long-arrow-right';
	$icons[] = 'w2rr-fa-long-arrow-up';
	$icons[] = 'w2rr-fa-magic';
	$icons[] = 'w2rr-fa-magnet';
	$icons[] = 'w2rr-fa-mail-forward';
	$icons[] = 'w2rr-fa-mail-reply';
	$icons[] = 'w2rr-fa-mail-reply-all';
	$icons[] = 'w2rr-fa-male';
	$icons[] = 'w2rr-fa-map-marker';
	$icons[] = 'w2rr-fa-mars';
	$icons[] = 'w2rr-fa-mars-double';
	$icons[] = 'w2rr-fa-mars-stroke';
	$icons[] = 'w2rr-fa-mars-stroke-h';
	$icons[] = 'w2rr-fa-mars-stroke-v';
	$icons[] = 'w2rr-fa-maxcdn';
	$icons[] = 'w2rr-fa-meanpath';
	$icons[] = 'w2rr-fa-medium';
	$icons[] = 'w2rr-fa-medkit';
	$icons[] = 'w2rr-fa-meh-o';
	$icons[] = 'w2rr-fa-mercury';
	$icons[] = 'w2rr-fa-microphone';
	$icons[] = 'w2rr-fa-microphone-slash';
	$icons[] = 'w2rr-fa-minus';
	$icons[] = 'w2rr-fa-minus-circle';
	$icons[] = 'w2rr-fa-minus-square';
	$icons[] = 'w2rr-fa-minus-square-o';
	$icons[] = 'w2rr-fa-mobile';
	$icons[] = 'w2rr-fa-mobile-phone';
	$icons[] = 'w2rr-fa-money';
	$icons[] = 'w2rr-fa-moon-o';
	$icons[] = 'w2rr-fa-mortar-board';
	$icons[] = 'w2rr-fa-motorcycle';
	$icons[] = 'w2rr-fa-music';
	$icons[] = 'w2rr-fa-navicon';
	$icons[] = 'w2rr-fa-neuter';
	$icons[] = 'w2rr-fa-newspaper-o';
	$icons[] = 'w2rr-fa-openid';
	$icons[] = 'w2rr-fa-outdent';
	$icons[] = 'w2rr-fa-pagelines';
	$icons[] = 'w2rr-fa-paint-brush';
	$icons[] = 'w2rr-fa-paper-plane';
	$icons[] = 'w2rr-fa-paper-plane-o';
	$icons[] = 'w2rr-fa-paperclip';
	$icons[] = 'w2rr-fa-paragraph';
	$icons[] = 'w2rr-fa-paste';
	$icons[] = 'w2rr-fa-pause';
	$icons[] = 'w2rr-fa-paw';
	$icons[] = 'w2rr-fa-paypal';
	$icons[] = 'w2rr-fa-pencil';
	$icons[] = 'w2rr-fa-pencil-square';
	$icons[] = 'w2rr-fa-pencil-square-o';
	$icons[] = 'w2rr-fa-phone';
	$icons[] = 'w2rr-fa-phone-square';
	$icons[] = 'w2rr-fa-photo';
	$icons[] = 'w2rr-fa-picture-o';
	$icons[] = 'w2rr-fa-pie-chart';
	$icons[] = 'w2rr-fa-pied-piper';
	$icons[] = 'w2rr-fa-pied-piper-alt';
	$icons[] = 'w2rr-fa-pinterest';
	$icons[] = 'w2rr-fa-pinterest-p';
	$icons[] = 'w2rr-fa-pinterest-square';
	$icons[] = 'w2rr-fa-plane';
	$icons[] = 'w2rr-fa-play';
	$icons[] = 'w2rr-fa-play-circle';
	$icons[] = 'w2rr-fa-play-circle-o';
	$icons[] = 'w2rr-fa-plug';
	$icons[] = 'w2rr-fa-plus';
	$icons[] = 'w2rr-fa-plus-circle';
	$icons[] = 'w2rr-fa-plus-square';
	$icons[] = 'w2rr-fa-plus-square-o';
	$icons[] = 'w2rr-fa-power-off';
	$icons[] = 'w2rr-fa-print';
	$icons[] = 'w2rr-fa-puzzle-piece';
	$icons[] = 'w2rr-fa-qq';
	$icons[] = 'w2rr-fa-qrcode';
	$icons[] = 'w2rr-fa-question';
	$icons[] = 'w2rr-fa-question-circle';
	$icons[] = 'w2rr-fa-quote-left';
	$icons[] = 'w2rr-fa-quote-right';
	$icons[] = 'w2rr-fa-ra';
	$icons[] = 'w2rr-fa-random';
	$icons[] = 'w2rr-fa-rebel';
	$icons[] = 'w2rr-fa-recycle';
	$icons[] = 'w2rr-fa-reddit';
	$icons[] = 'w2rr-fa-reddit-square';
	$icons[] = 'w2rr-fa-refresh';
	$icons[] = 'w2rr-fa-remove';
	$icons[] = 'w2rr-fa-renren';
	$icons[] = 'w2rr-fa-reorder';
	$icons[] = 'w2rr-fa-repeat';
	$icons[] = 'w2rr-fa-reply';
	$icons[] = 'w2rr-fa-reply-all';
	$icons[] = 'w2rr-fa-retweet';
	$icons[] = 'w2rr-fa-rmb';
	$icons[] = 'w2rr-fa-road';
	$icons[] = 'w2rr-fa-rocket';
	$icons[] = 'w2rr-fa-rotate-left';
	$icons[] = 'w2rr-fa-rotate-right';
	$icons[] = 'w2rr-fa-rouble';
	$icons[] = 'w2rr-fa-rss';
	$icons[] = 'w2rr-fa-rss-square';
	$icons[] = 'w2rr-fa-rub';
	$icons[] = 'w2rr-fa-ruble';
	$icons[] = 'w2rr-fa-rupee';
	$icons[] = 'w2rr-fa-save';
	$icons[] = 'w2rr-fa-scissors';
	$icons[] = 'w2rr-fa-search';
	$icons[] = 'w2rr-fa-search-minus';
	$icons[] = 'w2rr-fa-search-plus';
	$icons[] = 'w2rr-fa-sellsy';
	$icons[] = 'w2rr-fa-send';
	$icons[] = 'w2rr-fa-send-o';
	$icons[] = 'w2rr-fa-server';
	$icons[] = 'w2rr-fa-share';
	$icons[] = 'w2rr-fa-share-alt';
	$icons[] = 'w2rr-fa-share-alt-square';
	$icons[] = 'w2rr-fa-share-square';
	$icons[] = 'w2rr-fa-share-square-o';
	$icons[] = 'w2rr-fa-shekel';
	$icons[] = 'w2rr-fa-sheqel';
	$icons[] = 'w2rr-fa-shield';
	$icons[] = 'w2rr-fa-ship';
	$icons[] = 'w2rr-fa-shirtsinbulk';
	$icons[] = 'w2rr-fa-shopping-cart';
	$icons[] = 'w2rr-fa-sign-out';
	$icons[] = 'w2rr-fa-signal';
	$icons[] = 'w2rr-fa-simplybuilt';
	$icons[] = 'w2rr-fa-sitemap';
	$icons[] = 'w2rr-fa-skyatlas';
	$icons[] = 'w2rr-fa-skype';
	$icons[] = 'w2rr-fa-slack';
	$icons[] = 'w2rr-fa-sliders';
	$icons[] = 'w2rr-fa-slideshare';
	$icons[] = 'w2rr-fa-smile-o';
	$icons[] = 'w2rr-fa-soccer-ball-o';
	$icons[] = 'w2rr-fa-sort';
	$icons[] = 'w2rr-fa-sort-alpha-asc';
	$icons[] = 'w2rr-fa-sort-alpha-desc';
	$icons[] = 'w2rr-fa-sort-amount-asc';
	$icons[] = 'w2rr-fa-sort-amount-desc';
	$icons[] = 'w2rr-fa-sort-asc';
	$icons[] = 'w2rr-fa-sort-desc';
	$icons[] = 'w2rr-fa-sort-down';
	$icons[] = 'w2rr-fa-sort-numeric-asc';
	$icons[] = 'w2rr-fa-sort-numeric-desc';
	$icons[] = 'w2rr-fa-sort-up';
	$icons[] = 'w2rr-fa-soundcloud';
	$icons[] = 'w2rr-fa-space-shuttle';
	$icons[] = 'w2rr-fa-spinner';
	$icons[] = 'w2rr-fa-spoon';
	$icons[] = 'w2rr-fa-spotify';
	$icons[] = 'w2rr-fa-square';
	$icons[] = 'w2rr-fa-square-o';
	$icons[] = 'w2rr-fa-stack-exchange';
	$icons[] = 'w2rr-fa-stack-overflow';
	$icons[] = 'w2rr-fa-star';
	$icons[] = 'w2rr-fa-star-half';
	$icons[] = 'w2rr-fa-star-half-empty';
	$icons[] = 'w2rr-fa-star-half-full';
	$icons[] = 'w2rr-fa-star-half-o';
	$icons[] = 'w2rr-fa-star-o';
	$icons[] = 'w2rr-fa-steam';
	$icons[] = 'w2rr-fa-steam-square';
	$icons[] = 'w2rr-fa-step-backward';
	$icons[] = 'w2rr-fa-step-forward';
	$icons[] = 'w2rr-fa-stethoscope';
	$icons[] = 'w2rr-fa-stop';
	$icons[] = 'w2rr-fa-street-view';
	$icons[] = 'w2rr-fa-strikethrough';
	$icons[] = 'w2rr-fa-stumbleupon';
	$icons[] = 'w2rr-fa-stumbleupon-circle';
	$icons[] = 'w2rr-fa-subscript';
	$icons[] = 'w2rr-fa-subway';
	$icons[] = 'w2rr-fa-suitcase';
	$icons[] = 'w2rr-fa-sun-o';
	$icons[] = 'w2rr-fa-superscript';
	$icons[] = 'w2rr-fa-support';
	$icons[] = 'w2rr-fa-table';
	$icons[] = 'w2rr-fa-tablet';
	$icons[] = 'w2rr-fa-tachometer';
	$icons[] = 'w2rr-fa-tag';
	$icons[] = 'w2rr-fa-tags';
	$icons[] = 'w2rr-fa-tasks';
	$icons[] = 'w2rr-fa-taxi';
	$icons[] = 'w2rr-fa-tencent-weibo';
	$icons[] = 'w2rr-fa-terminal';
	$icons[] = 'w2rr-fa-text-height';
	$icons[] = 'w2rr-fa-text-width';
	$icons[] = 'w2rr-fa-th';
	$icons[] = 'w2rr-fa-th-large';
	$icons[] = 'w2rr-fa-th-list';
	$icons[] = 'w2rr-fa-thumb-tack';
	$icons[] = 'w2rr-fa-thumbs-down';
	$icons[] = 'w2rr-fa-thumbs-o-down';
	$icons[] = 'w2rr-fa-thumbs-o-up';
	$icons[] = 'w2rr-fa-thumbs-up';
	$icons[] = 'w2rr-fa-ticket';
	$icons[] = 'w2rr-fa-times';
	$icons[] = 'w2rr-fa-times-circle';
	$icons[] = 'w2rr-fa-times-circle-o';
	$icons[] = 'w2rr-fa-tint';
	$icons[] = 'w2rr-fa-toggle-down';
	$icons[] = 'w2rr-fa-toggle-left';
	$icons[] = 'w2rr-fa-toggle-off';
	$icons[] = 'w2rr-fa-toggle-on';
	$icons[] = 'w2rr-fa-toggle-right';
	$icons[] = 'w2rr-fa-toggle-up';
	$icons[] = 'w2rr-fa-train';
	$icons[] = 'w2rr-fa-transgender';
	$icons[] = 'w2rr-fa-transgender-alt';
	$icons[] = 'w2rr-fa-trash';
	$icons[] = 'w2rr-fa-trash-o';
	$icons[] = 'w2rr-fa-tree';
	$icons[] = 'w2rr-fa-trello';
	$icons[] = 'w2rr-fa-trophy';
	$icons[] = 'w2rr-fa-truck';
	$icons[] = 'w2rr-fa-try';
	$icons[] = 'w2rr-fa-tty';
	$icons[] = 'w2rr-fa-tumblr';
	$icons[] = 'w2rr-fa-tumblr-square';
	$icons[] = 'w2rr-fa-turkish-lira';
	$icons[] = 'w2rr-fa-twitch';
	$icons[] = 'w2rr-fa-twitter';
	$icons[] = 'w2rr-fa-twitter-square';
	$icons[] = 'w2rr-fa-umbrella';
	$icons[] = 'w2rr-fa-underline';
	$icons[] = 'w2rr-fa-undo';
	$icons[] = 'w2rr-fa-university';
	$icons[] = 'w2rr-fa-unlink';
	$icons[] = 'w2rr-fa-unlock';
	$icons[] = 'w2rr-fa-unlock-alt';
	$icons[] = 'w2rr-fa-unsorted';
	$icons[] = 'w2rr-fa-upload';
	$icons[] = 'w2rr-fa-usd';
	$icons[] = 'w2rr-fa-user';
	$icons[] = 'w2rr-fa-user-md';
	$icons[] = 'w2rr-fa-user-plus';
	$icons[] = 'w2rr-fa-user-secret';
	$icons[] = 'w2rr-fa-user-times';
	$icons[] = 'w2rr-fa-users';
	$icons[] = 'w2rr-fa-venus';
	$icons[] = 'w2rr-fa-venus-double';
	$icons[] = 'w2rr-fa-venus-mars';
	$icons[] = 'w2rr-fa-viacoin';
	$icons[] = 'w2rr-fa-video-camera';
	$icons[] = 'w2rr-fa-vimeo-square';
	$icons[] = 'w2rr-fa-vine';
	$icons[] = 'w2rr-fa-vk';
	$icons[] = 'w2rr-fa-volume-down';
	$icons[] = 'w2rr-fa-volume-off';
	$icons[] = 'w2rr-fa-volume-up';
	$icons[] = 'w2rr-fa-warning';
	$icons[] = 'w2rr-fa-wechat';
	$icons[] = 'w2rr-fa-weibo';
	$icons[] = 'w2rr-fa-weixin';
	$icons[] = 'w2rr-fa-whatsapp';
	$icons[] = 'w2rr-fa-wheelchair';
	$icons[] = 'w2rr-fa-wifi';
	$icons[] = 'w2rr-fa-windows';
	$icons[] = 'w2rr-fa-won';
	$icons[] = 'w2rr-fa-wordpress';
	$icons[] = 'w2rr-fa-wrench';
	$icons[] = 'w2rr-fa-xing';
	$icons[] = 'w2rr-fa-xing-square';
	$icons[] = 'w2rr-fa-yahoo';
	$icons[] = 'w2rr-fa-yen';
	$icons[] = 'w2rr-fa-youtube';
	$icons[] = 'w2rr-fa-youtube-play';
	$icons[] = 'w2rr-fa-youtube-square';
	return $icons;
}

function w2rr_current_user_can_edit_target_post($target_post_id) {
	if (!current_user_can('edit_others_posts')) {
		$post = get_post($target_post_id);
		$current_user = wp_get_current_user();
		if ($current_user->ID != $post->post_author)
			return false;
		if ($post->post_status == 'pending'  && !is_admin())
			return false;
	}
	return true;
}

function w2rr_get_edit_target_post_link($target_post_id, $context = 'display') {
	if (w2rr_current_user_can_edit_target_post($target_post_id)) {
		$post = get_post($target_post_id);
		$current_user = wp_get_current_user();
		if (current_user_can('edit_others_posts') && $current_user->ID != $post->post_author)
			return get_edit_post_link($target_post_id, $context);
		else
			return apply_filters('w2rr_get_edit_target_post_link', get_edit_post_link($target_post_id, $context), $target_post_id);
	}
}

function w2rr_hex2rgba($color, $opacity = false) {
	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
		return $default;

	//Sanitize $color if "#" is provided
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if (abs($opacity) > 1) {
		$opacity = 1.0;
	} elseif (abs($opacity) < 0) {
		$opacity = 0;
	}
	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';

	//Return rgb(a) color string
	return $output;
}

function w2rr_adjust_brightness($hex, $steps) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(-255, min(255, $steps));

	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return = '#';

	foreach ($color_parts as $color) {
		$color   = hexdec($color); // Convert to decimal
		$color   = max(0,min(255,$color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}

function w2rr_error_log($wp_error) {
	w2rr_addMessage($wp_error->get_error_message(), 'error');
	error_log($wp_error->get_error_message());
}

function w2rr_getAdminNotificationEmail() {
	if (get_option('w2rr_admin_notifications_email'))
		return get_option('w2rr_admin_notifications_email');
	else 
		return get_option('admin_email');
}

function w2rr_wpmlTranslationCompleteNotice() {
	global $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress && defined('WPML_ST_VERSION')) {
		echo '<p class="description">';
		esc_html_e('After save do not forget to set completed translation status for this string on String Translation page.', 'W2RR');
		echo '</p>';
	}
}

function w2rr_phpmailerInit($phpmailer) {
	$phpmailer->AltBody = wp_specialchars_decode($phpmailer->Body, ENT_QUOTES);
}
function w2rr_mail($email, $subject, $body, $headers = null) {
	// create and add HTML part into emails
	add_action('phpmailer_init', 'w2rr_phpmailerInit');

	if (!$headers) {
		$headers[] = "From: " . get_option('blogname') . " <" . w2rr_getAdminNotificationEmail() . ">";
		$headers[] = "Reply-To: " . w2rr_getAdminNotificationEmail();
		$headers[] = "Content-Type: text/html";
	}
		
	$subject = "[" . get_option('blogname') . "] " .$subject;

	$body = make_clickable(wpautop($body));
	
	$email = apply_filters('w2rr_mail_email', $email, $subject, $body, $headers);
	$subject = apply_filters('w2rr_mail_subject', $subject, $email, $body, $headers);
	$body = apply_filters('w2rr_mail_body', $body, $email, $subject, $headers);
	$headers = apply_filters('w2rr_mail_headers', $headers, $email, $subject, $body);
	
	add_action('wp_mail_failed', 'w2rr_error_log');

	return wp_mail($email, $subject, $body, $headers);
}

global $w2rr_target_posts;
/**
 * This function can be called from the loop. It gives wrong "global $post;"
 * 
 * @param mix $post
 * @return boolean|w2rr_targetPost
 */
function w2rr_getTargetPost($post = null) {
	global $w2rr_target_posts;
	
	$target_post = false;
	
	if (!$post) {
		// check if it is too earlier to call get_query_var() function
		global $wp_query;
		if (!$wp_query) {
			return false;
		}
			
		if (get_query_var('target-post') || w2rr_getValue($_GET, 'target-post')) {
			if (!($target_post = get_query_var('target-post'))) {
				$target_post = w2rr_getValue($_GET, 'target-post');
			}
		}
		
		if (!$target_post && function_exists("w2dc_isListing")) {
			if ($listing = w2dc_isListing()) {
				return new w2rr_targetPost($listing->post);
			}
		}
			
		if (!$target_post && get_queried_object()) {
			if ($review = w2rr_isReview()) {
				return $review->target_post;
			} else {
				$target_post = get_queried_object_id();
			}
		}
		
		if (!$target_post) {
			global $post;
			if ($post) {
				$target_post = $post->ID;
			}
		}
		
		if (!$target_post) {
			return false;
		}
		
		if (isset($w2rr_target_posts[$target_post])) {
			return $w2rr_target_posts[$target_post];
		}
		
		$frontend_controller = new w2rr_frontend_controller();
		add_filter('post_limits', array($frontend_controller, 'findOnlyOnePost'));
			
		// search by ID
		$posts = get_posts(array(
				'include'     => $target_post,
				'post_type'   => w2rr_getWorkingPostTypes(),
				'post_status' => 'publish,private',
				'numberposts' => 1
		));
		if (!$posts) {
			// search by name
			$posts = get_posts(array(
					'name'        => $target_post,
					'post_type'   => w2rr_getWorkingPostTypes(),
					'post_status' => 'publish,private',
					'numberposts' => 1
			));
		}
		remove_filter('post_limits', array($frontend_controller, 'findOnlyOnePost'));
		if (count($posts)) {
			$post = array_shift($posts);
		} else {
			return false;
		}
	}
	
	if (is_object($post)) {
		$post_id = $post->ID;
	} elseif (is_numeric($post)) {
		$post_id = $post;
	} else {
		$post_id = 'global';
	}
	
	if (isset($w2rr_target_posts[$post_id])) {
		return $w2rr_target_posts[$post_id];
	} else {
		
		$target_post = new w2rr_targetPost($post);
		
		$target_post = apply_filters('w2rr_get_target_post', $target_post);
		
		if ($target_post && $target_post->post) {
			$w2rr_target_posts[$post_id] = $target_post;
			
			return $target_post;
		} else {
			return false;
		}
	}
}

function w2rr_getSelectedPages() {
	$selected_pages = array(
			w2rr_get_wpml_dependent_option('w2rr_page_add_review'),
			w2rr_get_wpml_dependent_option('w2rr_page_single_review'),
			w2rr_get_wpml_dependent_option('w2rr_page_all_reviews'),
			w2rr_get_wpml_dependent_option('w2rr_page_dashboard')
	);
	
	return apply_filters('w2rr_selected_pages', $selected_pages);
}

function w2rr_getWorkingPostTypes() {
	return get_option('w2rr_working_post_types') ? get_option('w2rr_working_post_types') : array();
}

function w2rr_addWorkingPostType($name) {
	$post_types = get_option('w2rr_working_post_types');
	
	$post_types[] = $name;
	
	$post_types = array_unique($post_types);
	
	update_option('w2rr_working_post_types', $post_types);
}

function w2rr_do_enqueue_scripts_styles($load_scripts_styles) {
	global $w2rr_instance, $w2rr_enqueued;
	
	if (get_option('w2rr_force_include_js_css')) {
		return true;
	}
	
	$target_post = w2rr_getTargetPost();
	if (in_array(get_post_type($target_post->post), w2rr_getWorkingPostTypes())) {
		return true;
	}
	
	if ((($w2rr_instance->frontend_controllers || $load_scripts_styles) && !$w2rr_enqueued)) {
		return true;
	}
}

function w2rr_setFrontendController($shortcode, $shortcode_instance, $do_duplicate = true) {
	global $w2rr_instance;
	
	$w2rr_instance->frontend_controllers[$shortcode][] = $shortcode_instance;
	
	// this duplicate property needed because we unset each controller when we render shortcodes, but WP doesn't really know which shortcode already was processed
	if ($do_duplicate) {
		$w2rr_instance->_frontend_controllers[$shortcode][] = $shortcode_instance;
	}
	
	return $shortcode_instance;
}

function w2rr_getFrontendControllers($shortcode = false, $property = false) {
	global $w2rr_instance;
	
	if (!$shortcode) {
		return $w2rr_instance->frontend_controllers;
	} else {
		if (!$property) {
			if (isset($w2rr_instance->frontend_controllers[$shortcode])) {
				return $w2rr_instance->frontend_controllers[$shortcode];
			} else {
				return false;
			}
		} else {
			if (isset($w2rr_instance->frontend_controllers[$shortcode][0]->$property)) {
				return $w2rr_instance->frontend_controllers[$shortcode][0]->$property;
			} else {
				return false;
			}
		}
	}
}

function w2rr_getFrontendControllerByHash($hash) {
	global $w2rr_instance;
	
	if (!$w2rr_instance->frontend_controllers) {
		return false;
	}
	
	foreach ($w2rr_instance->frontend_controllers AS $shortcodes) {
		foreach ($shortcodes AS $controller) {
			if (is_object($controller) && $controller->hash == $hash) {
				return $controller;
			}
		}
	}
}

function w2rr_isAddReviewPage() {
	global $post, $w2rr_instance;
	
	if ($w2rr_instance->add_review_page_id && $post) {
		return ($w2rr_instance->add_review_page_id == $post->ID);
	}
}

function w2rr_isReview() {
	
	if (get_query_var("review-w2rr")) {
		if ($post = get_page_by_path(get_query_var('review-w2rr'), OBJECT, W2RR_REVIEW_TYPE)) {
			return w2rr_getReview($post);
		}
	}
	
	if (get_query_var("w2rr_review")) {
		if ($post = get_page_by_path(get_query_var('w2rr_review'), OBJECT, W2RR_REVIEW_TYPE)) {
			return w2rr_getReview($post);
		}
	}
	
	if (get_query_var("reviews") && get_query_var("reviews") != 'all') {
		if ($post = get_page_by_path(get_query_var('reviews'), OBJECT, W2RR_REVIEW_TYPE)) {
			return w2rr_getReview($post);
		}
	}
	
	if (!empty($_POST['review_id'])) {
		return w2rr_getReview($_POST['review_id']);
	}
	
	if ($controllers = w2rr_getFrontendControllers(W2RR_REVIEW_PAGE_SHORTCODE)) {
		$controller = array_shift($controllers);
	
		return $controller->review;
	}
	
	return false;
	
	/* $queried_object = get_queried_object();
	if (get_post_type($queried_object) == W2RR_REVIEW_TYPE) {
		return w2rr_getReview($queried_object);
	} */
}

function w2rr_isAllReviews() {
	
	if (get_query_var("reviews") == 'all') {
		if ($post = get_page_by_path(get_query_var('reviews'), OBJECT, W2RR_REVIEW_TYPE)) {
			return w2rr_getReview($post);
		}
	}
	
	/* $queried_object = get_queried_object();
	if (is_object($queried_object) && get_class($queried_object) == 'WP_Post_Type' && $queried_object->name == W2RR_REVIEW_TYPE) {
		return true;
	} */
}

function w2rr_isRRPageInAdmin() {
	global $pagenow;
	
	$post_types_array = w2rr_getWorkingPostTypes();
	$post_types_array[] = W2RR_REVIEW_TYPE;

	if (
		is_admin() &&
		(($pagenow == 'edit.php' || $pagenow == 'post-new.php') && ($post_type = w2rr_getValue($_GET, 'post_type', 'post')) &&
				(in_array($post_type, $post_types_array))
		) ||
		($pagenow == 'post.php' && ($post_id = w2rr_getValue($_GET, 'post')) && ($post = get_post($post_id)) && w2rr_getValue($_GET, 'action') == 'edit' &&
				(in_array($post->post_type, $post_types_array))
		) ||
		(($page = w2rr_getValue($_GET, 'page')) &&
				(in_array($page,
						array(
								'w2rr_settings',
								'w2rr_csv_import',
						)
				))
		) ||
		($pagenow == 'widgets.php') ||
		($pagenow == 'profile.php') ||
		($pagenow == 'user-edit.php')
	) {
		return true;
	}
}

function w2rr_wrapKeys(&$val) {
	$val = "`".$val."`";
}
function w2rr_wrapValues(&$val) {
	$val = "'".$val."'";
}
function w2rr_wrapIntVal(&$val) {
	$val = intval($val);
}

function w2rr_utf8ize($mixed) {
	if (is_array($mixed)) {
		foreach ($mixed as $key => $value) {
			$mixed[$key] = w2rr_utf8ize($value);
		}
	} elseif (is_string($mixed) && function_exists("mb_convert_encoding")) {
		return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
	}
	return $mixed;
}

function w2rr_get_registered_image_sizes($unset_disabled = true) {
	$wais = & $GLOBALS['_wp_additional_image_sizes'];

	$sizes = array();

	foreach (get_intermediate_image_sizes() as $_size) {
		if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
			$sizes[ $_size ] = array(
					'width'  => get_option("{$_size}_size_w"),
					'height' => get_option("{$_size}_size_h"),
					'crop'   => (bool) get_option("{$_size}_crop"),
			);
		}
		elseif (isset($wais[$_size])) {
			$sizes[ $_size ] = array(
					'width'  => $wais[$_size]['width'],
					'height' => $wais[$_size]['height'],
					'crop'   => $wais[$_size]['crop'],
			);
		}

		// size registered, but has 0 width and height
		if($unset_disabled && ($sizes[ $_size ]['width'] == 0) && ($sizes[ $_size ]['height'] == 0)) {
			unset($sizes[$_size]);
		}
	}

	return $sizes;
}

function w2rr_isReviewElementsOnPage() {
	global $w2rr_instance;

	$shortcodes = array(
			'webrr-review-content',
			'webrr-review-header',
			'webrr-review-title',
			'webrr-review-comments',
			'webrr-review-gallery',
			'webrr-review-rating',
			'webrr-review-ratings-overall',
			'webrr-review-votes',
	);
	$review_page = get_post($w2rr_instance->review_page_id);

	$pattern = get_shortcode_regex($shortcodes);
	if (preg_match_all('/'.$pattern.'/s', $review_page->post_content, $matches) && array_key_exists(2, $matches)) {
		foreach ($matches[2] AS $key=>$_shortcode) {
			if (in_array($_shortcode, $shortcodes)) {
				return true;
			}
		}
	}

	return apply_filters("w2rr_is_review_elements_on_page", false);
}

function w2rr_locate_template() {

	$templates = array();

	if ($listing = w2rr_isReview()) {
		$templates[] = 'w2rr-listing.php';
	}

	$templates[] = 'page.php';

	return locate_template($templates);
}

?>