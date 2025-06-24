<?php

// @codingStandardsIgnoreFile

class w2dc_listing_comments_elementor_widget extends w2dc_elementor_widget {

	public function get_name() {
		return 'listing_comments';
	}

	public function get_title() {
		return esc_html__('Listing Comments', 'w2dc');
	}

	public function get_icon() {
		return 'eicon-code';
	}
	
	public function get_categories() {
		return array('directory-single-category');
	}
	
	protected function register_controls() {
	
		$this->start_controls_section(
				'content_section',
				array(
						'label' => esc_html__('Listing comments', 'w2dc'),
						'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				)
		);
		
		global $w2dc_listing_comments_widget_params;
		
		$controls = w2dc_elementor_convert_params($w2dc_listing_comments_widget_params);
		
		foreach ($controls AS $param_name=>$control) {
			$this->add_control($param_name, $control);
		}
	
		$this->end_controls_section();
	}
	
	protected function render() {
		
		$settings = $this->get_settings_for_display();
		
		$controller = new w2dc_listing_comments_controller();
		$controller->init($settings);
		echo $controller->display();
	}
}

?>