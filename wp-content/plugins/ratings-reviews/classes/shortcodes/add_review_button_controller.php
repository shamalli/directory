<?php 

/**
 *  [webrr-add-review-button] shortcode
 *
 *
 */
class w2rr_add_review_button_controller extends w2rr_frontend_controller {
	public $request_by = 'add_review_button_controller';

	public function init($args = array()) {
		global $w2rr_instance;
		
		parent::init($args);
		
		$this->args = array_merge(array(
				'post' => '',
				'text' => esc_html__('Add Review', 'W2RR')
		), $args);
	
		$target_post = w2rr_getTargetPost($this->args['post']);
		
		// something went wrong, we can not find target post
		if (empty($target_post)) {
			return ;
		}
		
		// we do not need to place review on Selected pages
		if (in_array($target_post->post->ID, w2rr_getSelectedPages())) {
			return ;
		}
		
		// post should be one of working post types
		if (!in_array(get_post_type($target_post->post), w2rr_getWorkingPostTypes())) {
			return ;
		}
		
		$this->add_template_args(array(
				'post_id' => $target_post->post->ID,
				'text' => $this->args['text'],
		));
		$this->template = 'ratings_reviews/add_review_button.tpl.php';
	}
	
	public function display() {
		
		$target_post = w2rr_getTargetPost($this->args['post']);
		
		// we do not need to place review on Selected pages
		if ($target_post && in_array($target_post->post->ID, w2rr_getSelectedPages())) {
			return esc_html__("This is special page you have selected to be in the settings. You can not add a review for this page!");
		}
		
		$output =  w2rr_renderTemplate($this->template, $this->template_args, true);
		wp_reset_postdata();
		
		return $output;
	}
}

?>