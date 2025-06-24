<?php

class w2rr_elementor_widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/elementor_widget.php');
		
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/reviews.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/add_review_button.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/post_rating.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/post_ratings_overall.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/post_reviews_counter.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/post_reviews.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_header.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_content.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_comments.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_gallery.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_votes.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_title.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_rating.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/review_ratings_overall.php');
		require_once(W2RR_PATH . 'classes/widgets/elementor/widgets/slider.php');

		add_action('elementor/widgets/register', array($this, 'register_widgets'));
	}

	public function register_widgets() {

		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_reviews_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_add_review_button_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_post_rating_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_post_ratings_overall_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_post_reviews_counter_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_post_reviews_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_header_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_content_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_comments_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_gallery_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_votes_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_title_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_rating_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_review_ratings_overall_elementor_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new w2rr_slider_elementor_widget() );
	}

}

function w2rr_load_elementor_widgets() {
	
	if (!defined('ELEMENTOR_VERSION')) {
		return;
	}

	w2rr_elementor_widgets::get_instance();
}
add_action('init', 'w2rr_load_elementor_widgets');

function w2rr_add_elementor_widget_categories($elements_manager) {

	$elements_manager->add_category(
			'reviews-category',
			array(
				'title' => esc_html__('Reviews elements', 'w2rr'),
				'icon' => 'eicon-code',
			)
	);
	
	$elements_manager->add_category(
			'post-reviews-category',
			array(
				'title' => esc_html__('Post reviews elements', 'w2rr'),
				'icon' => 'eicon-code',
			)
	);
	
	$elements_manager->add_category(
			'reviews-single-category',
			array(
				'title' => esc_html__('Review single page', 'w2rr'),
				'icon' => 'eicon-code',
			)
	);
}
add_action('elementor/elements/categories_registered', 'w2rr_add_elementor_widget_categories');


function w2rr_elementor_convert_params($params) {
	
	$el_params = array();
	
	foreach ($params AS $param) {
		
		$new_param = array(
				'type' => \Elementor\Controls_Manager::TEXT,
		);
		
		if (!empty($param['heading'])) {
			$new_param['label'] = $param['heading'];
		}
		if (!empty($param['description'])) {
			$new_param['description'] = $param['description'];
		}
		if (!empty($param['value'])) {
			$new_param['default'] = $param['value'];
		}
		
		switch ($param['type']) {
			
			case 'textarea':
				$new_param['type'] = \Elementor\Controls_Manager::TEXTAREA;
			break;
				
			case 'post_type':
				$new_param['options'] = w2rr_elementor_get_post_types();
				$new_param['type'] = \Elementor\Controls_Manager::SELECT;
			break;
			
			case 'tax':
				$new_param['options'] = w2rr_elementor_get_taxes();
				$new_param['type'] = \Elementor\Controls_Manager::SELECT;
			break;
			
			case 'reviews_ordering':
				$new_param['options'] = w2rr_elementor_get_ordering();
				$new_param['type'] = \Elementor\Controls_Manager::SELECT;
			break;
			
			case 'dropdown':
				if (!empty($param['value']) && is_array($param['value'])) {
					$new_param['options'] = array_flip($param['value']);
					$new_param['type'] = \Elementor\Controls_Manager::SELECT;
				}
				
				break;
				
			case 'checkbox':
				if (!empty($param['value']) && is_array($param['value'])) {
					if (count($param['value']) == 2) {
						$new_param['options'] = array_flip($param['value']);
						$new_param['type'] = \Elementor\Controls_Manager::SELECT;
					} else {
						$new_param['options'] = array_flip($param['value']);
						$new_param['type'] = \Elementor\Controls_Manager::SELECT2;
						$new_param['multiple'] = true;
						$new_param['default'] = array();
					}
				} elseif(!is_array($param['value'])) {
					$new_param['type'] = \Elementor\Controls_Manager::SWITCHER;
				}
				
			break;
		}
		
		if (!empty($param['std'])) {
			$new_param['default'] = $param['std'];
		} else {
			if ($new_param['type'] == \Elementor\Controls_Manager::SELECT && !empty($new_param['options'])) {
				$_options = $new_param['options'];
				reset($_options);
				$new_param['default'] = key($_options) . '';
			}
		}
		
		if (!empty($param['dependency'])) {
			$dep_param_name = $param['dependency']['element'];
			$dep_param_value = $param['dependency']['value'];
			$new_param['condition'] = array($dep_param_name => $dep_param_value);
		}
		
		$new_param['label_block'] = true;
		
		$el_params[$param['param_name']] = $new_param;
	}
	
	return $el_params;
}

function w2rr_elementor_get_ordering() {
	
	$ordering = array(0 => esc_html__("- Default -", "w2rr"));
	
	$_ordering = w2rr_reviewsOrderingItems();
	
	foreach ($_ordering AS $ordering_item) {
		$ordering[$ordering_item['value']] = $ordering_item['label'];
	}
	
	return $ordering;
}

function w2rr_elementor_get_taxes() {
	
	$taxes = array(0 => esc_html__("- No tax -", "w2rr"));
	
	$_taxes = get_taxonomies(array(), 'objects');
	
	foreach ($_taxes AS $tax) {
		$taxes[$tax->name] = $tax->label;
	}
	
	return $taxes;
}

function w2rr_elementor_get_post_types() {
	
	$post_types = array(0 => esc_html__("- All -", "w2rr"));
	
	$_post_types = w2rr_getWorkingPostTypes();
	
	foreach ($_post_types AS $post_type) {
		if ($post_type_obj = get_post_type_object($post_type)) {
			$post_types[$post_type_obj->name] = $post_type_obj->label;
		}
	}
	
	return $post_types;
}

?>