<?php

// @codingStandardsIgnoreFile

class w2dc_stripe extends w2dc_payment_gateway
{
	public $secret_key;
	public $publishable_key;

    /**
	 * Initialize the Stripe gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct() {
        parent::__construct();

        $this->secret_key = get_option('w2dc_stripe_live_secret');
        $this->publishable_key = get_option('w2dc_stripe_live_public');
        
        if (get_option('w2dc_stripe_test'))
        	$this->enableTestMode();
	}

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    public function enableTestMode() {
        $this->secret_key = get_option('w2dc_stripe_test_secret');
        $this->publishable_key = get_option('w2dc_stripe_test_public');
    }
    
    public function name() {
    	return esc_html__('Stripe', 'w2dc');
    }

    public function description() {
    	return esc_html__('One time payment by Stripe. After successful transaction listing will become active and raised up.', 'w2dc');
    }
    
    public function buy_button() {
    	return '<img src="' . W2DC_PAYMENTS_RESOURCES_URL . 'images/stripe.png" />';
    }
    
    public function submitPayment($invoice) {
    	include_once W2DC_PAYMENTS_PATH . 'classes/gateways/stripe/init.php';

		\Stripe\Stripe::setApiKey($this->secret_key);

		$token = $_POST['stripe_token'];

		$customer = \Stripe\Customer::create(array(
				'email' => $_POST['stripe_email'],
				'card' => $token
		));

		try {
			$charge = \Stripe\Charge::create(array(
					'customer' => $customer->id,
					'amount' => $invoice->taxesPrice(false)*100,
					'currency' => get_option('w2dc_payments_currency')
			));
		} catch(\Stripe\CardErrorTest $e) {
			$body = $e->getJsonBody();
			$err = $body['error'];
			$invoice->logMessage($err['message']);
			return false;
		} catch (\Stripe\InvalidRequestErrorTest $e) {
			$invoice->logMessage("Invalid parameters were supplied to Stripe's API");
			return false;
		} catch (\Stripe\AuthenticationErrorTest $e) {
			$invoice->logMessage("Authentication with Stripe's API failed");
			return false;
		} catch (\Stripe\ApiRequestorTest $e) {
			$invoice->logMessage("Network communication with Stripe failed");
			return false;
		} catch (\Stripe\ErrorTest $e) {
			$invoice->logMessage("Transaction failed");
			return false;
		} catch (Exception $e) {
			$invoice->logMessage("Transaction failed");
			return false;
		}

		if (w2dc_create_transaction(
				$this->name(),
				$invoice->post->ID,
				'Completed',
				$charge->id,
				$charge->amount/100,
				0,
				$charge->currency,
				1,
				$charge
		)) {
			if ($invoice->item_object->complete()) {
				$invoice->setStatus('paid');
				$transaction_data = array();
				$keys = $charge->keys();
				foreach ($keys AS $k)
					if (is_string($charge->offsetGet($k)))
						$transaction_data[] = $k . ' = ' . esc_attr($charge->offsetGet($k));
				$invoice->logMessage(sprintf(esc_html__('Payment successfully completed. Transaction data: %s', 'w2dc'), implode('; ', $transaction_data)));
			}
		}
	}
}
