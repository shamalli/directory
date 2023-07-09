<?php
class Sabai_Addon_PaidListings_Helper_CreateOrder extends Sabai_Helper
{
    public function help(Sabai $application, Sabai_Addon_Entity_Entity $entity, Sabai_Addon_PaidListings_Model_Plan $plan, $paymentType, array $data = array())
    {
        $price = $plan->getPrice($paymentType);
        $order = $plan->createOrder()->markNew();
        $order->User = $application->getUser();
        $order->status = Sabai_Addon_PaidListings::ORDER_STATUS_CREATED;
        $order->currency = $plan->currency;
        $order->price = $price;
        $order->payment_type = $paymentType;
        $order->entity_id = $entity->getId();
        $order->createOrderLog(__('Order created.', 'sabai-paidlistings'), $order->status);
        // Get current feature settings for the entity
        $all_feature_settings = isset($entity->paidlistings_plan) ? $entity->getSingleFieldValue('paidlistings_plan', 'addon_features') : array();
        // Create items
        foreach ($plan->features as $feature_name => $feature_settings) {
            if (!empty($feature_settings['enable'])) {
                unset($feature_settings['enable']);
                $order_item = $order->createOrderItem()->markNew();
                $order_item->feature_name = $feature_name;
                $order_item->status = Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_PENDING;
                // Append custom order data for this feature if any set
                if (isset($data[$feature_name])) {
                    $feature_settings += $data[$feature_name];
                }
                foreach ($feature_settings as $meta_key => $meta_value) {
                    if (!is_scalar($meta_value)) {
                        $meta_value = serialize($meta_value);
                    } elseif (is_bool($meta_value)) {
                        $meta_value = (int)$meta_value;
                    }
                    $order_item_meta = $order_item->createOrderItemMeta()->markNew();
                    $order_item_meta->key = $meta_key;
                    $order_item_meta->value = $meta_value;
                }
                if ($ifeature = $application->PaidListings_FeatureImpl($feature_name)) {
                    $all_feature_settings[$feature_name] = $ifeature->paidListingsFeatureOnOrder($plan->type, (array)@$all_feature_settings[$feature_name], $feature_settings);
                    if (!is_array($all_feature_settings[$feature_name])) {
                        unset($all_feature_settings[$feature_name]);
                    }
                }
            } else {
                unset($all_feature_settings[$feature_name]);
            }
        }
        $order->getModel()->commit();
        
        return $order->reload()->setEntityData('addon_features', $all_feature_settings);
    }
}