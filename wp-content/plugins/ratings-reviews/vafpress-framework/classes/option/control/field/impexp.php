<?php

class W2RR_VP_Option_Control_Field_ImpExp extends W2RR_VP_Control_Field
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

	public function render()
	{
		$this->_setup_data();
		return W2RR_VP_View::instance()->load('option/impexp', $this->get_data());
	}

}

/**
 * EOF
 */