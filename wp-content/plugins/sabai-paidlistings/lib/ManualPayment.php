<?php
require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/IGateway.php';

class Sabai_Addon_ManualPayment extends Sabai_Addon
    implements Sabai_Addon_PaidListings_IGateway, Sabai_Addon_System_IAdminSettings
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
            'logo' => $this->_config['logo'],
            'text' => $this->_config['text'],
        );
    }
        
    public function paidListingsGatewayGetCheckoutForm(array $formStorage, Sabai_Addon_PaidListings_Model_Plan $plan)
    {
        return array();
    }
    
    public function paidListingsGatewayCheckout(Sabai_Addon_Form_Form $form, Sabai_Addon_PaidListings_Model_Order $order, $returnUrl, $cancelUrl)
    {
        $order->gateway = $this->_name;
        $order->markPaymentPending();
        $order->getModel()->commit();
        
        if ($this->_config['mail']['enable']) {
            $settings = array(
                'email' => array(
                    'subject' => $this->_config['mail']['subject'],
                    'body' => $this->_config['mail']['body'],
                )
            );
            $this->_application->System_SendEmail($settings, null, $this->_getOrderTags($order), $order->User);
        }
    }
    
    public function paidListingsGatewayGetPostCheckoutNotice(Sabai_Addon_PaidListings_Model_Order $order)
    {
        return strtr($this->_config['instructions'], $this->_getOrderTags($order));
    }
    
    protected function _getOrderTags(Sabai_Addon_PaidListings_Model_Order $order = null)
    {
        if (!$order) {
            return array('{order_id}', '{order_price}', '{order_currency}', '{order_user_name}', '{order_user_email}', '{order_date}',
                '{plan_name}', '{plan_description}'
            );
        }
        return array(
            '{order_id}' => $order->id,
            '{order_plan}' => $order->Plan->name, // for version <1.3.3
            '{order_price}' => $order->price,
            '{order_currency}' => $order->currency,
            '{order_user_name}' => $order->User->name,
            '{order_user_email}' => $order->User->email,
            '{order_date}' => $this->_application->Date($order->created),
            '{plan_name}' => $order->Plan->name,
            '{plan_description}' => $order->Plan->description,
        );
    }
    
    public function getDefaultConfig()
    {
        return array(
            'label' => 'text',
            'text' => __('Manual Payment', 'sabai-paidlistings'),
            'logo' => null,
            'instructions' => '<p>Place your payment instructions here. You can edit this text from Settings -> Sabai -> ManualPayment</p>',
            'mail' => array(
                'enable' => true,
                'subject' => __('[{site_name}] We received your order (ID: {order_id})', 'sabai-paidlistings'),
                'body' => __('Hi {recipient_name},
                
We have received your order placed on {order_date} and its now pending payment.

------------------------------------
{plan_name} - {order_price} {order_currency}
------------------------------------

Regards,
{site_name}
{site_url}', 'sabai-paidlistings'),
            ),
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
                'instructions' => array(
                    '#type' => 'textarea',
                    '#title' => __('Payment Instructions', 'sabai-paidlistings'),
                    '#description' => sprintf(__('Displayed on the thank you page, after the customer has completed the order. Available template tags: %s', 'sabai-paidlistings'), implode(' ', $this->_getOrderTags())),
                    '#default_value' => $this->_config['instructions'],
                    '#rows' => 10,
                ),
                'mail' => array(
                    '#tree' => true,
                    'enable' => array(
                        '#type' => 'checkbox',
                        '#title' => __('Send payment instructions email', 'sabai-paidlistings'),
                        '#default_value' => !empty($this->_config['mail']['enable']),
                    ),
                    'subject' => array(
                        '#type' => 'textfield',
                        '#title' => __('Payment instructions email subject', 'sabai-paidlistings'),
                        '#default_value' => $this->_config['mail']['subject'],
                        '#states' => array(
                            'visible' => array('input[name="mail[enable][]"]' => array('type' => 'checked', 'value' => true)),
                        ),
                    ),
                    'body' => array(
                        '#type' => 'textarea',
                        '#title' => __('Payment instructions email body', 'sabai-paidlistings'),
                        '#rows' => 10,
                        '#default_value' => $this->_config['mail']['body'],
                        '#states' => array(
                            'visible' => array('input[name="mail[enable][]"]' => array('type' => 'checked', 'value' => true)),
                        ),
                        '#description' => sprintf(__('Available tempalte tags: %s', 'sabai-paidlistings'), implode(' ', $this->_getOrderTags()) . ' {recipient_name} {site_name} {site_url} {site_email}'),
                    ),
                ),
            ),
        );
    }
}