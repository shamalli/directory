<?php

// @codingStandardsIgnoreFile

class w2dc_csv_manager {
	public $menu_page_hook;
	
	public $test_mode = false;
	
	public $log = array('errors' => array(), 'messages' => array());
	public $header_columns = array();
	public $rows = array();
	public $collated_fields = array();
	
	public $csv_file_name;
	public $images_dir;
	public $import_type;
	public $export_type;
	public $import_export_helper;
	public $columns_separator;
	public $values_separator;
	public $if_term_not_found;
	public $selected_user;
	public $do_geocode;
	public $is_claimable;
	public $users = array();
	public $users_logins = array();
	public $users_emails = array();
	public $users_ids = array();
	
	public $collation_fields;
	
	public function __construct() {
		add_action('admin_init', array($this, 'createHelper'));
		
		// Export
		if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'w2dc_csv_import' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'export_settings' && isset($_REQUEST['csv_export'])) {
			add_action('admin_init', array($this, 'csvExport'));
		}
		// Export Images
		if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'w2dc_csv_import' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'export_settings' && isset($_REQUEST['export_images'])) {
			add_action('admin_init', array($this, 'exportImages'));
		}

		add_action('admin_menu', array($this, 'menu'));
	}
	
	public function menu() {
		if (defined('W2DC_DEMO') && W2DC_DEMO) {
			$capability = 'publish_posts';
		} else {
			$capability = 'manage_options';
		}

		$this->menu_page_hook = add_submenu_page('w2dc_settings',
			esc_html__('CSV Import/Export', 'w2dc'),
			esc_html__('CSV Import/Export', 'w2dc'),
			$capability,
			'w2dc_csv_import',
			array($this, 'w2dc_csv_import')
		);
	}
	
	public function setImportType($import_type) {
		$this->import_type = $import_type;
	}
	
	public function createHelper() {
		if (!$this->import_type) {
			$this->import_type = w2dc_getValue($_POST, 'import_type');
		}
		if ($this->import_type == 'create_listings' || $this->import_type == 'update_listings') {
			$this->import_export_helper = new w2dc_csv_import_export_listings($this);
		}
		
		if (!$this->export_type) {
			$this->export_type = w2dc_getValue($_POST, 'export_type');
		}
		if ($this->export_type == 'export_listings') {
			$this->import_export_helper = new w2dc_csv_import_export_listings($this);
		}
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'geocode_locations') {
			$this->import_export_helper = new w2dc_csv_import_export_listings($this);
		}
	}
	
	public function buildCollationColumns() {
		$this->import_export_helper->buildCollationColumns();
	}
	
	public function w2dc_csv_import() {
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'geocode_locations') {
			// GeoCode Locations
			$this->geocodeLocationsProcess();
		} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'import_settings') {
			// 2nd Step Import
			$this->csvCollateColumns();
		} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'import_collate' && isset($_REQUEST['csv_file_name'])) {
			// 3rd Step Import
			$this->csvImport();
		} elseif (!isset($_REQUEST['action'])) {
			// 1st Step Import
			$this->csvImportSettings();
		}
	}
	
	public function geocodeLocationsProcess() {
		
		$this->do_geocode = true;
		
		$this->import_export_helper->geocodeLocationsProcess();
	
		$this->csvImportSettings();
	}
	
	// 1st Step
	public function csvImportSettings($vars = array()) {

		w2dc_renderTemplate('csv_manager/import_settings.tpl.php', $vars);
	}

	// 2nd Step
	public function csvCollateColumns() {
		$this->buildCollationColumns();
		
		// test geolocation
		$w2dc_locationGeoname = new w2dc_locationGeoname();
		$geolocation_response = $w2dc_locationGeoname->geocodeRequest('Amphitheatre Parkway Mountain View, CA 94043', 'test');
		if (is_wp_error($geolocation_response)) {
			$debug_page = '<a href="'.admin_url('admin.php?page=w2dc_debug').'">' . esc_html__('More info at the debug page.', 'w2dc') . '</a>';
			w2dc_addMessage(esc_html__('Geolocation service does not work. If you are going to import addresses in CSV file, they should have geo coordinates. Otherwise map markers will not be created and the search will not work!', 'w2dc') . ' ' . $debug_page, 'error');
		}
		
		$users = get_users(array('orderby' => 'ID', 'fields' => array('ID', 'user_login')));

		if ((w2dc_getValue($_POST, 'submit') || w2dc_getValue($_POST, 'goback')) && wp_verify_nonce($_POST['w2dc_csv_import_nonce'], W2DC_PATH) && (!defined('W2DC_DEMO') || !W2DC_DEMO)) {
			$errors = false;

			$validation = new w2dc_form_validation();
			$validation->set_rules('columns_separator', esc_html__('Columns separator', 'w2dc'), 'required');
			$validation->set_rules('values_separator', esc_html__('Categories separator', 'w2dc'), 'required');

			// GoBack button places on import results page
			if (w2dc_getValue($_POST, 'goback')) {
				$validation->set_rules('csv_file_name', esc_html__('CSV file name', 'w2dc'), 'required');
				$validation->set_rules('images_dir', esc_html__('Images directory', 'w2dc'));
				$validation->set_rules('fields[]', esc_html__('Import fields', 'w2dc'));
				$this->import_export_helper->validateSettings($validation);
			}

			if ($validation->run()) {
				$this->columns_separator = $validation->result_array('columns_separator');
				$this->values_separator = $validation->result_array('values_separator');
				
				// GoBack button places on import results page
				if (w2dc_getValue($_POST, 'goback')) {
					$this->csv_file_name = $validation->result_array('csv_file_name');
					$this->images_dir = $validation->result_array('images_dir');
					$this->collated_fields = $validation->result_array('fields[]');
					$this->import_export_helper->buildSettings($validation);
				}

				// GoBack button places on import results page
				if (w2dc_getValue($_POST, 'goback')) {
					$csv_file_name = $this->csv_file_name;

					if (!is_file($csv_file_name)) {
						w2dc_addMessage(esc_html__("CSV temp file doesn't exist", 'w2dc'));
						return $this->csvImportSettings($validation->result_array());
					}

					if ($this->images_dir && !is_dir($this->images_dir)) {
						w2dc_addMessage(esc_html__("Images temp directory doesn't exist", 'w2dc'));
						return $this->csvImportSettings($validation->result_array());
					}
				} else {
					$csv_file = $_FILES['csv_file'];

					if ($csv_file['error'] || !is_uploaded_file($csv_file['tmp_name'])) {
						w2dc_addMessage(esc_html__('There was a problem trying to upload CSV file', 'w2dc'), 'error');
						return $this->csvImportSettings($validation->result_array());
					}
	
					if (strtolower(pathinfo($csv_file['name'], PATHINFO_EXTENSION)) != 'csv' && $csv_file['type'] != 'text/csv') {
						w2dc_addMessage(esc_html__('This is not CSV file', 'w2dc'), 'error');
						return $this->csvImportSettings($validation->result_array());
					}
					
					if (function_exists('mb_detect_encoding') && !mb_detect_encoding(file_get_contents($csv_file['tmp_name']), 'UTF-8', true)) {
						w2dc_addMessage(esc_html__("CSV file must be in UTF-8", 'w2dc'), 'error');
						return $this->csvImportSettings($validation->result_array());
					}
					
					$upload_dir = wp_upload_dir();
					$csv_file_name = $upload_dir['path'] . '/' . $csv_file["name"];
					move_uploaded_file($csv_file['tmp_name'], $csv_file_name);

					if ($_FILES['images_file']['tmp_name']) {
						$images_file = $_FILES['images_file'];
						
						if ($images_file['error'] || !is_uploaded_file($images_file['tmp_name'])) {
							w2dc_addMessage(esc_html__('There was a problem trying to upload ZIP images file', 'w2dc'), 'error');
							return $this->csvImportSettings($validation->result_array());
						}
	
						if (!$this->extractImages($images_file['tmp_name'])) {
							w2dc_addMessage(esc_html__('There was a problem trying to unpack ZIP images file', 'w2dc'), 'error');
							return $this->csvImportSettings($validation->result_array());
						}
					}
				}
				
				$this->extractCsv($csv_file_name);

				if ($this->log['errors']) {
					foreach ($this->log['errors'] AS $message)
						w2dc_addMessage($message, 'error');

					return $this->csvImportSettings($validation->result_array());
				}
				
				$template_fields = array(
						'collation_fields' => $this->collation_fields,
						'collated_fields' => $this->collated_fields,
						'headers' => $this->header_columns,
						'rows' => $this->rows,
						'import_type' => $this->import_type,
						'columns_separator' => $this->columns_separator,
						'values_separator' => $this->values_separator,
						'csv_file_name' => $csv_file_name,
						'images_dir' => $this->images_dir,
						'users' => $users,
				);
				
				$template_fields = $this->import_export_helper->addTemplateFields($template_fields);

				w2dc_renderTemplate('csv_manager/collate_columns.tpl.php', $template_fields);
			} else {
				w2dc_addMessage($validation->error_array(), 'error');
				
				return $this->csvImportSettings($validation->result_array());
			}
		} else
			return $this->csvImportSettings();
	}
	
	// 3rd Step
	public function csvImport() {
		if ((w2dc_getValue($_POST, 'submit') || w2dc_getValue($_POST, 'tsubmit')) && wp_verify_nonce($_POST['w2dc_csv_import_nonce'], W2DC_PATH) && (!defined('W2DC_DEMO') || !W2DC_DEMO)) {
			if (w2dc_getValue($_POST, 'tsubmit'))
				$this->test_mode = true;

			$errors = false;

			$validation = new w2dc_form_validation();
			$validation->set_rules('import_type', esc_html__('Import type', 'w2dc'), 'required');
			$validation->set_rules('csv_file_name', esc_html__('CSV file name', 'w2dc'), 'required');
			$validation->set_rules('images_dir', esc_html__('Images directory', 'w2dc'));
			$validation->set_rules('columns_separator', esc_html__('Columns separator', 'w2dc'), 'required');
			$validation->set_rules('values_separator', esc_html__('Categories separator', 'w2dc'), 'required');
			$validation->set_rules('fields[]', esc_html__('Import fields', 'w2dc'));
			$this->import_export_helper->validateSettings($validation);
				
			if ($validation->run()) {
				$this->import_type = $validation->result_array('import_type');
				$this->csv_file_name = $validation->result_array('csv_file_name');
				$this->images_dir = $validation->result_array('images_dir');
				$this->columns_separator = $validation->result_array('columns_separator');
				$this->values_separator = $validation->result_array('values_separator');
				$this->import_export_helper->buildSettings($validation);
				
				$this->createHelper();
				$this->buildCollationColumns();
				
				$this->collated_fields = $validation->result_array('fields[]');
				
				if (!is_file($this->csv_file_name)) {
					$this->log['errors'][] = esc_html__("CSV temp file doesn't exist", 'w2dc');
				}

				if ($this->images_dir && !is_dir($this->images_dir)) {
					$this->log['errors'][] = esc_html__("Images temp directory doesn't exist", 'w2dc');
				}
				
				$this->import_export_helper->checkFields();
				
				echo "<h2>" . esc_html__('CSV Import', 'w2dc') . "</h2>";
				if (!$this->log['errors']) {
					$this->extractCsv($this->csv_file_name);
					
					ob_implicit_flush(true);
					w2dc_renderTemplate('admin_header.tpl.php');
					
					echo "<h3>" . esc_html__('Import results', 'w2dc') . "</h3>";

					$this->processCSV();
	
					if (!$this->log['errors'] && !$this->test_mode) {
						unlink($this->csv_file_name);
						if ($this->images_dir)
							$this->removeImagesDir($this->images_dir);
					}
				} else {
					echo "<h3>" . esc_html__('Error messages', 'w2dc') . "</h3>";
					
					foreach ($this->log['errors'] AS $error) {
						echo '<p>'.$error.'</p>';
					}
				}
				
				$template_fields = array(
						'log' => $this->log,
						'test_mode' => $this->test_mode,
						'fields' => $this->collated_fields,
						'import_type' => $this->import_type,
						'columns_separator' => $this->columns_separator,
						'values_separator' => $this->values_separator,
						'csv_file_name' => $this->csv_file_name,
						'images_dir' => $this->images_dir,
				);
				
				$template_fields = $this->import_export_helper->addTemplateFields($template_fields);
				
				w2dc_renderTemplate('csv_manager/import_results.tpl.php', $template_fields);
			} else {
				w2dc_addMessage($validation->error_array(), 'error');
				
				return $this->csvImportSettings($validation->result_array());
			}
		}
	}
	
	public function extractCsv($csv_file) {
		
		if ($fp = fopen($csv_file, 'r')) {
			$n = 0;
			
			$this->log = array('errors' => array(), 'messages' => array());
			$this->header_columns = array();
			$this->rows = array();
			
			while (($line_columns = fgetcsv($fp, 0, $this->columns_separator)) !== FALSE) {
				if ($line_columns) {
					if (!$this->header_columns) {
						$this->header_columns = $line_columns;
						foreach ($this->header_columns as &$column)
							$column = trim($column);
					} else {
						if (count($line_columns) > count($this->header_columns))
							$this->log['errors'][] = sprintf(esc_html__('Line %d has too many columns', 'w2dc'), $n+1);
						elseif (count($line_columns) < count($this->header_columns))
							$this->log['errors'][] = sprintf(esc_html__('Line %d has less columns than header line', 'w2dc'), $n+1);
						else
							$this->rows[] = $line_columns;
					}
				}
				$n++;
			}
			fclose($fp);
		} else {
			$this->log['errors'][] = esc_html__("Can't open CSV file", 'w2dc');
			return false;
		}
	}
	
	public function extractImages($zip_file) {
		$dir = trailingslashit(get_temp_dir() . 'w2dc_' . time());
		
		require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
		
		$zip = new PclZip($zip_file);
		if ($files = $zip->extract(PCLZIP_OPT_PATH, $dir, PCLZIP_OPT_REMOVE_ALL_PATH)) {
			$this->images_dir = $dir;
			return true;
		}

		return false;
	}
	
	public function removeImagesDir($dir) {
		if (!isset($GLOBALS['wp_filesystem']) || !is_object($GLOBALS['wp_filesystem'])) {
			WP_Filesystem();
		}

		$wp_file = new WP_Filesystem_Direct($dir);
		return $wp_file->rmdir($dir, true);
	}

	public function processCSV() {
		$this->users = get_users(array('fields' => array('ID', 'user_login', 'user_email')));
		foreach ($this->users AS $user) {
			$this->users_logins[] = $user->user_login;
			$this->users_emails[] = $user->user_email;
			$this->users_ids[] = $user->ID;
		}
		
		printf(esc_html__('Import started, number of available rows in file: %d', 'w2dc'), count($this->rows));
		echo "<br />";
		if ($this->test_mode) {
			esc_html_e('Test mode enabled', 'w2dc');
			echo "<br />";
		}
		
		$this->import_export_helper->processCSVImport();
		
		printf(esc_html__('Import finished, number of errors: %d, total rejected lines: %d', 'w2dc'), count($this->log['errors']), $this->import_export_helper->total_rejected_lines);
		echo "<br />";
		echo "<br />";
	}
	
	public function setErrorOnLine($error) {
		$this->log['errors'][] = $error;
		echo "<span style='color: red'>" . $error . "</span>";
		echo "<br />";
		return true;
	}
	
	public function processUser(&$item_data, $line_n) {
		if (isset($item_data['user_id'])) {
			return $item_data['user_id'];
		} elseif (isset($item_data['user_info']) && is_array($item_data['user_info'])) {
			$login = $item_data['user_info'][0];
			$email = $item_data['user_info'][1];
			$password = wp_generate_password(6, false);
			
			$post_author_id = wp_insert_user(array(
					'display_name' => $login,
					'user_login' => $login,
					'user_email' => $email,
					'user_pass' => $password
			));
			
			$this->users_logins[] = $login;
			$this->users_emails[] = $email;
			$this->users_ids[] = $post_author_id;
			
			return $post_author_id;
		} else {
			return $this->selected_user;
		}
	}
	
	public function processImages($post_id, &$item_data, $line_n) {
		$_thumbnail_id_inserted = false;
		
		foreach ($item_data['images'] AS $image_item) {
			$value = explode('>', $image_item);
			// import images from ZIP file or by URLs
			if ($this->images_dir) {
				$image_file_name = $value[0];
				
				$subdir = w2dc_getValue(wp_upload_dir(null, false, true), 'subdir', '');
				
				$url_to_search = trim($subdir, '/') . '/' . $image_file_name;
				
				// check if this attachment already exists
				$attachment_id = attachment_url_to_postid($url_to_search);
				if ($attachment_id) {
					// insert attachment ID to the post meta
					add_post_meta($post_id, '_attached_image', $attachment_id);
				
					// first image is the logo
					if (!$_thumbnail_id_inserted) {
						update_post_meta($post_id, '_thumbnail_id', $attachment_id);
						$_thumbnail_id_inserted = true;
					}
				} else {
					$image_title = (isset($value[1]) ? $value[1] : '');
					if (file_exists($this->images_dir . $image_file_name)) {
						$filepath = $this->images_dir . $image_file_name;
				
						$file = array('name' => basename($filepath),
								'tmp_name' => $filepath,
								'error' => 0,
								'size' => filesize($filepath)
						);
				
						copy($filepath, $filepath . '.backup');
						$image = wp_handle_sideload($file, array('test_form' => FALSE));
						rename($filepath . '.backup', $filepath);
						
						$this->insertAttachment($post_id, $image_file_name, $image, $image_title, $filepath, $_thumbnail_id_inserted);
					} else {
						$error = sprintf(esc_html__("There isn't specified image file \"%s\" inside ZIP file. Or temp folder wasn't created: \"%s\"", 'w2dc'), $image_file_name, $this->images_dir);
						$error_on_line = $this->setErrorOnLine($error);
					}
				}
			} else {
				$image_url = $value[0];
				$image_file_name = basename($image_url);
				$image_title = (isset($value[1]) ? $value[1] : '');
				
				$uploaddir = wp_upload_dir();
				$uploadfile = $uploaddir['path'] . '/' . $image_file_name;
				
				$contents = file_get_contents($image_url);
				$savefile = fopen($uploadfile, 'w');
				fwrite($savefile, $contents);
				fclose($savefile);
				
				$file = array('name' => $image_file_name,
						'tmp_name' => $uploadfile,
						'error' => 0,
						'size' => filesize($uploadfile)
				);
				$image = wp_handle_sideload($file, array('test_form' => FALSE));
				
				$this->insertAttachment($post_id, $image_file_name, $image, $image_title, $uploadfile, $_thumbnail_id_inserted);
			}
		}
	}
	
	public function insertAttachment($post_id, $image_file_name, $image, $image_title, $filepath, &$_thumbnail_id_inserted) {
		if (!isset($image['error'])) {
			$attachment = array(
					'post_mime_type' => $image['type'],
					'post_title' => $image_title,
					'post_content' => '',
					'post_status' => 'inherit'
			);
			if ($attach_id = wp_insert_attachment($attachment, $image['file'], $post_id)) {
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$attach_data = wp_generate_attachment_metadata($attach_id, $image['file']);
				wp_update_attachment_metadata($attach_id, $attach_data);
					
				// insert attachment ID to the post meta
				add_post_meta($post_id, '_attached_image', $attach_id);
			
				// first image is the logo
				if (!$_thumbnail_id_inserted) {
					update_post_meta($post_id, '_thumbnail_id', $attach_id);
					$_thumbnail_id_inserted = true;
				}
			} else {
				$error = sprintf(esc_html__('Image file "%s" could not be inserted.', 'w2dc'), $image_file_name);
				$error_on_line = $this->setErrorOnLine($error);
			}
		} else {
			$error = sprintf(esc_html__("Image file \"%s\" wasn't attached. Full path: \"%s\". Error: %s", 'w2dc'), $image_file_name, $filepath, $image['error']);
			$error_on_line = $this->setErrorOnLine($error);
		}
	}
	
	public function csvExport() {
		$number = 1000;
		$offset = 0;
		
		$validation = new w2dc_form_validation();
		$validation->set_rules('number', esc_html__('Listings number', 'w2dc'), 'integer');
		$validation->set_rules('offset', esc_html__('Listings offset', 'w2dc'), 'integer');
		if ($validation->run()) {
			if ($validation->result_array('number')) {
				$number = $validation->result_array('number');
			}
			if ($validation->result_array('offset')) {
				$offset = $validation->result_array('offset');
			}
		}
		
		$csv_output = $this->import_export_helper->csvExport($number, $offset);
		
		$csv_file_name = $this->import_export_helper->csvExportFileName();

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: application/octet-stream; charset=utf-8");
		header("Content-Disposition: attachment; filename=\"" . $csv_file_name . "\";" );
		header("Content-Transfer-Encoding: binary");

		$outputBuffer = fopen("php://output", 'w');
		foreach($csv_output as $val) {
			fputcsv($outputBuffer, $val);
		}
		fclose($outputBuffer);
		
		exit;
	}
	
	public function exportImages() {
		$images = array();
		$upload_dir = wp_upload_dir();
		$upload_dir_path = trailingslashit($upload_dir['basedir']);

		$args = array(
				'post_type' => W2DC_POST_TYPE,
				'post_status' => 'publish,private,draft,pending',
				'posts_per_page' => -1
		);
		$query = new WP_Query($args);
		while ($query->have_posts()) {
			$query->the_post();
			$post = get_post();
			$listing = w2dc_getListing($post);

			foreach ($listing->images AS $attachment_id=>$image) {
				if ($image_file = wp_get_attachment_metadata($attachment_id, true)) {
					$file_path = $upload_dir_path . $image_file['file'];
					if (file_exists($file_path))
						$images[] = $file_path;
				}
			}
		}
		$images = array_unique($images);
		
		$images = apply_filters("w2dc_csv_export_images", $images);

		if ($images) {
			$zip_file = trailingslashit(get_temp_dir()) . 'w2dc_images.zip';
			
			require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');

			$zip = new PclZip($zip_file);
			$path = $zip->create(implode(',', $images), PCLZIP_OPT_REMOVE_ALL_PATH);
			if (!$path)
				die('Error : ' . $zip->errorInfo(true));

			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private", false);
			header("Content-Type: application/octet-stream");
			header('Content-Disposition: attachment; filename="w2dc_images.zip"');
			header('Content-Length: ' . filesize($zip_file));
			flush();
			readfile($zip_file);
			
			register_shutdown_function('unlink', $zip_file);
		}

		exit;
	}
}

?>