<?php

class W2DC_VP_Util_Reflection
{

	public static function is_multiselectable($object)
	{
		if(is_object($object))
		{
			if($object instanceof W2DC_VP_MultiSelectable)
				return true;
		}
		elseif(is_string($object))
		{
			$class = self::field_class_from_type($object);
			if(function_exists('class_implements'))
			{
				if(class_exists($class))
				{
					$interfaces = class_implements($class);
					if(isset($interfaces['W2DC_VP_MultiSelectable']))
						return true;	
				}
				else
				{
					return false;
				}
			}
			else
			{
				$dummy = new $class;
				if($dummy instanceof W2DC_VP_MultiSelectable)
					return true;
				unset($dummy);
			}
		}
		return false;
	}


	public static function field_type_from_class($class)
	{
		$prefix = apply_filters('w2dc_vp_field_type_from_class_prefix', array('W2DC_VP_Control_Field_', 'W2DC_VP_Option_Control_Field_'));
		return strtolower(str_replace($prefix, '', $class));
	}

	public static function field_class_from_type($type)
	{
		// default prefix
		$prefix = 'W2DC_VP_Control_Field_';

		// special case
		if($type === 'impexp')
			$prefix = 'W2DC_VP_Option_Control_Field_';

		$prefix = apply_filters( 'w2dc_vp_field_class_from_type_prefix', $prefix, $type );
			
		$class = $prefix . $type;
		return $class;
	}

}