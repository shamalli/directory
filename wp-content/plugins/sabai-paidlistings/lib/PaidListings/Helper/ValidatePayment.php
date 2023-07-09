<?php
class Sabai_Addon_PaidListings_Helper_ValidatePayment extends Sabai_Helper
{
    const INVALID_PLAN = 0, INVALID_TYPE = 1, INVALID_METHOD = 2;
    
    public function help(Sabai $application, $plan, $paymentType = '', $paymentMethod = null, $bundle = null)
    {
        if (!$plan instanceof Sabai_Addon_PaidListings_Model_Plan) {
            if (empty($plan)
                || (!$plan = $application->PaidListings_Plan($plan))
                || !$plan->active
                || $plan->entity_bundle_name !== $bundle
            ) {
                throw new Sabai_RuntimeException(__('Invalid payment plan.', 'sabai-paidlistings'), self::INVALID_PLAN);
            }
        }
        
        if (!in_array($paymentType, array('', 'w', 'm', '3m', '6m', 'y'), true)) {
            throw new Sabai_RuntimeException(__('Please select a payment type.', 'sabai-paidlistings'), self::INVALID_TYPE);
        }

        if ($paymentType === '') {
            if ($plan->price <= 0) return; // free
        } else {
            if (!isset($plan->recurring[$paymentType])) {
                throw new Sabai_RuntimeException(__('The selected payment plan does not support the selected recurring payment type.', 'sabai-paidlistings'), self::INVALID_TYPE);
            }
        }
        
        if (!isset($paymentMethod)) return; // no gateway checking
        
        if (!$application->isAddonLoaded($paymentMethod)) {
            throw new Sabai_RuntimeException(__('Invalid payment method.', 'sabai-paidlistings'), self::INVALID_METHOD);
        }        
        
        $gateway_info = $application->getAddon($paymentMethod)->paidListingsGatewayGetInfo();
        if (!empty($gateway_info['currencies']) && !in_array($plan->currency, $gateway_info['currencies'])) {
            throw new Sabai_RuntimeException(sprintf(__('The selected payment method does not support the currency (%s) set for the plan.', 'sabai-paidlistings'), $plan->currency), self::INVALID_METHOD);
        }
        
        if ($paymentType === '') {
            if (!$plan->onetime) {
                throw new Sabai_RuntimeException(__('The selected payment method does not support one-time payments.', 'sabai-paidlistings'), self::INVALID_METHOD);
            }
        } else {
            if (empty($gateway_info['recurring'])) {
                throw new Sabai_RuntimeException(__('The selected payment method does not support recurring payments.', 'sabai-paidlistings'), self::INVALID_METHOD);
            } elseif (!in_array($paymentType, $gateway_info['recurring'])) {
                throw new Sabai_RuntimeException(__('The selected payment method does not support the selected recurring payment type.', 'sabai-paidlistings'), self::INVALID_METHOD);                        
            }
        }
    }
}