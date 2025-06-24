<?php 

class w2rr_ajax_controller {
	
	public $review_id;

	public function __construct() {
		add_action('wp_ajax_w2rr_get_sharing_buttons', array($this, 'get_sharing_buttons'));
		add_action('wp_ajax_nopriv_w2rr_get_sharing_buttons', array($this, 'get_sharing_buttons'));

		add_action('wp_ajax_w2rr_reviews_controller_request', array($this, 'controller_request'));
		add_action('wp_ajax_nopriv_w2rr_reviews_controller_request', array($this, 'controller_request'));
		
		add_action('wp_ajax_w2rr_review_dialog', array($this, 'review_dialog'));
		add_action('wp_ajax_nopriv_w2rr_review_dialog', array($this, 'review_dialog'));
	}

	public function controller_request() {
		global $w2rr_instance;
		
		$post_args = $_POST;
		
		$hash = $_POST['hash'];
		
		$shortcode_atts = array_merge(array(
				'posts' => '',
				'name' => '',
				'perpage' => 10,
				'onepage' => 0,
				'reviews_order_by' => 'post_date',
				'reviews_order' => 'DESC',
				'hide_order' => 0,
				'paged' => 1,
				'include_get_params' => 1,
				'template' => 'ratings_reviews/reviews_block.tpl.php',
		), $post_args);
		
		// This is required workaround
		$_REQUEST['reviews_order_by'] = w2rr_getValue($post_args, 'reviews_order_by', $shortcode_atts['reviews_order_by']);
		$_REQUEST['reviews_order'] = w2rr_getValue($post_args, 'reviews_order', $shortcode_atts['reviews_order']);
		
		// Strongly required for paginator
		set_query_var('page', $shortcode_atts['paged']);
		
		$controller = new w2rr_reviews_controller;
		$controller->init($shortcode_atts);
		$controller->hash = $hash;
		
		// this does not allow paginator to set up admin_url('admin-ajax.php') in get_pagenum_link()
		global $w2rr_global_base_url;
		$w2rr_global_base_url = $controller->base_url;
		add_filter('get_pagenum_link', array($w2rr_instance->ajax_controller, 'get_pagenum_link'));
		
		$reviews_html = '';
		if (isset($post_args['do_append']) && $post_args['do_append']) {
			if ($controller->reviews) {
				while ($controller->query->have_posts()) {
					$controller->query->the_post();
					$reviews_html .= '<article id="post-' . get_the_ID() . '" class="w2rr-row w2rr-review w2rr-review-wrapper ' . (implode(' ', $controller->getReviewClasses())) . '">';
					$reviews_html .= $controller->reviews[get_the_ID()]->display($controller, false, true);
					$reviews_html .= '</article>';
				}
			}
			unset($controller->args['do_append']);
		} else {
			$reviews_html = w2rr_renderTemplate('ratings_reviews/reviews_block.tpl.php', array('frontend_controller' => $controller), true);
		}
		wp_reset_postdata();
		
		$out = array(
				'html' => $reviews_html,
				'hash' => $controller->hash,
				'hide_show_more_reviews_button' => ($shortcode_atts['paged'] >= $controller->query->max_num_pages) ? 1 : 0,
		);
		
		if ($json = json_encode(w2rr_utf8ize($out))) {
			// this is JSON encoded output, no need in esc_html()
			echo $json;
		} else {
			echo json_last_error_msg();
		}
		
		die();
	}
	
	public function get_pagenum_link($result) {
		global $w2rr_global_base_url;

		if ($w2rr_global_base_url) {
			preg_match('/paged=(\d+)/', $result, $matches);
			if (isset($matches[1])) {
				global $wp_rewrite;
				if ($wp_rewrite->using_permalinks()) {
					$parsed_url = parse_url($w2rr_global_base_url);
					$query_args = (isset($parsed_url['query'])) ? wp_parse_args($parsed_url['query']) : array();
					foreach ($query_args AS $key=>$arg) {
						if (!is_array($arg)) {
							$query_args[$key] = urlencode($arg);
						}
					}
					$url_without_get = ($pos_get = strpos($w2rr_global_base_url, '?')) ? substr($w2rr_global_base_url, 0, $pos_get) : $w2rr_global_base_url;
					return esc_url(add_query_arg($query_args, trailingslashit(trailingslashit($url_without_get) . 'page/' . $matches[1])));
				} else
					return add_query_arg('page', $matches[1], $w2rr_global_base_url);
			} else 
				return $w2rr_global_base_url;
		}
		return $result;
	}
	
	public function get_sharing_buttons() {
		w2rr_renderTemplate('frontend/sharing_buttons_ajax_response.tpl.php', array('post_id' => $_POST['post_id'], 'post_url' => $_POST['post_url']));
		die();
	}
	
	public function review_dialog() {
		
		global $w2rr_instance;
	
		if (isset($_REQUEST['review_id']) && is_numeric($_REQUEST['review_id'])) {
			$review_id = $_REQUEST['review_id'];
	
			if ($review_id) {
				$controller = new w2rr_frontend_controller;
				$controller->init();
				$args = array(
						'post_type' => W2RR_REVIEW_TYPE,
						'post_status' => 'publish',
						'p' => $review_id,
						'posts_per_page' => 1,
				);
				$controller->query = new WP_Query($args);
	
				while ($controller->query->have_posts()) {
					$controller->query->the_post();
					
					$review = w2rr_getReview(get_post());
				}
				
				$controller->reviews[$review->post->ID] = $review;
				$controller->review = $review;
				
				$controller->review->increaseClicksStats();
				
				$w2rr_instance->reviews_manager->setup_breadcrumbs($controller);
				$controller->addBreadCrumbs($review->title());
	
				$this->review_id = $review->post->ID;
				
				if ($w2rr_instance->review_page_id) {
					$html = get_the_content(null, false, $w2rr_instance->review_page_id);
						
					$html = do_shortcode($html);
				
					$html = apply_filters("w2rr_the_content_review_page", $html);
				}
				
				if (!$w2rr_instance->review_page_id || !$html) {
					$html = w2rr_renderTemplate('ratings_reviews/review_single.tpl.php', array(
								'reviews_controller' => $controller,
								'frontend_controller' => $controller
					), true);
				}
					
				$out = array(
						'review_title' => $review->title(),
						'review_html' => $html,
				);
	
				if ($json = json_encode(w2rr_utf8ize($out))) {
					echo $json;
				} else {
					echo json_last_error_msg();
				}
			}
		}
	
		die();
	}
}
?>