<?php
class Sabai_Addon_PaidListings_Controller_Admin_DeletePlan extends Sabai_Addon_Form_Controller
{
    protected function _doGetFormSettings(Sabai_Context $context, array &$formStorage)
    {
        $this->_submitButtons['submit'] = array(
            '#value' => __('Delete Plan', 'sabai-paidlistings'),
            '#btn_type' => 'danger',
        );
        $url_params = array('sort' => $context->getRequest()->asStr('sort'), 'order' => $context->getRequest()->asStr('order'), 'type' => $context->getRequest()->asStr('type'));
        $this->_cancelUrl = $context->bundle->getAdminPath() . '/plans';
        $form = array();
        $form['#header'][] = sprintf(
            '<div class="sabai-alert sabai-alert-warning">%s</div>',
            __('Are you sure you want to delete this plan? This cannot be undone.', 'sabai-paidlistings')
        );
        
        // Add URL params as hidden
        foreach ($url_params as $key => $value) {
            $form[$key] = array(
                '#type' => 'hidden',
                '#value' => $value,
            );
        }

        return $form;
    }

    public function submitForm(Sabai_Addon_Form_Form $form, Sabai_Context $context)
    {
        $context->plan->markRemoved()->commit();
        $this->Action('paidlistings_delete_plan_success', array($context->plan));
        $context->setSuccess($this->_cancelUrl);
    }
}