<?php

abstract class w2rr_widget extends WP_Widget {
	protected $fields = array();
	
	private static $is_JSforMultipleDropBox = false;

	public function __construct($id_base, $name, $description = '') {
		$options["description"] = $description;
		
		parent::__construct($id_base, $name, $options);
		
		$this->addField("textfield", "title", esc_html__("Title", "W2RR"));

		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_custom_style'), 9999);
		add_action('wp_enqueue_scripts', array($this, 'enqueue_dynamic_css'));

		add_action('siteorigin_panel_enqueue_admin_scripts', array($this, 'admin_enqueue_scripts'));
	}
	
	public function admin_enqueue_scripts() {
		global $w2rr_instance;
		
		$w2rr_instance->admin->admin_enqueue_scripts_styles('widgets.php');
	}
	
	public function wp_enqueue_scripts() {
		global $w2rr_instance;
		
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true)) {
				$w2rr_instance->enqueue_scripts_styles(true);
			}
		}
	}
	
	public function wp_enqueue_custom_style() {
		global $w2rr_instance;
		
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true)) {
				$w2rr_instance->enqueue_scripts_styles_custom(true);
			}
		}
	}
	
	public function enqueue_dynamic_css() {
		global $w2rr_instance;
		
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true)) {
				$w2rr_instance->enqueue_dynamic_css(true);
			}
		}
	}
	
	public function addField($type, $name = false, $label = false, $description = false, $options = array(), $std = false, $dependency = array()) {
		$field = new stdClass();
		
		$field->name = $name;
		$field->type = $type;
		$field->label = $label;
		$field->description = $description;
		$field->options = $options;
		$field->std = $std;
		$field->dependency = $dependency;

		$this->fields[] = $field;
	}

	public function convertParams($params) {
		foreach ($params AS $param) {
			$type = false;
			$name = false;
			$label = false;
			$description = false;
			$options = array();
			$std = false;
			$dependency = false;
			if (isset($param['type'])) {
				$type = $param['type'];
			}
			if (isset($param['param_name'])) {
				$name = $param['param_name'];
			}
			if (isset($param['heading'])) {
				$label = $param['heading'];
			}
			if (isset($param['description'])) {
				$description = $param['description'];
			}
			if (isset($param['value'])) {
				if (is_array($param['value'])) {
					$options = $param['value'];
				} else {
					$std = $param['value'];
				}
			}
			if (isset($param['std'])) {
				$std = $param['std'];
			}
			if (isset($param['dependency'])) {
				$dependency = $param['dependency'];
			}
			$this->addField($type, $name, $label, $description, $options, $std, $dependency);
		}
	}
	
	public function update($new_instance, $old_instance) {
		foreach($this->fields as $field){
			$field = (object) $field;
			
			if (isset($new_instance[$field->name])) {
				$old_instance[$field->name] = $new_instance[$field->name];
			} else {
				$old_instance[$field->name] = '';
			}
		}
		
		return $old_instance;
	}
	
	public function renderLabel($field, $id){
		if (!empty($field->label)) {
			echo "<label for=\"{$id}\">" . esc_html($field->label) . "</label>";
		}
	}

	public function renderDescription($field){
		if (!empty($field->description)) {
			echo "<span class=\"w2rr-widget-description\">" . esc_html($field->description) . "</span>";
		}
	}

	public function renderDependency($field){
		if ($field->dependency) {
			echo "<span class=\"w2rr-widget-dependency\" data-dependency-element=\"{$field->dependency['element']}\" data-dependency-value=\"{$field->dependency['value']}\"></span>";
		}
	}

	public function checkDependency($original_field, $instance){
		if ($original_field->dependency) {
			foreach ($this->fields AS $field) {
				$value = isset($instance[$field->name]) ? $instance[$field->name] : $field->std;
				if (is_array($value)) {
					if ($field->name == $original_field->dependency['element'] && !in_array($original_field->dependency['value'], $value)) {
						return "style=\"display:none\"";
					}
				} else {
					if ($field->name == $original_field->dependency['element'] && $value != $original_field->dependency['value']) {
						return "style=\"display:none\"";
					}
				}
			}
		}
	}
	
	public function form($instance) {
		echo '<script>
				(function($) {
					"use strict";
			
					$(function() {
							var inputs = $(".widget-content, .so-content").find("input, select").not(":input[type=text], :input[type=submit], :input[type=reset]");
							inputs.each(function() {
								$(this).on("change", function() {
									var input = $(this);
									var dependencies = input.parents(".widget-content, .so-content").find(".w2rr-widget-dependency");
									dependencies.each(function() {
										var name = $(this).data("dependency-element");
										var value = $(this).data("dependency-value");
										if (input.data("original-name") == name) {
											if (input.val() == value) {
												$(this).parent("p").show();
											} else {
												$(this).parent("p").hide();
											}
										}
									});
								});
							});
					});
				})(jQuery);
				</script>';
		
		foreach($this->fields as $key => $field){
			$field = (object) $field;
			
			$method_name = "render_{$field->type}_field";
			
			$this->$method_name($field, $instance);
		}
	}
	
	public function widget($args, $instance) {
		$this->render_widget($instance, $args);
	}
	
	abstract public function render_widget($instance, $args);
	
	public function render_textfield_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr($instance[$field->name]) : $field->std;
		
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		echo "<input class=\"widefat\" id=\"{$id}\" name=\"{$name}\" type=\"text\" value=\"{$value}\" />";
		$this->renderDescription($field);
		echo "</p>";
	}
	
	public function render_hidden_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr($instance[$field->name]) : $field->std;
		
		echo "<input id=\"{$id}\" name=\"{$name}\" type=\"hidden\" value=\"{$value}\" />";
	}

	public function render_dropdown_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr($instance[$field->name]) : null;
		$std = $field->std;
		
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		echo "<select id=\"{$id}\" name=\"{$name}\" class=\"widefat w2rr-widget-select-control\" data-original-name=\"{$field->name}\">";
		foreach ($field->options as $label=>$option_val){
			if (is_int($label)) {
				$label = $option_val;
			}

			if ((!is_null($value) && $option_val == $value) || (is_null($value) && $option_val === $std)) {
				$selected = " selected=\"selected\"";
			} else {
				$selected = "";
			}
			
			echo "<option value=\"{$option_val}\"{$selected}>{$label}</option>";
		}
		echo "</select>";
		$this->renderDescription($field, $id);
		echo "</p>";
	}
	
	public function render_textarea_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr($instance[$field->name]) : $field->std;
		
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		echo "<textarea id=\"{$id}\" name=\"{$name}\" style=\"display:block;width:100%;\">{$value}</textarea>";
		$this->renderDescription($field, $id);
		echo "</p>";
	}
	
	public function render_reviews_ordering_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? $instance[$field->name] : '';
		
		$ordering = w2rr_reviewsOrderingItems();
		
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);

		echo "<select id=\"{$id}\" name=\"{$name}\" class=\"widefat w2rr-widget-select-control\">";
		foreach ($ordering AS $ordering_item) {
			echo "<option value=\"{$ordering_item['value']}\" " . selected($value, $ordering_item['value']) . ">{$ordering_item['label']}</option>";
		}
		echo "</select>";
		$this->renderDescription($field, $id);
		echo "</p>";
	}
	
	public function outputJSforMultipleDropBox() {
		if (!self::$is_JSforMultipleDropBox) {
			$out = '<script>
					(function($) {
						"use strict";
				
						$(function() {
							$("body").on("change", ".w2rr-widget-select-multiple-control", function() {
								$(this).next("input").val($(this).val());
							})
						});
					})(jQuery);
					</script>';
			echo $out;
			
			self::$is_JSforMultipleDropBox = true;
		}
	}

	public function render_checkbox_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		if (!$field->options) {
			$value = isset($instance[$field->name]) ? $instance[$field->name] : $field->std;
		} else {
			$value = isset($instance[$field->name]) ? $instance[$field->name] : $field->std;
		}

		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		if (!$field->options) {
			$checked = "";
			if ($value == 1) {
				$checked = "checked = \"checked\"";
			}
			echo "<input id=\"{$id}\" name=\"{$name}\" type=\"checkbox\" value=\"1\" {$checked} data-original-name=\"{$field->name}\" />";
			$this->renderLabel($field, $id);
		} else {
			$this->renderLabel($field, $id);
			foreach ($field->options AS $option_name=>$key) {
				$checked = "";
				if (is_array($value) && in_array($key, $value)) {
					$checked = "checked = \"checked\"";
				}
				echo "<br />";
				echo "<label>";
				echo "<input name=\"{$name}[]\" type=\"checkbox\" value=\"{$key}\" {$checked}/>";
				echo esc_html($option_name);
				echo "</label>";
			}
		}
		$this->renderDescription($field, $id);
		echo "</p>";
	}

	public function render_colorpicker_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr(strip_tags($instance[$field->name])) : $field->std;

		echo '<script>
				(function($) {
					"use strict";
					$(function() {
						$(".w2rr-select-color").wpColorPicker({
							change: function(event, ui) {
								$(this).parents("form").find("input[type=submit]").trigger("change");
								$(this)
								.val(ui.color.toString())
								.trigger("change");
							}
						});
					});
				})(jQuery);
			</script>';
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		echo "<input
				type=\"text\"
				id=\"{$id}\"
				name=\"{$name}\"
				value=\"{$value}\"
				class=\"w2rr-select-color widefat\"
			/>";
		$this->renderDescription($field, $id);
		echo "</p>";
	}
	
	public function render_datefieldmin_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr(strip_tags($instance[$field->name])) : $field->std;
		if (!is_numeric($value)) {
			$value = strtotime($value);
		}

		$settings['field_id'] = $id;
		$settings['param_name'] = $name;
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		w2rr_renderTemplate('search_fields/fields/datetime_input_vc_min.tpl.php', array('settings' => $settings, 'value' => $value, 'dateformat' => w2rr_getDatePickerFormat()));
		$this->renderDescription($field, $id);
		echo "</p>";
	}

	public function render_datefieldmax_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? esc_attr(strip_tags($instance[$field->name])) : $field->std;
		if (!is_numeric($value)) {
			$value = strtotime($value);
		}

		$settings['field_id'] = $id;
		$settings['param_name'] = $name;
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		w2rr_renderTemplate('search_fields/fields/datetime_input_vc_max.tpl.php', array('settings' => $settings, 'value' => $value, 'dateformat' => w2rr_getDatePickerFormat()));
		$this->renderDescription($field, $id);
		echo "</p>";
	}
	
	public function render_post_type_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? $instance[$field->name] : '';
		
		$post_types = array(0 => esc_html__("- All -", "W2RR"));
	
		$_post_types = w2rr_getWorkingPostTypes();
		
		foreach ($_post_types AS $post_type) {
			if ($post_type_obj = get_post_type_object($post_type)) {
				$post_types[$post_type_obj->name] = $post_type_obj->label;
			}
		}
		
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		
		echo "<select id=\"{$id}\" name=\"{$name}\" class=\"widefat w2rr-widget-select-control\">";
		foreach ($post_types AS $post_type_name=>$post_type_label) {
		echo "<option value=\"{$post_type_name}\" " . selected($value, $post_type_name) . ">{$post_type_label}</option>";
		}
		echo "</select>";
		$this->renderDescription($field, $id);
		echo "</p>";
	}
	
	public function render_tax_field($field, $instance) {
		$id = $this->get_field_id($field->name);
		$name = $this->get_field_name($field->name);
		$value = isset($instance[$field->name]) ? $instance[$field->name] : '';
		
		$taxes = array(0 => esc_html__("- No tax -", "W2RR"));
		
		$_taxes = get_taxonomies(array(), 'objects');
		
		foreach ($_taxes AS $tax) {
			$taxes[$tax->name] = $tax->label;
		}
		
		echo "<p " . $this->checkDependency($field, $instance) . ">";
		$this->renderDependency($field);
		$this->renderLabel($field, $id);
		
		echo "<select id=\"{$id}\" name=\"{$name}\" class=\"widefat w2rr-widget-select-control\">";
		foreach ($taxes AS $tax_name=>$tax_label) {
		echo "<option value=\"{$tax_name}\" " . selected($value, $tax_name) . ">{$tax_label}</option>";
		}
		echo "</select>";
		$this->renderDescription($field, $id);
		echo "</p>";
	}

	public function render_hr_field($field, $instance) {
		echo "<hr/>";
	}
}

add_action('admin_enqueue_scripts', 'w2rr_widgets_enqueue_scripts');
function w2rr_widgets_enqueue_scripts($hook) {
	if ($hook == "widgets.php"){
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}

add_action('widgets_init', 'w2rr_register_widgets');
function w2rr_register_widgets() {
	foreach (get_declared_classes() as $class) {
		if (is_subclass_of($class, "w2rr_widget")) {
			register_widget($class);
		}
	}
}
