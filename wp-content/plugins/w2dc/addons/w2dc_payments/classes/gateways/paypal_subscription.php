<?php

// @codingStandardsIgnoreFile

/**
 * Paypal Subscription Class
 *
 */

class w2dc_paypal_subscription extends w2dc_payment_gateway
{
    /**
	 * Initialize the Paypal gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
        parent::__construct();

        // Some default values of the class
		$this->gatewayUrl = 'https://www.paypal.com/cgi-bin/webscr';
		$this->ipnLogFile = 'paypal.ipn_results.log';

		// Populate $fields array with a few default
		$this->addField('rm', '2');           // Return method = POST
		$this->addField('src', '1');
		$this->addField('cmd', '_xclick-subscriptions');
		$this->addField('no_note', '1');
	}

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    public function enableTestMode()
    {
        $this->testMode = TRUE;
        $this->gatewayUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    
	public function name() {
    	return esc_html__('PayPal subscription', 'w2dc');
    }

    public function description() {
    	return esc_html__('Regular automatic payments from your PayPal account.', 'w2dc');
    }
    
    public function buy_button()
    {
    	return '<img src="' . W2DC_PAYMENTS_RESOURCES_URL . 'images/paypal_s.png" />';
    }
    
    public function calcRecurringPeriod($invoice)
    {
    	$active_period = $invoice->item_object->getItemOptions();
    	if (isset($active_period['active_interval']) && isset($active_period['active_period'])) {
    		if ($active_period['active_period'] == 'day') {
    			$unit = 'D';
    		}
    		if ($active_period['active_period'] == 'week') {
    			$unit = 'W';
    		}
    		if ($active_period['active_period'] == 'month') {
    			$unit = 'M';
    		}
    		if ($active_period['active_period'] == 'year') {
    			$unit = 'Y';
    		}
    		$duration = $active_period['active_interval'];

    		if (isset($unit) && isset($duration))
    			return array('unit' => $unit, 'duration' => $duration);
    	}
    	return false;
    }
    
    public function submitPayment($invoice) {
    	if (!($period = $this->calcRecurringPeriod($invoice))) {
    		$invoice->setGateway('');
    		w2dc_addMessage(esc_html__('This item is not allowed to be paid as subscription or it is not possible to pay for recurring cycle of this item using selected payment gateway.', 'w2dc'), 'error');
    		wp_redirect(w2dc_get_edit_invoice_link($invoice->post->ID));
    		die();
    	}
    	
    	if (get_option('w2dc_paypal_test'))
    		$this->enableTestMode();

    	$this->addField('business', get_option('w2dc_paypal_email'));
    	$this->addField('return', urlencode(w2dc_get_edit_invoice_link($invoice->post->ID)));
    	$this->addField('cancel_return', urlencode(w2dc_get_edit_invoice_link($invoice->post->ID)));
    	$this->addField('notify_url', home_url('ipn_token/'.ipn_token().'/gateway/paypal_subscription'));
    	$this->addField('item_name', $invoice->post->post_title);
    	$this->addField('item_number', $invoice->post->ID);
    	$this->addField('currency_code', get_option('w2dc_payments_currency'));
    	$this->addField('a3', $invoice->taxesPrice(false));
    	$this->addField('p3', $period['duration']);
    	$this->addField('t3', $period['unit']);
    	 
    	header("Location: " . $this->buildPaymentLink());
    	die();
    }

    /**
	 * Validate the IPN notification
	 *
	 * @param none
	 * @return boolean
	 */
	public function validateIpn()
	{
		// parse the paypal URL
		$urlParsed = parse_url($this->gatewayUrl);

		// generate the post string from the _POST vars
		$postString = '';

		foreach ($_POST as $field=>$value)
		{
			$this->ipnData["$field"] = $value;
			
			$postString .= $field .'=' . preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}', urlencode(stripslashes($value))) . '&';
		}

		$postString .="cmd=_notify-validate"; // append ipn command

		// open the connection to paypal
		$fp = fsockopen('ssl://'.$urlParsed['host'], "443", $errno, $errstr, 30);

		if(!$fp)
		{
			// Could not open the connection, log error if enabled
			$this->lastError = "fsockopen error no. $errno: $errstr";
			$this->logResults(false);

			return false;
		}
		else
		{
			// Post the data back to paypal

			fputs($fp, "POST " . $urlParsed['path'] . " HTTP/1.1\r\n");
			fputs($fp, "Host: " . $urlParsed['host'] . "\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded; charset=windows-1252\r\n");
			fputs($fp, "Content-length: " . strlen($postString) . "\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $postString . "\r\n\r\n");

			// loop through the response from the server and append to variable
			while(!feof($fp))
			{
				$this->ipnResponse .= fgets($fp, 1024);
			}

		 	fclose($fp); // close connection
		}

		if (preg_match("/VERIFIED/", $this->ipnResponse))
		{
		 	// Valid IPN transaction.
		 	$this->logResults(true);
		 	return true;
		}
		else
		{
		 	// Invalid IPN transaction.  Check the log for details.
			$this->lastError = "IPN Validation Failed " . $urlParsed['path'] . ":" . $urlParsed['host'];
			$this->logResults(false);
			return false;
		}
	}
}

function w2dc_handle_ipn_paypal_subscription($wp) {
	if (array_key_exists('ipn_token', $wp->query_vars) && $wp->query_vars['ipn_token'] == ipn_token() && array_key_exists('gateway', $wp->query_vars) && $wp->query_vars['gateway'] == 'paypal_subscription') {
		$paypal = new w2dc_paypal_subscription();
		if (get_option('w2dc_paypal_test')) {
			$paypal->enableTestMode();
		}

		if ($paypal->validateIpn()) {
			if (strcasecmp($paypal->ipnData['business'], get_option('w2dc_paypal_email')) === 0) {
				$invoice_id = $paypal->ipnData['item_number'];
				if ($invoice = getInvoiceByID($invoice_id)) {
					switch ($paypal->ipnData['txn_type']) {
						// seems, there is a bug in paypal subscriptions alghoritm: 'subscr_payment' IPN was received before 'subscr_signup' IPN
						case 'subscr_payment':
							if (is_unique_transaction($paypal->ipnData['txn_id'])) {
								if ($invoice->price && floatval($paypal->ipnData['mc_gross']) == $invoice->taxesPrice(false) && $paypal->ipnData['mc_currency'] == get_option('w2dc_payments_currency')) {
									if (w2dc_create_transaction(
											$paypal->name(),
											$paypal->ipnData['item_number'],
											$paypal->ipnData['payment_status'],
											$paypal->ipnData['txn_id'],
											$paypal->ipnData['mc_gross'],
											$paypal->ipnData['mc_fee'],
											$paypal->ipnData['mc_currency'],
											1,
											$paypal->ipnData
									)) {
										if ($paypal->ipnData['payment_status'] == 'Completed') {
											if ($invoice->item_object->complete()) {
												$invoice->setStatus('paid');
												$transaction_data = array();
												foreach ($paypal->ipnData AS $key=>$value) {
													$transaction_data[] = $key . ' = ' . esc_attr($value);
												}
												$invoice->logMessage(sprintf(esc_html__('Recurring payment was successfully completed. Transaction data:  %s', 'w2dc'), implode('; ', $transaction_data)));
											}
										} else {
											$invoice->logMessage(sprintf(esc_html__('Payment status: %s', 'w2dc'),  $paypal->ipnData['payment_status']));
										}
									}
								}
							}
							break;
						case 'subscr_cancel':
						case 'subscr_eot':
							$invoice->logMessage(esc_html__('Subscription canceled', 'w2dc'));
							break;
					}
				}
			}
		} else {
			$wp_error = new WP_Error(403, $paypal->ipnResponse);
			w2dc_error_log($wp_error);
		}

		die();
	}
}
add_action('parse_request', 'w2dc_handle_ipn_paypal_subscription');

function w2dc_handle_ipn_paypal_subscription_rewrite_rules($rules) {
	return array('ipn_token/'.ipn_token().'/gateway/paypal_subscription' => 'index.php?ipn_token='.ipn_token().'&gateway=paypal_subscription') + $rules;
}
add_filter('rewrite_rules_array', 'w2dc_handle_ipn_paypal_subscription_rewrite_rules');

function w2dc_ipn_paypal_subscription_rewrite_rules() {
	if ($rules = get_option('rewrite_rules'))
		if (!isset($rules['ipn_token/'.ipn_token().'/gateway/paypal_subscription'])) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
}
add_action('wp_loaded', 'w2dc_ipn_paypal_subscription_rewrite_rules');
