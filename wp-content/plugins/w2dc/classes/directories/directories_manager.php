<?php

// @codingStandardsIgnoreFile

class w2dc_directories_manager {
	
	public function __construct() {
		w2dc_directories_manager_init($this);
		
		add_filter('admin_init', array($this, 'init'));
		add_filter('w2dc_build_settings', array($this, 'add_slugs_warning_in_settings'), 100);
	}
	
	public function init() {
		if (isset($_GET['action']) && $_GET['action'] == 'add') {
			$this->addOrEditDirectoryValidation();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['directory_id'])) {
			$this->addOrEditDirectoryValidation($_GET['directory_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['directory_id'])) {
			$this->deleteDirectoryValidation($_GET['directory_id']);
		}
	}

	public function menu() {
		add_submenu_page('w2dc_settings',
			esc_html__('Listings directories', 'w2dc'),
			esc_html__('Listings directories', 'w2dc'),
			'manage_options',
			'w2dc_directories',
			array($this, 'w2dc_manage_directories_page')
		);
	}
	
	public function add_slugs_warning_in_settings($options) {
		
		foreach ($options['template']['menus']['general']['controls']['title_slugs']['fields'] AS $key=>$title_slugs_fields) {
			if ($title_slugs_fields['name'] == 'w2dc_permalinks_structure') {
				break;
			}
		}
		
		array_splice($options['template']['menus']['general']['controls']['title_slugs']['fields'], $key, 0, array(
			array(
					'type' => 'notebox',
					'name' => 'slugs_warning',
					'label' => esc_html__('Notice about slugs:', 'w2dc'),
					'description' => sprintf(esc_html__('You can manage listings, categories, locations and tags slugs in <a href="%s">directories settings</a>', 'w2dc'), admin_url('admin.php?page=w2dc_directories')),
					'status' => 'warning',
			)
		));
		
		return $options;
	}

	public function w2dc_manage_directories_page() {
		if (isset($_GET['action']) && $_GET['action'] == 'add') {
			$this->addOrEditDirectory();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['directory_id'])) {
			$this->addOrEditDirectory($_GET['directory_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['directory_id'])) {
			$this->deleteDirectory($_GET['directory_id']);
		} else {
			$this->showDirectoriesTable();
		}
	}
	
	public function showDirectoriesTable() {
		global $w2dc_instance;
		
		$directories = $w2dc_instance->directories;

		$directories_table = new w2dc_manage_directories_table();
		$directories_table->prepareItems($directories);

		w2dc_renderTemplate('directories/directories_table.tpl.php', array('directories_table' => $directories_table));
	}
	
	public function addOrEditDirectoryValidation($directory_id = null) {
		global $w2dc_instance;

		$directories = $w2dc_instance->directories;
		
		if (!$directory = $directories->getDirectoryById($directory_id)) {
			$directory = new w2dc_directory();
		}

		if (w2dc_getValue($_POST, 'submit') && wp_verify_nonce(w2dc_getValue($_POST, 'w2dc_directories_nonce'), W2DC_PATH)) {
			$validation = new w2dc_form_validation();
			$validation->set_rules('name', esc_html__('Directory name', 'w2dc'), 'required');
			$validation->set_rules('single', esc_html__('Single form', 'w2dc'), 'required');
			$validation->set_rules('plural', esc_html__('Plural form', 'w2dc'), 'required');
			$validation->set_rules('listing_slug', esc_html__('Listing slug', 'w2dc'), 'alpha_dash');
			$validation->set_rules('category_slug', esc_html__('Category slug', 'w2dc'), 'alpha_dash');
			$validation->set_rules('location_slug', esc_html__('Location slug', 'w2dc'), 'alpha_dash');
			$validation->set_rules('tag_slug', esc_html__('Tag slug', 'w2dc'), 'alpha_dash');
			$validation->set_rules('categories', esc_html__('Assigned categories', 'w2dc'));
			$validation->set_rules('locations', esc_html__('Assigned locations', 'w2dc'));
			$validation->set_rules('levels', esc_html__('Levels', 'w2dc'));
			apply_filters('w2dc_directory_validation', $validation);
		
			if ($validation->run() && $this->checkSlugs($validation->result_array())) {
				if ($directory->id) {
					if ($directories->saveDirectoryFromArray($directory_id, $validation->result_array())) {
						w2dc_addMessage(esc_html__('Directory was updated successfully!', 'w2dc'));
					}
				} else {
					if ($directories->createDirectoryFromArray($validation->result_array())) {
						w2dc_addMessage(esc_html__('Directory was created succcessfully!', 'w2dc'));
					}
				}
				wp_redirect(admin_url('admin.php?page=w2dc_directories'));
				die();
			} else {
				$directory->buildDirectoryFromArray($validation->result_array());
				w2dc_addMessage($validation->error_array(), 'error');
		
				if ($directory_id) {
					wp_redirect(admin_url('admin.php?page=w2dc_directories&action=edit&directory_id='.$directory_id));
				} else {
					wp_redirect(admin_url('admin.php?page=w2dc_directories&action=add&directory_id='.$directory_id));
				}
				die();
			}
		}
	}
	
	public function addOrEditDirectory($directory_id = null) {
		global $w2dc_instance;

		$directories = $w2dc_instance->directories;
		
		if (!$directory = $directories->getDirectoryById($directory_id)) {
			$directory = new w2dc_directory();
		}

		w2dc_renderTemplate('directories/add_edit_directory.tpl.php', array('directory' => $directory, 'directory_id' => $directory_id));
	}
	
	public function deleteDirectoryValidation($directory_id) {
		global $w2dc_instance;

		$directories = $w2dc_instance->directories;
		if ($directory = $directories->getDirectoryById($directory_id)) {
			if (w2dc_getValue($_POST, 'submit') && ($new_directory_id = w2dc_getValue($_POST, 'new_directory')) && is_numeric($new_directory_id)) {
				if ($directories->deleteDirectory($directory_id, $new_directory_id)) {
					w2dc_addMessage(esc_html__('Directory was deleted successfully!', 'w2dc'));
				}

				wp_redirect(admin_url('admin.php?page=w2dc_directories'));
				die();
			}
		}
	}
	
	public function deleteDirectory($directory_id) {
		global $w2dc_instance;

		$directories = $w2dc_instance->directories;
		if ($directory = $directories->getDirectoryById($directory_id)) {
			$question = sprintf(esc_html__('Are you sure you want delete "%s" directory?', 'w2dc'), $directory->name);
			$question .= '<br /><br />' . esc_html__('Existing listings will be moved to directory:', 'w2dc');
			foreach ($w2dc_instance->directories->directories_array AS $directory) {
				if ($directory->id != $directory_id) {
					$question .= '<br />' . '<label><input type="radio" name="new_directory" value="' . $directory->id . '" ' . checked($directory->id, $w2dc_instance->directories->getDefaultDirectory()->id, false) . ' />' . $directory->name . '</label>';
				}
			}
				
			w2dc_renderTemplate('delete_question.tpl.php', array('heading' => esc_html__('Delete directory', 'w2dc'), 'question' => $question, 'item_name' => $directory->name));
		} else {
			$this->showDirectoriesTable();
		}
	}
	
	public function checkSlugs($validation_results) {
		global $w2dc_instance;
		
		$slugs_to_check = array(
				$validation_results['listing_slug'],
				$validation_results['category_slug'],
				$validation_results['location_slug'],
				$validation_results['tag_slug'],
		);
		
		if (count($slugs_to_check) !== count(array_unique($slugs_to_check))) {
			w2dc_addMessage(esc_html__('All slugs must be unique and different!', 'w2dc'), 'error');
			return false;
		}
		
		foreach ($w2dc_instance->index_pages_all AS $page) {
			if (in_array($page['slug'], $slugs_to_check)) {
				w2dc_addMessage(esc_html__('One or several slugs equal to the slug of directory page! This may cause problems.', 'w2dc'), 'error');
				return false;
			}
		}
		return true;
	}
}

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class w2dc_manage_directories_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => esc_html__('directory', 'w2dc'),
				'plural' => esc_html__('directories', 'w2dc'),
				'ajax' => false
		));
	}

	public function get_columns($directories = array()) {
		$columns = array(
				'id' => esc_html__('ID', 'w2dc'),
				'directory_name' => esc_html__('Name', 'w2dc'),
				'shortcode' => esc_html__('Shortcode', 'w2dc'),
				'page' => esc_html__('Page', 'w2dc'),
				'slugs' => esc_html__('Slugs', 'w2dc'),
				'visibility' => esc_html__('Visibility', 'w2dc'),
		);
		$columns = apply_filters('w2dc_directory_table_header', $columns, $directories);

		return $columns;
	}
	
	public function getItems($directories) {
		$items_array = array();
		$first_directory = $directories->getDefaultDirectory();
		foreach ($directories->directories_array as $id=>$directory) {
			if ($id == $first_directory->id) {
				$shortcode = '[webdirectory]';
			} else {
				$shortcode = '[webdirectory id="' . $directory->id . '"]';
			}
			
			if ($directory->url) {
				$directory_url = sprintf('<a href="%s" target="_blank">%s</a>', $directory->url, $directory->url);
			} else {
				$directory_url = '<strong>' . esc_html__('Required page is missing!', 'w2dc') . '</strong>';
			}
			
			$items_array[$id] = array(
					'directory' => $directory,
					'id' => $directory->id,
					'directory_name' => $directory->name,
					'shortcode' => $shortcode,
					'page' => $directory_url,
					'categories' => $directory->categories,
					'locations' => $directory->locations,
					'levels' => $directory->levels,
			);

			$items_array[$id] = apply_filters('w2dc_directory_table_row', $items_array[$id], $directory);
		}
		return $items_array;
	}

	public function prepareItems($directories) {
		$this->_column_headers = array($this->get_columns($directories), array(), array());
		
		$this->items = $this->getItems($directories);
	}
	
	public function column_slugs($item) {
		$slugs[] = $item['directory']->listing_slug;
		$slugs[] = $item['directory']->category_slug;
		$slugs[] = $item['directory']->location_slug;
		$slugs[] = $item['directory']->tag_slug;
		
		return implode('<br />', $slugs);
	}
	
	public function column_directory_name($item) {
		global $w2dc_instance;

		$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&directory_id=%d">' . esc_html__('Edit', 'w2dc') . '</a>', $_GET['page'], 'edit', $item['id']),
				'delete' => sprintf('<a href="?page=%s&action=%s&directory_id=%d">' . esc_html__('Delete', 'w2dc') . '</a>', $_GET['page'], 'delete', $item['id']),
		);
		
		if ($item['id'] == $w2dc_instance->directories->getDefaultDirectory()->id) {
			unset($actions['delete']);
		}
		
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&directory_id=%d">' . $item['directory_name'] . '</a>', $_GET['page'], 'edit', $item['id']), $this->row_actions($actions));
	}
	
	public function column_visibility($item) {
		$html = array();
		if (empty($item['categories'])) {
			$html[] = '<img src="' . W2DC_RESOURCES_URL . 'images/accept.png" /> ' . esc_html__('All Categories', 'w2dc');
		} else {
			$html[] = '<img src="' . W2DC_RESOURCES_URL . 'images/delete.png" /> ' . esc_html__('Partial Categories', 'w2dc');
		}
		if (empty($item['locations'])) {
			$html[] = '<hr /><img src="' . W2DC_RESOURCES_URL . 'images/accept.png" /> ' . esc_html__('All Locations', 'w2dc');
		} else {
			$html[] = '<hr /><img src="' . W2DC_RESOURCES_URL . 'images/delete.png" /> ' . esc_html__('Partial Locations', 'w2dc');
		}	
		if (empty($item['levels'])) {
			$html[] = '<hr /><img src="' . W2DC_RESOURCES_URL . 'images/accept.png" /> ' . esc_html__('All Levels', 'w2dc');
		} else {
			$html[] = '<hr /><img src="' . W2DC_RESOURCES_URL . 'images/delete.png" /> ' . esc_html__('Partial Levels', 'w2dc');
		}
		
		$html = apply_filters('w2dc_directories_in_pages_options', $html, $item);
		
		if ($html)
			return implode('<br />', $html);
		else
			return ' ';
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}
	
	function no_items() {
		esc_html__('No directories found.', 'w2dc');
	}
}

?>