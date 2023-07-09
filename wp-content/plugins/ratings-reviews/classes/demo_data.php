<?php

define('W2RR_DEMO_DATA_PATH', W2RR_PATH . 'demo-data/');

class w2rr_demo_data_manager {
	public function __construct() {
		add_action('admin_menu', array($this, 'menu'));
	}

	public function menu() {
		if (defined('W2RR_DEMO') && W2RR_DEMO) {
			$capability = 'publish_posts';
		} else {
			$capability = 'manage_options';
		}
		
		add_submenu_page('w2rr_settings',
		esc_html__('Demo data Import', 'W2RR'),
		esc_html__('Demo data Import', 'W2RR'),
		$capability,
		'w2rr_demo_data',
		array($this, 'w2rr_demo_data_import_page')
		);
	}
	
	public function w2rr_demo_data_import_page() {
		global $w2rr_instance, $wpdb;
		
		if (w2rr_getValue($_POST, 'submit') && wp_verify_nonce($_POST['w2rr_csv_import_nonce'], W2RR_PATH) && (!defined('W2RR_DEMO') || !W2RR_DEMO)) {
			
			w2rr_check_add_review_page();
			
			// update multi-rating option
			$multi_rating = 'Usability
Comfort
Price
Service
Size
Distance';
			update_option('w2rr_reviews_multi_rating', $multi_rating);
			
			$post_ids = array();
			
			$page = array(
					'post_status' => 'publish',
					'post_title' => esc_html__('Sample Reviews Page', 'W2RR'),
					'post_type' => 'page',
					'post_content' => '',
					'comment_status' => 'open'
			);
			$page_id = wp_insert_post($page);
			$post_ids[] = $page_id;
			
			$page = array(
					'post_status' => 'publish',
					'post_title' => esc_html__('Submit Review Page', 'W2RR'),
					'post_type' => 'page',
					'post_content' => '',
					'comment_status' => 'closed'
			);
			$page_id = wp_insert_post($page);
			update_option('w2rr_page_add_review', $page_id);
			
			$page = array(
					'post_status' => 'publish',
					'post_title' => esc_html__('Single Review Page', 'W2RR'),
					'post_type' => 'page',
					'post_content' => '',
					'comment_status' => 'closed'
			);
			$page_id = wp_insert_post($page);
			update_option('w2rr_page_single_review', $page_id);
			
			$page = array(
					'post_status' => 'publish',
					'post_title' => esc_html__('Reviews Dashboard Page', 'W2RR'),
					'post_type' => 'page',
					'post_content' => '',
					'comment_status' => 'closed'
			);
			$page_id = wp_insert_post($page);
			update_option('w2rr_page_dashboard', $page_id);
			
			// add demo reviews to first 10 WC products
			if (class_exists('WC_Query')) {
				// add products type to working post types
				w2rr_addWorkingPostType('product');
				
				// retrieve first 10 products from the shop products
				$wc_query = new WC_Query();
				$args = array_merge(array(
						'post_type' => 'product',
						'perpage' => 10,
				), $wc_query->get_catalog_ordering_args());
				
				$query = new WP_Query($args);
				
				$products = array();
				while ($query->have_posts()) {
					$query->the_post();
				
					$products[] = get_the_id();
				}
				shuffle($products);
				
				$post_ids = $post_ids + $products;
			}
			
			// add demo reviews to first 10 listings
			if (class_exists('w2dc_plugin')) {
				$listings_controller = new w2dc_listings_controller();
				$listings_controller->init();
				foreach ($listings_controller->listings AS $listing) {
					$post_ids[] = $listing->post->ID;
				}
			}
			
			$csv_manager = new w2rr_csv_manager();
			$csv_manager->setImportType('create_reviews');
			$csv_manager->createHelper();
			$csv_manager->columns_separator = ',';
			$csv_manager->values_separator = ';';
			$csv_manager->selected_user = get_current_user_id();
			$csv_manager->collated_fields = array(
					'title',
					'content',
					'images',
					'creation_date',
					'ratings',
					'votes',
					'post_id'
			);
			$csv_file_name = W2RR_DEMO_DATA_PATH . 'reviews.csv';
			$zip_images_file_name = W2RR_DEMO_DATA_PATH . 'images.zip';
			$csv_manager->extractImages($zip_images_file_name);
			
			foreach ($post_ids AS $post_id) {
				$csv_manager->extractCsv($csv_file_name);
				
				foreach ($csv_manager->rows as $line=>$row) {
					$csv_manager->rows[$line][6] = $post_id;
				}
				
				ob_start();
				$csv_manager->processCSV();
				ob_clean();
			}
			
			if ($csv_manager->images_dir) {
				$csv_manager->removeImagesDir($csv_manager->images_dir);
			}
			
			$reviews_link = "<a href='".admin_url('edit.php?post_type=w2rr_review')."'>reviews</a>";
			$pages_link = "<a href='".admin_url('edit.php?post_type=page')."'>pages</a>";
			
			w2rr_addMessage(sprintf(esc_html__("Import of the demo data was successfully completed. Look at your %s and %s.", "W2RR"), $reviews_link, $pages_link));
			
			w2rr_renderTemplate('demo_data_import.tpl.php');
		} elseif (w2rr_is_w2dc() && w2rr_getValue($_POST, 'submit_w2dc') && wp_verify_nonce($_POST['w2rr_csv_import_nonce'], W2RR_PATH) && (!defined('W2RR_DEMO') || !W2RR_DEMO)) {
			
			update_option('w2rr_reviews_multi_rating', get_option('w2dc_reviews_multi_rating'));
			
			$w2dc_reviews = get_posts(array(
					'post_type' => 'w2dc_review',
					'posts_per_page' => -1,
					'post_status' => 'any'
			));
			
			foreach ($w2dc_reviews AS $review) {
				$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_type='%s' WHERE ID=%d", W2RR_REVIEW_TYPE, $review->ID));
				$listing_id = $wpdb->get_row($wpdb->prepare("SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key='_listing_id' AND post_id=%d", $review->ID), ARRAY_A);
				$wpdb->query($wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_key='_post_id' WHERE meta_key='_listing_id' AND post_id=%d", $review->ID));
				
				$w2rr_instance->reviews_manager->updatePostRatings($listing_id['meta_value']);
			}
			
			$reviews_link = "<a href='".admin_url('edit.php?post_type=w2rr_review')."'>reviews</a>";
			w2rr_addMessage(sprintf(esc_html__("Import of W2DC data was successfully completed. Look at your %s.", "W2RR"), $reviews_link));
			
			w2rr_renderTemplate('demo_data_import.tpl.php');
		} else {
			$this->importInstructions();
		}
	}
	
	public function importInstructions() {
		$w2dc_reviews = false;
		if (w2rr_is_w2dc()) {
			$w2dc_reviews = get_posts(array(
					'post_type' => 'w2dc_review',
					'posts_per_page' => -1,
					'post_status' => 'any'
			));
		}
		
		w2rr_renderTemplate('demo_data_import.tpl.php', array('w2dc_reviews' => $w2dc_reviews));
	}
}

?>