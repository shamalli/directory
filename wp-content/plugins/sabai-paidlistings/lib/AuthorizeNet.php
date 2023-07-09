<?php
require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/IGateway.php';

class Sabai_Addon_AuthorizeNet extends Sabai_Addon
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
            'label' => $this->_config['label'],
            'logo' => empty($this->_config['logo']) ? $this->_application->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/images/cc.gif' : $this->_config['logo'],
            'text' => $this->_config['text'],
            'currencies' => array('USD', 'CAD', 'GBP', 'EUR'),
        );
    }
    
    public function paidListingsGatewayGetCheckoutForm(array $formStorage, Sabai_Addon_PaidListings_Model_Plan $plan)
    {
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
    
    public function paidListingsGatewayCheckout(Sabai_Addon_Form_Form $form, Sabai_Addon_PaidListings_Model_Order $order, $returnUrl, $cancelUrl)
    {
        if (!class_exists('AuthorizeNetRequest', false)) {        
            $lib_dir = dirname(__FILE__) . '/AuthorizeNet/lib';
            require $lib_dir . '/shared/AuthorizeNetException.php';
            require $lib_dir . '/shared/AuthorizeNetRequest.php';
            require $lib_dir . '/shared/AuthorizeNetResponse.php';
            require $lib_dir . '/AuthorizeNetAIM.php';
        }
        $value = $form->values[$this->_name];
        $request = new AuthorizeNetAIM($this->_config['login'], $this->_config['transaction_key']);
        $request->setSandbox((bool)$this->_config['sb']);
        $request->setFields(array(
            //'currency_code' => $order->currency,
            'card_code' => $value['card']['cvv'],
            'first_name' => $value['card']['first_name'],
            'last_name' => $value['card']['last_name'],
            'address' => $value['address']['street'],
            'city' => $value['address']['city'],
            'state' => $value['address']['state'],
            'zip' => $value['address']['zip'],
            'country' => $value['address']['country'],
        ));
        $response = $request->authorizeAndCapture(
            $order->price,
            $value['card']['number'],
            $value['card']['date']['month'] . $value['card']['date']['year']
        );              
        if ($response->error) {
            switch ($response->response_reason_code) {
                case 6:
                    $error_for = $this->_name . '[card][number]';
                    break;
                case 7:
                case 8:
                    $error_for = $this->_name . '[card][date]';
                    break;
                case 78:
                    $error_for = $this->_name . '[card][cvv]';
                    break;
                case 27:
                    $error_for = $this->_name . '[address][street]';
                    break;
                default:
                    $error_for = '';
            }
            $form->setError(isset($response->response_reason_text) ? $response->response_reason_text : $response->error_message, $error_for);
            return;
        }        
        
        if ($response->approved) {
            $order->markPaymentPaid();
        } else {
            $order->markPaymentPending();
        }
        $order->transaction_id = $response->transaction_id;
        $order->gateway = $this->_name;
        $order->gateway_data = array(
            'response_code' => $response->response_code,
            'response_subcode' => $response->response_subcode,
            'response_reason_code' => $response->response_reason_code,
            'response_reason_text' => (string)$response->response_reason_text,
        );
        $order->getModel()->commit();
    }
    
    public function paidListingsGatewayGetPostCheckoutNotice(Sabai_Addon_PaidListings_Model_Order $order){}
    
    public function getDefaultConfig()
    {
        return array(
            'login' => '',
            'transaction_key' => '',
            'label' => 'text_logo',
            'logo' => null,
            'text' => __('Credit Card (Authorize.net)', 'sabai-paidlistings'),
            'sb' => true,
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
                'login' => array(
                    '#type' => 'textfield',
                    '#title' => __('API Login ID', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['login'],
                ),
                'transaction_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Transaction Key', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['transaction_key'],
                ),
                'sb' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Enable sandbox mode', 'sabai-paidlistings'),
                    '#default_value' => $this->_config['sb'],
                ),
            ),
        );
    }
}