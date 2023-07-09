<?php
class Sabai_Addon_PaidListings_Helper_OrderablePlans extends Sabai_Helper
{    
    public function help(Sabai $application, Sabai_Addon_Entity_Entity $entity, $planType, $onetimeOnly = false, $recurringOnly = false)
    {
        $plans = $application->PaidListings_ActivePlans($entity->getBundleName(), $planType);
        if (empty($plans)) {
            return array();
        }
        
        $application->Entity_LoadFields($entity);
        
        $plans_orderable = $features = array();
        foreach (array_keys($plans) as $plan_id) {
            if ($planType === 'base') {
                if ($onetimeOnly && !$plans[$plan_id]->onetime) {
                    continue;
                }
                if ($recurringOnly && !$plans[$plan_id]->recurring) {
                    continue;
                }
            } else {
                if (!$plans[$plan_id]->onetime) {
                    continue;
                }
            }
            foreach ((array)$plans[$plan_id]->features as $feature_name => $feature) {
                if (empty($feature['enable'])) continue;
                
                if (!isset($features[$feature_name])) { 
                    $features[$feature_name] = ($ifeature = $application->PaidListings_FeatureImpl($feature_name))
                        && $ifeature->paidListingsFeatureIsOrderable($entity, $feature);
                }
                if ($features[$feature_name]) {
                    $plans_orderable[$plan_id] = $plans[$plan_id];
                    continue 2;
                }
            }
        }
        
        return $plans_orderable;
    }
}
