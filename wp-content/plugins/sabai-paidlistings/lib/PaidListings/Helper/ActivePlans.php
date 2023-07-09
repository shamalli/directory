<?php
class Sabai_Addon_PaidListings_Helper_ActivePlans extends Sabai_Helper
{
    protected $_plans = array();
    
    public function help(Sabai $application, $bundle, $type = null, $id = null)
    {
        if (is_object($bundle)) {
            $bundle = $bundle->name;
        }
        if (!isset($this->_plans[$bundle])) {
            $this->_plans[$bundle] = array();
            foreach ($application->getModel('Plan', 'PaidListings')->entityBundleName_is($bundle)->active_is(1)->fetch(0, 0, 'weight', 'ASC') as $plan) {
                $this->_plans[$bundle][$plan->type][$plan->id] = $plan;
            }
        }
        if (!isset($type)) {
            return $this->_plans[$bundle];
        }
        if (!isset($id)) {
            $ret = array();
            foreach ((array)$type as $_type) {
                $ret += (array)@$this->_plans[$bundle][$_type];
            }
            return $ret;
        }
        return @$this->_plans[$bundle][$type][$id];
    }
}