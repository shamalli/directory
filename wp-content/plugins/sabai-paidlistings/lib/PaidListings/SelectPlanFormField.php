<?php
class Sabai_Addon_PaidListings_SelectPlanFormField extends Sabai_Addon_Form_Field_Radios
{    
    public function formFieldGetFormElement($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        foreach ($data['#plans'] as $plan) {
            $data['#options'][$plan->id] = $plan->name;
            $data['#options_description'][$plan->id] = $plan->description;
        }
        if (empty($data['#options'])) {
            $data['#required'] = false;
            return;
        }
        $data += array(
            '#default_value_auto' => true,
            '#title' => __('Select Plan', 'sabai-paidlistings'),
            '#class' => 'sabai-paidlistings-plans',
        );
        return parent::formFieldGetFormElement($name, $data, $form);
    }
}