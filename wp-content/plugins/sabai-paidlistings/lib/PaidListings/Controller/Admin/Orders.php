<?php
require_once dirname(dirname(__FILE__)) . '/ViewOrders.php';

class Sabai_Addon_PaidListings_Controller_Admin_Orders extends Sabai_Addon_PaidListings_Controller_ViewOrders
{
    protected function _getEntityBundleName(Sabai_Context $context)
    {
        return $context->bundle->name;
    }
}
