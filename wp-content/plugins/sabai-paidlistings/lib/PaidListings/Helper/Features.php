<?php
class Sabai_Addon_PaidListings_Helper_Features extends Sabai_Helper
{
    /**
     * Returns all available payment plan features
     * @param Sabai $application
     */
    public function help(Sabai $application, $useCache = true)
    {
        if (!$useCache
            || (!$features = $application->getPlatform()->getCache('paidlistings_features'))
        ) {
            $features = array();
            foreach ($application->getInstalledAddonsByInterface('Sabai_Addon_PaidListings_IFeatures') as $addon_name) {
                if (!$application->isAddonLoaded($addon_name)) continue;
                
                foreach ($application->getAddon($addon_name)->paidListingsGetFeatureNames() as $feature_name) {
                    if (!$application->getAddon($addon_name)->paidListingsGetFeature($feature_name)) {
                        continue;
                    }
                    $features[$feature_name] = $addon_name;
                }
            }
            $application->getPlatform()->setCache($features, 'paidlistings_features');
        }

        return $features;
    }
}