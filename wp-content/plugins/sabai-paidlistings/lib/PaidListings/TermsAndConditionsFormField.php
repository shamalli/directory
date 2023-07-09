<?php
class Sabai_Addon_PaidListings_TermsAndConditionsFormField extends Sabai_Addon_Form_Field_AbstractField
{    
    public function formFieldGetFormElement($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        $config = $this->_addon->getConfig();
        if (empty($config['tac']) || $config['tac'] === 'none') return;
        
        $children = array(
            'agree_tac' => array(
                '#type' => 'checkbox',
                '#required' => !empty($config['tac_required']),
            ) + $form->defaultElementSettings(),
        );
        if ($config['tac'] === 'inline') {
            $children['agree_tac']['#title'] = strip_tags(__('I agree to the <a href="%s" target="_blank">terms and conditions</a>', 'sabai-paidlistings'));
            $children['tac_inline'] = array(
                '#title' => __('Terms and Conditions', 'sabai-paidlistings'),
                '#type' => 'item',
                '#markup' => '<textarea readonly="readonly" style="width:100%;">'. nl2br(Sabai::h($this->_addon->getApplication()->getPlatform()->getOption($this->_addon->getName() . '_tac'))) . '</textarea>',
            ) + $form->defaultElementSettings();
            $data['#children'] = array(0 => array($children['tac_inline'], $children['agree_tac']));
        } else {
            $children['agree_tac']['#title'] = sprintf(__('I agree to the <a href="%s" target="_blank">terms and conditions</a>', 'sabai-paidlistings'), rtrim($this->_addon->getApplication()->getScriptUrl('main'), '/') . '/' . $config['tac_link']);
            $children['agree_tac']['#title_no_escape'] = true;
            $data['#children'] = array(0 => array($children['agree_tac']));
        }
        $data['#tree'] = true;
        $data['#class'] = 'sabai-form-group';
        $data += $form->defaultElementSettings();
        return $form->createFieldset($name, $data);
    }
    
    public function formFieldOnSubmitForm($name, &$value, array &$data, Sabai_Addon_Form_Form $form)
    {
        if (!isset($data['#children'][0])) return;
        
        foreach (array_keys($data['#children'][0]) as $ele_key) {
            $ele_name = sprintf('%s[%s]', $name, $ele_key);
            $ele_data =& $data['#children'][0][$ele_key];
            if (is_null($value) || !array_key_exists($ele_key, $value)) {
                $value[$ele_key] = null;
            }

            // Send form submit notification to the element
            try {
                $this->_addon->getApplication()->Form_FieldImpl($ele_data['#type'])->formFieldOnSubmitForm($ele_name, $value[$ele_key], $ele_data, $form);
            } catch (Sabai_IException $e) {
                // Catch any application level exception that might occur and display it as a form element error.
                $form->setError($e->getMessage(), $ele_name);
            }

            if ($form->hasError($ele_name)) continue;

            // Copy the value to be used in subsequent validation steps
            $ele_value =& $value[$ele_key];

            // Process custom validations if any
            foreach ($ele_data['#element_validate'] as $callback) {
                try {
                    $this->_addon->getApplication()->CallUserFuncArray($callback, array($form, &$ele_value, $ele_data));
                } catch (Sabai_IException $e) {
                    $form->setError($e->getMessage(), $ele_data);
                }
            }
        }
    }

    public function formFieldOnCleanupForm($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        if (!isset($data['#children'][0])) return;
        
        foreach (array_keys($data['#children'][0]) as $ele_key) {
            $ele_name = sprintf('%s[%s]', $name, $ele_key);
            $ele_data =& $data['#children'][0][$ele_key];
            try {
                $this->_addon->getApplication()->Form_FieldImpl($ele_data['#type'])->formFieldOnCleanupForm($ele_name, $ele_data, $form);
            } catch (Exception $e) {
                $this->_addon->getApplication()->LogError($e);
            }
        }
    }

    public function formFieldOnRenderForm($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        if (!isset($data['#children'][0])) return;
        
        $form->renderElement($data);
        $form->renderChildElements($name, $data);
    }
}