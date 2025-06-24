<?php 

/**
 *  [webrr-reviews] shortcode
 *
 *
 */
class w2rr_reviews_controller extends w2rr_frontend_controller {
	public $request_by = 'reviews_controller';
	public $reviews = array();
	public $review;
	public $head_post;

	public function init($args = array()) {
		global $w2rr_instance;
		
		parent::init($args);
	
		if (get_query_var('page')) {
			$paged = get_query_var('page');
		} elseif (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} else {
			$paged = 1;
		}
		
		$shortcode_atts = array_merge(array(
				'posts' => '', // exact reviews by ID1,ID2,...
				'name' => '', // exact review by post name
				'perpage' => 10,
				'onepage' => 0,
				'reviews_order_by' => 'post_date',
				'reviews_order' => 'DESC',
				'status' => 'publish',
				'hide_order' => 0,
				'hide_paginator' => 0,
				'hide_images' => 0,
				'with_images' => 0, // get only posts have images
				'reviews_view_type' => 'list', // list, grid
				'reviews_view_grid_columns' => 2, // 2, 3, 4
				'reviews_view_grid_masonry' => 0,
				'target_post' => false, // reviews only of this target post
				'target_post_type' => '', // all reviews of posts of certain post type
				'terms' => '',
				'tax' => '',
				'paged' => $paged,
				'include_get_params' => 1,
				'template' => 'ratings_reviews/reviews_block.tpl.php',
				'uid' => null,
		), $args);
		$shortcode_atts = apply_filters('w2rr_related_shortcode_args', $shortcode_atts, $args);
		
		$this->args = $shortcode_atts;
		if ($shortcode_atts['include_get_params']) {
			$get_params = $_GET;
			array_walk_recursive($get_params, 'sanitize_text_field');
			$this->args = array_merge($this->args, $get_params);
		}
		
		if (!empty($this->args['target_post'])) {
			if (wp_doing_ajax()) {
				$shortcode_atts['posts'] = $this->args['posts'];
			} else {
				$target_post = w2rr_getTargetPost();
					
				$shortcode_atts['posts'] = $target_post->post->ID;
				
				// save target post to use in AJAX later (order by, paginator)
				$this->args['posts'] = $target_post->post->ID;
			}
		}
		
		$exact_posts_ids = array();
		if (!empty($shortcode_atts['posts'])) {
			if (is_array($shortcode_atts['posts'])) {
				$exact_posts_ids = $shortcode_atts['posts'];
			} else {
				$exact_posts_ids = wp_parse_id_list($shortcode_atts['posts']);
			}
		}
		
		if (!empty($this->args['target_post_type'])) {
			$post_type_posts = get_posts(array(
					'post_type'      => $this->args['target_post_type'],
					'posts_per_page' => -1,
					'fields'         => 'ids',
			));
			foreach ($post_type_posts AS $post) {
				$exact_posts_ids[] = $post->ID;
			}
		}
		
		
		
		if (!empty($this->args['terms']) && !empty($this->args['tax']) && taxonomy_exists($this->args['tax'])) {
			if (is_string($this->args['terms'])) {
				$terms = explode(',', $this->args['terms']);
			} elseif (is_array($this->args['terms'])) {
				$terms = $this->args['terms'];
			}
				
			$field = 'term_id';
			foreach ($terms AS $term) {
				if (!is_numeric($term)) {
					$field = 'slug';
				}
			}
			
			$term_posts = get_posts(array(
					'post_type' => w2rr_getWorkingPostTypes(),
					'numberposts' => -1,
					'tax_query' => array(
							array(
									'taxonomy'         => $this->args['tax'],
									'field'            => $field,
									'terms'            => $terms,
									'include_children' => false
							)
					)
			));
			
			if ($term_posts) {
				foreach ($term_posts AS $post) {
					$exact_posts_ids[] = $post->ID;
				}
			}
		}

		$base_url_args = apply_filters('w2rr_base_url_args', array());
		if (isset($args['base_url'])) {
			$this->base_url = add_query_arg($base_url_args, $args['base_url']);
		} else {
			$this->base_url = add_query_arg($base_url_args, get_permalink());
		}

		$this->template = $this->args['template'];

		$args = array(
				'post_type' => W2RR_REVIEW_TYPE,
				'post_status' => $shortcode_atts['status'],
				'posts_per_page' => $shortcode_atts['perpage'],
				'paged' => $shortcode_atts['paged'],
		);
		if ($shortcode_atts['name']) {
			add_filter('post_limits', array($this, 'findOnlyOnePost'));
			$args['name'] = $shortcode_atts['name'];
		}
		
		if ($exact_posts_ids) {
			$args['meta_query'][] = array(
					'key' => '_post_id',
					'value' => $exact_posts_ids,
					'compare' => 'IN'
			);
		}
		if (!empty($shortcode_atts['author'])) {
			$args['author'] = $shortcode_atts['author'];
		}

		// render just one page - all found reviews on one page
		if ($shortcode_atts['onepage']) {
			$args['posts_per_page'] = -1;
		}
		
		if (!empty($shortcode_atts['with_images'])) {
			$args['meta_query'][] = array('key' => '_thumbnail_id');
		}

		$args = array_merge($args, apply_filters('w2rr_reviews_order_args', array(), $shortcode_atts, $this->args['include_get_params']));

		if (!empty($this->args['post__in'])) {
			if (is_string($this->args['post__in'])) {
				$args = array_merge($args, array('post__in' => wp_parse_id_list($this->args['post__in'])));
			} elseif (is_array($this->args['post__in'])) {
				$args['post__in'] = $this->args['post__in'];
			}
		}
		if (!empty($this->args['post__not_in'])) {
			$args = array_merge($args, array('post__not_in' => wp_parse_id_list($this->args['post__not_in'])));
		}
		
		$this->query = new WP_Query($args);
		
		$this->getItems();
		
		if ($shortcode_atts['name']) {
			if (count($this->reviews)) {
				$reviews_array = $this->reviews;
				$review = array_shift($reviews_array);
				
				$this->review = $review;
			}
		}
		
		// this is reset is really required after the loop ends
		wp_reset_postdata();
		remove_filter('post_limits', array($this, 'findOnlyOnePost'));
		
		apply_filters('w2rr_reviews_controller_construct', $this);
	}
	
	public function getItems() {
		while ($this->query->have_posts()) {
			$this->query->the_post();
	
			$review = w2rr_getReview(get_post());
		
			$this->reviews[get_the_ID()] = $review;
		}
		wp_reset_postdata();
		
		return $this->reviews;
	}
	
	public function getReviewsBlockClasses() {
		$classes[] = "w2rr-container-fluid";
		$classes[] = "w2rr-reviews-block";
		$classes[] = "w2rr-mobile-reviews-grid-" . get_option('w2rr_mobile_reviews_grid_columns');
		
		if ($this->args['reviews_view_type'] == 'grid') {
			$classes[] = "w2rr-reviews-grid";
			$classes[] = "w2rr-reviews-grid-" . $this->args['reviews_view_grid_columns'];
			if ($this->args['reviews_view_grid_masonry']) {
				$classes[] = "w2rr-reviews-grid-masonry";
			} else {
				$classes[] = "w2rr-reviews-grid-no-masonry";
			}
		} else {
			$classes[] = "w2rr-reviews-list-view";
		}
		
		$classes = apply_filters("w2rr_reviews_block_classes", $classes, $this);
	
		return implode(" ", $classes);
	}
	
	public function getReviewClasses() {
		$classes = array();

		return $classes;
	}
	
	public function printPaginatorButtons() {
		if (empty($this->args['hide_paginator'])) {
			if ($this->query->max_num_pages > 1) {
				if (get_option('w2rr_paginator_button') == 'paginator') {
					w2rr_renderPaginator($this->query, $this->hash, $this);
				} elseif (get_option('w2rr_paginator_button') == 'more_reviews') { ?>
					<div class="w2rr-row"><button class="w2rr-btn w2rr-btn-primary w2rr-btn-block w2rr-show-more-button" data-controller-hash="<?php w2rr_esc_e($this->hash); ?>"><?php esc_html_e('Show more reviews', 'w2rr'); ?></button></div> <?php 
				}
			}
		}
	}
}

add_filter('w2rr_reviews_order_args', 'w2rr_order_reviews', 10, 3);
function w2rr_order_reviews($order_args = array(), $defaults = array(), $include_GET_params = true) {
	global $w2rr_instance;

	if ($include_GET_params && isset($_GET['reviews_order_by']) && $_GET['reviews_order_by']) {
		$order_by = $_GET['reviews_order_by'];
		$order = w2rr_getValue($_GET, 'reviews_order', 'DESC');
	} else {
		if (isset($defaults['reviews_order_by']) && $defaults['reviews_order_by']) {
			$order_by = $defaults['reviews_order_by'];
			$order = w2rr_getValue($defaults, 'reviews_order', 'DESC');
		} else {
			$order_by = 'post_date';
			$order = 'DESC';
		}
	}

	$order_args['orderby'] = $order_by;
	$order_args['order'] = $order;

	if ($order_by == 'post_date') {
		$order_args['orderby'] = 'date';
	} elseif ($order_by == 'rating') {
		$order_args['orderby'] = 'meta_value_num';
		$order_args['meta_key'] = '_avg_rating';
	} elseif ($order_by == 'votes') {
		$order_args['orderby'] = 'meta_value_num';
		$order_args['meta_key'] = '_votes_sum';
	}

	return $order_args;
}

?>