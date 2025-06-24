<?php

class W2RR_VP_Option_Parser
{

	public function parse_array_options($arr, $auto_group_naming)
	{

		$set = new W2RR_VP_Option_Control_Set();

		if(empty($arr['title']))
			$arr['title'] = 'Vafpress';
		if(empty($arr['logo']))
			$arr['logo']  = 'vp-logo.png';

		$set->set_title(isset($arr['title']) ? $arr['title'] : '')
		    ->set_logo(isset($arr['logo']) ? $arr['logo'] : '');

		$auto_menu_index  = 0;
		$auto_menu        = "the_menu_";

		// Loops trough all the menus
		if (!empty($arr['menus'])) foreach ($arr['menus'] as $menu)
		{
			// Create menu object and add to set
			$w2rr_vp_menu = new W2RR_VP_Option_Control_Group_Menu();

			if($auto_group_naming)
			{
				if(isset($menu['name']) and !empty($menu['name']))
				{
					$w2rr_vp_menu->set_name($menu['name']);
				}
				else
				{
					$w2rr_vp_menu->set_name($auto_menu . $auto_menu_index);
					$auto_menu_index++;
				}
			}

			$w2rr_vp_menu->set_title(isset($menu['title']) ? $menu['title'] : '')
			        ->set_icon(isset($menu['icon']) ? $menu['icon'] : '');

			$set->add_menu($w2rr_vp_menu);

			// Loops through every submenu in each menu
			if (!empty($menu['menus']) and is_array($menu['menus'])) foreach ($menu['menus'] as $submenu)
			{
				$w2rr_vp_submenu = new W2RR_VP_Option_Control_Group_Menu();

				if($auto_group_naming)
				{
					if(isset($submenu['name']) and !empty($submenu['name']))
					{
						$w2rr_vp_submenu->set_name($submenu['name']);
					}
					else
					{
						$w2rr_vp_submenu->set_name($auto_menu . $auto_menu_index);
						$auto_menu_index++;
					}
				}

				$w2rr_vp_submenu->set_title(isset($submenu['title']) ? $submenu['title'] : '')
				           ->set_icon(isset($submenu['icon']) ? $submenu['icon'] : '');

				$w2rr_vp_menu->add_menu($w2rr_vp_submenu);
				
				// Loops through every control in each submenu
				if (!empty($submenu['controls'])) foreach ($submenu['controls'] as $control)
				{
					if($control['type'] === 'section')
						$control = $this->parse_section($control);
					else
						$control = $this->parse_field($control);
					$w2rr_vp_submenu->add_control($control);
				}
			}
			else
			{
				// Loops through every control in each submenu
				if (!empty($menu['controls']) and is_array($menu['controls'])) foreach ($menu['controls'] as $control)
				{
					if($control['type'] === 'section')
						$control = $this->parse_section($control);
					else
						$control = $this->parse_field($control);
					$w2rr_vp_menu->add_control($control);
				}
			}
		}

		return $set;
	}

	private function parse_section($section)
	{
		$w2rr_vp_sec = new W2RR_VP_Option_Control_Group_Section();
		$w2rr_vp_sec->set_name(isset($section['name']) ? $section['name'] : '')
		       ->set_title(isset($section['title']) ? $section['title'] : '')
		       ->set_description(isset($section['description']) ? $section['description'] : '');

		if(isset($section['dependency']))
		{
			$func  = $section['dependency']['function'];
			$field = $section['dependency']['field'];
			$w2rr_vp_sec->set_dependency($func . '|' . $field);
		}

		// Loops through every field in each submenu
		if (!empty($section['fields'])) foreach ($section['fields'] as $field)
		{
			$w2rr_vp_field = $this->parse_field($field);
			$w2rr_vp_sec->add_field($w2rr_vp_field);
		}
		return $w2rr_vp_sec;
	}

	private function parse_field($field)
	{
		$class    = W2RR_VP_Util_Reflection::field_class_from_type($field['type']);
		$w2rr_vp_field = call_user_func("$class::withArray", $field);
		return $w2rr_vp_field;
	}

}

/**
 * EOF
 */