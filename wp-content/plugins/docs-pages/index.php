<?php
/*
Plugin Name: Documentation pages
Version: 1.0.0
Author: salephpscripts.com
Author URI: https://www.salephpscripts.com
*/

define('DOCS_PAGES_PATH', plugin_dir_path(__FILE__));

add_action('init', 'docs_pages_load_docs_page');
function docs_pages_load_docs_page() {
	
	global $docs_page_id;
	
	$args = array(
			'post_type' => 'page',
			'name' => 'documentation',
			'posts_per_page' => 1,
	);
	
	$query = new WP_Query($args);
	
	if ($query->posts) {
		$docs_page = $query->posts[0];
		$docs_page_id = $docs_page->ID;
	}
}

add_filter('query_vars', 'docs_pages_add_query_vars');
function docs_pages_add_query_vars($vars) {
	
	$vars[] = 'docs-path';
	
	return $vars;
}


add_filter('rewrite_rules_array', 'docs_pages_rewrite_rules', 11);
function docs_pages_rewrite_rules($rules) {
	
	global $docs_page_id;
	
	/* $docs_rules[] = array('documentation/?$' => 'index.php?page_id=' . $docs_page_id);
	$docs_rules[] = array('documentation/?(.+?)$' => 'index.php?page_id=' . $docs_page_id . '&docs_path=$matches[1]');
	
	return $docs_rules + $rules; */
	
	return array('documentation/?(.+?)?$' => 'index.php?page_id=' . $docs_page_id . '&docs-path=$matches[1]') + $rules;
}

add_filter('breadcrumb_trail_items', 'docs_pages_breadcrumbs', 10, 2);
function docs_pages_breadcrumbs($items, $args) {
	
	global $wp;

	if (strpos($wp->request, 'documentation') === 0 && empty($_GET['search'])) {
		$docs_path = trim(get_query_var('docs-path'), '/');
		
		if ($docs_path !='') {
			
			array_pop($items);
			
			$page_path = explode('/', $docs_path);
			
			$items[] = '<a href="' . home_url('documentation/') . '">Documentation</a>';
			
			$parts = array();
			foreach ($page_path AS $part_path_item) {
				
				$parts[] = $part_path_item;
				
				$part_path = implode('/', $parts);
				
				$file = DOCS_PAGES_PATH . 'pages/' . $part_path . '.php';
				
				if (!$file || !file_exists($file)) {
					$file = DOCS_PAGES_PATH . 'pages/documentation.php';
				}
				
				$out = include $file;
				
				$part_url = home_url('documentation/' . $part_path . '/');
				$part_title = $out['title'];
				array_push($items, '<a href="' . $part_url . '">' . $part_title . '</a>');
			}
		}
		
	}
	
	return $items;
}

add_filter('get_canonical_url', 'docs_pages_get_canonical_url', 100, 2);
function docs_pages_get_canonical_url($canonical_url, $post) {
	
	global $wp;
	
	if (strpos($wp->request, 'documentation') === 0 && empty($_GET['search'])) {
		$canonical_url = site_url($wp->request);
	}
	
	return $canonical_url;
}

function docs_pages_get_the_title($title) {
	
	global $wp;
	
	if (strpos($wp->request, 'documentation') === 0 && empty($_GET['search'])) {
		$docs_path = trim(get_query_var('docs-path'), '/');
			
		$file = false;
		if ($docs_path !='') {
			$page_path = explode('/', $docs_path);
	
			$file = DOCS_PAGES_PATH . 'pages/' . implode('/', $page_path) . '.php';
		}
	
		if (!$file || !file_exists($file)) {
			$file = DOCS_PAGES_PATH . 'pages/documentation.php';
		}
	
		$out = include $file;
			
		$title = $out['title'];
	} elseif (!empty($_GET['search'])) {
		$title = 'Search results';
	}
	
	return $title;
}

add_filter('pre_get_document_title', 'docs_pages_the_document_title', 100);
function docs_pages_the_document_title($title) {
	
	global $wp;
	
	$plugin_title = 'Web 2.0 Directory plugin';
	
	if (strpos($wp->request, 'documentation') === 0 && empty($_GET['search'])) {
		
		if (docs_pages_get_the_title($title) != 'Documentation') {
			$title = docs_pages_get_the_title($title) . ' - Documentation - ' . $plugin_title;
		} else {
			$title = docs_pages_get_the_title($title) . ' - ' . $plugin_title;
		}
	} elseif (!empty($_GET['search'])) {
		$title = 'Search results - Documentation - ' . $plugin_title;
	}
	
	return $title;
}

add_filter('w2dc_page_title_singular', 'docs_pages_the_title');
function docs_pages_the_title($title) {
	
	global $wp;
	
	if (strpos($wp->request, 'documentation') === 0 && empty($_GET['search'])) {
		$title = docs_pages_get_the_title($title);
	} elseif (!empty($_GET['search'])) {
		$title = 'Search results';
	}

	return $title;
}

add_filter('the_content', 'docs_pages_the_content');
function docs_pages_the_content($content) {
	
	global $wp;
	
	if (in_the_loop() && is_main_query()) {
		
		remove_filter("the_title", "docs_pages_the_content");
		
		if (strpos($wp->request, 'documentation') === 0 && empty($_GET['search'])) {
			$docs_path = trim(get_query_var('docs-path'), '/');
			
			$file = false;
			if ($docs_path !='') {
				$page_path = explode('/', $docs_path);
				
				$file = DOCS_PAGES_PATH . 'pages/' . implode('/', $page_path) . '.php';
			}
			
			if (!$file || !file_exists($file)) {
				$file = DOCS_PAGES_PATH . 'pages/documentation.php';
			}
			
			$out = include $file;
			
			$content = wpautop($out['content'] . docs_pages_menu_out());
		}
	}
	
	return $content;
}

function docs_pages_get_articles_by_score($path, $original_search_term, &$articles_by_score) {
	
	$keywords = explode(' ', $original_search_term);
	
	$files_dirs = glob($path);
	
	foreach ($files_dirs AS $fd) {

		if (is_file($fd)) {
			$out = include $fd;
				
			$title = $out['title'];
			
			$path = str_replace(DOCS_PAGES_PATH . 'pages/', '', $fd);
			if (strpos($path, 'documentation.php') !== false) {
				$url = site_url(str_replace('.php', '', $path) . '/');
			} else {
				$url = site_url('documentation/' . str_replace('.php', '', $path) . '/');
			}
				
			$description = $out['content'];
				
			$description = preg_replace('@<h2 id=".*?">.*?</h2>(.*)@', '$1', $description); // remove first <h2>
			$description = str_replace('<', ' <', $description); // add spaces near tags
			$description = strip_tags($description); // remove tags, leave spaces
			$description = str_replace('  ', ' ', $description); // remove double spaces
				
			$score = 0;
			foreach ($keywords AS $word) {
				if (stripos($title, $word) !== false) {
					$score += 50;
				}
	
				if (stripos($description, $word) !== false) {
					$score += substr_count(strtolower($description), strtolower($word));
				}
			}
				
			if ($score) {
				$_content = '<p class="w2dc-docs-search-suggestion">';
				
				//$_content .= $score;
	
				$_content .= '<a href="' . add_query_arg('highlight', $original_search_term, $url) . '">';
				$_content .= '<h4>' . $title . '</h4>';
				$_content .= '</a>';
				
				$_content .= preg_replace('/('.implode('|', $keywords) .')/iu', '<strong class="w2dc-docs-search-highlight">\0</strong>', docs_pages_make_excerpt($description, 50, $keywords));
	
				$_content .= '</p>';
				
				
	
				$articles_by_score[$score][] = $_content;
			}
		} elseif (is_dir($fd)) {
			docs_pages_get_articles_by_score($fd . '/*', $original_search_term, $articles_by_score);
		}
	}
	
	krsort($articles_by_score);
}

function docs_pages_make_excerpt($text, $limit, $keywords) {
	
	if (str_word_count($text, 0) > $limit) {
		
		$words      = str_word_count($text, 2);
		$pos_words  = array_keys($words);
		$excerpt    = '';
		$half_limit = ($limit % 2 == 0) ? $limit/2 : floor($limit/2);
		$duplicated_keywords = false;
		
		if (count($keywords) == 1) {
			$keywords[] = $keywords[0];
			
			$duplicated_keywords = true;
		}
		
		foreach ($keywords AS $key) {
			
			/* var_dump(array_search(strtolower($key), array_map('strtolower', $words)));
			var_dump($text);
			var_dump($key);
			echo "<br />";
			echo "<br />";
			echo "<br />";
			echo "<br />";
			echo "<br />";
			echo "<br />";
			echo "<br />"; */
			
			//if ($key_pos_letter = array_search(strtolower($key), array_map('strtolower', $words))) {
			
			if ($key_pos_letter = preg_grep("/^" . strtolower($key) . ".*/", array_map('strtolower', $words))) {
			
				// get the first key from array of matches (like strpos() on array)
				$key_pos_letter = array_keys($key_pos_letter);
				$key_pos_letter = $key_pos_letter[0];
				
				$key_pos_letter_index = array_search($key_pos_letter, $pos_words);
				
				if (isset($pos_words[$key_pos_letter_index - $half_limit])) {
					$start = $pos_words[$key_pos_letter_index - $half_limit];
				} else {
					$start = 0;
				}
				$pre_length = $key_pos_letter - $start;
				
				if ($key_pos_letter_index < $half_limit) {
					$start = 0;
				} else {
					$excerpt .= '... ';
				}
				
				$excerpt .= substr($text, $start, $pre_length);
				
				if (isset($pos_words[$key_pos_letter_index + $half_limit])) {
					$post_length = $pos_words[$key_pos_letter_index + $half_limit] - $key_pos_letter;
				} else {
					$post_length = $pos_words[count($pos_words) - 1] - $key_pos_letter;;
				}
				
				$excerpt .= substr($text, $key_pos_letter, $post_length);
				
				if (($key_pos_letter+$post_length) < strlen($text)) {
					$excerpt .= '...';
				}
				
				if ($duplicated_keywords) {
					$words     = array_splice($words, 0, $key_pos_letter_index);
					$pos_words = array_splice($pos_words, 0, $key_pos_letter_index);
				}
			}
		}
	}
	
	return $excerpt;
}

// process search
add_filter('the_content', 'docs_pages_the_content_search');
function docs_pages_the_content_search($content) {

	if (isset($_GET['search'])) {
		if ($original_search_term = sanitize_text_field($_GET['search'])) {
			
			$search_term = str_replace(array("[" , "]"), array("&#091;" , "&#093;"), $original_search_term);
			
			$articles_by_score = array();
			
			docs_pages_get_articles_by_score(DOCS_PAGES_PATH . 'pages/*', $original_search_term, $articles_by_score);
			
			
			$content = '<div class="w2dc-docs w2dc-docs-side">';
				
			$content .= '<h2>Search results for <strong>' . stripslashes($search_term) . '</strong></h2>';
			
			foreach ($articles_by_score AS $articles) {
				$content .= implode(' ', $articles);
			}
			
			
			$content = str_replace(array("[" , "]"), array("&#091;" , "&#093;"), $content);
			
			$content .= '</div>';
			
			$content .= docs_pages_menu_out();
		}
	} elseif (isset($_GET['highlight'])) {
		if ($original_search_term = sanitize_text_field($_GET['highlight'])) {
				
			$search_term = str_replace(array("[" , "]"), array("&#091;" , "&#093;"), $original_search_term);
				
			$keywords = explode(" ", $search_term);
				
			//$content = preg_replace('/('.implode('|', $keywords) .')/iu', '<strong class="w2dc-docs-search-highlight">\0</strong>', $content);
				
			// split the string into tag‍/‍no-tag parts using preg_split
			$parts = preg_split('/(<(?:[^"\'>]|"[^"<]*"|\'[^\'<]*\')*>)/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
				
			// iterate the parts while skipping every even part (i.e. the tag parts) and apply your replacement on it
			for ($i=0, $n=count($parts); $i<$n; $i+=2) {
				$parts[$i] = preg_replace('/('.implode('|', $keywords) .')/iu', '<strong class="w2dc-docs-search-highlight">\0</strong>', $parts[$i]);
			}
				
			$content = implode('', $parts);
		}
	}

	return $content;
}

function docs_pages_menu_out() {
	
	$menu_out = include DOCS_PAGES_PATH . 'menu.php';
	
	return $menu_out;
}

?>