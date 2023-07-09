<?php
class Sabai_Addon_PaidListings_Helper_LastOrder extends Sabai_Helper
{    
    public function help(Sabai $application, Sabai_Addon_Entity_Entity $entity)
    {
        return $application->getModel('Order', 'PaidListings')
            ->entityId_is($entity->getId())
            ->fetchOne('created', 'DESC');
    }
}