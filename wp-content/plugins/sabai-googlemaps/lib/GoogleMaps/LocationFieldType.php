<?php
class Sabai_Addon_GoogleMaps_LocationFieldType extends Sabai_Addon_Field_Type_AbstractType implements Sabai_Addon_Field_ISortable
{
    protected function _fieldTypeGetInfo()
    {
        return array(
            'label' => __('Location', 'sabai-googlemaps'),
            'default_widget' => 'googlemaps_marker',
            'default_renderer' => 'googlemaps_marker',
        );
    }

    public function fieldTypeGetSchema(array $settings)
    {
        return array(
            'columns' => array(
                'address' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'length' => 255,
                    'notnull' => true,
                    'was' => 'address',
                    'default' => '',
                ),
                'street' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'length' => 255,
                    'notnull' => true,
                    'was' => 'street',
                    'default' => '',
                ),
                'city' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'length' => 100,
                    'notnull' => true,
                    'was' => 'city',
                    'default' => '',
                ),
                'state' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'length' => 100,
                    'notnull' => true,
                    'was' => 'state',
                    'default' => '',
                ),
                'zip' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'length' => 30,
                    'notnull' => true,
                    'was' => 'zip',
                    'default' => '',
                ),
                'country' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'length' => 50,
                    'notnull' => true,
                    'was' => 'country',
                    'default' => '',
                ),
                'zoom' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                    'unsigned' => true,
                    'notnull' => true,
                    'length' => 2,
                    'was' => 'zoom',
                    'default' => 0,
                ),
                'lat' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_DECIMAL,
                    'length' => 9,
                    'scale' => 6,
                    'notnull' => true,
                    'unsigned' => false,
                    'was' => 'lat',
                    'default' => 0,
                ),
                'lng' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_DECIMAL,
                    'length' => 9,
                    'scale' => 6,
                    'notnull' => true,
                    'unsigned' => false,
                    'was' => 'lng',
                    'default' => 0,
                ),
            ),
            'indexes' => array(
                'lat_lng' => array(
                    'fields' => array(
                        'lat' => array('sorting' => 'ascending'),
                        'lng' => array('sorting' => 'ascending'),
                    ),
                    'was' => 'lat_lng',
                ),
            ),
        );
    }

    public function fieldTypeOnSave(Sabai_Addon_Field_IField $field, array $values)
    {
        $ret = array();
        foreach ($values as $weight => $value) {
            if (!is_array($value)) continue;

            foreach (array('city', 'state', 'zip', 'country') as $key) {
                if (is_array(@$value[$key])) {
                    $value[$key] = trim((string)array_shift($value[$key]));
                }
            }
            if (isset($value['lat'])) $value['lat'] = (float)$value['lat'];
            if (isset($value['lng'])) $value['lng'] = (float)$value['lng'];
            if ($value = array_filter($value)) {
                $ret[] = $value;
            }
        }

        return $ret;
    }

    public function fieldTypeOnLoad(Sabai_Addon_Field_IField $field, array &$values, Sabai_Addon_Entity_IEntity $entity)
    {
        foreach (array_keys($values) as $key) {
            settype($values[$key]['lat'], 'float');
            settype($values[$key]['lng'], 'float');
        }
    }
    
    public function fieldSortableDoSort(Sabai_Addon_Field_IQuery $query, $fieldName, array $args = null)
    {
        if (!isset($args['lat']) || !isset($args['lng'])) return;
        
        $query->sortByExtraField('distance', isset($args[0]) && $args[0] === 'desc' ? 'DESC' : 'ASC')->addExtraField(
            'distance',
            sprintf(
                '(%1$d * acos(cos(radians(%3$.6F)) * cos(radians(%2$s.lat)) * cos(radians(%2$s.lng) - radians(%4$.6F)) + sin(radians(%3$.6F)) * sin(radians(%2$s.lat))))',
                $args['is_mile'] ? 3959 : 6371,
                $fieldName,
                $args['lat'],
                $args['lng']
            )
        );
    }
}