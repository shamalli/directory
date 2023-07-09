<?php
abstract class Sabai_Addon_PaidListings_Controller_PricingTable extends Sabai_Controller
{
    protected $_columns = 3, $_linkOtherPaymentTypes;
    
    protected function _doExecute(Sabai_Context $context)
    {        
        //$plan_ids = $this->_getPlanIds($context);
        $payment_types = $this->_getPaymentTypes($context);
        if (!isset($this->_linkOtherPaymentTypes)) {
            $this->_linkOtherPaymentTypes = count($payment_types) > 1;
        }
        $bundle = $this->_getBundle($context);
        $plan_type = $this->_getPlanType($context);
        $plans = array();
        $max_feature_count = 0;
        foreach ($this->PaidListings_ActivePlans($bundle, $plan_type) as $plan) {
            foreach ($payment_types as $payment_type) {
                if ($payment_type == 1) {
                    if (!$plan->onetime) continue;
                } else {
                    if (!isset($plan->recurring[$payment_type])) continue;
                }

                $buttons = array($this->LinkTo($this->_getButtonLabel($context), $this->_getPlanOrderUrl($context, $bundle, $plan, $payment_type), array(), array('class' => 'sabai-btn sabai-btn-success')));
                if ($this->_linkOtherPaymentTypes) {
                    if ($payment_type != 1 && $plan->onetime) {
                        $buttons[] = $this->LinkTo($plan->getPaymentTypeDescription('', false), $this->_getPlanOrderUrl($context, $bundle, $plan, ''));
                    }
                    if ($plan->recurring) {
                        foreach ($plan->recurring as $recurring_interval => $recurring) {
                            if ($payment_type !== $recurring_interval) {
                                $buttons[] = $this->LinkTo($plan->getPaymentTypeDescription($recurring_interval, false, false), $this->_getPlanOrderUrl($context, $bundle, $plan, $recurring_interval));
                            }
                        }
                    }
                }
            
                $features = array();
                foreach ($plan->features as $feature_name => $feature_settings) {
                    if (($feature = $this->PaidListings_FeatureImpl($feature_name, true))
                        && ($summary = $feature->paidListingsFeatureGetSummary($bundle, $feature_settings, $payment_type == 1 ? '' : $payment_type))
                    ) {
                        foreach ((array)$summary as $_summary) {
                            $features[] = $_summary;
                        }
                    }
                }
                if ($max_feature_count < ($count = count($features))) {
                    $max_feature_count = $count;
                }

                $price = $this->PaidListings_MoneyFormat($plan->getPrice($payment_type), $plan->currency, 2, true, true);
                if ($price['decimals']) {
                    $pos = -1 * $price['decimals'];
                    $price['decimals'] = substr($price['value'], $pos);
                    $price['value'] = substr($price['value'], 0, $pos - 1);
                }
                $plans[] = array(
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'price' => $price,
                    'features' => $features,
                    'featured' => $plan->featured,
                    'payment_type' => $plan->getDurationLabel($payment_type),
                    'buttons' => $buttons,
                );
            }
        }
        $context->plans = $this->Filter('paidlistings_pricing_table_plans', $plans, array($bundle, $plan_type, $payment_types));
        $context->max_feature_count = $max_feature_count;
        $context->span = in_array($this->_columns, array(1, 2, 3, 4, 6, 12)) ? 12 / $this->_columns : 3;
        
        $context->addTemplateDir($this->getPlatform()->getAssetsDir('sabai-paidlistings') . '/templates')->addTemplate('paidlistings_pricing_table'); 
        $this->LoadCss($this->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/css/sabai-paidlistings-pricing-table.min.css', 'sabai-paidlistings-pricing-table', null, false);
        if ($this->getPlatform()->isLanguageRTL()) {
            $this->LoadCss($this->getPlatform()->getAssetsUrl('sabai-paidlistings') . '/css/sabai-paidlistings-pricing-table-rtl.min.css', 'sabai-paidlistings-pricing-table-rtl', 'sabai-paidlistings-pricing-table', false);
        }
    }
    
    protected function _getButtonLabel(Sabai_Context $context)
    {
        return _x('Order Now', 'pricing table', 'sabai-paidlistings');
    }
    
    protected function _getPaymentTypes(Sabai_Context $context)
    {
        return array(1);
    }
    
    protected function _getPlanType(Sabai_Context $context)
    {
        return 'base';
    }
    
    abstract protected function _getBundle(Sabai_Context $context);
    abstract protected function _getPlanOrderUrl(Sabai_Context $context, $bundleName, Sabai_Addon_PaidListings_Model_Plan $plan, $paymentType = null);
}
