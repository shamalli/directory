<?php
class Sabai_Addon_PaidListings_Helper_PaymentForm extends Sabai_Helper
{
    public function help(Sabai $application, Sabai_Addon_PaidListings_Model_Plan $plan, $formStorage, $paymentType = null, $onetimeOnly = false, $recurringOnly = false)
    {
        $form = array(
            '#inherits' => array('paidlistings_payment_form'),
            '#next_btn_label' => __('Confirm Order', 'sabai-paidlistings'),
            '#validate' => array(array(array($this, 'validate'), array($application, $plan))),
        );
        
        $payment_type_options = $paid_payment_type_options = array();
        if (!$recurringOnly && $plan->onetime) {
            $payment_type_options[''] = $plan->getPaymentTypeDescription('', true);
            if ($plan->price > 0) {
                $paid_payment_type_options[] = '';
            }
        }
        if (!$onetimeOnly && $plan->recurring) {
            foreach ($plan->recurring as $recurring_interval => $recurring) {
                $payment_type_options[$recurring_interval] = $plan->getPaymentTypeDescription($recurring_interval, true);
                if ($recurring['price'] > 0) {
                    $paid_payment_type_options[] = $recurring_interval;
                }
            }
        }

        $form['payment_type'] = array(
            '#title' => __('Payment Type', 'sabai-paidlistings'),
            '#type' => 'radios',
            '#options' => $payment_type_options,
            '#title_no_escape' => true,
            '#default_value_auto' => true,
            '#display_required' => true,
            '#class' => 'sabai-paidlistings-payment-types',
            '#default_value' => $paymentType,
        );
        
        if (!empty($paid_payment_type_options)) {   
            $methods = $methods_to_payment_types = $method_info = array();
            foreach ($application->getInstalledAddonsByInterface('Sabai_Addon_PaidListings_IGateway') as $gateway) {
                $method_info[$gateway] = $application->getAddon($gateway)->paidListingsGatewayGetInfo();
                if (empty($method_info[$gateway]['enable'])) continue;
            
                if ($plan->onetime) {
                    $methods[$gateway] = $this->_getPaymentMethodLabel($method_info[$gateway]);
                    $methods_to_payment_types[$gateway][] = '';
                }
                if (isset($method_info[$gateway]['recurring']) && $plan->recurring) {
                    foreach ($plan->recurring as $recurring_interval => $recurring) {
                        if (in_array($recurring_interval, $method_info[$gateway]['recurring'])) {
                            $methods[$gateway] = $this->_getPaymentMethodLabel($method_info[$gateway]);
                            $methods_to_payment_types[$gateway][] = $recurring_interval;
                        }
                    }
                }
            }

            if (!empty($methods)) {
                $attr = array();
                foreach (array_keys($methods_to_payment_types) as $key) {
                    $attr[$key]['data-values'] = json_encode($methods_to_payment_types[$key]);
                }
                $form += array(
                    'method' => array(
                        '#type' => 'radios',
                        '#title' => __('Payment Method', 'sabai-paidlistings'),
                        '#options' => $methods,
                        '#title_no_escape' => true,
                        '#required' => array(array($this, 'isPaymentMethodRequired'), array($plan)),
                        '#states' => array(
                            'visible' => array(
                                'input[name="payment_type"]' => array('value' => $paid_payment_type_options),
                            ),
                            'show_options' => array(
                                'input[name="payment_type"]' => array('type' => 'selected', 'value' => true),
                            ),
                        ),
                        '#attributes' => $attr,
                        '#default_value_auto' => true,
                    ),
                );

                $method_requested = isset($_REQUEST['method']) && isset($methods[$_REQUEST['method']]) ? $_REQUEST['method'] : null;
                foreach (array_keys($methods) as $gateway) {
                    $gateway_form = $application->getAddon($gateway)->paidListingsGatewayGetCheckoutForm($formStorage, $plan);
                    if (false === $gateway_form) return array(); // skip payment
                
                    if (empty($gateway_form)) continue;
                
                    // Do not perform required field check if the gateway was not selected
                    if (!empty($gateway_form['#required'])
                        && $method_requested
                        && $method_requested !== $gateway
                    ) {
                        $gateway_form['#required'] = false;
                        $gateway_form['#display_required'] = true;
                    }
                
                    $form[$gateway] = $gateway_form + array(
                        '#title' => $method_info[$gateway]['text'],
                        '#tree' => true,
                        '#states' => array(
                            'visible' => array(
                                'input[name="payment_type"]' => array('value' => $paid_payment_type_options),
                                'input[name="method"]' => array('value' => $gateway),
                            ),
                        ),
                    );
                }
            }
            $form['tac'] = array(
                '#type' => 'paidlistings_tac',
            );
        }
        
        return $form;
    }
    
    
    public function isPaymentMethodRequired($form, $plan)
    {
        $payment_type = $form->values['payment_type'];
        $price = $payment_type === '' ? $plan->price : @$plan->recurring[$payment_type]['price'];

        return !empty($price);
    }
    
    public function validate($form, $application, $plan)
    {
        try {
            $application->PaidListings_ValidatePayment($plan, $form->values['payment_type'], @$form->values['method']);
        } catch (Sabai_RuntimeException $e) {
            switch ($e->getCode()) {
                case Sabai_Addon_PaidListings_Helper_ValidatePayment::INVALID_METHOD:
                    $element = 'method';
                    break;
                case Sabai_Addon_PaidListings_Helper_ValidatePayment::INVALID_TYPE:
                    $element = 'payment_type';
                    break;
                default:
                    $element = null;
            }
            $form->setError($e->getMessage(), $element);
        }
    }
    
    protected function _getPaymentMethods(Sabai $application, Sabai_Addon_PaidListings_Model_Plan $plan)
    {
        $gateways = array();
        foreach ($application->getInstalledAddonsByInterface('Sabai_Addon_PaidListings_IGateway') as $gateway_addon) {
            $info = $application->getAddon($gateway_addon)->paidListingsGatewayGetInfo();
            if (empty($info['enable'])) continue;
            
            if ($plan->onetime) {
                $gateways[$gateway_addon] = $this->_getPaymentMethodLabel($info);
                continue;
            }
            if ($plan->recurring) {
                foreach ($plan->recurring as $recurring_interval => $recurring) {
                    if (in_array($recurring_interval, $info['recurring'])) {
                        $gateways[$gateway_addon] = $this->_getPaymentMethodLabel($info);
                        continue 2;
                    }
                }
            }
        }
        return $gateways;
    }
    
    protected function _getPaymentMethodLabel(array $info)
    {
        // Set to text mode if no logo
        if (strpos($info['label'], 'logo') !== false && !strlen($info['logo'])) {
            $info['label'] = 'text';
        }
        switch ($info['label']) {
            case 'logo':
                return '<img style="margin:5px !important;" src="'. $info['logo'] .'" alt="' . Sabai::h($info['text']) . '" />';
            case 'text':
                return Sabai::h($info['text']);
            case 'logo_text':
                return '<img style="margin:5px !important;" src="'. $info['logo'] .'" />' . Sabai::h($info['text']);
            case 'text_logo':
                return Sabai::h($info['text']) . '<img style="margin:5px !important;" src="'. $info['logo'] .'" />';
        }
    }
}
