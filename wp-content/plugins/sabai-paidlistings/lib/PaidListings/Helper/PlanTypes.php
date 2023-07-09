<?php
class Sabai_Addon_PaidListings_Helper_PlanTypes extends Sabai_Helper
{
    /**
     * Returns all paid listing plan types
     * @param Sabai $application
     */
    public function help(Sabai $application, $withAll = true, $withDescription = false)
    {
        $labels = array(
            'base' => __('Base', 'sabai-paidlistings'),
            'addon' => __('Add-on', 'sabai-paidlistings'),
        );
        if ($withAll) {
            $labels = array('' => __('All', 'sabai-paidlistings')) + $labels;
        }
        if (!$withDescription) {
            return $labels;
        }
        $descriptions = array(
            'base' => __('A base plan includes a basic package of features and is required for any paid listing.', 'sabai-paidlistings'),
            'addon' => __('An add-on plan includes additional features or services that may only be purchased on top of a base plan.', 'sabai-paidlistings'),
        );
        return array($labels, $descriptions);
    }
}