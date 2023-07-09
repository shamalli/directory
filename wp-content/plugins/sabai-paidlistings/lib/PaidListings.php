<?php
require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/IFeatures.php';

class Sabai_Addon_PaidListings extends Sabai_Addon
    implements Sabai_Addon_Form_IFields,
               Sabai_Addon_Field_ITypes,
               Sabai_Addon_Field_IWidgets,
               Sabai_Addon_System_IAdminRouter,
               Sabai_Addon_System_IAdminSettings
{
    const VERSION = '1.3.29', PACKAGE = 'sabai-paidlistings';
    const ORDER_STATUS_CREATED = 10, ORDER_STATUS_PENDING = 1, ORDER_STATUS_PROCESSING = 2, ORDER_STATUS_PAID = 3, ORDER_STATUS_COMPLETE = 4,
        ORDER_STATUS_REFUNDED = 5, ORDER_STATUS_EXPIRED = 6, ORDER_STATUS_FAILED = 7, ORDER_STATUS_CANCELLED = 8, ORDER_STATUS_SUSPENDED = 9,
        ORDER_ITEM_STATUS_PENDING = 1, ORDER_ITEM_STATUS_DELIVERED = 2, ORDER_ITEM_STATUS_CANCELLED = 3;

    public function systemGetAdminRoutes()
    {
        $routes = array();
        if ($bundle_types = $this->_application->PaidListings_EntityBundleTypes()) {
            foreach ($this->_application->getModel('Bundle', 'Entity')->type_in($bundle_types)->fetch() as $bundle) {
                if (!$this->_application->isAddonLoaded($bundle->addon)) continue;
                
                $routes += array(
                    $bundle->getAdminPath() . '/plans' => array(
                        'controller' => 'Plans',
                        'title_callback' => true,
                        'callback_path' => 'plans',
                        'type' => Sabai::ROUTE_TAB,
                        'weight' => 25,
                    ),
                    $bundle->getAdminPath() . '/plans/add' => array(
                        'controller' => 'AddPlan',
                        'title_callback' => true,
                        'callback_path' => 'add_plan',
                    ),
                    $bundle->getAdminPath() . '/plans/:plan_id' => array(
                        'controller' => 'EditPlan',
                        'title_callback' => true,
                        'access_callback' => true,
                        'format' => array(':plan_id' => '\d+'),
                        'callback_path' => 'edit_plan',
                    ),
                    $bundle->getAdminPath() . '/plans/:plan_id/delete' => array(
                        'controller' => 'DeletePlan',
                        'title_callback' => true,
                        'callback_path' => 'delete_plan',
                    ),
                    $bundle->getAdminPath() . '/orders' => array(
                        'controller' => 'Orders',
                        'title_callback' => true,
                        'callback_path' => 'orders',
                        'type' => Sabai::ROUTE_TAB,
                        'weight' => 26,
                    ),
                );
            }
        }

        return $routes;
    }

    public function systemOnAccessAdminRoute(Sabai_Context $context, $path, $accessType, array &$route)
    {
        switch ($path) {
            case 'edit_plan':
                if ((!$plan_id = $context->getRequest()->asInt('plan_id'))
                    || (!$plan = $this->getModel('Plan')->fetchById($plan_id))
                ) return false;
                $context->plan = $plan;
                return true;
        }
    }

    public function systemGetAdminRouteTitle(Sabai_Context $context, $path, $title, $titleType, array $route)
    {
        switch ($path) {
            case 'orders':
                return __('Orders', 'sabai-paidlistings');
            case 'plans':
                return __('Plans', 'sabai-paidlistings');
            case 'add_plan':
                return __('Add Plan', 'sabai-paidlistings');
            case 'edit_plan':
                return __('Edit Plan', 'sabai-paidlistings');
            case 'delete_plan':
                return __('Delete Plan', 'sabai-paidlistings');
        }
    }
    
    public function onEntityCreateBundlesSuccess($entityType, $bundles)
    {
        $reload_routes = false;
        $bundle_types = $this->_application->PaidListings_EntityBundleTypes();
        foreach ($bundles as $bundle) {
            if (!in_array($bundle->type, $bundle_types)) continue;
            
            $this->_createEntityField($bundle);
            $reload_routes = true;
        }
        if ($reload_routes) {
            $this->_application->getAddon('System')->reloadRoutes($this, true);
        }
    }
    
    public function onEntityUpdateBundlesSuccess($entityType, $bundles)
    {
        $this->onEntityCreateBundlesSuccess($entityType, $bundles);
    }
            
    public function onEntityDeleteBundlesSuccess($entityType, $bundles)
    {        
        $this->getModel('Plan')->entityBundleName_in(array_keys($bundles))->delete();
        $this->onEntityUpdateBundlesSuccess($entityType, $bundles);
    }
    
    public function onPaidListingsIEntityBundleTypesInstalled(Sabai_Addon $addon, ArrayObject $log)
    {
        if ($addon->hasParent()) return;
        
        // Add fields to bundles
        if ($bundle_types = $addon->paidListingsGetEntityBundleTypes()) {
            foreach ($this->_application->getModel('Bundle', 'Entity')->type_in($bundle_types)->fetch() as $bundle) {
                if (!$this->_application->isAddonLoaded($bundle->addon)) continue;
                
                $this->_createEntityField($bundle);
            }
        }
        
        $this->_application->getAddon('System')->reloadRoutes($this, true);
        $this->_application->getPlatform()->deleteCache('paidlistings_entity_bundle_types');
    }

    public function onPaidListingsIEntityBundleTypesUninstalled(Sabai_Addon $addon, ArrayObject $log)
    {
        if ($addon->hasParent()) return;
        
        // Delete plans for directory listings
        if ($bundle_types = $addon->paidListingsGetEntityBundleTypes()) {
            $bundle_names = array();
            foreach ($this->_application->getModel('Bundle', 'Entity')->type_in($bundle_types)->fetch() as $bundle) {
                if (!$this->_application->isAddonLoaded($bundle->addon)) continue;
                
                $bundle_names[] = $bundle->name;
            }
            if (!empty($bundle_names)) {
                $this->getModel('Plan')->entityBundleName_in($bundle_names)->delete();
            }
        }
        
        $this->_application->getAddon('System')->reloadRoutes($this, true);
        $this->_application->getPlatform()->deleteCache('paidlistings_entity_bundle_types');
    }

    public function onPaidListingsIEntityBundleTypesUpgraded(Sabai_Addon $addon, ArrayObject $log)
    {
        if ($addon->hasParent()) return;
        
        $this->_application->getAddon('System')->reloadRoutes($this, true);
        $this->_application->getPlatform()->deleteCache('paidlistings_entity_bundle_types');
    }
    
    protected function _createEntityField($bundle)
    {
        $this->_application->getAddon('Entity')->createEntityField(
            $bundle,
            'paidlistings_plan',
            array(
                'type' => 'paidlistings_plan',
                'label' => __('Plan', 'sabai-paidlistings'),
                'settings' => array(),
                'weight' => 99,
                'max_num_items' => 1, // Only 1 entry per entity should be created
            ),
            Sabai_Addon_Entity::FIELD_REALM_ALL
        );
    }
    
    public function onPaidListingsIFeaturesInstalled(Sabai_Addon $addon, ArrayObject $log)
    {
        if ($addon->hasParent()) return;
        
        $this->_application->getPlatform()->deleteCache('paidlistings_features')->deleteCache('paidlistings_features_by_bundle');
    }

    public function onPaidListingsIFeaturesUninstalled(Sabai_Addon $addon, ArrayObject $log)
    {
        if ($addon->hasParent()) return;
        
        $this->_application->getPlatform()->deleteCache('paidlistings_features')->deleteCache('paidlistings_features_by_bundle');
    }

    public function onPaidListingsIFeaturesUpgraded(Sabai_Addon $addon, ArrayObject $log)
    {
        if ($addon->hasParent()) return;
        
        $this->_application->getPlatform()->deleteCache('paidlistings_features')->deleteCache('paidlistings_features_by_bundle');
    }

    public function onPaidListingsOrderReceived($order)
    {        
        $this->_application->PaidListings_SendOrderNotification(array('received', 'received_admin'), $order);
    }
    
    public function onPaidListingsOrderStatusChange($order, $isManual = false)
    {
        switch ($order->status) {
            case self::ORDER_STATUS_COMPLETE:
                $this->_application->PaidListings_SendOrderNotification('complete', $order); 
                break;
            case self::ORDER_STATUS_PAID:
                $this->_application->PaidListings_SendOrderNotification('awaiting_fullfillment_admin', $order); 
                // Apply features that have not yet been applied
                $order->with('Entity')->with('OrderItems', array('OrderItemMetas'));
                $this->_application->PaidListings_ApplyFeatures($order->Entity, array($order)); 
                return;
            case self::ORDER_STATUS_REFUNDED:
            case self::ORDER_STATUS_EXPIRED:
            case self::ORDER_STATUS_FAILED:
            case self::ORDER_STATUS_SUSPENDED:
            case self::ORDER_STATUS_CANCELLED:
                $order->with('Entity');
                $this->_application->Entity_LoadFields($order->Entity);
                // Unapply order item features that have already been applied otherwise cancel
                foreach ($order->OrderItems as $order_item) {
                    if ($order_item->isCancelled()
                        || (!$ifeature = $this->_application->PaidListings_FeatureImpl($order_item->feature_name))
                    ) {
                        continue;
                    }
                    // Create log
                    if ($order_item->isDelivered()) {
                        if ($ifeature->paidListingsFeatureUnapply($order->Entity, $order_item)) {
                            $order_item->status = self::ORDER_ITEM_STATUS_CANCELLED;
                            $order_log = $order->createOrderLog(__('Item delivery cancelled.', 'sabai-paidlistings'));
                        } else {
                            $order_log = $order->createOrderLog(__('Item delivery cancel failed.', 'sabai-paidlistings'), 0, true);
                        }
                    } else {
                        $order_item->status = self::ORDER_ITEM_STATUS_CANCELLED;
                        $order_log = $order->createOrderLog(__('Item cancelled.', 'sabai-paidlistings'));
                    }
                    $order_log->markNew();
                    $order_log->OrderItem = $order_item;
                }
                $this->getModel()->commit();
                return;
        }
    }
    
    public function onPaidListingsOrderItemsStatusChange($orderItems)
    {
        $order_ids = array();
        foreach ($orderItems as $order_item) {
            $order_ids[] = $order_item->order_id;
        }
        if (empty($order_ids)) return;

        // Create log for orders that have all features applied
        $orders_completed = array();
        foreach ($this->getModel('Order')->fetchByIds($order_ids)->with('OrderItems') as $order) {
            if ($order->isComplete()) {
                continue; // No more logs to create for order with complete status
            }
            foreach ($order->OrderItems as $order_item) {
                if (!$order_item->isComplete()) {
                    continue 2;
                }
            }
            $order->status = self::ORDER_STATUS_COMPLETE;
            // Create log
            $order->createOrderLog(__('Order complete.', 'sabai-paidlistings'), $order->status)->markNew();
                
            $orders_completed[] = $order->id;
        }
        
        $this->getModel()->commit();
        
        // Reload orders and notify
        if (!empty($orders_completed)) {
            foreach ($this->getModel('Order')->fetchByIds($orders_completed)->with('OrderItems') as $order) {
                $this->_application->Action('paidlistings_order_status_change', array($order));
            }
        }
    }

    public function formGetFieldTypes()
    {
        return array('paidlistings_cc', 'paidlistings_select_plan', 'paidlistings_tac');
    }

    public function formGetField($type)
    {
        switch ($type) {
            case 'paidlistings_cc':
                require_once dirname(__FILE__) . '/PaidListings/CreditCardFormField.php';
                return new Sabai_Addon_PaidListings_CreditCardFormField($this, $type);
            case 'paidlistings_select_plan':
                require_once dirname(__FILE__) . '/PaidListings/SelectPlanFormField.php';
                return new Sabai_Addon_PaidListings_SelectPlanFormField($this, $type);
            case 'paidlistings_tac':
                require_once dirname(__FILE__) . '/PaidListings/TermsAndConditionsFormField.php';
                return new Sabai_Addon_PaidListings_TermsAndConditionsFormField($this, $type);
        }
    }
    
    public function fieldGetTypeNames()
    {
        return array('paidlistings_plan');
    }

    public function fieldGetType($name)
    {
        require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/FieldType.php';
        return new Sabai_Addon_PaidListings_FieldType($this, $name);
    }

    public function fieldGetWidgetNames()
    {
        return array('paidlistings_plan');
    }

    public function fieldGetWidget($name)
    {
        require_once SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib/PaidListings/FieldWidget.php';
        return new Sabai_Addon_PaidListings_FieldWidget($this, $name);
    }
    
    public function onSystemEmailSettingsFilter(&$settings, $addonName)
    {
        if ($this->_application->getAddon($addonName)->getType() !== 'Directory') return;
        
        $settings += array(
            'order_received' => array(
                'type' => 'user',
                'title' => __('Order Received Notification Email', 'sabai-paidlistings'),
                'description' => __('If enabled, a notification email is sent to the user when a user places an order.', 'sabai-paidlistings'),
                'tags' => $this->_getTemplateTags(),
                'enable' => true,
                'email' => array(
                    'subject' => __('[{site_name}] We have received your order (Order ID: {order_id})', 'sabai-paidlistings'),
                    'body' => __('Hi {recipient_name},
                
We have received an order from you on {order_date}.

Please review your order below:

------------------------------------
{order_plan} - {order_price} {order_currency}
------------------------------------

Regards,
{site_name}
{site_url}', 'sabai-paidlistings'),
                ),
            ),
            'order_complete' => array(
                'type' => 'user',
                'title' => __('Order Complete Notification Email', 'sabai-paidlistings'),
                'description' => __('If enabled, a notification email is sent to the user when an order is complete.', 'sabai-paidlistings'),
                'tags' => $this->_getTemplateTags(),
                'enable' => true,
                'email' => array(
                    'subject' => __('[{site_name}] Your order (ID: {order_id}) is complete', 'sabai-paidlistings'),
                    'body' => __('Hi {recipient_name},
                
We have processed your order placed on {order_date} and its now complete.

------------------------------------
{order_plan} - {order_price} {order_currency}
------------------------------------

Regards,
{site_name}
{site_url}', 'sabai-paidlistings'),
                ),
            ),  
            'order_received_admin' => array(
                'type' => 'admin',
                'title' => __('Order Received Admin Notification Email', 'sabai-paidlistings'),
                'description' => __('If enabled, a notification email is sent to administrators when a user place an order and payment received.', 'sabai-paidlistings'),
                'tags' => $this->_getTemplateTags(),
                'enable' => true,
                'email' => array(
                    'subject' => __('[{site_name}] A new order (Order ID: {order_id}) has been placed', 'sabai-paidlistings'),
                    'body' => __('Hi {recipient_name},
                
A new order from {order_user_name} ({order_user_email}) has been placed on {order_date}.

------------------------------------
{order_plan} - {order_price} {order_currency}
------------------------------------

You can view the details of the order at {order_admin_url}.

Regards,
{site_name}
{site_url}', 'sabai-paidlistings'),
                ),
            ),
            'order_awaiting_fullfillment_admin' => array(
                'type' => 'admin',
                'title' => __('Order Awaiting Fullfillment Admin Notification Email', 'sabai-paidlistings'),
                'description' => __('If enabled, a notification email is sent to administrators when ordered items for an order are ready for delivery.', 'sabai-paidlistings'),
                'tags' => $this->_getTemplateTags(),
                'enable' => true,
                'email' => array(
                    'subject' => __('[{site_name}] There is an order (Order ID: {order_id}) awaiting fullfillment', 'sabai-paidlistings'),
                    'body' => __('Hi {recipient_name},

The following order placed on {order_date} is awaiting fullfillment.

------------------------------------
{order_plan} - {order_price} {order_currency}
------------------------------------

You can view the details of the order at {order_admin_url}.

Regards,
{site_name}
{site_url}', 'sabai-paidlistings'),
                ),
            ),
        );
    }
    
    private function _getTemplateTags()
    {
        return array_merge($this->_getOrderTemplateTags(), $this->_getListingTemplateTags());
    }
        
    private function _getOrderTemplateTags()
    {
        return array('{order_id}', '{order_plan}', '{order_price}', '{order_currency}', '{order_user_name}', '{order_user_email}', '{order_admin_url}', '{order_date}', '{order_status}');
    }
    
    private function _getListingTemplateTags()
    {
        return array('{listing_id}', '{listing_title}', '{listing_summary}', '{listing_author_name}', '{listing_author_email}', '{listing_url}', '{listing_date}');
    }
    
    public function onFormBuildContentAdminListposts(&$form, &$storage)
    {
        $bundle_types = $this->_application->PaidListings_EntityBundleTypes();
        if (!in_array($form['#bundle']->type, $bundle_types)
            || (!$base_plans = $this->_application->PaidListings_ActivePlans($form['#bundle']->name, array('base')))
        ) {
            return;
        }
        $form['#filters']['paidlistings_plan'] = array(
            'order' => 10,
            'default_option_label' => sprintf(__('All plans', 'sabai-paidlistings')),
            'options' => array(0 => __('No plan', 'sabai-paidlistings')) + $base_plans,
        );
        $form[Sabai_Addon_Form::FORM_SUBMIT_BUTTON_NAME]['action']['#options']['paidlistings_set_plan'] = __('Set Plan', 'sabai-paidlistings');
        $form[Sabai_Addon_Form::FORM_SUBMIT_BUTTON_NAME]['paidlistings_set_plan'] = array(
            '#type' => 'select',
            '#default_value' => null,
            '#multiple' => false,
            '#options' => $base_plans,
            '#weight' => 2,
            '#states' => array(
                'visible' => array('select[name="action"]' => array('value' => 'paidlistings_set_plan')),
            ),
            '#tree' => false,
        );
        $form['#submit'][0][] = array($this, 'updateEntities');  
    }
    
    public function onContentAdminPostsUrlParamsFilter(&$urlParams, $context, $bundle)
    {
        $bundle_types = $this->_application->PaidListings_EntityBundleTypes();
        if (in_array($bundle->type, $bundle_types)
            && ('' !== $plan_id = $context->getRequest()->asStr('paidlistings_plan', ''))
        ) {
            $urlParams['paidlistings_plan'] = $plan_id;
        }
    }
    
    public function onContentAdminPostsQuery($context, $bundle, $query, $countQuery, $sort, $order)
    {
        $bundle_types = $this->_application->PaidListings_EntityBundleTypes();
        if (in_array($bundle->type, $bundle_types)
            && ('' !== $plan_id = $context->getRequest()->asStr('paidlistings_plan', ''))
        ) {
            if (empty($plan_id)) {
                $query->fieldIsNull('paidlistings_plan', 'plan_id');
                $countQuery->fieldIsNull('paidlistings_plan', 'plan_id');
            } else {
                $query->fieldIs('paidlistings_plan', $plan_id, 'plan_id');
                $countQuery->fieldIs('paidlistings_plan', $plan_id, 'plan_id');
            }
        }
    }
    
    public function updateEntities(Sabai_Addon_Form_Form $form)
    {
        if (!empty($form->values['entities'])
            && $form->values['action'] === 'paidlistings_set_plan'
            && ($plan_id = $form->values['paidlistings_set_plan'])
        ) {
            foreach ($this->_application->Entity_Entities('content', $form->values['entities']) as $entity) {
                if ($entity->getSingleFieldValue('paidlistings_plan', 'plan_id') != $plan_id) {
                    $this->_application->Entity_Save($entity, array('paidlistings_plan' => array('plan_id' => $plan_id)));
                }
            }
        }
    }
    
    public function onSabaiWebResponseRenderHtmlLayout(Sabai_Context $context, &$content)
    {        
        // The main stylesheet should already have been included by the platform if not requesting the full page content
        if ($context->getContainer() !== '#sabai-content') return;

        if (!$this->_application->getPlatform()->isAdmin()) {
            $this->_application->LoadCss('main.min.css', 'sabai-paidlistings', 'sabai', 'sabai-paidlistings');
            if ($this->_application->getPlatform()->isLanguageRTL()) {
                $this->_application->LoadCss('main-rtl.min.css', 'sabai-paidlistings-rtl', 'sabai-paidlistings', 'sabai-paidlistings');
            }
        }
    }
    
    public function systemGetAdminSettingsForm()
    {
        return array(
            'tac' => array(
                '#title' => __('Payment Terms and Conditions', 'sabai-paidlistings'),
                '#type' => 'radios',
                '#options' => array(
                    'none' => __('No terms and conditions', 'sabai-paidlistings'),
                    'link' => __('Show terms and conditions link', 'sabai-paidlistings'),
                    'inline' => __('Show terms and conditions inline', 'sabai-paidlistings'),
                ),
                '#default_value' => isset($this->_config['tac']) ? $this->_config['tac'] : 'none',
            ),
            'tac_link' => array(
                '#type' => 'textfield',
                '#size' => 20,
                '#field_prefix' => rtrim($this->_application->getScriptUrl('main'), '/') . '/',
                '#states' => array(
                    'visible' => array(
                        'input[name="tac"]' => array('value' => 'link'),
                    ), 
                ),
                '#default_value' => isset($this->_config['tac_link']) ? $this->_config['tac_link'] : null,
            ),
            'tac_text' => array(
                '#type' => 'textarea',
                '#rows' => 10,
                '#default_value' => $this->_application->getPlatform()->getOption($this->_name . '_tac', $this->_application->getPlatform()->getOption('directory_claim_tac')),
                '#states' => array(
                    'visible' => array(
                        'input[name="tac"]' => array('value' => 'inline'),
                    ), 
                ),
            ),
            'tac_required' => array(
                '#type' => 'yesno',
                '#title' => __('Users must agree to terms and conditions', 'sabai-paidlistings'),
                '#states' => array(
                    'invisible' => array(
                        'input[name="tac"]' => array('value' => 'none'),
                    ), 
                ),
                '#default_value' => isset($this->_config['tac_required']) ? (bool)$this->_config['tac_required'] : true,
            ),
        );
    }
    
    public function systemSaveAdminSettings($config)
    {
        // Save tac to platform instead of the add-ons table
        $this->_application->getPlatform()->setOption($this->_name . '_tac', $config['tac_text']);
        unset($config['tac_text']);
        $this->saveConfig($config);
    }
}