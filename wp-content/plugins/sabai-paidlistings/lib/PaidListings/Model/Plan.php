<?php
class Sabai_Addon_PaidListings_Model_Plan extends Sabai_Addon_PaidListings_Model_Base_Plan
{
    public function __toString()
    {
        return $this->name;
    }
    
    public function getPrice($paymentType = '')
    {
        return $paymentType && isset($this->recurring[$paymentType]['price']) ? $this->recurring[$paymentType]['price'] : $this->price;
    }
    
    public function getTrialPeriodDays($recurringInterval)
    {
        return (int)@$this->recurring[$recurringInterval]['trial_period'];
    }
    
    public function getDescription($paymentType = '', $html = false)
    {
        if (strlen($this->description)) {
            return $html ? $this->description : strip_tags($this->description);
    
            }
        return $this->getPaymentTypeDescription($paymentType, $html);
    }

    public function getPaymentTypeDescription($paymentType = '', $html = false, $trial = true)
    {
        $formatted = $this->_model->PaidListings_MoneyFormat($this->getPrice($paymentType), $this->currency);
        $ret = sprintf(
            __('%s (%s)', 'sabai-paidlistings'),
            $html ? '<strong>' . $formatted . '</strong>' : strip_tags($formatted),
            $this->getDurationLabel($paymentType)
        );
        if ($paymentType === '') return $ret;
        
        return $trial && ($trial_days = $this->getTrialPeriodDays($paymentType))
            ? sprintf(__('%s with %d-day trial', 'sabai-paidlistings'), $ret, $trial_days)
            : $ret;
    }
    
    public function getDurationLabel($paymentType)
    {
        switch ($paymentType) {
            case '':
                return __('One Time', 'sabai-paidlistings');
            case 'w':
                return __('Per Week', 'sabai-paidlistings');
            case 'm':
                return __('Per Month', 'sabai-paidlistings');
            case '3m':
                return __('Every 3 Months', 'sabai-paidlistings');
            case '6m':
                return __('Every 6 Months', 'sabai-paidlistings');
            case 'y':
                return __('Per Year', 'sabai-paidlistings');
        }
    }
}

class Sabai_Addon_PaidListings_Model_PlanRepository extends Sabai_Addon_PaidListings_Model_Base_PlanRepository
{
}
