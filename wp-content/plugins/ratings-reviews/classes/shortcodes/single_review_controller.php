<?php 

/**
 *  [webrr-review-page] shortcode
 *
 *
 */
class w2rr_single_review_controller extends w2rr_frontend_controller {
	public $request_by = 'single_review_controller';
	public $review;
	public $is_review;
	public $is_single;
	public $object_single;
	public $head_post;
	
	public function __construct() {
		global $w2rr_instance;
		
		parent::__construct();
		
		if (w2rr_isReview()) {
			
			if (get_query_var(W2RR_REVIEW_TYPE)) {
				$name = get_query_var(W2RR_REVIEW_TYPE);
			} elseif (get_query_var("review-w2rr")) {
				$name = get_query_var("review-w2rr");
			} elseif (get_query_var("reviews")) {
				$name = get_query_var("reviews");
			}
			
			$reviews_controller = new w2rr_reviews_controller();
			$reviews_controller->init(array(
					'name' => $name,
			));
			if ($reviews_controller->review) {
				$review = $reviews_controller->review;
		
				$this->page_title = $review->title();
				$this->review = $review;
				$this->is_review = true;
				$this->is_single = true;
				$this->object_single = $review;
				
				$w2rr_instance->reviews_manager->setup_breadcrumbs($this);
				$this->addBreadCrumbs($review->title());
				
				add_filter('language_attributes', array($this, 'add_opengraph_doctype'));
				
				add_action('wp_head', array($this, 'insert_fb_in_head'), -10);
				if (function_exists('rel_canonical')) {
					remove_action('wp_head', 'rel_canonical');
				}
				// replace the default WordPress canonical URL function with your own
				add_action('wp_head', array($this, 'rel_canonical_with_custom_tag_override'));
			}
			
			$this->add_template_args(array('reviews_controller' => $reviews_controller));
			$this->template = 'ratings_reviews/review_single.tpl.php';
			
			if (w2rr_isReview() && $w2rr_instance->review_page_id) {
				if (w2rr_isReviewElementsOnPage()) {
					$this->template  = false;
				}
			}
		}
	}

	public function init($args = array()) {
		
		parent::init($args);
		
		$shortcode_atts = array_merge(array(
				'comments_template' => false,
		), $args);
	
		if (w2rr_isReview()) {
			if ($this->review) {
				$this->add_template_args(array('comments_template' => $shortcode_atts['comments_template']));
	
				if (!wp_doing_ajax()) {
					$this->review->increaseClicksStats();
				}
			}
		}
		
		// this is reset is really required after the loop ends
		wp_reset_postdata();
		
		apply_filters('w2rr_single_review_controller_construct', $this);
	}
	
	// rewrite canonical URL
	public function rel_canonical_with_custom_tag_override() {
		echo '<link rel="canonical" href="' . get_permalink($this->object_single->post->ID) . '" />
';
	}
	
	// Adding the Open Graph in the Language Attributes
	public function add_opengraph_doctype($output) {
		
		if (!is_plugin_active('wordpress-seo/wp-seo.php') && !is_plugin_active('wordpress-seo-premium/wp-seo-premium.php')) {
			return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
		}
		
		return $output;
	}
	
	// Lets add Open Graph Meta Info
	public function insert_fb_in_head() {
		
		if (!is_plugin_active('wordpress-seo/wp-seo.php') && !is_plugin_active('wordpress-seo-premium/wp-seo-premium.php')) {
			echo '<meta property="og:type" content="article" data-w2rr-og-meta="true" />
';
			echo '<meta property="og:title" content="' . $this->og_title() . '" />
';
			echo '<meta property="og:description" content="' . $this->og_description() . '" />
';
			echo '<meta property="og:url" content="' . $this->og_url() . '" />
';
			echo '<meta property="og:site_name" content="' . $this->og_site_name() . '" />
';
			if ($thumbnail_src = $this->og_image()) {
				echo '<meta property="og:image" content="' . esc_attr($thumbnail_src) . '" />
';
			}
		}
	
		add_filter('wpseo_opengraph_title', array($this, 'og_title'), 10, 2);
		add_filter('wpseo_opengraph_desc', array($this, 'og_description'), 10, 2);
		add_filter('wpseo_opengraph_url', array($this, 'og_url'), 10, 2);
		add_filter('wpseo_opengraph_image', array($this, 'og_image'), 10, 2);
		add_filter('wpseo_opengraph_site_name', array($this, 'og_site_name'), 10, 2);
	}
	
	public function og_title() {
		return esc_attr($this->object_single->title())  . ' - ' . get_bloginfo('name');
	}
	
	public function og_description() {
		if ($this->object_single->post->post_excerpt) {
			$excerpt = $this->object_single->post->post_excerpt;
		} else {
			$excerpt = $this->object_single->getExcerptFromContent();
		}
	
		return esc_attr($excerpt);
	}
	
	public function og_url() {
		return get_permalink($this->object_single->post->ID);
	}
	
	public function og_site_name() {
		return get_bloginfo('name');
	}
	
	public function og_image() {
		return $this->object_single->get_logo_url();
	}
}

?>