<?php

class VP_W2THEME_Control_Field_TextArea extends VP_W2THEME_Control_Field
{

	public function __construct()
	{
		parent::__construct();
	}

	public static function withArray($arr = array(), $class_name = null)
	{
		if(is_null($class_name))
			$instance = new self();
		else
			$instance = new $class_name;
		$instance->_basic_make($arr);
		return $instance;
	}

	public function render($is_compact = false)
	{
		$this->_setup_data();
		$this->add_data('is_compact', $is_compact);
		return VP_W2THEME_View::instance()->load('control/textarea', $this->get_data());
	}

	public function set_value($_value)
	{
		$this->_value = $_value;
		return $this;
	}

}

/**
 * EOF
 */