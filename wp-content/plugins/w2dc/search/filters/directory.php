<?php

add_filter("w2dc_query_args", "w2dc_query_args_directory", 10, 2);
function w2dc_query_args_directory($q_args, $args) {
	global $w2dc_instance;
	
	if (!empty($args['directories'])) {
		if ($directories_ids = array_filter(explode(',', $args['directories']), 'trim')) {
			$q_args = w2dc_set_directory_args($q_args, $directories_ids);
		}
	} elseif (!empty($args['id'])) {
		$q_args = w2dc_set_directory_args($q_args, $args['id']);
			
	} elseif (!empty($args['directory'])) {
		$q_args = w2dc_set_directory_args($q_args, $args['directory']);
			
	}
	
	return $q_args;
}

?>