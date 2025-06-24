<?php

function w2rr_recaptcha() {
	if (get_option('w2rr_enable_recaptcha') && get_option('w2rr_recaptcha_public_key') && get_option('w2rr_recaptcha_private_key')) {
		if (get_option('w2rr_recaptcha_version') == 'v2') {
			return '<div class="g-recaptcha" data-sitekey="'.get_option('w2rr_recaptcha_public_key').'"></div>';
		} elseif (get_option('w2rr_recaptcha_version') == 'v3') {
			ob_start();
			?>
			<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
			<script>
			(function($) {
				"use strict";

				$(function() {
					grecaptcha.ready(function() {
						grecaptcha.execute('<?php echo get_option('w2rr_recaptcha_public_key'); ?>').then(function(token) {
							$('#g-recaptcha-response').val(token);
						})
					});
				});
			})(jQuery);
			</script>
			<?php 
			return ob_get_clean();
		}
	}
}

function w2rr_is_recaptcha_passed() {
	if (get_option('w2rr_enable_recaptcha') && get_option('w2rr_recaptcha_public_key') && get_option('w2rr_recaptcha_private_key')) {
		if (isset($_POST['g-recaptcha-response']))
			$captcha = $_POST['g-recaptcha-response'];
		else
			return false;
		
		$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=".get_option('w2rr_recaptcha_private_key')."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		if (!is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$json = json_decode($body);
			if ($json->success === false)
				return false;
			else
				return true;
		} else
			return false;
	} else
		return true;
}

function w2rr_show_404() {
	status_header(404);
	nocache_headers();
	include(get_404_template());
	exit;
}


if (!function_exists('w2rr_renderPaginator')) {
	function w2rr_renderPaginator($query, $hash = null, $frontend_controller = null) {
		global $w2rr_instance;

		if (get_class($query) == 'WP_Query') {
			if (get_query_var('page'))
				$paged = get_query_var('page');
			elseif (get_query_var('paged'))
				$paged = get_query_var('paged');
			else
				$paged = 1;

			$total_pages = $query->max_num_pages;
			$total_lines = ceil($total_pages/10);
		
			if ($total_pages > 1) {
				$current_page = max(1, $paged);
				$current_line = floor(($current_page-1)/10) + 1;
		
				$previous_page = $current_page - 1;
				$next_page = $current_page + 1;
				$previous_line_page = floor(($current_page-1)/10)*10;
				$next_line_page = ceil($current_page/10)*10 + 1;
				
				echo '<div class="w2rr-pagination-wrapper">';
				echo '<ul class="w2rr-pagination">';
				if ($total_pages > 10 && $current_page > 10)
					echo '<li class="w2rr-inactive previous_line"><a href="' . get_pagenum_link($previous_line_page) . '" title="' . esc_attr__('Previous Line', 'w2rr') . '" data-page=' . $previous_line_page . ' data-controller-hash=' . $hash . '><<</a></li>' ;
			
				if ($total_pages > 3 && $current_page > 1)
					echo '<li class="w2rr-inactive previous"><a href="' . get_pagenum_link($previous_page) . '" title="' . esc_attr__('Previous Page', 'w2rr') . '" data-page=' . $previous_page . ' data-controller-hash=' . $hash . '><</i></a></li>' ;
			
				$count = ($current_line-1)*10;
				$end = ($total_pages < $current_line*10) ? $total_pages : $current_line*10;
				while ($count < $end) {
					$count = $count + 1;
					if ($count == $current_page)
						echo '<li class="w2rr-active"><a href="' . get_pagenum_link($count) . '">' . $count . '</a></li>' ;
					else
						echo '<li class="w2rr-inactive"><a href="' . get_pagenum_link($count) . '" data-page=' . $count . ' data-controller-hash=' . $hash . '>' . $count . '</a></li>' ;
				}
			
				if ($total_pages > 3 && $current_page < $total_pages)
					echo '<li class="w2rr-inactive next"><a href="' . get_pagenum_link($next_page) . '" title="' . esc_attr__('Next Page', 'w2rr') . '" data-page=' . $next_page . ' data-controller-hash=' . $hash . '>></i></a></li>' ;
			
				if ($total_pages > 10 && $current_line < $total_lines)
					echo '<li class="w2rr-inactive next_line"><a href="' . get_pagenum_link($next_line_page) . '" title="' . esc_attr__('Next Line', 'w2rr') . '" data-page=' . $next_line_page . ' data-controller-hash=' . $hash . '>>></a></li>' ;
			
				echo '</ul>';
				echo '</div>';
			}
		}
	}
}

function w2rr_renderSharingButton($post_id, $post_url, $button) {
	global $w2rr_social_services;

	$post_title = urlencode(get_the_title($post_id));
	if ($thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), array(200, 200))) {
		$post_thumbnail = urlencode($thumb_url[0]);
	} else {
		$post_thumbnail = '';
	}
	$post_url = urlencode($post_url);

	if (isset($w2rr_social_services[$button])) {
		$share_url = false;
		$share_counter = false;
		switch ($button) {
			case 'facebook':
				$share_url = 'http://www.facebook.com/sharer.php?u=' . $post_url;
				if (get_option('w2rr_share_counter')) {
					$response = wp_remote_get('http://graph.facebook.com/?id=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->share->share_count)) ? intval($json->share->share_count) : 0;
					}
				}
			break;
			case 'twitter':
				$share_url = 'http://twitter.com/share?url=' . $post_url . '&amp;text=' . $post_title;
			break;
			case 'google':
				$share_url = 'https://plus.google.com/share?url=' . $post_url;
				if (get_option('w2rr_share_counter')) {
					$args = array(
				            'method' => 'POST',
				            'headers' => array(
				                'Content-Type' => 'application/json'
				            ),
				            'body' => json_encode(array(
				                'method' => 'pos.plusones.get',
				                'id' => 'p',
				                'method' => 'pos.plusones.get',
				                'jsonrpc' => '2.0',
				                'key' => 'p',
				                'apiVersion' => 'v1',
				                'params' => array(
				                    'nolog' => true,
				                    'id' => $post_url,
				                    'source' => 'widget',
				                    'userId' => '@viewer',
				                    'groupId' => '@self'
				                ) 
				             )),          
				            'sslverify'=>false
				        ); 
				    $response = wp_remote_post("https://clients6.google.com/rpc", $args);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->result->metadata->globalCounts->count)) ? intval($json->result->metadata->globalCounts->count) : 0;
					}
				}
			break;
			case 'digg':
				$share_url = 'http://www.digg.com/submit?url=' . $post_url;
			break;
			case 'reddit':
				$share_url = 'http://reddit.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
				if (get_option('w2rr_share_counter')) {
					$response = wp_remote_get('https://www.reddit.com/api/info.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->data->children[0]->data->score)) ? intval($json->data->children[0]->data->score) : 0;
					}
				}
			break;
			case 'linkedin':
				$share_url = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $post_url;
				if (get_option('w2rr_share_counter')) {
					$response = wp_remote_get('https://www.linkedin.com/countserv/count/share?url=' . $post_url . '&format=json');
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'pinterest':
				$share_url = 'https://www.pinterest.com/pin/create/button/?url=' . $post_url . '&amp;media=' . $post_thumbnail . '&amp;description=' . $post_title;
				if (get_option('w2rr_share_counter')) {
					$response = wp_remote_get('https://api.pinterest.com/v1/urls/count.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $response['body']);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'stumbleupon':
				$share_url = 'http://www.stumbleupon.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
				if (get_option('w2rr_share_counter')) {
					$response = wp_remote_get('https://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->result->views)) ? intval($json->result->views) : 0;
					}
				}
			break;
			case 'tumblr':
				$share_url = 'http://www.tumblr.com/share/link?url=' . str_replace('http://', '', str_replace('https://', '', $post_url)) . '&amp;name=' . $post_title;
			break;
			case 'vk':
				$share_url = 'http://vkontakte.ru/share.php?url=' . $post_url;
				if (get_option('w2rr_share_counter')) {
					$response = wp_remote_get('https://vkontakte.ru/share.php?act=count&index=1&url=' . $post_url);
					if (!is_wp_error($response)) {
						$tmp = array();
						preg_match('/^VK.Share.count\(1, (\d+)\);$/i', $response['body'], $tmp);
						$share_counter = (isset($tmp[1])) ? intval($tmp[1]) : 0;
					}
				}
			break;
			case 'whatsapp':
				$share_url = 'whatsapp://send?text=' . $post_url;
			break;
			case 'telegram':
				$share_url = 'https://telegram.me/share/url?url=' . $post_url . '&text=' . $post_title;
			break;
			case 'viber':
				$share_url = 'viber://forward?text=' . $post_url;
			break;
			case 'email':
				$share_url = 'mailto:?Subject=' . $post_title . '&amp;Body=' . $post_url;
			break;
		}

		if ($share_url !== false) {
			echo '<a href="'.$share_url.'" data-toggle="w2rr-tooltip" data-placement="top" title="'.sprintf(esc_html__('Share on %s', 'w2rr'),  $w2rr_social_services[$button]['label']).'" target="_blank"><img src="'.W2RR_RESOURCES_URL.'images/social/'.get_option('w2rr_share_buttons_style').'/'.$button.'.png" /></a>';
			if (get_option('w2rr_share_counter') && $share_counter !== false)
				echo '<span class="w2rr-share-count">'.number_format($share_counter).'</span>';
		}
	}
}

function w2rr_hintMessage($message, $placement = 'auto', $return = false) {
	$out = '<a class="w2rr-hint-icon" href="javascript:void(0);" data-content="' . esc_attr($message) . '" data-html="true" rel="popover" data-placement="' . esc_attr($placement) . '" data-trigger="hover"></a>';
	if ($return) {
		return $out;
	} else {
		echo $out;
	}
}

?>