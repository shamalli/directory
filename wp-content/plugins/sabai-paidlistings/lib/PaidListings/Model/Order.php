<?php
class Sabai_Addon_PaidListings_Model_Order extends Sabai_Addon_PaidListings_Model_Base_Order
{
    protected $_entityData = array();
    
    public function getLabel()
    {
        return '#' . str_pad($this->id, 5, 0, STR_PAD_LEFT);
    }
    
    public function isComplete()
    {
        return $this->status === Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE;
    }
    
    public function isPaid() 
    {
        return $this->status === Sabai_Addon_PaidListings::ORDER_STATUS_PAID;
    }
    
    public function markPaymentPaid($commit = false)
    {
        $this->status = Sabai_Addon_PaidListings::ORDER_STATUS_PAID;
        $this->createOrderLog(__('Order confirmed and payment complete.', 'sabai-paidlistings'), $this->status);
        if ($commit) {
            $this->_model->commit();
        }
        return $this;
    }
    
    public function markPaymentPending($commit = false)
    {
        $this->status = Sabai_Addon_PaidListings::ORDER_STATUS_PENDING;
        $this->createOrderLog(__('Order is pending payment.', 'sabai-paidlistings'), $this->status);
        if ($commit) {
            $this->_model->commit();
        }
        return $this;
    }
    
    public function getStatusLabel($status = null)
    {
        if (!isset($status)) {
            $status = $this->status;
        }
        switch ($status) {
            case Sabai_Addon_PaidListings::ORDER_STATUS_PENDING:
                return __('Pending Payment', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_PROCESSING:
                return __('Processing', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_PAID:
                return __('Paid', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE:
                return __('Complete', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_EXPIRED:
                return __('Expired', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_FAILED:
                return __('Failed', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_REFUNDED:
                return __('Refunded', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_CANCELLED:
                return __('Cancelled', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED:
                return __('Suspended', 'sabai-paidlistings');
            case Sabai_Addon_PaidListings::ORDER_STATUS_CREATED:
                return _x('Created', 'order created', 'sabai-paidlistings');
            default:
                return '';
        }
    }
    
    public function getStatusLabelClass($status = null)
    {
        if (!isset($status)) {
            $status = $this->status;
        }
        switch ($status) {
            case Sabai_Addon_PaidListings::ORDER_STATUS_PENDING:
                return'sabai-label-warning';
            case Sabai_Addon_PaidListings::ORDER_STATUS_PROCESSING:
            case Sabai_Addon_PaidListings::ORDER_STATUS_PAID:
                return 'sabai-label-info';                    
            case Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE:
                return 'sabai-label-success';
            case Sabai_Addon_PaidListings::ORDER_STATUS_FAILED:
            case Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED:
                return 'sabai-label-danger';
            case Sabai_Addon_PaidListings::ORDER_STATUS_CREATED:
            case Sabai_Addon_PaidListings::ORDER_STATUS_EXPIRED:
            case Sabai_Addon_PaidListings::ORDER_STATUS_CANCELLED:
            case Sabai_Addon_PaidListings::ORDER_STATUS_REFUNDED:
                return 'sabai-label-default';
            default:
                return '';
        }
    }
    
    public function getOrderStatusUserMessage($status = null)
    {
        if (!isset($status)) {
            $status = $this->status;
        }
        switch ($status) {
            case Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE:
                $ret = __('Your order (ID: %s) has been processed successfully and is complete.', 'sabai-paidlistings');
                break;
            case Sabai_Addon_PaidListings::ORDER_STATUS_PAID:
            case Sabai_Addon_PaidListings::ORDER_STATUS_PROCESSING:
                $ret = __('Your order (ID: %s) is currently being processed. We will notify you once it is complete.', 'sabai-paidlistings');
                break;
            case Sabai_Addon_PaidListings::ORDER_STATUS_PENDING:
                $ret = __('Your order (ID: %s) is currently awaiting payment. We will process your order once we receive your payment.', 'sabai-paidlistings');
                break;
            default:
                $ret = __('An error occurred while processing your order (ID: %s). Please contact the administrator for details.', 'sabai-paidlistings');
        }
        return sprintf($ret, $this->getLabel());
    }
        
    public function createOrderLog($message = '', $status = 0, $isError = false)
    {
        $order_log = parent::createOrderLog()->markNew();
        $order_log->order_id = $this->id;
        $order_log->message = strlen($message) ? mb_strcut(strtr($message, array("\r" => '', "\n" => ' ')), 0, 255) : $message;
        $order_log->status = $status;
        $order_log->is_error = $isError;
        return $order_log;
    }
    
    public function getGatewayData($key, $default = null)
    {
        if (isset($this->gateway_data[$key])) return $this->gateway_data[$key];
        return isset($this->gateway_data[0][$key]) ? $this->gateway_data[0][$key] : $default; // for compat with < 1.2.8
    }
    
    /* Add data from this order that should be stored as entity field data */
    public function setEntityData($key, $value)
    {
        $this->_entityData[$key] = $value;
        return $this;
    }
    
    public function getEntityData()
    {
        return $this->_entityData;
    }
    
    public function getFormattedPrice()
    {
        $ret = $this->_model->PaidListings_MoneyFormat($this->price, $this->currency);
        switch ($this->payment_type) {
            case 'w':
                return sprintf(__('%s / week', 'sabai-paidlistings'), $ret);
            case 'm':
                return sprintf(__('%s / month', 'sabai-paidlistings'), $ret);
            case '3m':
                return sprintf(__('%s / 3 months', 'sabai-paidlistings'), $ret);
            case '6m':
                return sprintf(__('%s / 6 months', 'sabai-paidlistings'), $ret);
            case 'y':
                return sprintf(__('%s / year', 'sabai-paidlistings'), $ret);
            default:
               return $ret;
        }
    }

    public function canChangeStatus($status = null)
    {
        if (!$this->isComplete() && $this->isStatusFrozen()) return false;
        
        if (!isset($status)) {
            $status = $this->status;
        }

        if ($this->isComplete()) {
            return $status !== Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE && in_array($status, self::frozenStatuses());
        }
        
        return true;
    }
    
    public function isStatusFrozen()
    {
        return in_array($this->status, array(
            Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE,
            Sabai_Addon_PaidListings::ORDER_STATUS_EXPIRED,
            Sabai_Addon_PaidListings::ORDER_STATUS_FAILED,
            Sabai_Addon_PaidListings::ORDER_STATUS_REFUNDED,
            Sabai_Addon_PaidListings::ORDER_STATUS_CANCELLED,
            Sabai_Addon_PaidListings::ORDER_STATUS_SUSPENDED
        ));
    }
}

class Sabai_Addon_PaidListings_Model_OrderRepository extends Sabai_Addon_PaidListings_Model_Base_OrderRepository
{
}