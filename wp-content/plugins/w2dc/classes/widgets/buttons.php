<?php

// @codingStandardsIgnoreFile

add_action('init', function() {
	global $w2dc_buttons_widget_params;
	$w2dc_buttons_widget_params = array(
			array(
					'type' => 'directories',
					'param_name' => 'directories',
					'heading' => esc_html__("Set specific directory for submit button", "w2dc"),
					'description' => esc_html__("Select some items to dispay submit buttons for each directory", "w2dc"),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_button_text',
					'value' => array(esc_html__('No', 'w2dc') => '0', esc_html__('Yes', 'w2dc') => '1'),
					'heading' => esc_html__('Hide button names, display only popups', 'w2dc'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'buttons',
					'value' => array(
							esc_html__('Submit button', 'w2dc') => 'submit',
							esc_html__('My bookmarks page link', 'w2dc') => 'favourites',
							esc_html__('Claim button (only on single listing page)', 'w2dc') => 'claim',
							esc_html__('Edit listing button (only on single listing page)', 'w2dc') => 'edit',
							esc_html__('Print listing button (only on single listing page)', 'w2dc') => 'print',
							esc_html__('Bookmark listing button (only on single listing page)', 'w2dc') => 'bookmark',
							esc_html__('Save PDF listing button (only on single listing page)', 'w2dc') => 'pdf',
							esc_html__('Logout button', 'w2dc') => 'logout',
					),
					'std' => array('submit', 'favourites', 'claim', 'edit', 'print', 'bookmark', 'pdf', 'logout'),
					'heading' => esc_html__('Select buttons to display', 'w2dc'),
					'description' => esc_html__('Most of buttons can be displayed only on single listings pages', 'w2dc'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'visibility',
					'heading' => esc_html__("Show only on directory pages", "w2dc"),
					'value' => 0,
					'description' => esc_html__("Otherwise it will load plugin's files on all pages", "w2dc"),
			),
	);
}, 0);

class w2dc_buttons_widget extends w2dc_widget {

	public function __construct() {
		global $w2dc_instance, $w2dc_buttons_widget_params;

		parent::__construct(
				'w2dc_buttons_widget',
				esc_html__('Directory widget - Buttons', 'w2dc')
		);

		$this->convertParams($w2dc_buttons_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $w2dc_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($w2dc_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
	
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="w2dc-content w2dc-widget w2dc-buttons-widget">';
			$controller = new w2dc_buttons_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>