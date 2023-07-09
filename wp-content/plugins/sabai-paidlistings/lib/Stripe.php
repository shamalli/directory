<?php
require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/IGateway.php';

class Sabai_Addon_Stripe extends Sabai_Addon
    implements Sabai_Addon_PaidListings_IGateway,
               Sabai_Addon_System_IMainRouter,
               Sabai_Addon_System_IAdminSettings
{
    const VERSION = '1.3.29', PACKAGE = 'sabai-paidlistings';
    
    public function isUninstallable($currentVersion)
    {
        return true;
    }
    
    public function systemGetMainRoutes()
    {
        return array(
            '/sabai/stripe/webhook' => array(
                'controller' => 'Webhook',
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
            'logo' => empty($this->_config['logo']) ? $this->_application->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/images/cc.gif' : $this->_config['logo'],
            'text' => $this->_config['text'],
            'recurring' => array('w', 'm', '3m', '6m', 'y'),
        );
    }
        
    public function paidListingsGatewayGetCheckoutForm(array $formStorage, Sabai_Addon_PaidListings_Model_Plan $plan)
    {
        $this->_application->LoadJs('https://js.stripe.com/v2/', 'stripe', null, false);    
        $form = array(
            'card' => array(
                '#title' => __('Credit Card', 'sabai-paidlistings'),
                '#display_required' => true,
                '#collapsible' => false,
                '#tree' => true,
                'type' => array(
                    '#type' => 'radios',
                    '#default_value' => 'new',
                    '#options' => array(
                        'new' => __('New credit card', 'sabai-paidlistings'),
                    ),
                    '#class' => 'sabai-hidden',
                ),
                'new' => array(
                    '#type' => 'paidlistings_cc',
                    '#states' => array(
                        'visible' => array(
                            '[name="' . $this->_name . '[card][type]"]' => array('value' => 'new'),
                        ),
                    ),
                    '#required' => array($this, 'isCreditCardInfoRequired'),
                ),
                'address' => array(
                    '#title' => __('Billing Address', 'sabai-paidlistings'),
                    '#type' => 'address',
                    '#country_type' => 'select',
                    '#country' => '',
                    '#states' => array(
                        'visible' => array(
                            '[name="' . $this->_name . '[card][type]"]' => array('value' => 'new'),
                        ),
                    ),
                    //'#required' => array($this, 'isCreditCardInfoRequired'),
                ),
            ),
        );
        $this->initStripe();
        if (($customer = $this->_getStripeCustomer())
            && ($card = $customer->cards->data[0])
        ) {
            $form['card']['type']['#class'] = null;
            $form['card']['type']['#options'] = array(
                $card->id => sprintf('%s XXXX-XXXX-XXXX-%s (%s/%s)', $card->brand, $card->last4, str_pad($card->exp_month, 2, 0, STR_PAD_LEFT), substr($card->exp_year, 2)),
            ) + $form['card']['type']['#options'];
            $form['card']['type']['#default_value'] = $card->id;
        }
        return $form;
    }
    
    public function isCreditCardInfoRequired($form)
    {
        return $this->_name === $form->values['method']
            && $form->values[$this->_name]['card']['type'] === 'new';
    }
    
    public function onFormBuildPaidListingsPaymentForm(&$form, &$storage)
    {
        if ($form['#is_rebuild']) return;
        
        $form['#js'][] = sprintf('
jQuery(document).ready(function($) {
    var $form = $("#%1$s"),
        $submitBtn = $form.find("input[name=\"_sabai_form_submit[0]\"]"), 
        responseHandler = function(status, response) {
            if (response.error) {
                $form.prepend("<div class=\"sabai-form-header\"><div class=\"sabai-alert sabai-alert-danger\">" + response.error.message +  "</div></div>");
                $form.find("input[type=submit]").prop("disabled", false);
                SABAI.scrollTo($form);
            } else {
                $form.append($("<input type=\"hidden\" name=\"stripeToken\" />").val(response.id))
                    .append($("<input type=\"hidden\" name=\""+ $submitBtn.attr("name") +"\" value=\"" + $submitBtn.val() + "\" />")) // required when submitting via JS
                    .get(0).submit();
            }
        };
    $submitBtn.click(function(e) { 
        if ($form.find("input[name=\"method\"]:checked").val() !== "%3$s"
            || $form.find("[name=\"%3$s[card][type]\"]:checked").val() !== "new"
        ) return;
        
        var date = $form.find("[name=\"%3$s[card][new][date]\"]").val().split("/");
        if (!date[0] || !date[1]) return;
        
        var request = {
            number: $form.find("[name=\"%3$s[card][new][number]\"]").val(),
            cvc: $form.find("[name=\"%3$s[card][new][cvv]\"]").val(),
            exp_month: date[0],
            exp_year: "20" + date[1],
            name: $form.find("[name=\"%3$s[card][new][name]\"]").val(),
            address_line1: $form.find("[name=\"%3$s[card][address][street]\"]").val() || null,
            address_line2: $form.find("[name=\"%3$s[card][address][street2]\"]").val() || null,
            address_city: $form.find("[name=\"%3$s[card][address][city]\"]").val() || null,
            address_state: $form.find("[name=\"%3$s[card][address][state]\"]").val() || null,
            address_zip: $form.find("[name=\"%3$s[card][address][zip]\"]").val() || null,
            address_country: $form.find("[name=\"%3$s[card][address][country]\"]").val() || null,
        }
        if (!request.number || !request.cvc || !request.name) return;
        
        $form.find("input[type=submit]").prop("disabled", true);
        Stripe.setPublishableKey("%2$s");
        Stripe.card.createToken(request, responseHandler);
        return false;
    });
});',
            $form['#id'],
            empty($this->_config['test']) ? $this->_config['pb_key'] : $this->_config['test_pb_key'],
            $this->_name
        );
    }
    
    protected function _getStripeCustomer()
    {
        if ($customer_id = $this->_application->getPlatform()->getUserMeta($this->_application->getUser()->id, 'stripe_customer_id')) {
            try {
                return Stripe_Customer::retrieve($customer_id);
            } catch (Stripe_InvalidRequestError $e) {  
                // customer with the csutom ID does not exist
            }
        }
        return false;
    }
    
    protected function _getOrCreateStripeCustomer($token)
    {
        if (!$customer = $this->_getStripeCustomer()) {
            if (!empty($token)) {
                $customer = Stripe_Customer::create(array(
                    'email' => $this->_application->getUser()->email,
                    'description' => $this->_application->getUser()->username,
                    'metadata' => array('id' => $this->_application->getUser()->id),
                    'card' => $token,
                ));
                $this->_application->getPlatform()->setUserMeta($this->_application->getUser()->id, 'stripe_customer_id', $customer->id);
            }
        } else {
            if (!empty($token)) {
                // new card
                $customer->card = $token;
                $customer->save();
            }
        }
        return $customer;
    }
    
    protected function _getStripePaymentAmount($currency, $price)
    {
        if (!in_array(strtoupper($currency), $this->_application->PaidListings_NonDecimalCurrencies())) {
            $price *= 100;
        }
        return $price;
    }
    
    public function paidListingsGatewayCheckout(Sabai_Addon_Form_Form $form, Sabai_Addon_PaidListings_Model_Order $order, $returnUrl, $cancelUrl)
    {
        $this->initStripe();
        $amount = $this->_getStripePaymentAmount($order->currency, $order->price);
        try {
            if (!$stripe_customer = $this->_getOrCreateStripeCustomer(@$_POST['stripeToken'])) {
                $form->setError(__('Invalid credit card. Please try creating a new card.', 'sabai-paidlistings'));
                return;
            }        
            if (!in_array($order->payment_type, array('w', 'm', '3m', '6m', 'y'))) {
                $charge = Stripe_Charge::create(array(
                    'amount' => $amount,
                    'currency' => $order->currency,
                    'customer' => $stripe_customer->id,
                    'description' => $order->Plan->name,
                ));
                $paid = $charge->paid;
                $transaction_id = $charge->id;
            } else {
                $interval_count = 1;
                switch ($order->payment_type) {
                    case 'w':
                        $interval = 'week';
                        break;
                    case 'm':
                        $interval = 'month';
                        break;
                    case '3m':
                        $interval = 'month';
                        $interval_count = 3;
                        break;
                    case '6m':
                        $interval = 'month';
                        $interval_count = 6;
                        break;
                    case 'y':
                        $interval = 'year';
                        break;
                }
                // Generate unique ID like this since Stripe does now allow modifying prices and etc.
                $plan_data = array(
                    'amount' => $amount,
                    'interval' => $interval,
                    'interval_count' => $interval_count,
                    'currency' => $order->currency,
                    'trial_period_days' => $order->Plan->getTrialPeriodDays($order->payment_type),
                    'metadata' => array('id' => $order->Plan->id),
                );
                $plan_id = md5(serialize($plan_data));
                try {
                    $stripe_plan = Stripe_Plan::retrieve($plan_id);
                } catch (Stripe_InvalidRequestError $e) {  
                    $stripe_plan = Stripe_Plan::create(array('id' => $plan_id, 'name' => $order->Plan->name) + $plan_data);
                }
                $subscription = $stripe_customer->subscriptions->create(array(
                    'plan' => $stripe_plan->id,
                ));
                $paid = in_array($subscription->status, array('active', 'trialing'));
                $transaction_id = $subscription->id;
            }
        } catch(Stripe_CardError $e) {
            $body = $e->getJsonBody();
            // Card error can be displayed to user
            $form->setError($body['error']['message']);
            return;
        } catch (Stripe_Error $e) {
            $body = $e->getJsonBody();
            // Show raw error message if admin
            if ($this->_application->getUser()->isAdministrator()) {
                $form->setError($body['error']['message']);
            } else {
                $this->_application->LogError($body['error']['message']);
                $form->setError(__('The order cannot be processed. You have not been charged. Please contact the administrator for details.', 'sabai-paidlistings'));
            }
            return;
        }
 
        if ($paid) {
            $order->markPaymentPaid();
        } else {
            $order->markPaymentPending();
        }
        $order->transaction_id = $transaction_id;
        $order->gateway = $this->_name;
        $gateway_data = array();
        if (isset($subscription)) {
            $order->setEntityData('recurring_payment_id', $subscription->id);
            $gateway_data += array(
                'subscription_id' => $subscription->id,
                'subscription_status' => $subscription->status,
                'trial_period_days' => $subscription->plan->trial_period_days,
            );
        }
        $order->gateway_data = $gateway_data;
        $order->getModel()->commit();
    }
    
    public function paidListingsGatewayGetPostCheckoutNotice(Sabai_Addon_PaidListings_Model_Order $order){}
    
    public function getDefaultConfig()
    {
        return array(
            'label' => 'text_logo',
            'text' => __('Credit Card (Stripe)', 'sabai-paidlistings'),
            'logo' => null,
            'secret_key' => '',
            'pb_key' => '',
            'test' => true,
            'test_secret_key' => '',
            'test_pb_key' => '',
        );
    }
    
    public function systemGetAdminSettingsForm()
    {
        $header = array();
        if (!extension_loaded('openssl')) {
            $header[] = '<div class="sabai-alert sabai-alert-danger">' . __('The Stripe library requires the OpenSSL PHP extension installed.', 'sabai-paidlistings') . '</div>';
        }
        return array(
            '#header' => $header,
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
                    '#description' => sprintf(__('Default logo: %s', 'sabai-paidlistings'), $this->_application->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/images/cc.gif'),
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
                'secret_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Secret Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['secret_key'],
                ),
                'pb_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Publishable Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['pb_key'],
                ),
                'webhook_url' => array(
                    '#type' => 'item',
                    '#title' => __('Webhook URL', 'sabai-paidlistings'),
                    '#value' => (string)$this->_application->MainUrl('/sabai/stripe/webhook'),
                ),
                'test' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Enable test mode', 'sabai-paidlistings'),
                    '#default_value' => !empty($this->_config['test']),
                ),
                'test_secret_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Test Secret Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['test_secret_key'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="test[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'test_pb_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Test Publishable Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['test_pb_key'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="test[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
            ),
        );
    }
    
    public function initStripe()
    {
        require_once dirname(__FILE__) . '/Stripe/lib/Stripe.php';
        Stripe::setApiKey(empty($this->_config['test']) ? $this->_config['secret_key'] : $this->_config['test_secret_key']);
    }
    
    public function onStripeWebhookReceived($event)
    {
        $this->_application->getAddon('PaidListings'); // must manually load PaidListings add-on to access its constants
        $this->_application->Action('stripe_webhook_' . str_replace('.', '_', $event->type), array($event));
    }
    
    public function onStripeWebhookChargeSucceeded($event)
    {
        if ($event->data->object->paid) {
            $this->_updateOrderByWebhookEvent($event, Sabai_Addon_PaidListings::ORDER_STATUS_PAID);
        }
    }
    
    public function onStripeWebhookChargeRefunded($event)
    {
        if ($event->data->object->refunded) {
            $this->_updateOrderByWebhookEvent($event, Sabai_Addon_PaidListings::ORDER_STATUS_REFUNDED, true);
        }
    }
    
    public function onStripeWebhookCustomerSubscriptionUpdated($event)
    {
        $this->_onStripeWebhookCustomerSubscriptionEvent($event);
    }
    
    public function onStripeWebhookCustomerSubscriptionDeleted($event)
    {
        $this->_onStripeWebhookCustomerSubscriptionEvent($event);
    }
    
    protected function _onStripeWebhookCustomerSubscriptionEvent($event)
    {
        switch ($event->data->object->status) {
            case 'canceled':
                $this->_updateOrderByWebhookEvent($event, Sabai_Addon_PaidListings::ORDER_STATUS_CANCELLED, true);
                break;
            case 'unpaid':
                $this->_updateOrderByWebhookEvent($event, Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED, true);
                break;
        }
    }
    
    protected function _updateOrderByWebhookEvent($event, $status, $forceUpdateStatus = false)
    {
        // Get the order with the notified transaction ID
        if (!$event->data->object->id
            || (!$order = $this->_application->getModel('Order', 'PaidListings')->transactionId_is($event->data->object->id)->fetchOne())
        ) {
            $this->_application->LogError('Invalid transaction or recurring payment ID: ' . $event->data->object->id);
            return;
        }
        
        // Update order
        $gateway_data = $order->gateway_data;
        if (!isset($gateway_data['event'])) {
            $gateway_data['event'] = array();
        }
        $gateway_data['event'][] = (array)$event;
        $order->gateway_data = $gateway_data;
        $order_log = $order->createOrderLog()->markNew();
        $order_log->message = sprintf(__('Stripe webhoook received (type: %s).', 'sabai-paidlistings'), $event->type);
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
}