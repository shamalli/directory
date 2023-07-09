<?php 

class w2dc_levels_table_controller extends w2dc_frontend_controller {
	public $levels = array();
	public $template_args = array();

	public function init($args = array()) {
		global $w2dc_instance;

		parent::init($args);
		
		$shortcode_atts = array_merge(array(
				'show_period' => 1,
				'show_sticky' => 1,
				'show_featured' => 1,
				'show_categories' => 1,
				'show_locations' => 1,
				'show_maps' => 1,
				'show_images' => 1,
				'show_videos' => 1,
				'columns_same_height' => 1,
				'columns' => 3,
				'levels' => null,
				'directory' => null,
				'options' => '',
		), $args);
		
		$this->args = $shortcode_atts;
		
		$directory = null;
		if ($this->args['directory']) {
			$directory = $w2dc_instance->directories->getDirectoryById($this->args['directory']);
		}
		if (!$directory) {
			$directory = $w2dc_instance->current_directory;
		}
		$this->template_args['directory'] = $directory;
		
		// 1=option=no;2=option=yes;
		if ($this->args['options']) {
			$options = $this->args['options'];
			$this->args['options'] = array();
				
			$options = explode(';', $options);
			foreach ($options AS $option) {
				if (count(explode('>', $option)) == 3) {
					$option_parts = explode('>', $option);
				} elseif (count(explode('=', $option)) == 3) {
					$option_parts = explode('=', $option);
				}
				if (count($option_parts) == 3) {
					$this->args['options'][$option_parts[0]][$option_parts[1]] = $option_parts[2];
				}
			}
		}

		$this->levels = $w2dc_instance->levels->levels_array;
		if ($this->args['levels']) {
			// from frontend controller
			$levels = $this->levels_ids;
			
			$this->levels = array_intersect_key($w2dc_instance->levels->levels_array, array_flip($levels));
		} elseif ($directory->levels) {
			$this->levels = array_intersect_key($w2dc_instance->levels->levels_array, array_flip($directory->levels));
		}
		
		$this->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'submitlisting_step_level.tpl.php');

		apply_filters('w2dc_frontend_controller_construct', $this);
	}

	public function display() {
		if ($this->levels) {
			$output =  w2dc_renderTemplate($this->template, $this->template_args, true);
			wp_reset_postdata();
	
			return $output;
		}
	}
}

?>