<?php
interface Sabai_Addon_PaidListings_IFeature
{
    public function paidListingsFeatureGetInfo($key = null);
    public function paidListingsFeatureGetSettingsForm($entityBundleName, array $settings, array $parents);
    public function paidListingsFeatureGetOrderDescription(Sabai_Addon_PaidListings_Model_OrderItem $orderItem, array $settings);
    public function paidListingsFeatureIsAppliable(Sabai_Addon_Entity_Entity $entity, Sabai_Addon_PaidListings_Model_OrderItem $orderItem, $isManual = false);
    public function paidListingsFeatureApply(Sabai_Addon_Entity_Entity $entity, Sabai_Addon_PaidListings_Model_OrderItem $orderItem);
    public function paidListingsFeatureUnapply(Sabai_Addon_Entity_Entity $entity, Sabai_Addon_PaidListings_Model_OrderItem $orderItem);
    public function paidListingsFeatureOnOrder($planType, array $currentSettings, array $orderSettings);
    public function paidListingsFeatureIsOrderable(Sabai_Addon_Entity_Entity $entity, array $settings);
    public function paidListingsFeatureGetSummary($entityBundleName, array $settings, $paymentType);
}