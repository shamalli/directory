<?php

abstract class w2dc_elementor_widget extends \Elementor\Widget_Base {
	
	protected function content_template() {
		echo '<div class="w2dc-elementor-widget-content-template">' . $this->get_title() . '</div>';
	}
	
	public function get_settings_for_display($setting_key = null) {
		
		$settings = parent::get_settings_for_display($setting_key);
		
		foreach ($settings AS $key=>$setting) {
			if (is_null($setting)) {
				unset($settings[$key]);
			}
		}
		
		return $settings;
	}
}