<?php

class VP_W2THEME_Option_Parser
{

	public function parse_array_options($arr, $auto_group_naming)
	{

		$set = new VP_W2THEME_Option_Control_Set();

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
			$vp_w2theme_menu = new VP_W2THEME_Option_Control_Group_Menu();

			if($auto_group_naming)
			{
				if(isset($menu['name']) and !empty($menu['name']))
				{
					$vp_w2theme_menu->set_name($menu['name']);
				}
				else
				{
					$vp_w2theme_menu->set_name($auto_menu . $auto_menu_index);
					$auto_menu_index++;
				}
			}

			$vp_w2theme_menu->set_title(isset($menu['title']) ? $menu['title'] : '')
			        ->set_icon(isset($menu['icon']) ? $menu['icon'] : '');

			$set->add_menu($vp_w2theme_menu);

			// Loops through every submenu in each menu
			if (!empty($menu['menus']) and is_array($menu['menus'])) foreach ($menu['menus'] as $submenu)
			{
				$vp_w2theme_submenu = new VP_W2THEME_Option_Control_Group_Menu();

				if($auto_group_naming)
				{
					if(isset($submenu['name']) and !empty($submenu['name']))
					{
						$vp_w2theme_submenu->set_name($submenu['name']);
					}
					else
					{
						$vp_w2theme_submenu->set_name($auto_menu . $auto_menu_index);
						$auto_menu_index++;
					}
				}

				$vp_w2theme_submenu->set_title(isset($submenu['title']) ? $submenu['title'] : '')
				           ->set_icon(isset($submenu['icon']) ? $submenu['icon'] : '');

				$vp_w2theme_menu->add_menu($vp_w2theme_submenu);
				
				// Loops through every control in each submenu
				if (!empty($submenu['controls'])) foreach ($submenu['controls'] as $control)
				{
					if($control['type'] === 'section')
						$control = $this->parse_section($control);
					else
						$control = $this->parse_field($control);
					$vp_w2theme_submenu->add_control($control);
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
					$vp_w2theme_menu->add_control($control);
				}
			}
		}

		return $set;
	}

	private function parse_section($section)
	{
		$vp_w2theme_sec = new VP_W2THEME_Option_Control_Group_Section();
		$vp_w2theme_sec->set_name(isset($section['name']) ? $section['name'] : '')
		       ->set_title(isset($section['title']) ? $section['title'] : '')
		       ->set_description(isset($section['description']) ? $section['description'] : '');

		if(isset($section['dependency']))
		{
			$func  = $section['dependency']['function'];
			$field = $section['dependency']['field'];
			$vp_w2theme_sec->set_dependency($func . '|' . $field);
		}

		// Loops through every field in each submenu
		if (!empty($section['fields'])) foreach ($section['fields'] as $field)
		{
			$vp_w2theme_field = $this->parse_field($field);
			$vp_w2theme_sec->add_field($vp_w2theme_field);
		}
		return $vp_w2theme_sec;
	}

	private function parse_field($field)
	{
		$class    = VP_W2THEME_Util_Reflection::field_class_from_type($field['type']);
		$vp_w2theme_field = call_user_func("$class::withArray", $field);
		return $vp_w2theme_field;
	}

}

/**
 * EOF
 */