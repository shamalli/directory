<?php

// @codingStandardsIgnoreFile

class w2dc_category_page_elementor_widget extends w2dc_elementor_widget {

	public function get_name() {
		return 'category_page';
	}

	public function get_title() {
		return esc_html__('Category page', 'w2dc');
	}

	public function get_icon() {
		return 'eicon-single-page';
	}
	
	public function get_categories() {
		return array('directory-category-page-category');
	}
	
	protected function register_controls() {
	
		$this->start_controls_section(
				'content_section',
				array(
						'label' => esc_html__('Category page', 'w2dc'),
						'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				)
		);
		
		global $w2dc_category_page_widget_params;
		
		$controls = w2dc_elementor_convert_params($w2dc_category_page_widget_params);
		
		foreach ($controls AS $param_name=>$control) {
			$this->add_control($param_name, $control);
		}
	
		$this->end_controls_section();
	}
	
	protected function render() {
		
		global $w2dc_instance;
		
		$settings = $this->get_settings_for_display();
		
		$controller = new w2dc_directory_controller();
		$controller->init($settings, W2DC_CATEGORY_PAGE_SHORTCODE);
		
		echo $controller->display();
	}
}

?>