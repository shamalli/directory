<?php 

class w2rr_frontend_controller {
	
	public $args = array();
	public $query;
	public $page_title;
	public $template;
	public $is_review;
	public $review;
	public $reviews = array();
	public $paginator;
	public $breadcrumbs = array();
	public $base_url;
	public $messages = array();
	public $hash = null;
	public $request_by = 'frontend_controller';
	public $template_args = array();

	public function __construct($args = array()) {
		apply_filters('w2rr_frontend_controller_construct', $this);
		
		$this->template_args = array('frontend_controller' => $this);
	}
	
	public function add_template_args($args = array()) {
		$this->template_args += $args;
	}
	
	public function init($attrs = array()) {

		if (!$this->hash) {
			if (isset($attrs['uid']) && $attrs['uid']) {
				$this->hash = md5($attrs['uid']);
			} else {
				$this->hash = md5(get_class($this).serialize($attrs));
			}
		}
	}
	
	public function getPageTitle() {
		return esc_html($this->page_title);
	}

	public function addBreadCrumbs($breadcrumb) {
		if (is_array($breadcrumb)) {
			foreach ($breadcrumb AS $_breadcrumb) {
				$this->addBreadCrumbs($_breadcrumb);
			}
		} else {
			if (is_object($breadcrumb) && get_class($breadcrumb) == 'w2rr_breadcrumb') {
				$this->breadcrumbs[] = $breadcrumb;
			} else {
				$this->breadcrumbs[] = new w2rr_breadcrumb($breadcrumb);
			}
		}
	}
	
	public function getBreadCrumbsLinks() {
		$links = array();
		
		$breadcrumbs_process = $this->breadcrumbs;
		if (!get_option('w2rr_hide_home_link_breadcrumb')) {
			array_unshift($breadcrumbs_process, new w2rr_breadcrumb(esc_html__('Home', 'w2rr'), home_url()));
		}
		
		foreach ($breadcrumbs_process AS $key=>$breadcrumb) {
			$title = '';
			if ($breadcrumb->title) {
				$title = 'title="' . $breadcrumb->title . '"';
			}
			
			$links[] = '<a href="' . $breadcrumb->url . '" ' . $title . '>' . $breadcrumb->name . '</a>';
		}
		
		return $links;
	}
	
	public function printBreadCrumbs($separator = ' » ') {
		
		do_action("w2rr_print_breadcrumbs", $this);
		
		if ($breadcrumbs_process = $this->breadcrumbs) {
			$do_schema = false;
			if (count($this->breadcrumbs) > 1) {
				$do_schema = true;
			}
			
			$do_schema = apply_filters('w2rr_do_schema', $do_schema);
			
			if ($do_schema) {
				echo '<ol class="w2rr-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';
			} else {
				echo '<ol class="w2rr-breadcrumbs">';
			}

			if (!get_option('w2rr_hide_home_link_breadcrumb')) {
				array_unshift($breadcrumbs_process, new w2rr_breadcrumb(esc_html__('Home', 'w2rr'), home_url()));
			}
			
			$counter = 0;
			foreach ($breadcrumbs_process AS $key=>$breadcrumb) {
				$title = '';
				if ($breadcrumb->title) {
					$title = 'title="' . $breadcrumb->title . '"';
				}
				
				if ($breadcrumb->url) {
					if ($do_schema) {
						$counter++;
						echo '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="' . $breadcrumb->url . '" itemprop="item" ' . $title . '><span itemprop="name">' . $breadcrumb->name . '</span><meta itemprop="position" content="' . $counter . '" /></a></li>';
					} else {
						echo '<li><a href="' . $breadcrumb->url . '" ' . $title . '>' . $breadcrumb->name . '</a></li>';
					}
				} else {
					echo '<li>' . $breadcrumb->name . '</li>';
				}
				
				if ($key+1 < count($breadcrumbs_process)) {
					echo $separator;
				}
			}
			echo '</ol>';
		}
	}

	public function getBaseUrl() {
		return $this->base_url;
	}
	
	/**
	 * posts_per_page does not work in WP_Query when we search by name='slug' parameter,
	 * we have to use this hack
	 * 
	 * @return string
	 */
	public function findOnlyOnePost() {
		return 'LIMIT 0, 1';
	}
	
	public function getTargetPost() {
		return w2rr_getTargetPost();
	}
	
	public function set404() {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
	}
	
	public function display_content_filter($content) {
		global $post;
		
		// return content only for the following pages, otherwise it can fall into the infinite loop (not recursion)
		if (in_array($post->ID, w2rr_getSelectedPages())) {
			return $content  . $this->display();
		}
		
		return $content;
	}
	
	public function display() {
		$output =  w2rr_renderTemplate($this->template, $this->template_args, true);
		wp_reset_postdata();
		
		return $output;
	}
}

function w2rr_base_url_args($args) {
	if (isset($_REQUEST['order_by']) && $_REQUEST['order_by']) {
		$args['order_by'] = $_REQUEST['order_by'];
	}
	if (isset($_REQUEST['order']) && $_REQUEST['order']) {
		$args['order'] = $_REQUEST['order'];
	}
	
	if (isset($_REQUEST['reviews_order_by']) && $_REQUEST['reviews_order_by']) {
		$args['reviews_order_by'] = $_REQUEST['reviews_order_by'];
	}
	if (isset($_REQUEST['reviews_order']) && $_REQUEST['reviews_order']) {
		$args['reviews_order'] = $_REQUEST['reviews_order'];
	}

	return $args;
}
add_filter('w2rr_base_url_args', 'w2rr_base_url_args');


function w2rr_related_shortcode_args($shortcode_atts) {
	if (isset($shortcode_atts['author']) && $shortcode_atts['author'] === 'related') {
		if ($controllers = w2rr_getFrontendControllers(W2RR_REVIEWS_SHORTCODE)) {
			$controller = array_shift($controllers);
			
			if ($controller->is_single) {
				if ($controller->is_review) {
					$review = $controller->review;
					
					$shortcode_atts['author'] = $review->post->post_author;
					$shortcode_atts['post__not_in'] = $review->post->ID;
				}
			}
		} elseif ($user_id = get_the_author_meta('ID')) {
			$shortcode_atts['author'] = $user_id;
		}
	}

	return $shortcode_atts;
}
add_filter('w2rr_related_shortcode_args', 'w2rr_related_shortcode_args');

?>