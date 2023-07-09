<?php
abstract class Sabai_Addon_PaidListings_Controller_Order extends Sabai_Addon_Form_MultiStepController
{    
    private $_lastOrder;
    
    abstract protected function _getPlanType(Sabai_Context $context);
    abstract protected function _getEntity(Sabai_Context $context);
    
    protected function _getOrderMeta(Sabai_Context $context)
    {
        return array();
    }
    
    protected function _getSteps(Sabai_Context $context, array &$formStorage)
    {
        return array('select_plan', 'checkout');
    }
    
    protected function _getLastOrder(Sabai_Addon_Entity_Entity $entity)
    {
        if (!isset($this->_lastOrder)) {
            $this->_lastOrder = $this->PaidListings_LastOrder($entity);
        }
        return $this->_lastOrder;
    }
    
    protected function _getFormForStepSelectPlan(Sabai_Context $context, array &$formStorage)
    {
        $entity = $this->_getEntity($context);
        $onetime_only = $recurring_only = false;
        if ($last_order = $this->_getLastOrder($entity)) {
            if ($last_order->payment_type === '') {
                $onetime_only = true;
            } else {
                $recurring_only = true;
            }
        }
        if (!$plans = $this->PaidListings_OrderablePlans($entity, $this->_getPlanType($context), $onetime_only, $recurring_only)) {
            $context->setError(__('There are no plans available for the listing.', 'sabai-paidlistings'));
            return false;
        }
        
        $form = array(
            'plan' => array(
                '#type' => 'paidlistings_select_plan',
                '#plans' => $plans,
                '#required' => true,
            ),
        );
        $this->_ajaxSubmit = false;
        $this->_submitButtons = array();
        
        return $form;
    }
    
    protected function _getFormForStepCheckout(Sabai_Context $context, array &$formStorage)
    {
        if ($this->getUser()->isAnonymous()
            || (!$plan = $this->_getSelectedPlan($context, $formStorage))
        ) {
            return $this->_skipStepAndGetForm($context, $formStorage);
        }
        
        $entity = $this->_getEntity($context);
        $onetime_only = $recurring_only = false;
        
        if ($plan->type === 'base') {
            $entity = $this->_getEntity($context);
            if ($last_order = $this->_getLastOrder($entity)) {
                if ($last_order->payment_type === '') {
                    $onetime_only = true;
                } else {
                    $recurring_only = true;
                }
            }
        } else {
            $onetime_only = true;
        }
        
        return $this->PaidListings_PaymentForm($plan, $formStorage, null, $onetime_only, $recurring_only);
    }
    
    protected function _submitFormForStepCheckout(Sabai_Context $context, Sabai_Addon_Form_Form $form)
    {
        $entity = $this->_getEntity($context);
        $plan = $this->_getSelectedPlan($context, $form->storage);
        $order = $this->PaidListings_CreateOrder($entity, $plan, $form->values['payment_type'], $this->_getOrderMeta($context));
        // Checkout gateway
        if ($order->price) {
            $return_url = $this->_getPaymentReturnUrl($context, $form->storage);
            $cancel_url = $this->_getPaymentCancelUrl($context, $form->storage);
            $gateway = $form->values['method'];
            $this->getAddon($gateway)->paidListingsGatewayCheckout($form, $order, $return_url, $cancel_url);
            if ($form->hasError()) {
                $order->markRemoved()->getModel()->commit();
                return false;
            }
        } else {
            $order->markPaymentPaid(true);
        }
        // Update entity
        $entity_data = $order->getEntityData();
        switch ($plan->type) {
            case 'addon':
                unset($entity_data['plan_id']); 
                break;
            case 'base':
                $entity_data['plan_id'] = $plan->id;
                break;
        }
        $this->Entity_Save($entity, array('paidlistings_plan' => $entity_data));
        // Store order ID for later use
        $form->storage['order_id'] = $order->id;
    }
    
    protected function _complete(Sabai_Context $context, array $formStorage)
    {
        $order = $this->_getPaymentOrder($formStorage);
        $this->Action('paidlistings_order_received', array($order));
        $this->Action('paidlistings_order_status_change', array($order));

        $order->reload();
        switch ($order->status) {
            case Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE:
                $key = 'success';
                break;
            case Sabai_Addon_PaidListings::ORDER_STATUS_PAID:
            case Sabai_Addon_PaidListings::ORDER_STATUS_PROCESSING:
            case Sabai_Addon_PaidListings::ORDER_STATUS_PENDING:
                $key = 'info';
                break;
            default:
                $key = 'error';
                break;
        }
        // Display message
        $context->addTemplate('form_results')->setAttributes(array($key => array($order->getOrderStatusUserMessage())));
    }
    
    protected function _getSelectedPlan(Sabai_Context $context, array $formStorage)
    {
        if ((!$plan_id = $formStorage['values']['select_plan']['plan'])
            || (!$plan = $this->PaidListings_ActivePlans($this->_getEntity($context)->getBundleName(), $this->_getPlanType($context), $plan_id))
        ) {
            return false;
        }
        return $plan;
    }
    
    protected function _getPaymentOrder(array $formStorage)
    {
        if (empty($formStorage['order_id'])
            || (!$order = $this->getModel('Order', 'PaidListings')->fetchById($formStorage['order_id'], false, false))
        ) {
            throw new Sabai_RuntimeException('Invalid payment order');
        }
        return $order;
    }
    
    protected function _getPaymentReturnUrl(Sabai_Context $context, array $formStorage)
    {
        return $this->Url($context->getRoute(), array(Sabai_Addon_Form::FORM_BUILD_ID_NAME => $context->getRequest()->asStr(Sabai_Addon_Form::FORM_BUILD_ID_NAME)), '', '&');
    }
    
    protected function _getPaymentCancelUrl(Sabai_Context $context, array $formStorage)
    {
        return $this->Url($context->getRoute(), array(), '', '&');
    }
}
