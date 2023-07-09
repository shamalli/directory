<?php
class Sabai_Addon_PaidListings_CreditCardFormField extends Sabai_Addon_Form_Field_Group
{    
    public function formFieldGetFormElement($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        $_data = array(
            '#tree' => true,
            '#children' => array(),
            '#element_validate' => array(array($this, 'validate')),
        );
        if (!empty($data['#separate_names'])) {
            $_data['#children'][0] = array(
                'first_name' => array(
                    '#description' => __('First Name', 'sabai-paidlistings'),
                    '#type' => 'textfield',
                    '#prefix' => '<div class="sabai-row"><div class="sabai-col-sm-6">',
                    '#suffix' => '</div>',
                    '#default_value' => @$data['#default_value']['first_name'],
                ) + $form->defaultElementSettings(),
                'last_name' => array(
                    '#description' => __('Last Name', 'sabai-paidlistings'),
                    '#type' => 'textfield',
                    '#prefix' => '<div class="sabai-col-sm-6">',
                    '#suffix' => '</div></div>',
                    '#default_value' => @$data['#default_value']['last_name'],
                ) + $form->defaultElementSettings(),
            );
        } else {
            $_data['#children'][0] = array(
                'name' => array(
                    '#description' => __('Name on Card', 'sabai-paidlistings'),
                    '#type' => 'textfield',
                    '#default_value' => @$data['#default_value']['name'],
                ) + $form->defaultElementSettings(),
            );
        }
        $_data['#children'][0] += array(  
            'number' => array(
                '#type' => 'textfield',
                '#description' => __('Credit Card Number', 'sabai-paidlistings'),
                '#min_length' => 13,
                '#max_length' => 16,
                '#numeric' => true,
                '#default_value' => @$data['#default_value']['number'],
            ) + $form->defaultElementSettings(),
            'date' => array(
                '#type' => 'textfield',
                '#description' => __('Expiration Date', 'sabai-paidlistings'),
                '#prefix' => '<div class="sabai-row"><div class="sabai-col-xs-6">',
                '#suffix' => '</div>',
                '#mask' => '99/99',
                '#attributes' => array('placeholder' => 'MM/YY'),
                '#max_length' => 5,
                '#min_length' => 5,
                '#default_value' => @$data['#default_value']['date'],
            ) + $form->defaultElementSettings(),
            'cvv' => array(
                '#type' => 'textfield',
                '#description' => __('Security Code', 'sabai-paidlistings'),
                '#max_length' => 4,
                '#min_length' => 3,
                '#numeric' => true,
                '#prefix' => '<div class="sabai-col-xs-6">',
                '#suffix' => '</div></div>',
                '#default_value' => @$data['#default_value']['cvv'],
            ) + $form->defaultElementSettings(),
        );
        $data = $_data + $data + $form->defaultElementSettings();
        return $form->createFieldset($name, $data);
    }
    
    public function validate(Sabai_Addon_Form_Form $form, &$value, $element)
    {
        if (isset($value['date']) && strlen($value['date'])) {
            if (strpos($value['date'], '/')
                && strlen($value['date']) === 5
                && ($date = explode('/', $value['date']))
                && (1 <= $date[0] && 12 >= $date[0])
            ) {
                $value['date'] = array('month' => $date[0], 'year' => '20' . $date[1]);
            } else {
                $form->setError(__('Invalid credit card expiration date.', 'sabai-paidlistings'), $element['#name'] . '[date]');
            }
        } else {
            $value['date'] = array('month' => '', 'year' => '');
        }
    }
}