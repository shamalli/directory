<?php
require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/IGateway.php';

class Sabai_Addon_PayPal extends Sabai_Addon
    implements Sabai_Addon_System_IMainRouter,
               Sabai_Addon_System_IAdminSettings,
               Sabai_Addon_PaidListings_IGateway
{
    const VERSION = '1.3.29', PACKAGE = 'sabai-paidlistings';
    
    public function isInstallable()
    {        
        return parent::isInstallable() && $this->_application->CheckAddonVersion(array('PaidListings' => '1.3.0dev1'));
    }
    
    public function isUninstallable($currentVersion)
    {
        return true;
    }
    
    public function systemGetMainRoutes()
    {
        return array(
            '/sabai/paypal/ipn' => array(
                'controller' => 'Ipn',
                'type' => Sabai::ROUTE_CALLBACK,
                //'method' => 'post',
            ),
        );
    }

    public function systemOnAccessMainRoute(Sabai_Context $context, $path, $accessType, array &$route){}

    public function systemGetMainRouteTitle(Sabai_Context $context, $path, $title, $titleType, array $route){}
    
    public function paidListingsGatewayGetInfo()
    {
        return array(
            'enable' => empty($this->_config['disable']),
            'label' => $this->_config['label'],
            'text' => $this->_config['text'],
            'logo' => empty($this->_config['logo']) ? $this->_application->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/images/paypal.png' : $this->_config['logo'],
            'currencies' => array('USD', 'AUD', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MXN',
   'NOK', 'NZD', 'PLN', 'GBP', 'SGD', 'SEK', 'CHF', 'THB', 'RUB', 'BRL'),
            'recurring' => array('w', 'm', '3m', '6m', 'y'),
        );
    }
    
    public function paidListingsGatewayGetCheckoutForm(array $formStorage, Sabai_Addon_PaidListings_Model_Plan $plan)
    {
        if (!empty($formStorage['paypal_token'])
            && !empty($formStorage['order_id'])
            && ($order = $this->_application->getModel('Order', 'PaidListings')->fetchById($formStorage['order_id']))
        ) {
            $response = $this->_application->PayPal_Request('GetExpressCheckoutDetails', array('TOKEN' => $formStorage['paypal_token']));
            $paypal_checkout_token = $response['TOKEN'];
            $paypal_payerid = !empty($response['PAYERID']) ? $response['PAYERID'] : $_GET['PayerID']; // for some reason PAYERID is empty certain times            
            
            $order->gateway = $this->_name;
            $request = array(
                'TOKEN' => $paypal_checkout_token,
                'PAYERID' => $paypal_payerid,
            );
            if (!in_array($order->payment_type, array('w', 'm', '3m', '6m', 'y'))) {
                $request += array(
                    'PAYMENTREQUEST_0_AMT' => $order->price,
                    'PAYMENTREQUEST_0_ITEMAMT' => $order->price,
                    'PAYMENTREQUEST_0_CURRENCYCODE' => $order->currency,
                    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                    'PAYMENTREQUEST_0_SOFTDESCRIPTOR' => $this->_application->getPlatform()->getSiteName(),
                    'PAYMENTREQUEST_0_NOTIFYURL' => $this->_application->PayPal_IpnUrl(),
                    'L_PAYMENTREQUEST_0_NAME0' => $this->_application->Summarize($order->Plan->name, 127),
                    'L_PAYMENTREQUEST_0_DESC0' => $this->_application->Summarize($order->Plan->description, 127),
                    'L_PAYMENTREQUEST_0_AMT0' => $order->price,
                    'L_PAYMENTREQUEST_0_QTY0' => 1,
                    'L_PAYMENTREQUEST_0_ITEMCATEGORY0' => 'Digital',
                );
                $response = $this->_application->PayPal_Request('DoExpressCheckoutPayment', $request);
                // Force pending for testing?
                if (!empty($this->_config['sb']) && !empty($this->_config['sb_processing'])) {
                    $ret['PAYMENTINFO_0_PAYMENTSTATUS'] = 'Pending';
                    $ret['PAYMENTINFO_0_PENDINGREASON'] = 'Payment status set to "Pending" for testing. Actual payment status: ' . $response['PAYMENTINFO_0_PAYMENTSTATUS'];
                }
                // Update order and logs
                switch ($response['PAYMENTINFO_0_PAYMENTSTATUS']) {
                    case 'Pending':
                        $order->markPaymentPending(false, $response['PAYMENTINFO_0_PENDINGREASON']);
                        break;               
                    case 'Completed':
                        $order->markPaymentPaid();
                        break;               
                    default:
                        $order->status = Sabai_Addon_PaidListings::ORDER_STATUS_PROCESSING;
                        $order->createOrderLog(__('Order confirmed.', 'sabai-paidlistings'), $order->status);
                }
                $order->transaction_id = $response['PAYMENTINFO_0_TRANSACTIONID'];
                $order->gateway_data = array(
                    'transaction_id' => $response['PAYMENTINFO_0_TRANSACTIONID'],
                    'payment_status' => $response['PAYMENTINFO_0_PAYMENTSTATUS'],
                    'payment_type' => $response['PAYMENTINFO_0_PAYMENTTYPE'],
                );
            } else {
                switch ($order->payment_type) {
                    case 'w':
                        $period = 'Week';
                        $frequency = 1;
                        break;
                    case 'm':
                        $period = 'Month';
                        $frequency = 1;
                        break;
                    case '3m':
                        $period = 'Month';
                        $frequency = 3;
                        break;
                    case '6m':
                        $period = 'Month';
                        $frequency = 6;
                        break;
                    case 'y':
                        $period = 'Year';
                        $frequency = 1;
                        break;
                }
                $request += array(
                    'PROFILESTARTDATE' => date('Y-m-d', time()) . 'T00:00:00Z',
                    'DESC' => $this->_application->Summarize($order->Plan->name . ' - ' . $order->Plan->getDescription($order->payment_type), 127),
                    'BILLINGPERIOD' => $period,
                    'BILLINGFREQUENCY' => $frequency,
                    'AMT' => $order->price,
                    'CURRENCYCODE' => $order->currency,
                    'MAXFAILEDPAYMENTS' => 3
                );
                if ($trial_period_days = $order->Plan->getTrialPeriodDays($order->payment_type)) {
                    $request += array(
                        'TRIALBILLINGPERIOD' => 'Day',
                        'TRIALBILLINGFREQUENCY' => $trial_period_days,
                        'TRIALTOTALBILLINGCYCLES' => 1,
                        'TRIALAMT' => 0,
                    );
                }
                $response = $this->_application->PayPal_Request('CreateRecurringPaymentsProfile', $request);
                switch ($response['PROFILESTATUS']) {              
                    case 'ActiveProfile':
                        $order->markPaymentPaid();
                        break;   
                    case 'PendingProfile':
                    default:
                        $order->markPaymentPending();
                        break;
                }
                $order->transaction_id = $response['PROFILEID'];
                $gateway_data = array(
                    'recurring_payment_id' => $response['PROFILEID'],
                    'profile_status' => $response['PROFILESTATUS'],      
                );
                if ($trial_period_days) {
                    $gateway_data += array(
                        'trial_billing_period' => 'Day',
                        'trial_billing_frequency' => $trial_period_days,
                        'trial_total_billing_cycles' => 1,
                        'trial_amt' => 0,
                    );
                }
                $order->gateway_data = $gateway_data;
                $order->setEntityData('recurring_payment_id', $response['PROFILEID']);
            }
            $order->getModel()->commit();
            
            // returned from PayPal, so skip form submission
            return false;
        }
    }
    
    public function paidListingsGatewayCheckout(Sabai_Addon_Form_Form $form, Sabai_Addon_PaidListings_Model_Order $order, $returnUrl, $cancelUrl)
    {
        if (empty($form->storage['paypal_token'])) {
            $request = array(
                'RETURNURL' => (string)$returnUrl,
                'CANCELURL' => (string)$cancelUrl,
                'NOSHIPPING' => 1,
                'ALLOWNOTE' => 0,
                'SOLUTIONTYPE' => 'Sole', // allow cc payment
                'LOCALECODE' => $this->_application->getPlatform()->getLocale(),
                'EMAIL' => $this->_application->getUser()->email,
                'BRANDNAME' => $this->_application->getPlatform()->getSiteName(),
            );
            if (!in_array($order->payment_type, array('w', 'm', '3m', '6m', 'y'))) {
                $request += array(
                    'PAYMENTREQUEST_0_AMT' => $order->price,
                    'PAYMENTREQUEST_0_ITEMAMT' => $order->price,
                    'PAYMENTREQUEST_0_CURRENCYCODE' => $order->currency,
                    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                    'L_PAYMENTREQUEST_0_NAME0' => $this->_application->Summarize($order->Plan->name, 127),
                    'L_PAYMENTREQUEST_0_DESC0' => $this->_application->Summarize($order->Plan->getDescription($order->payment_type), 127),
                    'L_PAYMENTREQUEST_0_AMT0' => $order->price,
                    'L_PAYMENTREQUEST_0_QTY0' => 1,
                    'L_PAYMENTREQUEST_0_ITEMCATEGORY0' => 'Digital',
                );
            } else {
                $request += array(
                    'PAYMENTREQUEST_0_AMT' => 0,
                    'L_BILLINGTYPE0' => 'RecurringPayments',
                    'L_BILLINGAGREEMENTDESCRIPTION0' => $this->_application->Summarize($order->Plan->name . ' - ' . $order->Plan->getDescription($order->payment_type), 127),
                );
            }
            $response = $this->_application->PayPal_Request('SetExpressCheckout', $request);
            $form->redirect = $this->_application->Url(array('script_url' => $this->_application->PayPal_ExpressCheckoutUrl($response, !empty($this->_config['sb']))));
            $form->redirectMessage = __('Redirecting to PayPal...', 'sabai-paidlistings');
            $form->storage['paypal_token'] = $response['TOKEN'];
            $form->storage['order_id'] = $order->id;
        }
    }
    
    public function paidListingsGatewayGetPostCheckoutNotice(Sabai_Addon_PaidListings_Model_Order $order){}
    
    public function getDefaultConfig()
    {
        return array(
            'label' => 'logo',
            'text' => __('PayPal', 'sabai-paidlistings'),
            'logo' => null,
            'version' => '63.0',
            'user' => '',
            'pwd' => '',
            'sig' => '',
            'sb' => true,
            'sb_user' => '',
            'sb_pwd' => '',
            'sb_sig' => '',
            'sb_processing' => false,
        );
    }
    
    public function onPayPalUpgradeSuccess(Sabai_Addon $addon, $log, $previousVersion)
    {
        if (version_compare($previousVersion, '1.3.0', '<')) {            
            if (!$this->_application->isAddonLoaded('PaidDirectoryListings')
                || (!$config = $this->_application->getAddon('PaidDirectoryListings')->getConfig('paypal'))
            ) return;
            
            $this->saveConfig($config);
        }
    }
        
    public function onPayPalIpnReceived($ipn)
    {
        $this->_application->getAddon('PaidListings'); // must manually load PaidListings add-on to access its constants
        switch ($ipn['txn_type']) {
            case 'express_checkout':
                $action = 'paypal_express_checkout_ipn_received';
                break;
            case 'recurring_payment':
                $action = 'paypal_recurring_payment_ipn_received';
                break;
            case 'recurring_payment_expired':
                $action = 'paypal_recurring_payment_expired_ipn_received';
                break;
            case 'recurring_payment_failed':
                $action = 'paypal_recurring_payment_failed_ipn_received';
                break;
            case 'recurring_payment_profile_created':
                $action = 'paypal_recurring_payment_profile_created_ipn_received';
                break;
            case 'recurring_payment_profile_cancel':
                $action = 'paypal_recurring_payment_cancel_ipn_received';
                break;
            case 'recurring_payment_skipped':
                $action = 'paypal_recurring_payment_skipped_ipn_received';
                break;
            case 'recurring_payment_suspended':
                $action = 'paypal_recurring_payment_suspended_ipn_received';
                break;
            case 'recurring_payment_suspended_due_to_max_failed_payment':
                $action = 'paypal_recurring_payment_suspended_due_to_max_faield_payment_ipn_received';
                break;
        }
        $this->_application->Action($action, array($ipn));
    }
        
    public function onPayPalExpressCheckoutIpnReceived($ipn)
    {
        $force_update_status = false;
        switch ($ipn['payment_status']) {
            case 'Completed':
                $status = Sabai_Addon_PaidListings::ORDER_STATUS_PAID;
                break;
            case 'Expired':
                $status = Sabai_Addon_PaidListings::ORDER_STATUS_EXPIRED;
                break;
            case 'Failed':
                $status = Sabai_Addon_PaidListings::ORDER_STATUS_FAILED;
                break;
            case 'Refunded':
            case 'Reversed':
                $status = Sabai_Addon_PaidListings::ORDER_STATUS_REFUNDED;
                $force_update_status = true;
                break;
            case 'Pending':
                $status = Sabai_Addon_PaidListings::ORDER_STATUS_PENDING;
                break;
            default:
                return;
        } 
        $this->_updateOrderByIpn($ipn['txn_id'], $ipn, $status, $ipn['payment_status'], $force_update_status);
    }
    
    public function onPayPalRecurringPaymentIpnReceived($ipn)
    {
        $this->_updateRecurringPaymentOrderByIpn($ipn, Sabai_Addon_PaidListings::ORDER_STATUS_PAID);
    }
    
    public function onPayPalRecurringPaymentExpiredIpnReceived($ipn)
    {
        $this->_updateRecurringPaymentOrderByIpn($ipn, Sabai_Addon_PaidListings::ORDER_STATUS_EXPIRED, true);
    }
    
    public function onPayPalRecurringPaymentCancelIpnReceived($ipn)
    {
        $this->_updateRecurringPaymentOrderByIpn($ipn, Sabai_Addon_PaidListings::ORDER_STATUS_CANCELLED, true);
    }
    
    public function onPayPalRecurringPaymentSuspendedIpnReceived($ipn)
    {
        $this->_updateRecurringPaymentOrderByIpn($ipn, Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED, true);
    }
    
    public function onPayPalRecurringPaymentSuspendedDueToMaxFaieldPaymentIpnReceived($ipn)
    {
        $this->_updateRecurringPaymentOrderByIpn($ipn, Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED, true);
    }
    
    protected function _updateRecurringPaymentOrderByIpn($ipn, $status, $forceUpdateStatus = false)
    {        
        $this->_updateOrderByIpn($ipn['recurring_payment_id'], $ipn, $status, $ipn['profile_status'], $forceUpdateStatus);
    }
    
    protected function _updateOrderByIpn($txnId, $ipn, $status, $ipnStatus, $forceUpdateStatus = false)
    {
        // Get the order with the notified transaction ID
        if (!$txnId
            || (!$order = $this->_application->getModel('Order', 'PaidListings')->transactionId_is($txnId)->fetchOne())
        ) {
            $this->_application->LogError('Invalid transaction or recurring payment ID: ' . $txnId);
            return;
        }
        
        // Update order
        $gateway_data = $order->gateway_data;
        if (!isset($gateway_data['ipn'])) {
            $gateway_data['ipn'] = array();
        }
        $gateway_data['ipn'][] = $ipn;
        $order->gateway_data = $gateway_data;
        // Create log
        $order_log = $order->createOrderLog()->markNew();
        $order_log->message = sprintf(__('PayPal IPN received (type: %s, status: %s).', 'sabai-paidlistings'), $ipn['txn_type'], $ipnStatus);
        if ($forceUpdateStatus || !$order->isStatusFrozen()) {
            // Update status
            if ($order->status != $status) {
                $order->status = $order_log->status = $status;
                $status_changed = true;
            }
        }

        $order->getModel()->commit();
        
        // Do action if status changed
        if (!empty($status_changed)) {
            $order->reload();
            $this->_application->Action('paidlistings_order_status_change', array($order));
        }
    }
    
    public function systemGetAdminSettingsForm()
    {
        return array(
            'disable' => array(
                '#type' => 'checkbox',
                '#title' => __('Disable this payment method', 'sabai-paidlistings'),
                '#default_value' => !empty($this->_config['disable']),
            ),
            'settings' => array(
                '#states' => array(
                    'invisible' => array(
                        'input[name="disable[]"]' => array('type' => 'checked', 'value' => true),
                    ),
                ),
                '#tree' => false,
                'label' => array(
                    '#type' => 'radios',
                    '#title' => __('Payment Method Label', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['label'],
                    '#options' => array(
                        'text' => __('Text', 'sabai-paidlistings'),
                        'logo' => __('Logo', 'sabai-paidlistings'),
                        'text_logo' => __('Text + Logo', 'sabai-paidlistings'),
                        'logo_text' => __('Logo + Text', 'sabai-paidlistings'),
                    ),
                    '#class' => 'sabai-form-inline',
                ),
                'logo' => array(
                    '#type' => 'url',
                    '#title' => __('Payment Method Logo', 'sabai-paidlistings'),
                    '#description' => sprintf(__('Default logo: %s', 'sabai-paidlistings'), $this->_application->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/images/paypal.png'),
                    '#default_value' => $this->_config['logo'],
                    '#states' => array(
                        'invisible' => array(
                            'input[name="label"]' => array('value' => array('text')),
                        ),
                    ),
                ),
                'text' => array(
                    '#type' => 'textfield',
                    '#title' => __('Payment Method Text', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['text'],
                    '#states' => array(
                        'invisible' => array(
                            'input[name="label"]' => array('value' => 'logo'),
                        ),
                    ),
                ),
                'user' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Username', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['user'],
                ),
                'pwd' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Password', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['pwd'],
                ),
                'sig' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Signature', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sig'],
                ),
                'version' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Version', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['version'],
                    '#size' => 10,
                ),
                'ipn' => array(
                    '#type' => 'item',
                    '#title' => __('Classic API IPN endpoint URL', 'sabai-paidlistings'),
                    '#value' => (string)$this->_application->PayPal_IpnUrl(),
                ),
                'sb' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Enable sandbox mode', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb'],
                ),
                'sb_user' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Username (sandbox)', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_user'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'sb_pwd' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Password (sandbox)', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_pwd'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'sb_sig' => array(
                    '#type' => 'textfield',
                    '#title' => __('Classic API Signature (sandbox)', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_sig'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'sb_processing' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Set payment status as "Processing"', 'sabai-paidlistings'),
                    '#description' => __('Check this option to set the payment status of orders to "Processing" even when it is complete, which is useful for testing IPN.', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_processing'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'sb_ipn' => array(
                    '#type' => 'item',
                    '#title' => __('Classic API IPN endpoint URL (sandbox)', 'sabai-paidlistings'),
                    '#value' => (string)$this->_application->PayPal_IpnUrl(true),
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
            ),
        );
    }
}