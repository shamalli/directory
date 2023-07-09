<?php

class w2rr_post_reviews_elementor_widget extends w2rr_elementor_widget {

	public function get_name() {
		return 'post_reviews';
	}

	public function get_title() {
		return __('Post reviews', 'W2RR');
	}

	public function get_icon() {
		return 'eicon-code';
	}
	
	public function get_categories() {
		return array('post-reviews-category');
	}
	
	protected function register_controls() {
	
		$this->start_controls_section(
				'content_section',
				array(
						'label' => esc_html__('Post reviews', 'W2RR'),
						'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				)
		);
		
		global $w2rr_post_reviews_widget_params;
		$controls = w2rr_elementor_convert_params($w2rr_post_reviews_widget_params);
		
		foreach ($controls AS $param_name=>$control) {
			$this->add_control($param_name, $control);
		}
	
		$this->end_controls_section();
	}
	
	protected function render() {
		
		global $w2rr_instance;
		
		$settings = $this->get_settings_for_display();
		
		$settings['target_post'] = 1;
		
		$controller = new \w2rr_reviews_controller();
		$controller->init($settings);
		
		$w2rr_instance->frontend_controllers['webrr-reviews'][] = $controller;
		
		echo $controller->display();
	}
}

?>