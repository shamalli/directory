<?php
abstract class Sabai_Addon_PaidListings_Controller_ViewOrders extends Sabai_Addon_Form_Controller
{
    protected function _doGetFormSettings(Sabai_Context $context, array &$formStorage)
    {
        if (($order_id = $context->getRequest()->asInt('order_id'))
            && ($order = $this->getModel('Order', 'PaidListings')->fetchById($order_id))
            && in_array($order->Plan->entity_bundle_name, (array)$this->_getEntityBundleName($context))
            && $this->_isValidOrder($context, $order)
        ) {
            $order->with('Entity');
            $order_title = sprintf(__('Order %s', 'sabai-paidlistings'), $order->getLabel());
            $context->setInfo($order_title, $this->Url($context->getRoute(), array('order_id' => $order->id)));
            return $this->_viewSingleOrder($context, $order);
        }
        return $this->_viewOrders($context);
    }
    
    protected function _viewSingleOrder(Sabai_Context $context, $order)
    {
        $this->_submitable = false;
        $this->_cancelUrl = $context->getRoute();
        
        // Init form
        $form = array(
            'order_id' => array(
                '#type' => 'hidden',
                '#value' => $order->id,
            ),
        );
        
        $tab = $context->getRequest()->asStr('tab', 'items', array('items', 'logs'));
        if ($tab === 'logs') {
            $this->_addSingleOrderLogsForm($context, $order, $form);
        } else {
            $this->_addSingleOrderItemsForm($context, $order, $form);
        }
        
        // Set template for viewing this order
        $context->addTemplate($this->getPlatform()->getAssetsDir('sabai-paidlistings') . '/templates/paidlistings_order_single')
            ->setAttributes(array(
                'order' => $order,
                'tab' => $tab,
            ));
        
        return $form;
    }
    
    protected function _addSingleOrderLogsForm(Sabai_Context $context, $order, &$form)
    {
        // Create order logs table
        $form['logs'] = array(
            '#type' => 'tableselect',
            '#header' => array(
                'number' => '#',
                'date' => __('Log Date', 'sabai-paidlistings'),
                'message' => __('Log Message', 'sabai-paidlistings'),
                'item' => __('Order Item', 'sabai-paidlistings'),
                'status' => __('Order Status', 'sabai-paidlistings'),
            ),
            '#options' => array(),
            '#disabled' => true,
        );
        
        $number = 0;
        $order_logs = $order->OrderLogs->with('OrderItem')->getArray();
        ksort($order_logs);
        foreach ($order_logs as $order_log) {
            if ($order_log->OrderItem
                && ($ifeature = $this->PaidListings_FeatureImpl($order_log->OrderItem->feature_name))
            ) {
                $item = sprintf(__('%s (%s)', 'sabai-paidlistings'), $ifeature->paidListingsFeatureGetInfo('label'), Sabai::h($order_log->OrderItem->getLabel()));
            } else {
                $item = '';
            }
            $form['logs']['#options'][$order_log->id] = array(
                'number' => ++$number,
                'item' => $item,
                'message' => $order_log->message,
                'date' => $this->DateTime($order_log->created),
                'status' => $order_log->status ? sprintf('<span class="sabai-label %s">%s</span>', $order->getStatusLabelClass($order_log->status), $order->getStatusLabel($order_log->status)) : '',
            );
            if ($order_log->is_error) {
                $form['logs']['#row_attributes'][$order_log->id]['@row']['class'] = 'sabai-alert-danger';
            }
        }
    }
    
    protected function _addSingleOrderItemsForm(Sabai_Context $context, $order, &$form)
    {
        // Create order items table
        $form['items'] = array(
            '#type' => 'tableselect',
            '#header' => array(
                'id' => __('Item ID', 'sabai-paidlistings'),
                'name' => __('Item Name', 'sabai-paidlistings'),
                'description' => __('Description', 'sabai-paidlistings'),
                'status' => __('Status', 'sabai-paidlistings'),
            ),
            '#options' => array(),
            '#options_disabled' => array(),
            '#multiple' => true,
            '#disabled' => true,
        );
        $this->_submitButtons['submit'] = array(
            '#value' => __('Deliver Items', 'sabai-paidlistings'),
            '#btn_type' => 'primary',
        );
        $this->_ajaxOnSuccess = 'function (result, target, trigger) {target.hide(); return true;}';

        foreach ($order->OrderItems->with('OrderItemMetas') as $order_item) {
            if (!$ifeature = $this->PaidListings_FeatureImpl($order_item->feature_name)) {
                continue;
            }
            switch ($order_item->status) {
                case Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_PENDING:
                    if (($order->isPaid() || $order->isComplete())
                        && $ifeature->paidListingsFeatureIsAppliable($order->Entity, $order_item, true)
                    ) {
                        $class = 'sabai-label-info';
                        $status = __('Pending Delivery', 'sabai-paidlistings');
                        $this->_submitable = $this->getUser()->isAdministrator();
                        $form['items']['#disabled'] = !$this->_submitable;
                    } else {
                        $class = 'sabai-label-warning';
                        $status = __('Pending', 'sabai-paidlistings');
                        $form['items']['#options_disabled'][] = $order_item->id;
                    }
                    break;
                case Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_DELIVERED:
                    $class = 'sabai-label-success';
                    $status = __('Delivered', 'sabai-paidlistings');
                    $form['items']['#options_disabled'][] = $order_item->id;
                    break;
                case Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_CANCELLED:
                    $class = 'sabai-label-danger';
                    $status = __('Cancelled', 'sabai-paidlistings');
                    $form['items']['#options_disabled'][] = $order_item->id;
                    break;
            }
            $form['items']['#options'][$order_item->id] = array(
                'id' => Sabai::h($order_item->getLabel()),
                'name' => $ifeature->paidListingsFeatureGetInfo('label'),
                'description' => $ifeature->paidListingsFeatureGetOrderDescription($order_item, (array)$ifeature->paidListingsFeatureGetInfo('default_settings')),
                'status' => sprintf('<span class="sabai-label %s">%s</span>', $class, $status),
            );
        }
    }
    
    public function submitForm(Sabai_Addon_Form_Form $form, Sabai_Context $context)
    {
        if (!empty($form->values['orders'])) {
            switch ($form->values['action']) {
                case 'delete':
                    foreach ($form->values['orders'] as $order_id) {
                        if (isset($context->orders_deletable[$order_id]) && isset($context->orders[$order_id])) {
                            $context->orders[$order_id]->markRemoved();
                        }
                    }
                    $this->getModel(null, 'PaidListings')->commit();
                    break;
                case 'update_status':
                    if (empty($form->values['new_status'])) break;
                    $orders_updated = array();
                    foreach ($form->values['orders'] as $order_id) {
                        if (!isset($context->orders[$order_id])) continue;
                        
                        $order = $context->orders[$order_id];
                        if (!$order->canChangeStatus($form->values['new_status'])) continue;

                        $order->status = $form->values['new_status'];
                        $orders_updated[] = $order;
                    }
                    $this->getModel(null, 'PaidListings')->commit();
                    foreach ($orders_updated as $order) {
                        $order->reload();
                        $this->Action('paidlistings_order_status_change', array($order));
                    }
                    break;
            }
            $context->setSuccess();
        } elseif (!empty($form->values['items'])) {
            // Order items submitted for process
            $order = $context->order->with('Entity');
            $this->PaidListings_ApplyFeatures($order->Entity, array($order->with('OrderItems', array('OrderItemMetas'))));            
            $context->setSuccess($this->Url($context->getRoute(), array('order_id' => $order->id)));
        }
    }
    
    protected function _viewOrders(Sabai_Context $context)
    {
        // Init variables
        $criteria = $this->_getCriteria($context);
        $sortable_headers = array('date' => 'created');
        $sort = $context->getRequest()->asStr('sort', 'date', array_keys($sortable_headers));
        $order = $context->getRequest()->asStr('order', 'DESC', array('ASC', 'DESC'));
        $url_params = array('sort' => $sort, 'order' => $order);
        // Init entity ID
        if (($entity_id = $context->getRequest()->asInt('entity_id'))
            && ($entity = $this->Entity_Entity('content', $entity_id, false))
        ) {
            $url_params['entity_id'] = $entity_id;
            if ($criteria) {
                $criteria->entityId_is($entity_id);
            }
            $context->setInfo($entity->getTitle());
        }
        // Init form
        $form = array(
            'orders' => array(
                '#type' => 'tableselect',
                '#header' => array(
                    'id' => __('Order ID', 'sabai-paidlistings'),
                    'date' => __('Order Date', 'sabai-paidlistings'),
                    'plan' => __('Plan', 'sabai-paidlistings'),
                    'content' => $this->Entity_BundleLabel(current((array)$this->_getEntityBundleName($context)), true),
                    'user' => __('User', 'sabai-paidlistings'),
                    'items' => __('Items', 'sabai-paidlistings'),
                    'price' => __('Price', 'sabai-paidlistings'),
                    'status' => __('Status', 'sabai-paidlistings'),
                ),
                '#options' => array(),
                '#options_disabled' => array(),
                '#disabled' => true,
                '#multiple' => true,
            ),
        );
        $orders_deletable = $orders = $filters = array();
        $pager = null;
        if ($criteria) {
            // Get counts by status
            $counts = $this->getModel(null, 'PaidListings')->getGateway('Order')->getStatusCountByCriteria($criteria);
            $filters = array(0 => $this->LinkToRemote(sprintf(__('All (%d)', 'sabai-paidlistings'), array_sum($counts)), $context->getContainer(), $this->Url($context->getRoute(), $url_params), array(), array('class' => 'sabai-btn sabai-btn-default sabai-btn-xs')));
            $status_labels = $this->PaidListings_OrderStatusLabels();
            foreach ($status_labels as $status => $status_label) {
                if (empty($counts[$status])) continue;
                
                $filters[$status] = $this->LinkToRemote(sprintf(__('%s (%d)', 'sabai-paidlistings'), $status_label, $counts[$status]), $context->getContainer(), $this->Url($context->getRoute(), array('status' => $status) + $url_params), array(), array('class' => 'sabai-btn sabai-btn-default sabai-btn-xs'));            
            }
            $current_status = $context->getRequest()->asInt('status', 0, array_keys($filters));
            $filters[$current_status]->setAttribute('class', $filters[$current_status]->getAttribute('class') . ' sabai-active');
            if ($current_status) {
                $url_params['status'] = $current_status;
                if ($criteria) {
                    $criteria->status_is($current_status);
                }
                unset($form['orders']['#header']['status']);
            }
            if (count($filters) > 1) {    
                // Set sortable headers
                $this->_makeTableSortable($context, $form['orders'], array_keys($sortable_headers), array(), $sort, $order, $url_params);
            
                $plan_types = $this->PaidListings_PlanTypes(false);
                $commit = false;
                // Paginate orders
                $pager = $this->getModel('Order', 'PaidListings')
                    ->paginateByCriteria($criteria, 20, $sortable_headers[$sort], $order)
                    ->setCurrentPage($context->getRequest()->asInt(Sabai::$p, 1));
                foreach ($pager->getElements()->with('User')->with('Plan')->with('Entity')->with('OrderItems') as $order) {
                    $order_item_count = array(
                        Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_PENDING => 0,
                        Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_DELIVERED => 0,
                        Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_CANCELLED => 0,
                    );
                    foreach ($order->OrderItems as $order_item) {
                        $order_item_count[$order_item->status]++;
                    }
                    $order_item_labels = array();
                    if (!empty($order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_PENDING])) {
                        $order_item_labels[] = '<span class="sabai-label sabai-label-warning">' . sprintf(__('%d Pending', 'sabai-paidlistings'), $order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_PENDING]) . '</span>';
                    }
                    if (!empty($order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_DELIVERED])) {
                        $order_item_labels[] = '<span class="sabai-label sabai-label-success">' . sprintf(__('%d Delivered', 'sabai-paidlistings'), $order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_DELIVERED]) . '</span>';
                    }
                    if (!empty($order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_CANCELLED])) {
                        $order_item_labels[] = '<span class="sabai-label sabai-label-danger">' . sprintf(__('%d Cancelled', 'sabai-paidlistings'), $order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_CANCELLED]) . '</span>';
                    }
                    if ($order->Entity) {
                        $bundle = $this->Entity_Bundle($order->Entity);
                        $entity_link = $this->getPlatform()->isAdmin()
                            ? $this->LinkTo($order->Entity->getTitle(), $bundle->getAdminPath() . '/' . $order->Entity->getId())
                            : $this->Entity_Link($order->Entity);
                    } else {
                        $entity_link = '';
                    }
                    $single_order_link_method = $this->getPlatform()->isAdmin() ? 'LinkToModal' : 'LinkTo';
                    $form['orders']['#options'][$order->id] = array(
                        'plan' => sprintf(__('%s (%s)', 'sabai-paidlistings'), $order->Plan ? Sabai::h($order->Plan->name) : __('Unknown', 'sabai-paidlistings'), $plan_types[$order->Plan->type]),
                        'date' => $this->Date($order->created),
                        'id' => $this->$single_order_link_method('<strong class="sabai-row-title">' . Sabai::h($order->getLabel()) . '</strong>', $this->Url($context->getRoute(), array('order_id' => $order->id)), array('no_escape' => true, 'width' => 720), array('title' => sprintf(__('Order %s', 'sabai-paidlistings'), $order->getLabel()))),
                        'user' => $this->UserIdentityLink($order->User),
                        'items' => implode(PHP_EOL, $order_item_labels),
                        'price' => $order->getFormattedPrice(),
                        'status' => sprintf(
                            '<span class="sabai-label %s">%s</span>',
                            $order->getStatusLabelClass(),
                            $order->getStatusLabel()
                        ),
                        'content' => $entity_link,
                    );
                    // Update order status to completed if no pending order items. This could happen, for example status could not be updated because of database error.
                    if (empty($order_item_count[Sabai_Addon_PaidListings::ORDER_ITEM_STATUS_PENDING])
                        && !$order->isStatusFrozen()
                    ) {
                        $order->status = Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE;
                        $commit = true;
                    }
                    // Only allow deletion of orders without listings or status frozen (excluding completed)
                    if (!$order->Entity
                        || (!$order->isComplete() && $order->isStatusFrozen())
                    ) {
                        $orders_deletable[$order->id] = $order->id;
                    }
                    $orders[$order->id] = $order;
                }
        
                if ($commit) {
                    $this->getModel(null, 'PaidListings')->commit();
                }
            }
        }
        
        $context->addTemplate($this->getPlatform()->getAssetsDir('sabai-paidlistings') . '/templates/paidlistings_orders')
            ->setAttributes(array(
                'links' => array(),
                'filters' => $filters,
                'paginator' => $pager,
                'url_params' => $url_params,
                'orders' => $orders,
                'orders_deletable' => $orders_deletable,
            ));
        
        if ($this->_submitable = $this->getUser()->isAdministrator()) {
            // Do not allow manually changing the status to Complete
            unset($status_labels[Sabai_Addon_PaidListings::ORDER_STATUS_COMPLETE]);
            $this->_submitButtons = array(
                'action' => array(
                    '#type' => 'select',
                    '#options' => array(
                        '' => __('Bulk Actions', 'sabai-paidlistings'),
                        'delete' => __('Delete', 'sabai-paidlistings'),
                        'update_status' => __('Update Status', 'sabai-paidlistings'),
                    ),
                    '#weight' => 1,
                ),
                'new_status' => array(
                    '#type' => 'select',
                    '#default_value' => null,
                    '#multiple' => false,
                    '#options' => $status_labels,
                    '#weight' => 2,
                    '#states' => array(
                        'visible' => array('select[name="action"]' => array('value' => 'update_status')),
                    ),
                ),
                'apply' => array(
                    '#value' => __('Apply', 'sabai-paidlistings'),
                    '#btn_size' => 'small',
                    '#weight' => 10,
                ),
            );
            $form['orders']['#disabled'] = false;
        }
        
        if ($pager) $form[Sabai::$p] = array('#type' => 'hidden', '#value' => $pager->getCurrentPage());
        
        return $form;
    }
    
    protected function _getOrderDisplayId(Sabai_Addon_PaidListings_Model_Order $order, Sabai_Addon_PaidListings_Model_OrderItem $orderItem = null)
    {
        $order_id = '#' . str_pad($order->id, 5, 0, STR_PAD_LEFT);
        if (!isset($orderItem)) {
            return $order_id;
        }
        return !isset($orderItem) ? $order_id : $order_id . '-' . str_pad($orderItem->id, 5, 0, STR_PAD_LEFT);
    }
    
    protected function _getCriteria(Sabai_Context $context)
    {
        if (!$plan_ids = $this->getModel('Plan', 'PaidListings')->entityBundleName_in((array)$this->_getEntityBundleName($context))->fetch()->getArray('id')) {
            return;
        }        
        return $this->getModel(null, 'PaidListings')->createCriteria('Order')->planId_in($plan_ids);
    }
    
    protected function _isValidOrder(Sabai_Context $context, Sabai_Addon_PaidListings_Model_Order $order)
    {
        return true;
    }
    
    abstract protected function _getEntityBundleName(Sabai_Context $context);
}
