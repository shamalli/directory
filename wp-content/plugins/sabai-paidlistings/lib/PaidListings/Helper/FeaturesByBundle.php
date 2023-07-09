<?php
class Sabai_Addon_PaidListings_Helper_FeaturesByBundle extends Sabai_Helper
{
    /**
     * Returns all available payment plan features by bundle
     * @param Sabai $application
     */
    public function help(Sabai $application, $bundleType, $planType = 'base')
    {
        if (!$features_by_bundle = $application->getPlatform()->getCache('paidlistings_features_by_bundle')) {
            $features_by_bundle = array();
            foreach ($application->PaidListings_Features() as $feature_name => $addon_name) {
                if (!$application->isAddonLoaded($addon_name)) continue;
                
                foreach ((array)$application->getAddon($addon_name)->paidListingsGetFeature($feature_name)->paidListingsFeatureGetInfo('bundles') as $bundle_type => $plan_types) {
                    foreach ($plan_types as $plan_type) {
                        $features_by_bundle[(string)$bundle_type][$plan_type][$feature_name] = $feature_name;
                    }
                }
            }
            $application->getPlatform()->setCache($features_by_bundle, 'paidlistings_features_by_bundle');
        }

        $features = array();
        foreach ((array)$bundleType as $bundle_type) {
            foreach ((array)$planType as $plan_type) {
                if (isset($features_by_bundle[$bundle_type][$plan_type])) {
                    $features += $features_by_bundle[$bundle_type][$planType];
                }
            }
        }
        
        return $features;
    }
}