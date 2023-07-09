<?php
class Sabai_Addon_PaidListings_FieldType extends Sabai_Addon_Field_Type_AbstractType
{
    protected $_valueColumn = 'plan_id';
    
    protected function _fieldTypeGetInfo()
    {
        switch ($this->_name) {
            case 'paidlistings_plan':
                return array(
                    'label' => __('Plan', 'sabai-paidlistings'),
                    'default_settings' => array(),
                    'creatable' => false,
                    'editable' => false,
                );
        }
    }

    public function fieldTypeGetSchema(array $settings)
    {
        switch ($this->_name) {
            case 'paidlistings_plan':
                return array(
                    'columns' => array(
                        'plan_id' => array(
                            'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                            'notnull' => true,
                            'was' => 'plan_id',
                            'default' => 0,
                        ),
                        'addon_features' => array(
                            'type' => Sabai_Addon_Field::COLUMN_TYPE_TEXT,
                            'notnull' => true,
                            'was' => 'addon_features',
                        ),
                        'recurring_payment_id' => array(
                            'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                            'notnull' => true,
                            'was' => 'recurring_payment_id',
                            'length' => 100,
                        ),
                    ),
                    'indexes' => array(
                        'plan_id' => array(
                            'fields' => array('plan_id' => array('sorting' => 'ascending')),
                            'was' => 'plan_id',
                        ),
                    ),
                );       
        }
    }
    
    public function fieldTypeOnSave(Sabai_Addon_Field_IField $field, array $values, array $currentValues = null)
    {
        $ret = array();
        foreach ($values as $weight => $value) {
            if (!is_array($value)) continue;
            
            if (!isset($value['plan_id'])) {
                if (empty($currentValues[0]['plan_id'])) continue;
                
                $value['plan_id'] = $currentValues[0]['plan_id'];
            } else {
                if (empty($value['plan_id'])) {
                    $values[$weight] = false;
                    continue;
                }
            }

            $ret[] = array(
                'plan_id' => $value['plan_id'],
                'addon_features' => serialize((array)@$value['addon_features']),
                'recurring_payment_id' => isset($value['recurring_payment_id']) ? (string)$value['recurring_payment_id'] : '',
            );
            break;
        }

        return $ret;
    }

    public function fieldTypeOnLoad(Sabai_Addon_Field_IField $field, array &$values, Sabai_Addon_Entity_IEntity $entity)
    {
        foreach ($values as $key => $value) {
            $values[$key]['addon_features'] = (array)@unserialize($values[$key]['addon_features']);
        }
    }
    
    public function fieldTypeOnExport(Sabai_Addon_Field_IField $field, array &$values)
    {
        foreach (array_keys($values) as $key) {

            $values[$key] = $values[$key]['plan_id'] . '|' . $values[$key]['recurring_payment_id'];
        }
    }
    
    public function fieldTypeIsModified($field, $valueToSave, $currentLoadedValue)
    {   
        foreach ($currentLoadedValue as $key => $value) {
            $currentLoadedValue[$key]['addon_features'] = serialize((array)@$currentLoadedValue[$key]['addon_features']);
        }
        return $currentLoadedValue !== $valueToSave;
    }
}