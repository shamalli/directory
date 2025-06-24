<?php

class w2rr_review_title_elementor_widget extends w2rr_elementor_widget {

	public function get_name() {
		return 'review_title';
	}

	public function get_title() {
		return esc_html__('Review title', 'w2rr');
	}

	public function get_icon() {
		return 'eicon-code';
	}
	
	public function get_categories() {
		return array('reviews-single-category');
	}
	
	protected function register_controls() {
	
		$this->start_controls_section(
				'content_section',
				array(
						'label' => esc_html__('Review title', 'w2rr'),
						'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				)
		);
		
		global $w2rr_review_title_widget_params;
		$controls = w2rr_elementor_convert_params($w2rr_review_title_widget_params);
		
		foreach ($controls AS $param_name=>$control) {
			$this->add_control($param_name, $control);
		}
	
		$this->end_controls_section();
	}
	
	protected function render() {
		
		global $w2rr_instance;
		
		$settings = $this->get_settings_for_display();
		
		$controller = new \w2rr_review_title_controller();
		$controller->init($settings);
		
		$w2rr_instance->frontend_controllers['webrr-review-title'][] = $controller;
		
		echo $controller->display();
	}
}

?>