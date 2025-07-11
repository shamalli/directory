<?php

/**
 * For singleton accessor, use W2RR_VP_WP_MassEnqueuer class instead.
 */
class W2RR_VP_WP_MassEnqueuer
{
	private static $_instance = null;

	public static function instance()
	{
		if(self::$_instance == null)
		{
			self::$_instance = new W2RR_VP_WP_Enqueuer();
		}
		return self::$_instance;
	}

}