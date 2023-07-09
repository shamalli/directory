<?php
class Sabai_Addon_PaidListings_Controller_Admin_Plans extends Sabai_Addon_Form_Controller
{
    protected function _doGetFormSettings(Sabai_Context $context, array &$formStorage)
    {
        // Init variables
        $this->_submitable = false;
        $this->_successFlash = __('Settings saved.', 'sabai-paidlistings');
        $sortable_headers = array('name' => 'name', 'weight' => 'weight');
        $sort = $context->getRequest()->asStr('sort', 'weight', array_keys($sortable_headers));
        $order = $context->getRequest()->asStr('order', 'ASC', array('ASC', 'DESC'));
        $url_params = array('sort' => $sort, 'order' => $order);
        // Init plan type filters and current filter
        $types = $this->PaidListings_PlanTypes();
        foreach ($types as $type => $type_label) {
            $type_links[$type] = $this->LinkToRemote($type_label, $context->getContainer(), $this->Url($context->getRoute(), array('type' => $type) + $url_params), array(), array('class' => 'sabai-btn sabai-btn-default sabai-btn-xs'));
        }
        $type = $context->getRequest()->asStr('type', '', array_keys($type_links));
        $type_links[$type]->setAttribute('class', $type_links[$type]->getAttribute('class') . ' sabai-active');
        if ($type !== '') {
            $url_params['type'] = $type;
        }
        
        // Init form
        $form = array(
            'plans' => array(
                '#type' => 'tableselect',
                '#options' => array(),
                '#disabled' => true,
                '#header' => array(
                    'name' => __('Plan name', 'sabai-paidlistings'),
                    'description' => __('Description', 'sabai-paidlistings'),
                    'price' => __('Price', 'sabai-paidlistings'),
                    'status' => __('Status', 'sabai-paidlistings'),
                    'listings' => $this->Entity_BundleLabel($context->bundle->name, false),
                ),
            ),
        );
        
        // Paginate plans
        $plans = $this->getModel('Plan', 'PaidListings')->entityBundleName_is($context->bundle->name);
        if ($type) {
            $plans->type_is($type);
            $url_params['type'] = $type;
            unset($form['plans']['#header']['type']);
        }
        $pager = $plans->paginate(20, $sortable_headers[$sort], $order)
            ->setCurrentPage($url_params[Sabai::$p] = $context->getRequest()->asInt(Sabai::$p, 1));

        
        // Set sortable headers
        $this->_makeTableSortable($context, $form['plans'], array_keys($sortable_headers), array(), $sort, $order, $url_params);

        $plan_ids = array();
        foreach ($pager->getElements() as $plan) {
            $links = array(
                $this->LinkToModal(__('Edit', 'sabai-paidlistings'), $this->Url($this->_getPlanPath($context, $plan), $url_params), array('width' => 720), array('title' => __('Edit Plan', 'sabai-paidlistings'))),
                $this->LinkToModal(__('Delete', 'sabai-paidlistings'), $this->Url($this->_getPlanPath($context, $plan, '/delete'), $url_params), array('width' => 470), array('title' => __('Delete Plan', 'sabai-paidlistings'))),
            );
            $price = array();
            if ($plan->onetime) {
                $price[] = $plan->getPaymentTypeDescription('', true);
            }
            if ($plan->type === 'base') {
                if ($plan->recurring) {
                    foreach (array_keys($plan->recurring) as $payment_type) {
                        $price[] = $plan->getPaymentTypeDescription($payment_type, true);
                    }
                }
                $label = '';
            } else {
                $label = '<span class="sabai-label sabai-label-default">' . $types[$plan->type] . '</span> ';
            } 
            if ($plan->featured) {
                $label = '<i class="fa fa-certificate sabai-entity-icon-featured"></i> ' . $label;
            }
            $form['plans']['#options'][$plan->id] = array(
                'name' => $label . '<strong class="sabai-row-title">' . $this->LinkToModal($plan->name, $this->Url($this->_getPlanPath($context, $plan), $url_params), array('width' => 720), array('title' => __('Edit Plan', 'sabai-paidlistings'))) . '</strong> (ID: ' . $plan->id . ')<div class="sabai-row-action">' . $this->Menu($links) . '</div>',
                'description' => Sabai::h($plan->description),
                'price' => implode('<br />', $price),
                'status' => $plan->active ? '<span class="sabai-label sabai-label-success">' . __('Active', 'sabai-paidlistings') . '</span>' : '<span class="sabai-label sabai-label-danger">' . __('Inactive', 'sabai-paidlistings') . '</span>',
                'listings' => 0,
            );
            $plan_ids[] = $plan->id;
        }
        
        if (!empty($plan_ids)) {
            $listing_counts = $this->Entity_Query($context->bundle->entitytype_name)
                ->fieldIsIn('paidlistings_plan', $plan_ids, 'plan_id')
                ->groupByField('paidlistings_plan', 'plan_id')
                ->count();
            foreach ($listing_counts as $plan_id => $listing_count) {
                $form['plans']['#options'][$plan_id]['listings'] = $listing_count;
            }       
        }
        
        // Add URL params as hidden
        foreach ($url_params as $key => $value) {
            $form[$key] = array(
                '#type' => 'hidden',
                '#value' => $value,
            );
        }
        
        $context->addTemplate($this->getPlatform()->getAssetsDir('sabai-paidlistings') . '/templates/paidlistings_plans')
            ->setAttributes(array(
                'links' => array(
                    $this->_getAddPlanLink($context, $url_params),
                ),
                'filters' => array(),
                'paginator' => $pager,
                'url_params' => $url_params,
            ));
        
        return $form;
    }
    
    public function submitForm(Sabai_Addon_Form_Form $form, Sabai_Context $context)
    {
       $context->setSuccess($this->Url($context->getRoute(), $context->url_params));
    }
    
    protected function _getAddPlanLink(Sabai_Context $context, array $params)
    {
        return $this->LinkToModal(__('Add Plan', 'sabai-paidlistings'), $this->Url($context->getRoute() . 'add', $params), array('icon' => 'plus', 'width' => 720), array('class' => 'sabai-btn sabai-btn-primary sabai-btn-sm', 'title' => __('Add Plan', 'sabai-paidlistings')));
    }
    
    protected function _getPlanPath(Sabai_Context $context, Sabai_Addon_PaidListings_Model_Plan $plan, $path = '')
    {
        return $context->getRoute() . $plan->id . $path;
    }
}
