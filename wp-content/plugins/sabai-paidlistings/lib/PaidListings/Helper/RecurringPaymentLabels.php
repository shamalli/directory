<?php
class Sabai_Addon_PaidListings_Helper_RecurringPaymentLabels extends Sabai_Helper
{    
    /**
     * @param Sabai $application
     */
    public function help(Sabai $application)
    {
        return array(
            'w' => __('Per Week', 'sabai-paidlistings'),
            'm' => __('Per Month', 'sabai-paidlistings'),
            '3m' => __('Every 3 Months', 'sabai-paidlistings'),
            '6m' => __('Every 6 Months', 'sabai-paidlistings'),
            'y' => __('Per Year', 'sabai-paidlistings'),
        );
    }
}