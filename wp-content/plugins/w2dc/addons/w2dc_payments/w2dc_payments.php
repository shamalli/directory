<?php

// @codingStandardsIgnoreFile

define('W2DC_INVOICE_TYPE', 'w2dc_invoice');

define('W2DC_PAYMENTS_PATH', plugin_dir_path(__FILE__));

function w2dc_payments_loadPaths() {
	define('W2DC_PAYMENTS_TEMPLATES_PATH',  W2DC_PAYMENTS_PATH . 'templates/');
	define('W2DC_PAYMENTS_RESOURCES_URL', plugins_url('/', __FILE__) . 'resources/');
}
add_action('init', 'w2dc_payments_loadPaths', 0);

include_once W2DC_PAYMENTS_PATH . 'classes/invoice.php';

class w2dc_payments_plugin {

	public function init() {
		global $w2dc_instance;
		
		if (!get_option('w2dc_installed_payments'))
			add_action('init', 'w2dc_install_payments', 0);
		add_action('w2dc_version_upgrade', 'w2dc_upgrade_payments');

		add_action('init', array($this, 'register_invoice_type'));
		add_action('load-post-new.php', array($this, 'disable_new_invoices_page'));
		// remove links on all pages - 2 hooks needed
		add_action('admin_menu', array($this, 'disable_new_invoices_link'));
		add_action('admin_head', array($this, 'disable_new_invoices_link'));

		add_filter('w2dc_build_settings', array($this, 'plugin_settings'));
		
		add_filter('manage_'.W2DC_INVOICE_TYPE.'_posts_columns', array($this, 'add_invoices_table_columns'));
		add_filter('manage_'.W2DC_INVOICE_TYPE.'_posts_custom_column', array($this, 'manage_invoices_table_rows'), 10, 2);
		add_filter('post_row_actions', array($this, 'remove_row_actions'), 10, 2);
		add_action('wp_before_admin_bar_render', array($this, 'remove_create_invoice_link'));

		add_action('admin_init', array($this, 'remove_metaboxes'));
		add_action('add_meta_boxes', array($this, 'add_invoice_info_metabox'));
		add_action('add_meta_boxes', array($this, 'add_invoice_payment_metabox'));
		add_action('add_meta_boxes', array($this, 'add_invoice_log_metabox'));
		add_action('add_meta_boxes', array($this, 'add_invoice_actions_metabox'));

		add_filter('template_include', array($this, 'print_invoice_template'), 100000);
		
		$this->loadPricesByLevels();
		add_filter('w2dc_levels_loading', array($this, 'loadPricesByLevels'), 10, 2);

		add_filter('w2dc_level_html', array($this, 'levels_price_in_level_html'));
		add_filter('w2dc_level_validation', array($this, 'levels_price_in_level_validation'));
		add_filter('w2dc_level_create_edit_args', array($this, 'levels_price_in_level_create_add'), 1, 2);
		add_filter('w2dc_level_table_header', array($this, 'levels_price_table_header'));
		add_filter('w2dc_level_table_row', array($this, 'levels_price_table_row'), 10, 2);

		add_filter('w2dc_submitlisting_level_price', array($this, 'levels_price_front_table_row'), 10, 2);
		
		add_filter('w2dc_level_upgrade_meta', array($this, 'levels_upgrade_meta'), 10, 2);
		add_action('w2dc_upgrade_meta_html', array($this, 'levels_upgrade_meta_html'), 10, 2);
		
		add_filter('w2dc_create_listings_steps_html', array($this, 'pay_invoice_step'), 10, 2);

		add_filter('w2dc_create_option', array($this, 'create_price'), 10, 2);
		add_filter('w2dc_raiseup_option', array($this, 'raiseup_price'), 10, 2);
		add_filter('w2dc_renew_option', array($this, 'renew_price'), 10, 2);
		add_filter('w2dc_level_upgrade_option', array($this, 'upgrade_price'), 10, 3);
		
		add_action('init', array($this, 'invoice_actions'));

		add_action('w2dc_invoice_status_option', array($this, 'apply_payment_link'));
		add_action('init', array($this, 'apply_payment'));
		
		add_filter('query_vars', array($this, 'w2dc_payments_query_vars'));
		
		// This is really strange thing, that users may see ANY attachments (including invoices) owned by other users, so we need this hack
		add_filter('pre_get_posts', array($this, 'prevent_users_see_other_invoices'));
		
		add_filter('bulk_actions-edit-'.W2DC_INVOICE_TYPE, array($this, 'remove_bulk_actions'));
		
		add_action('w2dc_dashboard_links', array($this, 'add_invoices_dashboard_link'));
		add_filter('w2dc_dashboard_controller_construct', array($this, 'handle_dashboard_controller'));
		add_filter('w2dc_get_edit_invoice_link', array($this, 'edit_invoices_links'), 10, 2);
		
		// sometimes user under contributor role can not view own invoice, that may cause blank page on listings submission
		add_filter('map_meta_cap', array($this, 'map_meta_cap'), 10, 4);
		
		add_filter('posts_search', array($this, 'invoices_search_post_id'), 10, 2);

		add_action('w2dc_render_template', array($this, 'check_custom_template'), 10, 2);
	}
	
	/**
	 * check is there template in one of these paths:
	 * - themes/theme/w2dc-plugin/templates/w2dc_payments/
	 * - plugins/w2dc/templates/w2dc_payments/
	 * 
	 */
	public function check_custom_template($template, $args) {
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
				
			if ($template_path == W2DC_PAYMENTS_TEMPLATES_PATH && ($payments_template = w2dc_isTemplate('w2dc_payments/' . $template_file))) {
				return $payments_template;
			}
		}
		return $template;
	}

	public function add_invoices_table_columns($columns) {
		$w2dc_columns['item'] = esc_html__('Item', 'w2dc');
		$w2dc_columns['price'] = esc_html__('Price', 'w2dc');
		$w2dc_columns['payment'] = esc_html__('Payment', 'w2dc');

		$columns['title'] = esc_html__('Invoice', 'w2dc');
		
		unset($columns['cb']);

		return
			array('id' => esc_html__('Id', 'w2dc')) +
			array_slice($columns, 0, 1, true) +
			$w2dc_columns +
			array_slice($columns, 1, count($columns)-1, true);
	}
	
	public function manage_invoices_table_rows($column, $invoice_id) {
		switch ($column) {
			case "id":
				w2dc_esc_e($invoice_id);
				break;
			case "item":
				if (($invoice = getInvoiceByID($invoice_id)) && is_object($invoice->item_object))
					echo $invoice->item_object->getItemLink();
				break;
			case "price":
				if ($invoice = getInvoiceByID($invoice_id))
					echo $invoice->price();
				break;
			case "payment":
				if ($invoice = getInvoiceByID($invoice_id))
					if ($invoice->status == 'unpaid') {
						echo '<span class="w2dc-badge w2dc-invoice-status-unpaid">' . esc_html__('unpaid', 'w2dc') . '</span>';
						if (w2dc_current_user_can_edit_listing($invoice->post->ID) && current_user_can('edit_published_posts'))
							echo '<br /><a href="' . w2dc_get_edit_invoice_link($invoice_id) . '">' . esc_html__('pay invoice', 'w2dc') . '</a>';
					} elseif ($invoice->status == 'paid') {
						echo '<span class="w2dc-badge w2dc-invoice-status-paid">' . esc_html__('paid', 'w2dc') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					} elseif ($invoice->status == 'pending') {
						echo '<span class="w2dc-badge w2dc-invoice-status-pending">' . esc_html__('pending', 'w2dc') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					}
				break;
		}
	}
	
	public function remove_row_actions($actions, $post) {
		if ($post->post_type == W2DC_INVOICE_TYPE) {
			unset($actions['inline hide-if-no-js']);
			unset($actions['view']);
		}
		return $actions;
	}
	
	public function remove_create_invoice_link() {
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('new-w2dc_invoice');
	}
	
	public function remove_metaboxes() {
		remove_meta_box('submitdiv', W2DC_INVOICE_TYPE, 'side');
		remove_meta_box('slugdiv', W2DC_INVOICE_TYPE, 'normal');
		remove_meta_box('authordiv', W2DC_INVOICE_TYPE, 'normal');
	}
	
	public function add_invoice_info_metabox($post_type) {
		if ($post_type == W2DC_INVOICE_TYPE) {
			add_meta_box('w2dc_invoice_info',
					esc_html__('Invoice Info', 'w2dc'),
					array($this, 'invoice_info_metabox'),
					W2DC_INVOICE_TYPE,
					'normal',
					'high');
		}
	}
	
	public function invoice_info_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		w2dc_renderTemplate(array(W2DC_PAYMENTS_TEMPLATES_PATH, 'info_metabox.tpl.php'), array('invoice' => $invoice));
	}
	
	public function add_invoice_log_metabox($post_type) {
		global $post;

		if ($post_type == W2DC_INVOICE_TYPE) {
			if ($post && ($invoice = getInvoiceByID($post->ID)) && $invoice->log) {
				add_meta_box('w2dc_invoice_log',
						esc_html__('Invoice Log', 'w2dc'),
						array($this, 'invoice_log_metabox'),
						W2DC_INVOICE_TYPE,
						'normal',
						'high');
			}
		}
	}
	
	public function invoice_log_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		w2dc_renderTemplate(array(W2DC_PAYMENTS_TEMPLATES_PATH, 'log_metabox.tpl.php'), array('invoice' => $invoice));
	}

	public function add_invoice_payment_metabox($post_type) {
		global $post;

		if ($post_type == W2DC_INVOICE_TYPE && $post && ($invoice = getInvoiceByID($post->ID))) {
			if ($invoice->isPaymentMetabox()) {
				add_meta_box('w2dc_invoice_payment',
						esc_html__('Invoice Payment - choose payment gateway', 'w2dc'),
						array($this, 'invoice_payment_metabox'),
						W2DC_INVOICE_TYPE,
						'normal',
						'high');
			}
		}
	}
	
	public function invoice_payment_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		
		$paypal = new w2dc_paypal();
		$paypal_subscription = new w2dc_paypal_subscription();
		$bank_transfer = new w2dc_bank_transfer();
		$stripe = new w2dc_stripe();
		
		w2dc_renderTemplate(array(W2DC_PAYMENTS_TEMPLATES_PATH, 'payment_metabox.tpl.php'), array('invoice' => $invoice, 'paypal' => $paypal, 'paypal_subscription' => $paypal_subscription, 'bank_transfer' => $bank_transfer, 'stripe' => $stripe));
	}

	public function add_invoice_actions_metabox($post_type) {
		if ($post_type == W2DC_INVOICE_TYPE) {
			add_meta_box('w2dc_invoice_actions',
					esc_html__('Invoice actions', 'w2dc'),
					array($this, 'invoice_actions_metabox'),
					W2DC_INVOICE_TYPE,
					'side',
					'high');
		}
	}
	
	public function invoice_actions_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		w2dc_renderTemplate(array(W2DC_PAYMENTS_TEMPLATES_PATH, 'actions_metabox.tpl.php'), array('invoice' => $invoice));
	}
	
	public function plugin_settings($options) {
		$options['template']['menus']['payments'] = array(
			'name' => 'payments',
			'title' => esc_html__('Payments settings', 'w2dc'),
			'icon' => 'font-awesome:w2dc-fa-dollar',
			'controls' => array(
				'payments' => array(
					'type' => 'section',
					'title' => esc_html__('General payments settings', 'w2dc'),
					'description' => esc_html__('These settings are not related to price content fields. To see content fields settings - click on \'Configure\' link near price content field.', 'w2dc'),
					'fields' => array(
						array(
							'type' => 'select',
							'name' => 'w2dc_payments_currency',
							'label' => esc_html__('Currency', 'w2dc'),
							'items' => array(
								array('value' => 'USD', 'label' => esc_html__('US Dollars ($)', 'w2dc')),
								array('value' => 'EUR', 'label' => esc_html__('Euros (€)', 'w2dc')),
								array('value' => 'GBP', 'label' => esc_html__('Pounds Sterling (£)', 'w2dc')),
								array('value' => 'AUD', 'label' => esc_html__('Australian Dollars ($)', 'w2dc')),
								array('value' => 'BRL', 'label' => esc_html__('Brazilian Real (R$)', 'w2dc')),
								array('value' => 'CAD', 'label' => esc_html__('Canadian Dollars ($)', 'w2dc')),
								array('value' => 'CZK', 'label' => esc_html__('Czech Koruna (Kč)', 'w2dc')),
								array('value' => 'DKK', 'label' => esc_html__('Danish Krone (kr)', 'w2dc')),
								array('value' => 'HKD', 'label' => esc_html__('Hong Kong Dollar ($)', 'w2dc')),
								array('value' => 'HUF', 'label' => esc_html__('Hungarian Forint (Ft)', 'w2dc')),
								array('value' => 'ILS', 'label' => esc_html__('Israeli Shekel (₪)', 'w2dc')),
								array('value' => 'INR', 'label' => esc_html__('Indian Rupee (₹)', 'w2dc')),
								array('value' => 'JPY', 'label' => esc_html__('Japanese Yen (¥)', 'w2dc')),
								array('value' => 'MYR', 'label' => esc_html__('Malaysian Ringgits (RM)', 'w2dc')),
								array('value' => 'MXN', 'label' => esc_html__('Mexican Peso ($)', 'w2dc')),
								array('value' => 'NZD', 'label' => esc_html__('New Zealand Dollar ($)', 'w2dc')),
								array('value' => 'NOK', 'label' => esc_html__('Norwegian Krone (kr)', 'w2dc')),
								array('value' => 'PHP', 'label' => esc_html__('Philippine Pesos (P)', 'w2dc')),
								array('value' => 'PLN', 'label' => esc_html__('Polish Zloty (zł)', 'w2dc')),
								array('value' => 'RUB', 'label' => esc_html__('Russian Ruble (₽)', 'w2dc')),
								array('value' => 'SGD', 'label' => esc_html__('Singapore Dollar ($)', 'w2dc')),
								array('value' => 'SEK', 'label' => esc_html__('Swedish Krona (kr)', 'w2dc')),
								array('value' => 'CHF', 'label' => esc_html__('Swiss Franc (Fr)', 'w2dc')),
								array('value' => 'TWD', 'label' => esc_html__('Taiwan New Dollar ($)', 'w2dc')),
								array('value' => 'THB', 'label' => esc_html__('Thai Baht (฿)', 'w2dc')),
								array('value' => 'TRY', 'label' => esc_html__('Turkish Lira (₤)', 'w2dc')),
							),
							'description' => esc_html__('only PayPal currencies supported', 'w2dc'),
							'default' => array(get_option('w2dc_payments_currency')),
						),
						array(
							'type' => 'textbox',
							'name' => 'w2dc_payments_symbol_code',
							'label' => esc_html__('Currency symbol or code', 'w2dc'),
							'default' => get_option('w2dc_payments_symbol_code'),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'w2dc_payments_symbol_position',
							'label' => esc_html__('Currency symbol or code position', 'w2dc'),
							'items' => array(
								array('value' => 1, 'label' => '$1.00'),
								array('value' => 2, 'label' => '$ 1.00'),
								array('value' => 3, 'label' => '1.00$'),
								array('value' => 4, 'label' => '1.00 $'),
							),
							'default' => array(get_option('w2dc_payments_symbol_position')),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'w2dc_payments_decimal_separator',
							'label' => esc_html__('Decimal separator', 'w2dc'),
							'items' => array(
								array('value' => '.', 'label' => esc_html__('dot', 'w2dc')),
								array('value' => ',', 'label' => esc_html__('comma', 'w2dc')),
							),
							'default' => array(get_option('w2dc_payments_decimal_separator')),
						),
						array(
							'type' => 'toggle',
							'name' => 'w2dc_hide_decimals',
							'label' => esc_html__('Hide decimals in levels price table', 'w2dc'),
							'default' => get_option('w2dc_hide_decimals'),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'w2dc_payments_thousands_separator',
							'label' => esc_html__('Thousands separator', 'w2dc'),
							'items' => array(
								array('value' => '', 'label' => esc_html__('no separator', 'w2dc')),
								array('value' => '.', 'label' => esc_html__('dot', 'w2dc')),
								array('value' => ',', 'label' => esc_html__('comma', 'w2dc')),
								array('value' => 'space', 'label' => esc_html__('space', 'w2dc')),
							),
							'default' => array(get_option('w2dc_payments_thousands_separator')),
						),
					),
				),
				'taxes' => array(
					'type' => 'section',
					'title' => esc_html__('Sales tax', 'w2dc'),
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'w2dc_enable_taxes',
							'label' => esc_html__('Enable taxes', 'w2dc'),
							'default' => get_option('w2dc_enable_taxes'),
						),
						array(
							'type' => 'textarea',
							'name' => 'w2dc_taxes_info',
							'label' => esc_html__('Selling company information', 'w2dc'),
							'default' => get_option('w2dc_taxes_info'),
						),
						array(
							'type' => 'textbox',
							'name' => 'w2dc_tax_name',
							'label' => esc_html__('Tax name', 'w2dc'),
							'description' => esc_html__('abbreviation, e.g. "VAT"', 'w2dc'),
							'default' => get_option('w2dc_tax_name'),
						),
						array(
							'type' => 'textbox',
							'name' => 'w2dc_tax_rate',
							'label' => esc_html__('Tax rate', 'w2dc'),
							'description' => esc_html__('In percents', 'w2dc'),
							'default' => get_option('w2dc_tax_rate'),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'w2dc_taxes_mode',
							'label' => esc_html__('Include or exclude value added taxes', 'w2dc'),
							'description' => esc_html__('Do you want prices on the website to be quoted including or excluding value added taxes?', 'w2dc'),
							'items' => array(
								array('value' => 'include', 'label' => esc_html__('Include', 'w2dc')),
								array('value' => 'exclude', 'label' => esc_html__('Exclude', 'w2dc')),
							),
							'default' => array(get_option('w2dc_taxes_mode')),
						),
					),
				),
				'bank' => array(
					'type' => 'section',
					'title' => esc_html__('Bank transfer settings', 'w2dc'),
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'w2dc_allow_bank',
							'label' => esc_html__('Allow bank transfer', 'w2dc'),
							'default' => get_option('w2dc_allow_bank'),
						),
						array(
							'type' => 'textarea',
							'name' => 'w2dc_bank_info',
							'label' => esc_html__('Bank transfer information', 'w2dc'),
							'default' => get_option('w2dc_bank_info'),
						),
					),
				),
				'paypal' => array(
					'type' => 'section',
					'title' => esc_html__('PayPal settings', 'w2dc'),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'w2dc_paypal_email',
							'label' => esc_html__('Business email', 'w2dc'),
							'default' => get_option('w2dc_paypal_email'),
						),
						array(
							'type' => 'toggle',
							'name' => 'w2dc_paypal_single',
							'label' => esc_html__('Allow single payment', 'w2dc'),
							'default' => get_option('w2dc_paypal_single'),
						),
						array(
							'type' => 'toggle',
							'name' => 'w2dc_paypal_subscriptions',
							'label' => esc_html__('Allow subscriptions', 'w2dc'),
							'description' => esc_html__('Only for listings with limited active period', 'w2dc'),
							'default' => get_option('w2dc_paypal_subscriptions'),
						),
						array(
							'type' => 'toggle',
							'name' => 'w2dc_paypal_test',
							'label' => esc_html__('Test Sandbox mode', 'w2dc'),
							'description' => sprintf(wp_kses(__('You must have a <a href="%s" target="_blank">PayPal Sandbox</a> account setup before using this feature. <a href="%s">IPN URL</a>', 'w2dc'), 'post'), 'https://sandbox.paypal.com/', home_url('ipn_token/'.ipn_token().'/gateway/paypal')),
							'default' => get_option('w2dc_paypal_test'),
						),
					),
				),
				'stripe' => array(
					'type' => 'section',
					'title' => esc_html__('Stripe settings', 'w2dc'),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'w2dc_stripe_test_secret',
							'label' => esc_html__('Test secret key', 'w2dc'),
							'default' => get_option('w2dc_stripe_test_secret'),
						),
						array(
							'type' => 'textbox',
							'name' => 'w2dc_stripe_test_public',
							'label' => esc_html__('Test publishable key', 'w2dc'),
							'default' => get_option('w2dc_stripe_test_public'),
						),
						array(
							'type' => 'textbox',
							'name' => 'w2dc_stripe_live_secret',
							'label' => esc_html__('Live secret key', 'w2dc'),
							'default' => get_option('w2dc_stripe_live_secret'),
						),
						array(
							'type' => 'textbox',
							'name' => 'w2dc_stripe_live_public',
							'label' => esc_html__('Live publishable key', 'w2dc'),
							'default' => get_option('w2dc_stripe_live_public'),
						),
						array(
							'type' => 'toggle',
							'name' => 'w2dc_stripe_test',
							'label' => esc_html__('Test Sandbox mode', 'w2dc'),
							'description' => wp_kses(__('You can only use <a href="http://stripe.com/" target="_blank">Stripe</a> in test mode until you activate your account.', 'w2dc'), 'post'),
							'default' => get_option('w2dc_stripe_test'),
						),
					),
				),
			),
		);
		
		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
				'type' => 'textarea',
				'name' => 'w2dc_invoice_create_notification',
				'label' => esc_html__('Notification of new invoice', 'w2dc'),
				'default' => get_option('w2dc_invoice_create_notification'),
				'description' => esc_html__('Tags allowed: ', 'w2dc') . '[author], [invoice], [id], [billing], [item], [price], [link]',
		);

		$options['template']['menus']['notifications']['controls']['notifications']['fields'][] = array(
				'type' => 'textarea',
				'name' => 'w2dc_invoice_paid_notification',
				'label' => esc_html__('Notification of paid invoice', 'w2dc'),
				'default' => get_option('w2dc_invoice_paid_notification'),
				'description' => esc_html__('Tags allowed: ', 'w2dc') . '[author], [invoice], [price]',
		);
		
		return $options;
	}

	public function register_invoice_type() {
		$args = array(
			'labels' => array(
				'name' => esc_html__('Directory invoices', 'w2dc'),
				'singular_name' => esc_html__('Directory invoice', 'w2dc'),
				'edit_item' => esc_html__('View Invoice', 'w2dc'),
				'search_items' => esc_html__('Search invoices', 'w2dc'),
				'not_found' =>  esc_html__('No invoices found', 'w2dc'),
				'not_found_in_trash' => esc_html__('No invoices found in trash', 'w2dc')
			),
			'capabilities' => array(
				'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
			),
			'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
			'has_archive' => true,
			'description' => esc_html__('Directory invoices', 'w2dc'),
			'show_ui' => true,
			'supports' => array('author'),
			'menu_icon' => W2DC_PAYMENTS_RESOURCES_URL . 'images/dollar.png',
		);
		register_post_type(W2DC_INVOICE_TYPE, $args);
	}
	
	function disable_new_invoices_page() {
		if (isset($_GET['post_type']) && $_GET['post_type'] == W2DC_INVOICE_TYPE)
			wp_die("You ain't allowed to do that!");
	}
	function disable_new_invoices_link() {
		global $submenu;
		unset($submenu['edit.php?post_type=' . W2DC_INVOICE_TYPE][10]);

		if (function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if ($screen && $screen->post_type == W2DC_INVOICE_TYPE)
				echo '<style type="text/css">.add-new-h2, h1 .page-title-action { display:none; }</style>';
		}
	}
	
	public function loadPricesByLevels($level = null, $array = array()) {
		global $w2dc_instance, $wpdb;

		if (!$array) {
			$array = $wpdb->get_results("SELECT * FROM {$wpdb->w2dc_levels} ORDER BY order_num", ARRAY_A);

			foreach ($array AS $row) {
				$w2dc_instance->levels->levels_array[$row['id']]->price = $row['price'];
				$w2dc_instance->levels->levels_array[$row['id']]->raiseup_price = $row['raiseup_price'];
				
				if (is_object($level) && $level->id == $row['id']) {
					$level->price = $row['price'];
					$level->raiseup_price = $row['raiseup_price'];
				}
			}
		} else {
			$level->price = $array['price'];
			$level->raiseup_price = $array['raiseup_price'];
		}
		
		return $level;
	}
	
	public function levels_price_in_level_html($level) {
		w2dc_renderTemplate(array(W2DC_PAYMENTS_PATH, 'templates/levels_price_in_level.tpl.php'), array('level' => $level));
	}
	
	public function levels_price_in_level_validation($validation) {
		$validation->set_rules('price', esc_html__('Listings price', 'w2dc'), 'is_numeric');
		$validation->set_rules('raiseup_price', esc_html__('Listings raise up price', 'w2dc'), 'is_numeric');
		
		return $validation;
	}
	
	public function levels_price_in_level_create_add($insert_update_args, $array) {
		$insert_update_args['price'] = w2dc_getValue($array, 'price', 0);
		$insert_update_args['raiseup_price'] = w2dc_getValue($array, 'raiseup_price', 0);
		return $insert_update_args;
	}
	
	public function levels_price_table_header($columns) {
		$w2dc_columns['price'] = esc_html__('Price', 'w2dc');
		
		return array_slice($columns, 0, 2, true) + $w2dc_columns + array_slice($columns, 2, count($columns)-2, true);
	}

	public function levels_price_table_row($items_array, $level) {
		$w2dc_columns['price'] = formatPrice($level->price);
		
		return array_slice($items_array, 0, 1, true) + $w2dc_columns + array_slice($items_array, 1, count($items_array)-1, true);
	}

	public function levels_price_front_table_row($price, $level) {
		if ($level->price == 0) {
			return 0;
		} else {
			$thousands_separator = get_option('w2dc_payments_thousands_separator');
			if ($thousands_separator == 'space') {
				$thousands_separator = ' ';
			}

			$value = explode('.', number_format($level->price, 2, '.', $thousands_separator));
			$cents = array_pop($value);
			$price = implode('.', $value);
			if (!get_option('w2dc_hide_decimals')) {
				$out = $price . '<span class="w2dc-price-cents">' . $cents . '</span>';
			} else { 
				$out = $price;
			}
			switch (get_option('w2dc_payments_symbol_position')) {
				case 1:
					$out = get_option('w2dc_payments_symbol_code') . $out;
					break;
				case 2:
					$out = get_option('w2dc_payments_symbol_code') . ' ' . $out;
					break;
				case 3:
					$out = $out . get_option('w2dc_payments_symbol_code');
					break;
				case 4:
					$out = $out . ' ' . get_option('w2dc_payments_symbol_code');
					break;
			}
			return $out;
		}
	}
	
	public function levels_upgrade_meta($upgrade_meta, $level) {
		global $w2dc_instance;
	
		if (w2dc_getValue($_GET, 'page') == 'w2dc_manage_upgrades') {
			$results = array();
			foreach ($w2dc_instance->levels->levels_array AS $_level) {
				if (($price = w2dc_getValue($_POST, 'level_price_' . $level->id . '_' . $_level->id)) && is_numeric($price)) {
					$results[$_level->id]['price'] = $price;
				} else {
					$results[$_level->id]['price'] = 0;
				}
			}
	
			foreach ($upgrade_meta AS $level_id=>$meta) {
				if (isset($results[$level_id])) {
					$upgrade_meta[$level_id] = $results[$level_id] + $upgrade_meta[$level_id];
				}
			}
		}
	
		return $upgrade_meta;
	}
	
	public function levels_upgrade_meta_html($level1, $level2) {
		if (isset($level1->upgrade_meta[$level2->id]) && isset($level1->upgrade_meta[$level2->id]['price'])) {
			$price = $level1->upgrade_meta[$level2->id]['price'];
		} else {
			$price = 0;
		}
	
		echo get_option('w2dc_payments_symbol_code') . '<input type="text" size="4" name="level_price_' . $level1->id . '_' . $level2->id . '" value="' . esc_attr($price) . '" /><br />';
	}
	
	public function pay_invoice_step($step, $level = null) {
		if ($level && recalcPrice($level->price)) {
			echo '<div class="w2dc-adv-line"></div>';
			echo '<div class="w2dc-adv-step">';
			echo '<div class="w2dc-adv-circle">' . esc_html__('Step', 'w2dc') . $step++ . '</div>';
			echo esc_html__('Pay Invoice', 'w2dc');
			echo '</div>';
		}
		return $step++;
	}
	
	public function create_price($link_text, $listing) {
		return  $link_text .' - ' . formatPrice(recalcPrice($listing->level->price));
	}

	public function raiseup_price($link_text, $listing) {
		return  $link_text .' - ' . formatPrice(recalcPrice($listing->level->raiseup_price));
	}

	public function renew_price($link_text, $listing) {
		global $w2dc_instance;
		
		if ($w2dc_instance->listings_packages->can_user_create_listing_in_level($listing->level->id)) {
			return $link_text .' - ' . esc_html__('FREE', 'w2dc');
		} else {
			return $link_text .' - ' . formatPrice(recalcPrice($listing->level->price));
		}
		
		return $link_text;
	}

	public function upgrade_price($link_text, $old_level, $new_level) {
		return  $link_text .' - ' . (isset($old_level->upgrade_meta[$new_level->id]) ? formatPrice(recalcPrice($old_level->upgrade_meta[$new_level->id]['price'])) : formatPrice(0));
	}

	public function print_invoice_template($template) {
		global $w2dc_instance;

		if (is_page($w2dc_instance->index_page_id) && $w2dc_instance->action == 'printinvoice' && isset($_GET['invoice_id']) && is_numeric($_GET['invoice_id'])) {
			if (w2dc_current_user_can_edit_listing($_GET['invoice_id'])) {
				// check all folders
				if (!($template = w2dc_isTemplate('w2dc_payments/invoice_print.tpl.php')) && !($template = w2dc_isTemplate('w2dc_payments/invoice_print-custom.tpl.php'))) {
					if (!($template = w2dc_isTemplate('invoice_print.tpl.php')) && !($template = w2dc_isTemplate('invoice_print-custom.tpl.php'))) {
						$template = W2DC_PAYMENTS_TEMPLATES_PATH . 'invoice_print.tpl.php';
					}
				}
			} else
				wp_die('You are not able to access this page!');
		}
		return $template;
	}

	public function invoice_actions() {
		if (isset($_GET['post']) && is_numeric($_GET['post']) && w2dc_current_user_can_edit_listing($_GET['post'])) {
			$invoice_id = $_GET['post'];
			if (($post = get_post($invoice_id)) && $post->post_type == W2DC_INVOICE_TYPE && ($invoice = getInvoiceByID($invoice_id))) {
				$redirect = false;
				if (isset($_GET['w2dc_gateway']) && !$invoice->gateway) {
					switch ($_GET['w2dc_gateway']) {
						case 'paypal':
							if (get_option('w2dc_paypal_email') && get_option('w2dc_paypal_single'))
								$gateway = $_GET['w2dc_gateway'];
							break;
						case 'paypal_subscription':
							if (get_option('w2dc_paypal_email') && get_option('w2dc_paypal_subscriptions') && $invoice->is_subscription)
								$gateway = $_GET['w2dc_gateway'];
							break;
						case 'stripe':
							if ((get_option('w2dc_stripe_test') && get_option('w2dc_stripe_test_secret') && get_option('w2dc_stripe_test_public')) || (get_option('w2dc_stripe_live_secret') && get_option('w2dc_stripe_live_public')))
								$gateway = $_GET['w2dc_gateway'];
							break;
						case 'bank_transfer':
							if (get_option('w2dc_allow_bank'))
								$gateway = $_GET['w2dc_gateway'];
							break;
					}
					if (isset($gateway)) {
						$invoice->setStatus('pending');
						$invoice->setGateway($gateway);

						$gateway = $invoice->getGatewayObject();
						$invoice->logMessage(sprintf(esc_html__('Payment gateway was selected: %s', 'w2dc'), $gateway->name()));
						w2dc_addMessage(esc_html__('Payment gateway was selected!', 'w2dc'));
						$gateway->submitPayment($invoice);
						$redirect = true;
					}
				}
	
				if (isset($_GET['invoice_action']) && $_GET['invoice_action'] == 'reset_gateway') {
					$invoice->setStatus('unpaid');
					$invoice->setGateway('');
					$invoice->logMessage(esc_html__('Payment gateway was reset', 'w2dc'));
					w2dc_addMessage(esc_html__('Payment gateway was reset!', 'w2dc'));
					$redirect = true;
				}
				
				if (isset($_GET['invoice_action']) && $_GET['invoice_action'] == 'set_paid' && $invoice->status != 'paid' && current_user_can('edit_others_posts')) {
					if ($invoice->item_object->complete()) {
						$invoice->setStatus('paid');
						$invoice->logMessage(esc_html__('Invoice was manually set as paid', 'w2dc'));
						w2dc_addMessage(esc_html__('Invoice was manually set as paid!', 'w2dc'));
					} else 
						w2dc_addMessage(esc_html__('An error has occured!', 'w2dc'), 'error');
					$redirect = true;
				}

				if ($redirect) {
					wp_redirect(w2dc_get_edit_invoice_link($invoice_id, 'redirect'));
					die();
				}
			}
		}
	}
	
	public function w2dc_payments_query_vars($vars) {
		$vars[] = 'ipn_token';
		$vars[] = 'gateway';

		return $vars;
	}
	
	public function prevent_users_see_other_invoices($wp_query) {
		global $current_user;
		if (is_admin() && $current_user && !current_user_can('edit_others_posts') && isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == W2DC_INVOICE_TYPE) {
			$wp_query->set('author', $current_user->ID);
			add_filter('views_edit-'.W2DC_INVOICE_TYPE, array($this, 'remove_invoices_counts'));
		}
	}
	public function remove_invoices_counts($views) {
		return array();
	}

	public function remove_bulk_actions($actions) {
		return array();
	}
	
	public function process_invoices_query($frontend_controller) {
		global $w2dc_instance;

		if ($w2dc_instance->action == 'invoices') {
			if (get_query_var('page'))
				$paged = get_query_var('page');
			elseif (get_query_var('paged'))
				$paged = get_query_var('paged');
			else
				$paged = 1;
		} else
			$paged = -1;

		$args = array(
				'post_type' => W2DC_INVOICE_TYPE,
				'author' => get_current_user_id(),
				'paged' => $paged,
				'posts_per_page' => 10,
		);
		$frontend_controller->invoices_query = new WP_Query($args);
		wp_reset_postdata();
	}
	
	public function add_invoices_dashboard_link($frontend_controller) {
		global $w2dc_instance;
		$this->process_invoices_query($frontend_controller);

		echo '<li ' . (($frontend_controller->active_tab == 'invoices') ? 'class="w2dc-active"' : '') . '><a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'invoices')) . '">' . esc_html__('Invoices', 'w2dc'). ' (' . $frontend_controller->invoices_query->found_posts . ')</a></li>';
	}
	
	public function handle_dashboard_controller($frontend_controller) {
		global $w2dc_instance;

		if (get_class($frontend_controller) == 'w2dc_dashboard_controller') {
			$login_registrations = new w2dc_login_registrations;
			if ($login_registrations->is_action()) {
				$frontend_controller->template = $login_registrations->process($frontend_controller);
			} elseif (!is_user_logged_in()) {
				if (w2dc_get_wpml_dependent_option('w2dc_submit_login_page') && w2dc_get_wpml_dependent_option('w2dc_submit_login_page') != get_the_ID()) {
					$url = get_permalink(w2dc_get_wpml_dependent_option('w2dc_submit_login_page'));
					$url = add_query_arg('redirect_to', urlencode(get_permalink()), $url);
					wp_redirect($url);
				} else {
					$frontend_controller->template = $login_registrations->login_template();
				}
			} else {
				if ($w2dc_instance->action == 'invoices') {
					$this->process_invoices_query($frontend_controller);
			
					$frontend_controller->invoices = array();
					while ($frontend_controller->invoices_query->have_posts()) {
						$frontend_controller->invoices_query->the_post();
							
						$invoice = getInvoiceByID(get_the_ID());
						$frontend_controller->invoices[get_the_ID()] = $invoice;
					}
					// this is reset is really required after the loop ends
					wp_reset_postdata();
						
					$frontend_controller->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$frontend_controller->subtemplate = array(W2DC_PAYMENTS_TEMPLATES_PATH, 'invoices_dashboard.tpl.php');
					$frontend_controller->active_tab = 'invoices';
				} elseif ($w2dc_instance->action == 'view_invoice' && isset($_GET['post']) && is_numeric($_GET['post']) && w2dc_current_user_can_edit_listing($_GET['post'])) {
					if ($frontend_controller->invoice = getInvoiceByID($_GET['post'])) {
						$frontend_controller->paypal = new w2dc_paypal();
						$frontend_controller->paypal_subscription = new w2dc_paypal_subscription();
						$frontend_controller->bank_transfer = new w2dc_bank_transfer();
						$frontend_controller->stripe = new w2dc_stripe();
			
						$frontend_controller->template = array(W2DC_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
						$frontend_controller->subtemplate = array(W2DC_PAYMENTS_TEMPLATES_PATH, 'view_invoice_dashboard.tpl.php');
						$frontend_controller->active_tab = 'invoices';
					}
				}
			}
		}

		return $frontend_controller;
	}
	
	public function edit_invoices_links($url, $post_id) {
		global $w2dc_instance;

		if (!is_admin() && $w2dc_instance->dashboard_page_url && get_post_type($post_id) == W2DC_INVOICE_TYPE) {
			return w2dc_dashboardUrl(array('w2dc_action' => 'view_invoice', 'post' => $post_id));
		}
		
		return $url;
	}
	
	function map_meta_cap($caps, $cap, $user_id, $args) {
		if ('edit_post' == $cap) {
			if ($post = get_post($args[0])) {
				$post_type = get_post_type_object($post->post_type);
				if (is_object($post_type) && $post_type->name == W2DC_INVOICE_TYPE) {
					$caps = array();
					if ($user_id == $post->post_author)
						$caps[] = $post_type->cap->edit_posts;
					else
						$caps[] = $post_type->cap->edit_others_posts;
				}
			}
		}
		return $caps;
	}
	
	function invoices_search_post_id($search, $wp_query) {
		if (w2dc_getValue($_GET, 'post_type') == 'w2dc_invoice') {
		    if (!is_admin()) {
		        return $search;
		    }
		
		    if (!$wp_query->is_main_query() && !$wp_query->is_search()) {
		        return $search;
		    }   
		
		    $search_string = get_query_var('s');
		
		    if (!filter_var($search_string, FILTER_VALIDATE_INT)) {
		        return $search;
		    }
		
		    return "AND wp_posts.ID = '" . intval($search_string)  . "'";
		}
		return $search;
	}
	
	function apply_payment_link($invoice) {
		global $w2dc_instance;

		if ($listing = $invoice->item_object->getItem() ) {
			switch ($invoice->item_object->name) {
				case 'listing':
					$level_id = $listing->level->id;
					$action = esc_html__("activate", "w2dc");
					break;
				case 'listing_raiseup':
					$level_id = $listing->level->id;
					$action = esc_html__("raise up", "w2dc");
					break;
				case 'listing_upgrade':
					$level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
					$action = esc_html__("upgrade", "w2dc");
					break;
			}
			
			if ($invoice->status != 'paid') {
				if ($w2dc_instance->listings_packages->can_user_create_listing_in_level($level_id)) {
					$title = esc_attr(strip_tags($w2dc_instance->listings_packages->available_listings_descr($level_id, esc_html__('renew', 'w2dc'))));
					echo "<br />";
					echo $w2dc_instance->listings_packages->available_listings_descr($level_id, $action);
					echo esc_html__('You can', 'w2dc') . ' <a href="' . wp_nonce_url(add_query_arg('apply_listing_payment', $listing->post->ID), 'w2dc_invoice_apply', '_nonce') . '">' . esc_html__('apply payment', 'w2dc') . '</a>.';
				}
			}
		}
	}
	
	function apply_payment() {
		global $w2dc_instance;
	
		if (isset($_GET['apply_listing_payment']) && is_numeric($_GET['apply_listing_payment']) && isset($_GET['post']) && is_numeric($_GET['post'])) {
			if (isset($_GET['_nonce']) && wp_verify_nonce($_GET['_nonce'], 'w2dc_invoice_apply')) {
				if ($invoice = getInvoiceByID($_GET['post'])) {
					$listing = $invoice->item_object->getItem();
					switch ($invoice->item_object->name) {
						case 'listing':
							$level_id = $listing->level->id;
							break;
						case 'listing_raiseup':
							$level_id = $listing->level->id;
							break;
						case 'listing_upgrade':
							$level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
							break;
					}
					
					if ($w2dc_instance->listings_packages->can_user_create_listing_in_level($level_id)) {
						if ($invoice->item_object->complete()) {
							$invoice->setStatus('paid');
							$invoice->logMessage(esc_html__('Payment applied from user listings package.', 'w2dc'));
	
							$w2dc_instance->listings_packages->process_listing_creation_for_user($listing->level->id);
							
							wp_redirect(remove_query_arg('apply_listing_payment'));
							die();
						}
					}
				}
			}
		}
	}
}

function recalcPrice($price) {
	// if any services are free for admins - show 0 price
	if (get_option('w2dc_payments_free_for_admins') && current_user_can('manage_options')) {
		return 0;
	} else
		return $price;
}

function formatPrice($value = 0) {
	if ($value == 0) {
		$out = '<span class="w2dc-payments-free">' . esc_html__('FREE', 'w2dc') . '</span>';
	} else {
		$decimal_separator = get_option('w2dc_payments_decimal_separator');

		$thousands_separator = get_option('w2dc_payments_thousands_separator');
		if ($thousands_separator == 'space')
			$thousands_separator = ' ';

		$value = number_format($value, 2, $decimal_separator, $thousands_separator); 

		$out = '$ '.$value;
		switch (get_option('w2dc_payments_symbol_position')) {
			case 1:
				$out = get_option('w2dc_payments_symbol_code') . $value;
				break;
			case 2:
				$out = get_option('w2dc_payments_symbol_code') . ' ' . $value;
				break;
			case 3:
				$out = $value . get_option('w2dc_payments_symbol_code');
				break;
			case 4:
				$out = $value . ' ' . get_option('w2dc_payments_symbol_code');
				break;
		}
	}
	return $out;
}

function ipn_token() {
	return md5(site_url() . wp_salt());
}

function w2dc_install_payments() {
	global $wpdb;

	// there may be possible issue in WP, on some servers it doesn't allow to execute more than one SQL query in one request
	$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `price` FLOAT( 2 ) NOT NULL DEFAULT '0' AFTER `order_num`");
	if (array_search('price', $wpdb->get_col("DESC {$wpdb->w2dc_levels}"))) {
		$wpdb->query("ALTER TABLE {$wpdb->w2dc_levels} ADD `raiseup_price` FLOAT( 2 ) NOT NULL DEFAULT '0' AFTER `price`");
		if (array_search('raiseup_price', $wpdb->get_col("DESC {$wpdb->w2dc_levels}"))) {
			update_option('w2dc_payments_free_for_admins', 0);
			update_option('w2dc_payments_currency', 'USD');
			update_option('w2dc_payments_symbol_code', '$');
			update_option('w2dc_payments_symbol_position', 1);
			update_option('w2dc_payments_decimal_separator', ',');
			update_option('w2dc_payments_thousands_separator', 'space');
			update_option('w2dc_allow_bank', 1);
			update_option('w2dc_bank_info', '');
			update_option('w2dc_paypal_email', '');
			update_option('w2dc_paypal_subscriptions', 1);
			update_option('w2dc_paypal_test', 0);
			
			w2dc_upgrade_payments('1.6.0');
			w2dc_upgrade_payments('1.8.0');
			w2dc_upgrade_payments('1.9.0');
			w2dc_upgrade_payments('1.9.4');
			w2dc_upgrade_payments('1.12.7');
			w2dc_upgrade_payments('1.14.10');
			
			update_option('w2dc_installed_payments', 1);
		}
	}
}

function w2dc_upgrade_payments($new_version) {
	if ($new_version == '1.6.0') {
		update_option('w2dc_stripe_test_secret', '');
		update_option('w2dc_stripe_test_public', '');
		update_option('w2dc_stripe_live_secret', '');
		update_option('w2dc_stripe_live_public', '');
		update_option('w2dc_stripe_test', 1);
	}

	if ($new_version == '1.8.0') {
		update_option('w2dc_paypal_single', 1);
	}

	if ($new_version == '1.9.0') {
		update_option('w2dc_enable_taxes', 0);
		update_option('w2dc_taxes_info', '');
		update_option('w2dc_tax_name', '');
		update_option('w2dc_tax_rate', 0);
		update_option('w2dc_taxes_mode', 'include');
	}
	
	if ($new_version == '1.9.4') {
		update_option('w2dc_hide_decimals', 0);
	}

	if ($new_version == '1.12.7') {
		update_option('w2dc_invoice_paid_notification', 'Hello [author],

your invoice "[invoice]" was successfully set as paid.

Price: [price]');
	}

	if ($new_version == '1.14.10') {
		update_option('w2dc_invoice_create_notification', 'Hello [author],

new invoice was created "[invoice]".

Invoice ID: [id]

[billing]

Item: [item]

Price: [price]

You can pay by this link: [link]');
	}
}

function w2dc_get_edit_invoice_link($invoice_id, $context = 'display') {
	if (w2dc_current_user_can_edit_listing($invoice_id)) {
		return apply_filters('w2dc_get_edit_invoice_link', get_edit_post_link($invoice_id, $context), $invoice_id);
	}
}

global $w2dc_payments_instance;

$w2dc_payments_instance = new w2dc_payments_plugin();
$w2dc_payments_instance->init();

?>