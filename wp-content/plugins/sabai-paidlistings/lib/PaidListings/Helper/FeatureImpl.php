<?php
class Sabai_Addon_PaidListings_Helper_FeatureImpl extends Sabai_Helper
{
    private $_impls = array();

    /**
     * Gets an implementation of Sabai_Addon_PaidListings_IFeature interface for a given feature type
     * @param Sabai $application
     * @param string $feature
     * @param bool $useCache
     */
    public function help(Sabai $application, $feature, $returnFalse = true, $useCache = true)
    {
        if (!isset($this->_impls[$feature])) {
            $features = $application->PaidListings_Features($useCache);
            // Valid feature?
            if (!isset($features[$feature])
                || (!$application->isAddonLoaded($features[$feature]))
                || (!$impl = $application->getAddon($features[$feature])->paidListingsGetFeature($feature))
            ) {
                if ($returnFalse) return false;
                throw new Sabai_UnexpectedValueException(sprintf('Invalid feature: %s', $feature));
            }
            $this->_impls[$feature] = $impl;
        }

        return $this->_impls[$feature];
    }
}