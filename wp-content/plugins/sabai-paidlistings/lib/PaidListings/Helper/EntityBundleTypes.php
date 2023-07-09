<?php
class Sabai_Addon_PaidListings_Helper_EntityBundleTypes extends Sabai_Helper
{
    /**
     * Returns all paid listing entity bundle types
     * @param Sabai $application
     */
    public function help(Sabai $application, $useCache = true)
    {
        if (!$useCache
            || (!$bundle_types = $application->getPlatform()->getCache('paidlistings_entity_bundle_types'))
        ) {
            $bundle_types = array();
            foreach ($application->getInstalledAddonsByInterface('Sabai_Addon_PaidListings_IEntityBundleTypes') as $addon_name) {
                if (!$application->isAddonLoaded($addon_name)) continue;
                
                foreach ($application->getAddon($addon_name)->paidListingsGetEntityBundleTypes() as $bundle_type) {
                    $bundle_types[] = $bundle_type;
                }
            }
            $application->getPlatform()->setCache($bundle_types, 'paidlistings_entity_bundle_types');
        }

        return $bundle_types;
    }
}