<?php

class w2rr_query {
	
	private $_temp_post;
	private $_temp_query;
	
	public function __construct() {
		
		add_filter('rewrite_rules_array', array($this, 'rewrite_rules'), 1);
		add_filter('query_vars', array($this, 'add_query_vars'));
		add_action('template_redirect', array($this, 'template_redirect'));
		add_filter('template_include', array($this, 'template_include'), 99);
		add_filter('the_content', array($this, 'the_content'));
		add_filter('has_post_thumbnail', array($this, 'has_post_thumbnail'), 10, 3);
		add_action('wp_head', array($this, 'change_wp_query'), -99999);
		add_action('wp_head', array($this, 'back_wp_query'), 99999);
		add_filter("the_title", array($this, "the_title"));
		
		add_filter('redirect_canonical', array($this, 'prevent_wrong_redirect'), 10, 2);
		
		add_filter('wp_unique_post_slug_is_bad_flat_slug', array($this, 'reserve_slugs'), 10, 2);
	}
	
	public function change_wp_query() {
		global $post;
		global $wp_query;
	
		if ($queried_object = w2rr_isReview()) {
			$this->_temp_post 				= $post;
			$this->_temp_query 				= $wp_query;
			
			$wp_query = new WP_Query(array(
					'post_type' => W2RR_REVIEW_TYPE,
					'name' => $queried_object->post->post_name,
					'posts_per_page' => 1,
			));
			
			$post							= $queried_object->post;
			$GLOBALS['wp_the_query'] 		= $wp_query;
			$GLOBALS['post']				= $post;
		}
	}
	
	public function back_wp_query() {
		
		if ($this->_temp_query) {
			global $post;
			global $wp_query;
			global $w2rr_instance;
			
			if ($wp_query->query_vars['post_type'] == W2RR_REVIEW_TYPE && $w2rr_instance->review_page_id) {
				$post = get_post($w2rr_instance->review_page_id);
			} else {
				$post = $this->_temp_post;
			}
			$wp_query 							= $this->_temp_query;
			$GLOBALS['wp_the_query'] 			= $wp_query;
			
			$wp_query->is_singular			= true;
			$wp_query->is_tax				= false;
			$wp_query->is_home				= false;
			$wp_query->is_page				= true;
			$wp_query->queried_object_id	= $post->ID;
			$wp_query->queried_object		= $post;
		}
	}
	
	public function template_redirect() {
		global $wp_query;
		global $w2rr_instance;
	
		// empty tax pages does not render any content
		if ($wp_query->post_count == 0) {
			$wp_query->post_count = 1;
			$wp_query->posts[] = get_post($w2rr_instance->review_page_id);
		}
	
		if (w2rr_isReview() && $w2rr_instance->review_page_id) {
			$controller = new w2rr_single_review_controller();
			$controller->init();
	
			w2rr_setFrontendController(W2RR_REVIEW_PAGE_SHORTCODE, $controller);
		}
	}
	
	public function template_include($template) {
	
		if (w2rr_isReview()) {
			
			$default_template = w2rr_locate_template();
			
			if ($default_template != '') {
				return $default_template;
			}
		}
	
		return $template;
	}
	
	public function the_content($content) {
		
		global $w2rr_instance;
	
		if (in_the_loop() && is_main_query()) {
				
			remove_filter("the_content", array($this, "the_content"));
			
			global $w2rr_do_listing_content;
			if ($w2rr_do_listing_content) {
				return $content;
			}
				
			if (w2rr_isReview() && $w2rr_instance->review_page_id) {
				$content = get_the_content(null, false, $w2rr_instance->review_page_id);
					
				$content = apply_filters("w2rr_the_content_review_page", $content);
				
				$content = do_shortcode($content);
					
				if ($content) {
					return $content;
				}
			}
		}
	
		return $content;
	}
	
	public function has_post_thumbnail($has_thumbnail, $post, $thumbnail_id) {
	
		if (get_post_type($post) == W2RR_REVIEW_TYPE) {
			return false;
		}
	
		return $has_thumbnail;
	}
	
	public function the_title($title) {
		
		if (in_the_loop() && is_main_query()) {
				
			remove_filter("the_title", array($this, "the_title"));
				
			if (w2rr_isReview()) {
				if (!empty(w2rr_getFrontendControllers(W2RR_REVIEW_PAGE_SHORTCODE))) {
					$controllers = w2rr_getFrontendControllers(W2RR_REVIEW_PAGE_SHORTCODE);
						
					$title = $controllers[0]->page_title;
				}
			}
		}
		
		return $title;
	}
	
	public function rewrite_rules($rules) {
		global $w2rr_instance;
		
		$custom_rules = array();
		
		$custom_rules['reviews/([^\/.]+)/?$'] = W2RR_REVIEW_TYPE . '=$matches[1]';
		
		return $custom_rules + $rules;
	}
	
	public function add_query_vars($vars) {
		$vars[] = 'target-post';
		$vars[] = 'reviews-all';
		$vars[] = 'review-w2rr';
	
		return $vars;
	}
	
	public function prevent_wrong_redirect($requested_url = null, $do_redirect = true) {
		global $w2rr_instance;
		
		if (
			($w2rr_instance->add_review_page_id && get_permalink($w2rr_instance->add_review_page_id) == $requested_url) ||
			get_query_var(W2RR_REVIEW_TYPE) ||
			get_query_var('add-review') ||
			w2rr_isReview() ||
			w2rr_isAllReviews()
		) {
			$do_redirect = false;
		} else {
			return $requested_url;
		}
	}
	
	public function reserve_slugs($is_bad_flat_slug, $slug) {
		$slugs_to_check = array();
	
		$slugs_to_check[] = 'reviews';
		$slugs_to_check[] = 'add-review';
	
		if (in_array($slug, $slugs_to_check)) {
			return true;
		}
		return $is_bad_flat_slug;
	}
}

?>