<?php
class Sabai_Addon_PaidListings_Helper_GatewayImpl extends Sabai_Helper
{
    /**
     * Gets an implementation of Sabai_Addon_PaidListings_IGateway interface for a given payment gateway
     * @param Sabai $application
     * @param string $gateway
     */
    public function help(Sabai $application, $gateway, $returnFalse = false)
    {
        if (!$application->isAddonLoaded($gateway)) {
            if ($returnFalse) return false;
            throw new Sabai_UnexpectedValueException(sprintf('Invalid gateway: %s', $gateway));
        }
        return $application->getAddon($gateway);
    }
}