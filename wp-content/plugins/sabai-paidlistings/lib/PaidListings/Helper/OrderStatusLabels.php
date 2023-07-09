<?php
class Sabai_Addon_PaidListings_Helper_OrderStatusLabels extends Sabai_Helper
{    
    /**
     * @param Sabai $application
     */
    public function help(Sabai $application)
    {
        return array(
            Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE => __('Complete', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_PAID => __('Paid', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_PROCESSING => __('Processing', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_PENDING => __('Pending Payment', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_EXPIRED => __('Expired', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_FAILED => __('Failed', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_CANCELLED => __('Cancelled', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_REFUNDED => __('Refunded', 'sabai-paidlistings'),
            Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED => __('Suspended', 'sabai-paidlistings'),
        );
    }
}