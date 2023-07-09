<?php
class Sabai_Addon_PaidListings_Helper_ApplyFeatures extends Sabai_Helper
{    
    /**
     * @param Sabai $application
     * @param Sabai_Addon_Entity_Entity $entity Content to which ordered features should be applied
     */
    public function help(Sabai $application, Sabai_Addon_Entity_Entity $entity, $orders = null, $isManual = false)
    {
        $application->Entity_LoadFields($entity);
        if (!isset($orders)) {
            $orders = $application->getModel('Order', 'PaidListings')
                ->entityId_is($entity->getId())
                ->status_in(array(Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE, Sabai_Addon_PaidListings::ORDER_STATUS_PAID))
                ->fetch()
                ->with('User')
                ->with('OrderItems', array('OrderItemMetas'));
        }
        $order_items_updated = array();
        foreach ($orders as $order) {
            foreach ($order->OrderItems as $order_item) {
                if ($order_item->isComplete()
                    || (!$ifeature = $application->PaidListings_FeatureImpl($order_item->feature_name))
                ) {
                    continue;
                }
                if ($ifeature->paidListingsFeatureIsAppliable($entity, $order_item, $isManual)) {
                    if ($ifeature->paidListingsFeatureApply($entity, $order_item)) {
                        $order_item->status = Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_DELIVERED;
                        $order_item->createOrderLog(__('Item delivered.', 'sabai-paidlistings'));
                        $order_items_updated[] = $order_item;
                    } else {
                        $order_item->createOrderLog(__('Item delivery failed.', 'sabai-paidlistings'), true);
                    }
                }
            }
        }
        $application->getModel(null, 'PaidListings')->commit();
        
        if (!empty($order_items_updated)) {
            // Notify that the status of one or more order items have changed
            $application->Action('paidlistings_order_items_status_change', array($order_items_updated));
        }
    }
}