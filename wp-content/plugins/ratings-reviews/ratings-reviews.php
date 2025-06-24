<?php
/*
Plugin Name: Ratings & Reviews plugin
Plugin URI: https://www.salephpscripts.com/wordpress-ratings-reviews/
Description: Build Ratings & Reviews site in some minutes. The plugin combines flexibility of WordPress and functionality of ratings system.
Version: 1.3.4
Author: salephpscripts.com
Author URI: https://www.salephpscripts.com
*/

define('W2RR_VERSION', '1.3.4');

define('W2RR_PATH', plugin_dir_path(__FILE__));
define('W2RR_URL', plugins_url('/', __FILE__));

define('W2RR_TEMPLATES_PATH', W2RR_PATH . 'templates/');

define('W2RR_RESOURCES_PATH', W2RR_PATH . 'resources/');
define('W2RR_RESOURCES_URL', W2RR_URL . 'resources/');

define('W2RR_REVIEW_TYPE', 'w2rr_review');

define('W2RR_REVIEWS_SHORTCODE', 'webrr-reviews');
define('W2RR_REVIEW_PAGE_SHORTCODE', 'webrr-review-page');
define('W2RR_ADD_REVIEW_PAGE_SHORTCODE', 'webrr-add-review-page');
define('W2RR_ALL_REVIEWS_PAGE_SHORTCODE', 'webrr-all-reviews-page');
define('W2RR_DASHBOARD_SHORTCODE', 'webrr-dashboard');
define('W2RR_ADD_REVIEW_BUTTON_SHORTCODE', 'webrr-add-review-button');
define('W2RR_REVIEWS_SLIDER', 'webrr-slider');
define('W2RR_REVIEW_RATING', 'webrr-review-rating');
define('W2RR_REVIEW_RATINGS_OVERALL', 'webrr-review-ratings-overall');
define('W2RR_REVIEW_TITLE', 'webrr-review-title');
define('W2RR_REVIEW_HEADER', 'webrr-review-header');
define('W2RR_REVIEW_GALLERY', 'webrr-review-gallery');
define('W2RR_REVIEW_CONTENT', 'webrr-review-content');
define('W2RR_REVIEW_COMMENTS', 'webrr-review-comments');
define('W2RR_REVIEW_VOTES', 'webrr-review-votes');
define('W2RR_POST_RATING', 'webrr-post-rating');
define('W2RR_POST_RATINGS_OVERALL', 'webrr-post-ratings-overall');
define('W2RR_POST_REVIEWS_COUNTER', 'webrr-post-reviews-counter');
define('W2RR_POST_REVIEWS', 'webrr-post-reviews');

include_once W2RR_PATH . 'install.php';
include_once W2RR_PATH . 'classes/admin.php';
include_once W2RR_PATH . 'classes/form_validation.php';
include_once W2RR_PATH . 'classes/query.php';
include_once W2RR_PATH . 'classes/post.php';
include_once W2RR_PATH . 'classes/target_post.php';
include_once W2RR_PATH . 'classes/ordering.php';
include_once W2RR_PATH . 'classes/media_manager.php';
include_once W2RR_PATH . 'classes/upload_image.php';
include_once W2RR_PATH . 'classes/wc/wc_hooks.php';
include_once W2RR_PATH . 'classes/w2dc_hooks.php';
include_once W2RR_PATH . 'classes/demo_data.php';
include_once W2RR_PATH . 'classes/frontend_controller.php';
include_once W2RR_PATH . 'classes/breadcrumbs.php';
include_once W2RR_PATH . 'classes/shortcodes/reviews_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/add_review_button_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/add_review_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/single_review_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/all_reviews_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/slider_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_rating_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_title_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/post_rating_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/post_ratings_overall_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/post_reviews_counter_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/post_reviews_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_header_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_content_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_comments_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_gallery_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_votes_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_title_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_rating_controller.php';
include_once W2RR_PATH . 'classes/shortcodes/review_ratings_overall_controller.php';
include_once W2RR_PATH . 'classes/frontend/dashboard_controller.php';
include_once W2RR_PATH . 'classes/frontend/functions.php';
include_once W2RR_PATH . 'classes/frontend/login_registrations.php';
include_once W2RR_PATH . 'classes/ajax_controller.php';
include_once W2RR_PATH . 'vafpress-framework/bootstrap.php';
include_once W2RR_PATH . 'classes/settings_manager.php';
include_once W2RR_PATH . 'classes/ratings_reviews/functions.php';
include_once W2RR_PATH . 'classes/ratings_reviews/ratings_manager.php';
include_once W2RR_PATH . 'classes/ratings_reviews/ratings.php';
include_once W2RR_PATH . 'classes/ratings_reviews/reviews_manager.php';
include_once W2RR_PATH . 'classes/ratings_reviews/target_post_manager.php';
include_once W2RR_PATH . 'classes/ratings_reviews/comments_manager.php';
include_once W2RR_PATH . 'classes/ratings_reviews/review.php';
include_once W2RR_PATH . 'classes/ratings_reviews/review_ratings.php';
include_once W2RR_PATH . 'classes/widgets/widget.php';
include_once W2RR_PATH . 'classes/widgets/reviews.php';
include_once W2RR_PATH . 'classes/widgets/slider.php';
include_once W2RR_PATH . 'classes/widgets/add_review_button.php';
include_once W2RR_PATH . 'classes/widgets/post_rating.php';
include_once W2RR_PATH . 'classes/widgets/post_ratings_overall.php';
include_once W2RR_PATH . 'classes/widgets/post_reviews_counter.php';
include_once W2RR_PATH . 'classes/widgets/post_reviews.php';
include_once W2RR_PATH . 'classes/widgets/review_header.php';
include_once W2RR_PATH . 'classes/widgets/review_content.php';
include_once W2RR_PATH . 'classes/widgets/review_comments.php';
include_once W2RR_PATH . 'classes/widgets/review_gallery.php';
include_once W2RR_PATH . 'classes/widgets/review_votes.php';
include_once W2RR_PATH . 'classes/widgets/review_title.php';
include_once W2RR_PATH . 'classes/widgets/review_rating.php';
include_once W2RR_PATH . 'classes/widgets/review_ratings_overall.php';
include_once W2RR_PATH . 'classes/widgets/elementor/elementor.php';
include_once W2RR_PATH . 'compatibility/elementor.php';
include_once W2RR_PATH . 'classes/csv/csv_manager.php'; 
include_once W2RR_PATH . 'classes/csv/reviews.php';
include_once W2RR_PATH . 'classes/updater.php';
include_once W2RR_PATH . 'functions.php';
include_once W2RR_PATH . 'functions_ui.php';
include_once W2RR_PATH . 'vc.php';
include_once W2RR_PATH . 'classes/customization/color_schemes.php';

global $w2rr_instance;
global $w2rr_messages;
/*
 * There are 2 types of shortcodes in the system:
 1. those process as simple wordpress shortcodes
 2. require initialization on 'wp' hook
 
 */
global $w2rr_shortcodes;
$w2rr_shortcodes = array(
		W2RR_REVIEWS_SHORTCODE => 'w2rr_reviews_controller',
		W2RR_REVIEW_PAGE_SHORTCODE => 'w2rr_single_review_controller',
		W2RR_ADD_REVIEW_PAGE_SHORTCODE => 'w2rr_add_review_controller',
		W2RR_ALL_REVIEWS_PAGE_SHORTCODE => 'w2rr_all_reviews_controller',
		W2RR_DASHBOARD_SHORTCODE => 'w2rr_dashboard_controller',
		W2RR_ADD_REVIEW_BUTTON_SHORTCODE => 'w2rr_add_review_button_controller',
		W2RR_REVIEWS_SLIDER => 'w2rr_slider_controller',
		W2RR_REVIEW_RATING => 'w2rr_review_rating_controller',
		W2RR_REVIEW_RATINGS_OVERALL => 'w2rr_review_ratings_overall_controller',
		W2RR_REVIEW_TITLE => 'w2rr_review_title_controller',
		W2RR_REVIEW_HEADER => 'w2rr_review_header_controller',
		W2RR_REVIEW_GALLERY => 'w2rr_review_gallery_controller',
		W2RR_REVIEW_CONTENT => 'w2rr_review_content_controller',
		W2RR_REVIEW_COMMENTS => 'w2rr_review_comments_controller',
		W2RR_REVIEW_VOTES => 'w2rr_review_votes_controller',
		W2RR_POST_RATING => 'w2rr_post_rating_controller',
		W2RR_POST_RATINGS_OVERALL => 'w2rr_post_ratings_overall_controller',
		W2RR_POST_REVIEWS_COUNTER => 'w2rr_post_reviews_counter_controller',
);
$w2rr_shortcodes_init = array(
		W2RR_REVIEW_PAGE_SHORTCODE => 'w2rr_single_review_controller',
		W2RR_ADD_REVIEW_PAGE_SHORTCODE => 'w2rr_add_review_controller',
		W2RR_ALL_REVIEWS_PAGE_SHORTCODE => 'w2rr_all_reviews_controller',
		W2RR_DASHBOARD_SHORTCODE => 'w2rr_dashboard_controller',
);

class w2rr_plugin {
	public $admin;
	public $query;
	public $ratings_manager;
	public $reviews_manager;
	public $target_post_manager;
	public $comments_manager;
	public $media_manager;
	public $settings_manager;
	public $demo_data_manager;
	public $csv_manager;
	public $updater;
	
	public $review_page_id;
	public $add_review_page_id;
	public $all_reviews_page_id;
	public $dashboard_page_id;
	
	public $login_registrations_template;

	public $ajax_controller;

	public $frontend_controllers = array();
	public $_frontend_controllers = array(); // this duplicate property needed because we unset each controller when we render shortcodes, but WP doesn't really know which shortcode already was processed
	public $action;
	
	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activation'));
		register_deactivation_hook(__FILE__, array($this, 'deactivation'));
	}
	
	public function activation() {
		global $wp_version;

		if (version_compare($wp_version, '3.6', '<')) {
			deactivate_plugins(basename(__FILE__)); // Deactivate ourself
			wp_die("Sorry, but you can't run this plugin on current WordPress version, it requires WordPress v3.6 or higher.");
		}
		flush_rewrite_rules();
		
		wp_schedule_event(current_time('timestamp'), 'hourly', 'scheduled_events');
	}

	public function deactivation() {
		flush_rewrite_rules();

		wp_clear_scheduled_hook('scheduled_events');
	}
	
	public function init() {
		global $w2rr_shortcodes, $wpdb;

		if (isset($_REQUEST['w2rr_action'])) {
			$this->action = $_REQUEST['w2rr_action'];
		}

		add_action('init', array($this, 'load_textdomains'));

		foreach ($w2rr_shortcodes AS $shortcode=>$function) {
			add_shortcode($shortcode, array($this, 'renderShortcode'));
		}
		
		add_action('init', array($this, 'remove_admin_bar'));
		
		add_action('init', array($this, 'loadPages'), 1);
		add_action('init', array($this, 'register_post_type'), 0);

		add_filter('body_class', array($this, 'addBodyClasses'));

		add_action('wp', array($this, 'loadFrontendControllers'), 1);

		if (!get_option('w2rr_installed_plugin') || get_option('w2rr_installed_plugin_version') != W2RR_VERSION) {
			// load classes ONLY after the plugin was fully installed, otherwise it can not get review, ratings from the database
			if (get_option('w2rr_installed_plugin')) {
				$this->loadClasses();
			}

			add_action('init', 'w2rr_install_plugin', 0);
		} else {
			$this->loadClasses();
		}
		
		add_action('init', array($this, 'check_shortcodes_flush_rules'), 9999);
		add_action('save_post', array($this, 'check_shortcodes'), 10, 2);
		
		add_filter('post_type_link', array($this, 'review_permalink'), 10, 3);
		
		add_action('wp_ajax_w2rr_reset_ratings', array($this, 'reset_ratings'));
		add_action('wp_ajax_nopriv_w2rr_reset_ratings', array($this, 'reset_ratings'));
		
		add_shortcode(W2RR_REVIEWS_SHORTCODE, array($this, 'renderShortcode'));
		add_shortcode(W2RR_REVIEW_PAGE_SHORTCODE, array($this, 'renderShortcode'));
		add_shortcode(W2RR_ADD_REVIEW_PAGE_SHORTCODE, array($this, 'renderShortcode'));
		add_shortcode(W2RR_DASHBOARD_SHORTCODE, array($this, 'renderShortcode'));
		
		if (get_option('w2rr_display_mode') == 'comments') {
			add_filter('comments_template', array($this, 'comments_template'), 11);
		}
		
		add_filter('no_texturize_shortcodes', array($this, 'w2rr_no_texturize'));

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles_custom'), 9999);
		add_action('wp_enqueue_scripts', array($this, 'enqueue_dynamic_css'));
		
		add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
	}

	public function load_textdomains() {
		
		load_plugin_textdomain('w2rr', '', dirname(plugin_basename( __FILE__ )) . '/languages');
	}
	
	public function loadClasses() {
		$this->query = new w2rr_query;
		$this->ratings_manager = new w2rr_ratings_manager;
		$this->reviews_manager = new w2rr_reviews_manager;
		$this->target_post_manager = new w2rr_target_post_manager;
		$this->comments_manager = new w2rr_comments_manager;
		$this->ajax_controller = new w2rr_ajax_controller;
		$this->admin = new w2rr_admin;
		$this->updater = new w2rr_updater(__FILE__, get_option('w2rr_purchase_code'), get_option('w2rr_access_token'));
	}

	public function w2rr_no_texturize($shortcodes) {
		global $w2rr_shortcodes;
		
		foreach ($w2rr_shortcodes AS $shortcode=>$function)
			$shortcodes[] = $shortcode;
		
		return $shortcodes;
	}
	
	public function remove_admin_bar() {
		if (get_option('w2rr_hide_admin_bar') && !current_user_can('manage_options') && !current_user_can('editor') && !is_admin()) {
			show_admin_bar(false);
			add_filter('show_admin_bar', '__return_false', 99999);
		}
	}

	public function renderShortcode() {
		// Some themes and plugins can load our shortcodes at the admin part, breaking some important functionality
		if (!is_admin()) {
			global $w2rr_shortcodes;
	
			// remove content filters in order not to break the layout of page
			$filters_to_remove = array(
					'wpautop',
					'wptexturize',
					'shortcode_unautop',
					'convert_chars',
					'prepend_attachment',
					'convert_smilies',
			);
			$filters_to_repair = array();
			foreach ($filters_to_remove AS $filter) {
				while (($priority = has_filter('the_content', $filter)) !== false) {
					$filters_to_repair[$filter] = $priority;
					
					remove_filter('the_content', $filter, $priority);
				}
			}
	
			$attrs = func_get_args();
			$shortcode = $attrs[2];
	
			$filters_where_not_to_display = array(
					'wp_head',
					'init',
					'wp',
					'edit_attachment',
			);
			
			if (isset($this->_frontend_controllers[$shortcode]) && !in_array(current_filter(), $filters_where_not_to_display)) {
				$shortcode_controllers = $this->_frontend_controllers[$shortcode];
				foreach ($shortcode_controllers AS $key=>&$controller) {
					unset($this->_frontend_controllers[$shortcode][$key]); // there are possible more than 1 same shortcodes on a page, so we have to unset which already was displayed
					if (method_exists($controller, 'display')) {
						$out = $controller->display();
						
						if ($filters_to_repair) {
							foreach ($filters_to_repair AS $filter=>$priority) {
								add_filter('the_content', $filter, $priority);
							}
						}
						
						return $out;
					}
				}
			}
	
			if (isset($w2rr_shortcodes[$shortcode])) {
				$shortcode_class = $w2rr_shortcodes[$shortcode];
				if ($attrs[0] === '')
					$attrs[0] = array();
				$shortcode_instance = new $shortcode_class();
				
				w2rr_setFrontendController($shortcode, $shortcode_instance, false);
				
				$shortcode_instance->init($attrs[0], $shortcode);
	
				if (method_exists($shortcode_instance, 'display')) {
					
					$out = $shortcode_instance->display();
					
					if ($filters_to_repair) {
						foreach ($filters_to_repair AS $filter=>$priority) {
							add_filter('the_content', $filter, $priority);
						}
					}
					
					return $out;
				}
			}
		}
	}

	public function loadFrontendControllers() {
		global $post, $wp_query;
		
		if ($wp_query->posts) {
			$pattern = get_shortcode_regex();
			foreach ($wp_query->posts AS $archive_post) {
				if (isset($archive_post->post_content)) {
					$this->loadNestedFrontendController($pattern, $archive_post);
				}
			}
		} elseif ($post && isset($post->post_content)) {
			$pattern = get_shortcode_regex();
			$this->loadNestedFrontendController($pattern, $post);
		}
	}

	// this is recursive function to catch nested shortcodes
	public function loadNestedFrontendController($pattern, $post, $shortcode_content = '') {
		global $w2rr_shortcodes, $w2rr_shortcodes_init;
		
		if (empty($shortcode_content)) {
			$shortcode_content = $post->post_content;
		}
		
		switch ($post->ID) {
			case w2rr_get_wpml_dependent_option('w2rr_page_add_review'):
				$shortcode = W2RR_ADD_REVIEW_PAGE_SHORTCODE;
				$shortcode_instance = new w2rr_add_review_controller();
				break;
			case w2rr_get_wpml_dependent_option('w2rr_page_single_review'):
				$shortcode = W2RR_REVIEW_PAGE_SHORTCODE;
				$shortcode_instance = new w2rr_single_review_controller();
				break;
			case w2rr_get_wpml_dependent_option('w2rr_page_all_reviews'):
				$shortcode = W2RR_ALL_REVIEWS_PAGE_SHORTCODE;
				$shortcode_instance = new w2rr_all_reviews_controller();
				break;
			case w2rr_get_wpml_dependent_option('w2rr_page_dashboard'):
				$shortcode = W2RR_DASHBOARD_SHORTCODE;
				$shortcode_instance = new w2rr_dashboard_controller();
				break;
		}
		if (!empty($shortcode) && !empty($shortcode_instance)) {
			w2rr_setFrontendController($shortcode, $shortcode_instance);
			
			$shortcode_instance->init();
			
			add_filter('the_content', array($shortcode_instance, 'display_content_filter'));
		}

		if (preg_match_all('/'.$pattern.'/s', $shortcode_content, $matches) && array_key_exists(2, $matches)) {
			foreach ($matches[2] AS $key=>$shortcode) {
				if ($shortcode != 'shortcodes') {
					if (isset($w2rr_shortcodes_init[$shortcode]) && class_exists($w2rr_shortcodes_init[$shortcode])) {
						$shortcode_class = $w2rr_shortcodes_init[$shortcode];
						if (!($attrs = shortcode_parse_atts($matches[3][$key])))
							$attrs = array();
						$shortcode_instance = new $shortcode_class();
						
						w2rr_setFrontendController($shortcode, $shortcode_instance);
						
						$shortcode_instance->init($attrs, $shortcode);
					} elseif (isset($w2rr_shortcodes[$shortcode]) && class_exists($w2rr_shortcodes[$shortcode])) {
						$shortcode_class = $w2rr_shortcodes[$shortcode];
						$shortcode_instance = new $shortcode_class();
						
						w2rr_setFrontendController($shortcode, $shortcode_instance, false);
					}
					if ($shortcode_content = $matches[5][$key]) {
						// lets look deeper
						$this->loadNestedFrontendController($pattern, $post, $shortcode_content);
					}
				}
			}
		}
	}
	
	public function loadPages() {
		if ($page_id = w2rr_getReviewPage()) {
			$this->review_page_id = $page_id;
		}
		if ($page_id = w2rr_getAddReviewPage()) {
			$this->add_review_page_id = $page_id;
		}
		if ($page_id = w2rr_getAllReviewsPage()) {
			$this->all_reviews_page_id = $page_id;
		}
		if ($page_id = w2rr_getDashboardPage()) {
			$this->dashboard_page_id = $page_id;
		}
	}
	
	public function check_shortcodes_flush_rules() {
		if (!$option = get_option('w2rr_flush_rewrite_rules')) {
			return false;
		}
		
		if ($option == 1) {
			flush_rewrite_rules();
			update_option('w2rr_flush_rewrite_rules', 0);
		}
		
		return true;
	}
	
	/**
	 * forces to update rewrite rules on post save, when a post has our shortcodes
	 * 
	 * @param int $post_id
	 * @param obj $post_object
	 * @return boolean
	 */
	public function check_shortcodes($post_id = null, $post_object = null) {
		global $w2rr_shortcodes_init;

		$pattern = get_shortcode_regex();
		if (preg_match_all('/'.$pattern.'/s', $post_object->post_content, $matches) && array_key_exists(2, $matches)) {
			foreach ($matches[2] AS $key=>$shortcode) {
				if (isset($w2rr_shortcodes_init[$shortcode]) && class_exists($w2rr_shortcodes_init[$shortcode])) {
					update_option('w2rr_flush_rewrite_rules', 1);
				}
			}
		}

		return true;
	}
	
	public function review_permalink($permalink, $review_post, $leavename) {
		if ($review_post->post_type == W2RR_REVIEW_TYPE) {
			if ($target_post_id = get_post_meta($review_post->ID, '_post_id', true)) {
				if ($post = get_post($target_post_id)) {
					global $wp_rewrite;
	
					if ($wp_rewrite->using_permalinks()) {
						if ($leavename) {
							$postname = '%postname%';
						} else {
							$postname = $review_post->post_name;
						}

						$permalink = home_url('/reviews/' . $postname . '/');
					} else {	
						$permalink = add_query_arg(array(W2RR_REVIEW_TYPE => $review_post->post_name, 'target-post' => $post->post_name), '');
					}
				}
				
				$permalink = apply_filters('w2rr_review_permalink', $permalink, $review_post, $leavename);
				
				return $permalink;
			} else {
				return '';
			}
		}
		return $permalink;
	}
	
	public function comments_template($file) {
		global $w2rr_instance;
		
		if (get_option('w2rr_display_mode') == 'shortcodes') {
			// the problem appears, it attaches comments template twice
			remove_filter("comments_template", array($this, "comments_template"), 11);
			
			return false;
		}
	
		$target_post = w2rr_getTargetPost();
		
		if ($target_post && $target_post->getCommentStatus() == 'open' && in_array(get_post_type($target_post->post), w2rr_getWorkingPostTypes()) && !in_array($target_post->post->ID, w2rr_getSelectedPages())) {
			if (get_query_var('add-review') == 'add') {
				// Actually this scenario is not possible. Review submission will be only through [webrr-add-review-page] shortcode.
				// So there will be another starting point at the shortcode controller init() function.
				// It is required to handle logins/registrations/lostpassword pages.
				
				$w2rr_instance->media_manager->admin_enqueue_scripts_styles();
				
				return w2rr_isTemplate('ratings_reviews/templates_files/review_add.php');
			} elseif (w2rr_isAllReviews()) {
				return w2rr_isTemplate('ratings_reviews/templates_files/reviews_all.php');
			} elseif (w2rr_isReview()) {
				return w2rr_isTemplate('ratings_reviews/templates_files/review_single.php');
			} else {
				return w2rr_isTemplate('ratings_reviews/templates_files/reviews_template.tpl.php');
			}
		} else {
			return $file;
		}
	}
	
	public function addBodyClasses($classes) {
		$classes[] = 'w2rr-body';
	
		return $classes;
	}
	
	public function register_post_type() {
		
		$args = array(
			'labels' => array(
				'name' => esc_html__('Ratings & reviews', 'w2rr'),
				'singular_name' => esc_html__('Review', 'w2rr'),
				'add_new' => esc_html__('Create new review', 'w2rr'),
				'add_new_item' => esc_html__('Create new review', 'w2rr'),
				'edit_item' => esc_html__('Edit review', 'w2rr'),
				'new_item' => esc_html__('New review', 'w2rr'),
				'view_item' => esc_html__('View review', 'w2rr'),
				'search_items' => esc_html__('Search reviews', 'w2rr'),
				'not_found' =>  esc_html__('No reviews found', 'w2rr'),
				'not_found_in_trash' => esc_html__('No reviews found in trash', 'w2rr')
			),
			'has_archive' => true,
			'description' => esc_html__('Ratings & reviews', 'w2rr'),
			'public' => true,
			'exclude_from_search' => false, // this must be false otherwise it breaks pagination for custom taxonomies
			'supports' => array('title', 'author', 'comments'),
			'menu_icon' => W2RR_RESOURCES_URL . 'images/menuicon.png',
		);
		if (get_option('w2rr_enable_description')) {
			$args['supports'][] = 'editor';
		}
		if (get_option('w2rr_enable_summary')) {
			$args['supports'][] = 'excerpt';
		}
		register_post_type(W2RR_REVIEW_TYPE, $args);
	}

	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $w2rr_enqueued;
		if (w2rr_do_enqueue_scripts_styles($load_scripts_styles)) {
			add_action('wp_head', array($this, 'enqueue_global_vars'));
			
			wp_enqueue_script('jquery', false, array(), false, false);

			wp_register_style('w2rr-bootstrap', W2RR_RESOURCES_URL . 'css/bootstrap.css', array(), W2RR_VERSION);
			wp_register_style('w2rr-frontend', W2RR_RESOURCES_URL . 'css/frontend.css', array(), W2RR_VERSION);

			if (function_exists('is_rtl') && is_rtl()) {
				wp_register_style('w2rr-frontend-rtl', W2RR_RESOURCES_URL . 'css/frontend-rtl.css', array(), W2RR_VERSION);
			}

			wp_register_style('w2rr-font-awesome', W2RR_RESOURCES_URL . 'css/font-awesome.css', array(), W2RR_VERSION);

			wp_register_script('w2rr-js-functions', W2RR_RESOURCES_URL . 'js/js_functions.js', array('jquery'), W2RR_VERSION, true);

			wp_register_style('w2rr-media-styles', W2RR_RESOURCES_URL . 'lightbox/css/lightbox.min.css', array(), W2RR_VERSION);
			wp_register_script('w2rr_media_scripts_lightbox', W2RR_RESOURCES_URL . 'lightbox/js/lightbox.js', array('jquery'), false, true);
			
			if (!get_option('w2rr_single_review_is_on_page')) {
				// jQuery UI version 1.10.4
				wp_register_style('w2rr-jquery-ui-style', W2RR_RESOURCES_URL . 'css/jquery-ui/themes/redmond/jquery-ui.css');
				wp_enqueue_style('w2rr-jquery-ui-style');
			}
			
			wp_register_style('w2rr-reviews-slider', W2RR_RESOURCES_URL . 'css/bxslider/jquery.bxslider.css', array(), W2RR_VERSION);
			wp_enqueue_style('w2rr-reviews-slider');

			wp_enqueue_style('w2rr-bootstrap');
			wp_enqueue_style('w2rr-font-awesome');
			wp_enqueue_style('w2rr-frontend');
			wp_enqueue_style('w2rr-frontend-rtl');
			
			// Include dynamic-css file only when we are not in palettes comparison mode
			if (!isset($_COOKIE['w2rr_compare_palettes']) || !get_option('w2rr_compare_palettes')) {
				// Include dynamically generated css file if this file exists
				$upload_dir = wp_upload_dir();
				$filename = trailingslashit(set_url_scheme($upload_dir['baseurl'])) . 'w2rr-plugin.css';
				$filename_dir = trailingslashit($upload_dir['basedir']) . 'w2rr-plugin.css';
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once(ABSPATH .'/wp-admin/includes/file.php');
					WP_Filesystem();
				}
				if ($wp_filesystem && trim($wp_filesystem->get_contents($filename_dir))) { // if css file creation success
					wp_enqueue_style('w2rr-dynamic-css', $filename, array(), time());
				}
			}

			wp_enqueue_script('jquery-ui-dialog');
			
			wp_enqueue_script('w2rr-js-functions');

			if (get_option('w2rr_images_lightbox') && get_option('w2rr_enable_lightbox_gallery')) {
				wp_enqueue_style('w2rr-media-styles');
				wp_enqueue_script('w2rr_media_scripts_lightbox');
			}
			
			if (get_option('w2rr_enable_recaptcha') && get_option('w2rr_recaptcha_public_key') && get_option('w2rr_recaptcha_private_key')) {
				
				// adapted for WPML
				global $sitepress;
				$lang = ($sitepress && get_option('w2rr_recaptcha_language_from_wpml')) ? ICL_LANGUAGE_CODE : apply_filters('w2rr_recaptcha_language', '');
				
				if (get_option('w2rr_recaptcha_version') == 'v2') {
					if ($lang) {
						$lang = '?hl=' . $lang;
					}
					wp_register_script('w2rr-recaptcha', '//google.com/recaptcha/api.js'.$lang);
				} elseif (get_option('w2rr_recaptcha_version') == 'v3') {
					if ($lang) {
						$lang = '&lang=' . $lang;
					}
					wp_register_script('w2rr-recaptcha', '//google.com/recaptcha/api.js?render='.get_option('w2rr-recaptcha_public_key').$lang);
				}
				wp_enqueue_script('w2rr-recaptcha');
			}

			$w2rr_enqueued = true;
		}
	}
	
	public function enqueue_scripts_styles_custom($load_scripts_styles = false) {
		if ((($this->frontend_controllers || $load_scripts_styles)) || get_option('w2rr_force_include_js_css')) {
			if ($frontend_custom = w2rr_isResource('css/frontend-custom.css')) {
				wp_register_style('w2rr-frontend-custom', $frontend_custom, array(), W2RR_VERSION);
				
				wp_enqueue_style('w2rr-frontend-custom');
			}
		}
	}
	
	public function enqueue_global_vars() {
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$ajaxurl = admin_url('admin-ajax.php?lang=' .  $sitepress->get_current_language());
		} else
			$ajaxurl = admin_url('admin-ajax.php');
		
		echo '
<script>
';	
		echo 'var w2rr_controller_args_array = {};
';
		echo 'var w2rr_js_objects = ' . json_encode(
				array(
						'ajaxurl' => $ajaxurl,
						'ajax_load' => (int)get_option('w2rr_ajax_load'),
						'is_rtl' => is_rtl(),
						'leave_comment' => esc_html__('Leave a comment', 'w2rr'),
						'leave_reply' => esc_html__('Leave a reply to', 'w2rr'),
						'cancel_reply' => esc_html__('Cancel reply', 'w2rr'),
						'more' => esc_html__('More', 'w2rr'),
						'less' => esc_html__('Less', 'w2rr'),
						'recaptcha_public_key' => ((get_option('w2rr_enable_recaptcha') && get_option('w2rr_recaptcha_public_key') && get_option('w2rr_recaptcha_private_key')) ? get_option('w2rr_recaptcha_public_key') : ''),
						'lang' => (($sitepress && get_option('w2rr_map_language_from_wpml')) ? ICL_LANGUAGE_CODE : ''),
						'desktop_screen_width' => 992,
						'mobile_screen_width' => 768,
						'is_admin' => (int)is_admin(),
						'single_review_is_on_page' => (int)get_option('w2rr_single_review_is_on_page'),
				)
		) . ';
';
		echo '</script>
';
	}

	// Include dynamically generated css code if css file does not exist.
	public function enqueue_dynamic_css($load_scripts_styles = false) {
		$upload_dir = wp_upload_dir();
		$filename = trailingslashit(set_url_scheme($upload_dir['baseurl'])) . 'w2rr-plugin.css';
		$filename_dir = trailingslashit($upload_dir['basedir']) . 'w2rr-plugin.css';
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}
		if ((!$wp_filesystem || !trim($wp_filesystem->get_contents($filename_dir))) ||
			// When we are in palettes comparison mode - this will build css according to $_COOKIE['w2rr_compare_palettes']
			(isset($_COOKIE['w2rr_compare_palettes']) && get_option('w2rr_compare_palettes')))
		{
			ob_start();
			include W2RR_PATH . '/classes/customization/dynamic_css.php';
			$dynamic_css = ob_get_contents();
			ob_get_clean();
			
			wp_add_inline_style('w2rr-frontend', $dynamic_css);
		}
	}
	
	public function exclude_post_type_archive_link($archive_url, $post_type) {
		if ($post_type == W2RR_REVIEW_TYPE) {
			return false;
		}
		
		return $archive_url;
	}
	
	public function plugin_row_meta($links, $file) {
		if (dirname(plugin_basename(__FILE__) == $file)) {
			$row_meta = array(
					'docs' => '<a href="https://www.salephpscripts.com/wordpress-ratings-reviews/demo/documentation/">' . esc_html__("Documentation", "w2rr") . '</a>',
					'codecanoyn' => '<a href="https://www.salephpscripts.com/ratings-reviews/#changelog">' . esc_html__("Changelog", "w2rr") . '</a>',
			);
	
			return array_merge($links, $row_meta);
		}
	
		return $links;
	}
	
	public function plugin_action_links($links) {
		$action_links = array(
				'settings' => '<a href="' . admin_url('admin.php?page=w2rr_settings') . '">' . esc_html__("Settings", "w2rr") . '</a>',
		);
	
		return array_merge($action_links, $links);
	}
}

$w2rr_instance = new w2rr_plugin();
$w2rr_instance->init();

?>