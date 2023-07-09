<?php
require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/IGateway.php';

class Sabai_Addon_2Checkout extends Sabai_Addon
    implements Sabai_Addon_PaidListings_IGateway,
               Sabai_Addon_System_IAdminSettings
{
    const VERSION = '1.3.29', PACKAGE = 'sabai-paidlistings';
    
    public function isUninstallable($currentVersion)
    {
        return true;
    }
    
    public function paidListingsGatewayGetInfo()
    {
        return array(
            'enable' => empty($this->_config['disable']),
            'currencies' => array('ARS', 'AUD', 'BRL', 'GBP', 'CAD', 'DKK', 'EUR', 'HKD', 'INR', 'ILS', 'JPY', 'LTL', 'MYR', 'MXN', 'NZD', 'NOK', 'PHP', 'RON', 'RUB', 'SGD', 'ZAR', 'SEK', 'CHF', 'TRY', 'AED', 'USD'),
            'label' => $this->_config['label'],
            'logo' => empty($this->_config['logo']) ? $this->_application->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/images/cc.gif' : $this->_config['logo'],
            'text' => $this->_config['text'],
        );
    }
    
    public function paidListingsGatewayGetCheckoutForm(array $formStorage, Sabai_Addon_PaidListings_Model_Plan $plan)
    {
        $this->_application->LoadJs('https://www.2checkout.com/checkout/api/2co.min.js', '2checkout', null, false);
        return array(
            'card' => array(
                '#type' => 'paidlistings_cc',
                '#title' => __('Credit Card', 'sabai-paidlistings'),
                '#required' => array($this, 'isCardInfoRequired'),
                '#separate_names' => true,
            ),
            'address' => array(
                '#title' => __('Billing Address', 'sabai-paidlistings'),
                '#type' => 'address',
                '#country_type' => 'select',
                '#country' => '',
                '#required' => array($this, 'isCardInfoRequired'),
            ),
        );
    }
    
    public function isCardInfoRequired($form)
    {
        return $this->_name === $form->values['method'];
    }
    
    public function onFormBuildPaidListingsPaymentForm(&$form, &$storage)
    {
        if ($form['#is_rebuild']) return;
        
        $form['#js'][] = sprintf('
jQuery(document).ready(function($) {
    var $form = $("#%1$s"),
        $submitBtn = $form.find("input[name=\"_sabai_form_submit[0]\"]"), 
        successCallback = function(data) {
            $form.append($("<input type=\"hidden\" name=\"token\" />").val(data.response.token.token))
                .append($("<input type=\"hidden\" name=\""+ $submitBtn.attr("name") +"\" value=\"" + $submitBtn.val() + "\" />")) // required when submitting via JS
                .get(0).submit();
        },
        errorCallback = function(data) {
            if (data.errorCode === 200) {
                if (tokenRequest()) {
                    return;
                }
            }
            $form.prepend("<div class=\"sabai-form-header\"><div class=\"sabai-alert sabai-alert-danger\">" + data.errorMsg +  "</div></div>");
                $form.find("input[type=submit]").prop("disabled", false);
                SABAI.scrollTo($form);
        },
        tokenRequest = function() {
            var date = $form.find("[name=\"%5$s[card][date]\"]").val().split("/");
            if (!date[0] || !date[1]) return false;
            
            var request = {
                sellerId: "%3$s",
                publishableKey: "%4$s",
                ccNo: $form.find("input[name=\"%5$s[card][number]\"]").val(),
                cvv: $form.find("input[name=\"%5$s[card][cvv]\"]").val(),
                expMonth: date[0],
                expYear: "20" + date[1]
            };
            
            if (!request.sellerId || !request.publishableKey || !request.ccNo || !request.cvv) return false;
            
            TCO.requestToken(successCallback, errorCallback, request);
            return true;
        };

    TCO.loadPubKey("%2$s");
    $submitBtn.click(function(e) {
        if ($form.find("input[name=\"method\"]:checked").val() !== "%5$s") return;

        $form.find("input[type=submit]").prop("disabled", true);
        return !tokenRequest();   
    });
});',
            $form['#id'],
            empty($this->_config['sb']) ? 'production' : 'sandbox',
            empty($this->_config['sb']) ? $this->_config['account_num'] : $this->_config['sb_account_num'],
            empty($this->_config['sb']) ? $this->_config['pub_key'] : $this->_config['sb_pub_key'],
            $this->_name
        );
    }
    
    public function paidListingsGatewayCheckout(Sabai_Addon_Form_Form $form, Sabai_Addon_PaidListings_Model_Order $order, $returnUrl, $cancelUrl)
    {
        if (empty($_POST['token'])) {
            $form->setError('Invalid token');
            return;
        }
        
        require_once dirname(__FILE__) . '/2Checkout/lib/Twocheckout.php';
        if (empty($this->_config['sb'])) {
            $seller_id = $this->_config['account_num'];    
            Twocheckout::privateKey($this->_config['priv_key']);
        } else {
            $seller_id = $this->_config['sb_account_num'];
            Twocheckout::privateKey($this->_config['sb_priv_key']);
            Twocheckout::sandbox(true);
        }
        Twocheckout::sellerId($seller_id);
        // We do not have an order ID yet, but 2Checkout requires one so create a unique ID here
        $merchant_order_id = md5($this->_application->getUser()->id . time());
        $value = $form->values[$this->_name];
        try {
            $addr = array(
                'name' => $value['card']['first_name'] . ' ' . $value['card']['last_name'],
                'addrLine1' => (string)@$value['address']['street'],
                'addrLine2' => (string)@$value['address']['street2'],
                'city' => (string)@$value['address']['city'],
                'state' => (string)@$value['address']['state'],
                'zipCode' => (string)@$value['address']['zip'],
                'country' => (string)@$value['address']['country'],
                'email' => $this->_application->getUser()->email,
            );
            $charge = Twocheckout_Charge::auth(array(
                'sellerId' => $seller_id,
                'merchantOrderId' => $merchant_order_id,
                'token' => $_POST['token'],
                'currency' => $order->currency,
                'total' => $order->price,
                'billingAddr' => array_filter($addr),
            ), 'array');
            $response = $charge['response'];
        } catch (Twocheckout_Error $e) {
            $form->setError($e->getMessage());
            return;
        }
        
        if ($response['responseCode'] === 'APPROVED') {
            $order->markPaymentPaid();
        } else {
            $order->markPaymentPending();
        }
        $order->transaction_id = $response['transactionId'];
        $order->gateway = $this->_name;
        $order->gateway_data = array(
            'response_code' => $response['responseCode'],
            'response_msg' => $response['responseMsg'],
            'order_number' => $response['orderNumber'],
            'merchant_order_id' => $response['merchantOrderId'],
        );
        $order->getModel()->commit();
    }
    
    public function paidListingsGatewayGetPostCheckoutNotice(Sabai_Addon_PaidListings_Model_Order $order){}
    
    public function getDefaultConfig()
    {
        return array(
            'label' => 'text_logo',
            'text' => __('Credit Card (2Checkout)', 'sabai-paidlistings'),
            'logo' => null,
            'account_num' => null,
            'priv_key' => null,
            'pub_key' => null,
            'sb' => true,
            'sb_account_num' => null,
            'sb_priv_key' => null,
            'sb_pub_key' => null,
        );
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
                'account_num' => array(
                    '#type' => 'textfield',
                    '#title' => __('Account Number', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['account_num'],
                    '#integer' => true,
                ),
                'pub_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Publishable Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['pub_key'],
                ),
                'priv_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Private Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['priv_key'],
                ),
                'sb' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Enable sandbox mode', 'sabai-paidlistings'),
                    '#default_value' => !empty($this->_config['sb']),
                ),
                'sb_account_num' => array(
                    '#type' => 'textfield',
                    '#title' => __('Sandbox Account Number', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_account_num'],
                    '#integer' => true,
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'sb_pub_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Sandbox Publishable Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_pub_key'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="sb[]"]' => array('type' => 'checked', 'value' => true),
                        ),
                    ),
                ),
                'sb_priv_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Sandbox Private Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb_priv_key'],
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
