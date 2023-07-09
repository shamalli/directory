<?php
class Sabai_Addon_PaidListings_Helper_Plan extends Sabai_Helper
{
    /**
     * Returns all paid listing plan types
     * @param Sabai $application
     */
    public function help(Sabai $application, $planId)
    {
        if ($planId instanceof Sabai_Addon_Entity_Entity) {
            $planId = $planId->getSingleFieldValue('paidlistings_plan', 'plan_id');
        }
        return $application->getModel('Plan', 'PaidListings')->fetchById($planId);
    }
}