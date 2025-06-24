<?php

/**
 * For singleton accessor, use W2RR_VP_WP_MassEnqueuer class instead.
 */
class W2RR_VP_WP_Enqueuer
{

	private $_loaders = array();

	private $_id;

	public function __construct()
	{
		$this->_id = spl_object_hash($this);
		$loader    = new W2RR_VP_WP_Loader();
		add_action('w2rr_vp_loader_register_' . $this->_id, array($loader, 'register'), 10, 2);
	}

	public function add_loader($loader)
	{
		$this->_loaders[] = $loader;
	}

	public function register()
	{
		add_action('admin_enqueue_scripts', array($this, 'register_caller'));
	}

	public function register_caller($hook_suffix)
	{
		do_action('w2rr_vp_loader_register_' . $this->_id, $this->_loaders, $hook_suffix);
	}

}