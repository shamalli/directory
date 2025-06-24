<?php 

class w2rr_all_reviews_controller extends w2rr_frontend_controller {
	public $request_by = 'all_reviews_controller';

	public function init($args = array()) {
		global $w2rr_instance;
		
		parent::init($args);
		
		if (w2rr_isAllReviews()) {
			if ($target_post = $w2rr_instance->reviews_manager->setup_breadcrumbs($this)) {
				array_pop($this->breadcrumbs);
				$this->addBreadCrumbs(esc_html__('Reviews', 'w2rr'));
				$this->addBreadCrumbs(esc_html__('Reviews:', 'w2rr') . ' ' . $target_post->title());
				$this->page_title = esc_html__('Reviews:', 'w2rr') . ' ' . $target_post->title();
					
				$reviews_controller = new w2rr_reviews_controller;
				$reviews_controller->init(array_merge(array(
						'posts' => array($target_post->post->ID),
						'base_url' => w2rr_get_all_reviews_link($target_post),
						'perpage' => get_option('w2rr_reviews_number_per_page'),
						'all_reviews_page' => true,
						'reviews_view_type' => get_option('w2rr_views_switcher_default'),
						'reviews_view_grid_columns' => get_option('w2rr_reviews_view_grid_columns'),
						'reviews_view_grid_masonry' => get_option('w2rr_reviews_view_grid_masonry'),
				), $args));
				$this->add_template_args(array('reviews_controller' => $reviews_controller, 'target_post' => $target_post));
				$this->template = 'ratings_reviews/reviews_page.tpl.php';
			
				$this->base_url = w2rr_get_all_reviews_link($target_post);
				
				$this->all_reviews = true;
			}
		}
		
		// this is reset is really required after the loop ends
		wp_reset_postdata();
		
		apply_filters('w2rr_all_reviews_controller_construct', $this);
	}
}

?>