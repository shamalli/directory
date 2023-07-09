<?php
class Sabai_Addon_PaidListings_FieldWidget extends Sabai_Addon_Field_Widget_AbstractWidget
{
    protected function _fieldWidgetGetInfo()
    {
        return array(
            'label' => __('Plan', 'sabai-paidlistings'),
            'field_types' => array('paidlistings_plan'),
            'admin_only' => true,
        );
    }

    public function fieldWidgetGetForm(Sabai_Addon_Field_IField $field, array $settings, Sabai_Addon_Entity_Model_Bundle $bundle, $value = null, Sabai_Addon_Entity_IEntity $entity = null, array $parents = array(), $admin = false)
    {
        $plans = $this->_addon->getApplication()->PaidListings_ActivePlans($field->Bundle->name, array('base'));
        $form = array(
            'plan_id' => array(
                '#type' => 'select',
                '#options' => array(0 => __('No plan', 'sabai-paidlistings')) + $plans,
                '#default_value' => isset($value) ? $value['plan_id'] : null,
            ),
        );
        $i = 0;
        foreach ($this->_addon->getApplication()->PaidListings_FeaturesByBundle(array($field->Bundle->type, ''), 'addon') as $feature_name) {
            if (!$ifeature = $this->_addon->getApplication()->PaidListings_FeatureImpl($feature_name)) {
                continue;
            }
            $feature_info = $ifeature->paidListingsFeatureGetInfo();
            
            if (empty($feature_info['is_default_addon'])) {
                // Check which plans do not have the feature enabled
                $feature_plans = $plans;
                foreach ($feature_plans as $plan_id => $plan) {
                    if (!empty($plan->features[$feature_name]['enable'])) {
                        unset($feature_plans[$plan_id]);
                    }
                }
                if (empty($feature_plans)) continue;
            }
            
            $feature_form = $ifeature->paidListingsFeatureGetAddonSettingsForm(
                $field->Bundle->name,
                $plans,
                isset($value['addon_features'][$feature_name]) ? (array)$value['addon_features'][$feature_name] : array(),
                array_merge($parents, array('addon_features', $feature_name))
            );
            if ($feature_form) {
                $form['addon_features'][$feature_name] = $feature_form + array(
                    '#title' => $feature_info['label'],
                    '#weight' => empty($feature_info['is_default_addon']) ? ++$i : 0,
                    '#collapsible' => false,
                );
                if (empty($feature_info['is_default_addon'])) {
                    $form['addon_features'][$feature_name]['#states'] = array(
                        'visible' => array(
                            sprintf('select[name="%s[plan_id]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array('value' => array_keys($feature_plans)),
                        )
                    );
                } else {
                    $form['addon_features'][$feature_name]['#states'] = array(
                        'invisible' => array(
                            sprintf('select[name="%s[plan_id]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array('value' => 0),
                        )
                    );
                }
            }
        }
        
        return $form;
    }
}