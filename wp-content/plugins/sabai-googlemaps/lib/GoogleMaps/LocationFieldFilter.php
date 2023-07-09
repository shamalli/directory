<?php
class Sabai_Addon_GoogleMaps_LocationFieldFilter extends Sabai_Addon_Field_Filter_AbstractFilter
{
    protected $_selectables = array();
    
    protected function _fieldFilterGetInfo()
    {
        return array(
            'label' => __('Location', 'sabai-googlemaps'),
            'field_types' => array('googlemaps_marker'),
            'default_settings' => array(
                'filter_by' => 'city',
                'form' => 'checkboxes',
                'inline' => false,
                'show_more' => array('num' => 5, 'text' => null),
                'min_length' => 2,
                'match' => 'exact',
            ),
            'is_fieldset' => true,
        );
    }

    public function fieldFilterGetSettingsForm(Sabai_Addon_Field_IField $field, array $settings, array $parents = array())
    {
        $form = array(
            'filter_by' => array(
                '#type' => 'radios',
                '#title' => __('Filter by', 'sabai-googlemaps'),
                '#options' => array(
                    'city' => __('City', 'sabai-googlemaps'),
                    'state' => __('State / Province / Region', 'sabai-googlemaps'),
                    'zip' => __('Postal / Zip code', 'sabai-googlemaps'),
                    'country' => __('Country', 'sabai-googlemaps'),
                ),
                '#default_value' => $settings['filter_by'],
            ),
        );
        if ($selects = $this->_getSelectables($field)) {
            $form += array(
                'form' => array(
                    '#title' => __('Form element type', 'sabai-googlemaps'),
                    '#type' => 'radios',
                    '#options' => array('checkboxes' => __('Checkboxes', 'sabai-googlemaps'), 'select' => __('Select list', 'sabai-googlemaps')),
                    '#default_value' => $settings['form'],
                    '#weight' => 5,
                    '#states' => array(
                        'visible' => array(
                            sprintf('input[name="%s[filter_by]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                'type' => 'value',
                                'value' => array_keys($selects),
                            ),
                        ),
                    ),
                ),
                'inline' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Display inline', 'sabai-googlemaps'),
                    '#description' => __('Check this to align all options on the same line.', 'sabai-googlemaps'),
                    '#default_value' => $settings['inline'],
                    '#weight' => 10,
                    '#states' => array(
                        'visible' => array(
                            sprintf('input[name="%s[filter_by]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                'type' => 'value',
                                'value' => array_keys($selects),
                            ),
                        ),
                    ),
                ),
                'show_more' => array(
                    'num' => array(
                        '#type' => 'number',
                        '#integer' => true,
                        '#min_value' => 0,
                        '#title' => __('Number of options to display', 'sabai-googlemaps'),
                        '#description' => __('If there are more options than the number specified here, those options will be displayed in a popup window.', 'sabai-googlemaps'),
                        '#default_value' => $settings['show_more']['num'],
                        '#size' => 3,
                        '#states' => array(
                            'invisible' => array(
                                sprintf('input[name="%s[form]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                    'type' => 'value',
                                    'value' => 'select',
                                ),
                            ),
                        ),
                    ),
                    'text' => array(
                        '#type' => 'textfield',
                        '#title' => __('Label for link to open popup window', 'sabai-googlemaps'),
                        '#default_value' => isset($settings['show_more']['text']) ? $settings['show_more']['text'] : sprintf(__('More %s', 'sabai-googlemaps'), (string)$field),
                        '#states' => array(
                            'visible' => array(
                                sprintf('input[name="%s[show_more][num]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                    'type' => 'filled',
                                    'value' => true,
                                ),
                                sprintf('input[name="%s[show_more][num]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                    'type' => 'value',
                                    'value' => array(array(0, '!=')),
                                ),
                            ),
                        ),
                    ),
                    '#weight' => 15,
                    '#states' => array(
                        'visible' => array(
                            sprintf('input[name="%s[filter_by]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                'type' => 'value',
                                'value' => array_keys($selects),
                            ),
                            sprintf('input[name="%s[form]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array(
                                'type' => 'value',
                                'value' => 'checkboxes',
                            ),
                        ),
                    ),
                ),
            );
        } else {
            $form += array(
                'min_length' => array(
                    '#type' => 'number',
                    '#title' => __('Min. length of keywords in characters', 'sabai-googlemaps'),
                    '#size' => 3,
                    '#default_value' => $settings['min_length'],
                    '#integer' => true,
                    '#required' => true,
                    '#min_value' => 1,
                    '#display_unrequired' => true,
                ),
                'match' => array(
                    '#title' => __('Match any or all', 'sabai-googlemaps'),
                    '#type' => 'select',
                    '#options' => array('any' => __('Match any', 'sabai-googlemaps'), 'all' => __('Match all', 'sabai-googlemaps'), 'exact' => __('Exact match', 'sabai-googlemaps')),
                    '#default_value' => $settings['match'],
                ),
            );
        }
        
        return $form;
    }
    
    protected function _isSelectable(Sabai_Addon_Field_IField $field, array $settings)
    {
        $selects = $this->_getSelectables($field);
        return !empty($selects) && isset($selects[$settings['filter_by']]);
    }
    
    protected function _getSelectables(Sabai_Addon_Field_IField $field)
    {
        if (!isset($this->_selectables[$field->getFieldName()])) {
            $widget_settings = $field->getFieldWidgetSettings();
            $this->_selectables[$field->getFieldName()] = array();
            foreach (array('city', 'state', 'zip', 'country') as $type) {
                $_type = $type . '_type';
                if (isset($widget_settings[$_type]) && $widget_settings[$_type] === 'select') {
                    $this->_selectables[$field->getFieldName()][$type] = $type;
                }
            }
        }
        return $this->_selectables[$field->getFieldName()];
    }
    
    public function fieldFilterGetForm(Sabai_Addon_Field_IField $field, $filterName, array $settings, Sabai_Addon_Entity_Model_Bundle $bundle, $request = null, array $requests = null, $isSubmitOnChanage = true, array $parents = array())
    {
        if (!$this->_isSelectable($field, $settings)) {
            return array(
                '#type' => 'textfield',
            );
        }
        $options = $this->_getOptions($field, $settings);
        $options_valid = array_keys($options);
        if ($this->_showMoreLink($options, $settings)) {
            $options = $this->_getViewableOptions($options, $settings, $request);
            list($more_link, $js, $more_form) = $this->_getMoreOptions($field, $filterName, $settings, $request);
        }
        if ($settings['form'] === 'select') {
            $options = array('' => _x('Any', 'option', 'sabai-googlemaps')) + $options;
            $options_valid[] = '';
        }
        return array(
            '#type' => $settings['form'],
            '#options' => $options,
            '#options_valid' => $options_valid,
            '#class' => $settings['inline'] ? 'sabai-form-inline' : null,
            '#field_suffix' => isset($more_link) ? $more_link : null,
            '#prefix' => isset($more_form) ? '<div style="display:none;" class="sabai-googlemaps-marker-filter-option-more-options-' . str_replace('_', '-', $filterName) . '">'. $more_form .'</div>' : null,
            '#js' => @$js,
        );
    }
    
    protected function _showMoreLink(array $options, array $settings)
    {
        return $settings['show_more']['num'] > 0 && count($options) > $settings['show_more']['num'];
    }
    
    protected function _getViewableOptions(array $options, array $settings, $request)
    {
        $ret = array();
        $option_count = 0;
        if (isset($request)
            && ($request = array_intersect(array_keys($options), (array)$request))
        ) {
            foreach ($request as $_request) {
                $ret[$_request] = $options[$_request];
                unset($options[$_request]);
                ++$option_count;
                if ($option_count == $settings['show_more']['num']) break;
            }
        }
        if ($option_count < $settings['show_more']['num']) {
            $ret += array_slice($options, 0, $settings['show_more']['num'] - $option_count, true);
        }
        return $ret;
    }    
    
    public function fieldFilterIsFilterable(Sabai_Addon_Field_IField $field, $filterName, array $settings, &$value, array $requests = null)
    {
        return $this->_isSelectable($field, $settings) ? !empty($value) : $this->_isTextFilterable($settings, $value);
    }
    
    protected function _isTextFilterable(array $settings, &$value)
    {
        if (!$value = trim((string)$value)) {
            return false;
        }
        
        if ($settings['match'] !== 'exact') {
            $keywords = $this->_addon->getApplication()->Keywords($value, $settings['min_length']);
        
            if (empty($keywords[0])) return false; // no valid keywords
        
            $value = $keywords[0];
        } else {
            if (strlen($value) < $settings['min_length']) return false;
        }
        
        return true;
    }
    
    public function fieldFilterDoFilter(Sabai_Addon_Field_IQuery $query, Sabai_Addon_Field_IField $field, $filterName, array $settings, $value)
    {
        if (!$this->_isSelectable($field, $settings)) {
            switch ($settings['match']) {
                case 'any':
                    $query->startCriteriaGroup('OR');
                    foreach ($value as $keyword) {
                        $query->addContainsCriteria($field, $settings['filter_by'], $keyword);
                    }
                    $query->finishCriteriaGroup();
                    break;
                case 'all':
                    foreach ($value as $keyword) {
                        $query->addContainsCriteria($field, $settings['filter_by'], $keyword);
                    }
                    break;
                default:
                    $query->addIsCriteria($field, $settings['filter_by'], $value);
            }
        } else {
            $query->addInCriteria($field, $settings['filter_by'], (array)$value);
        }
    }
    
    public function fieldFilterGetPreview(Sabai_Addon_Field_IField $field, $filterName, array $settings)
    {
        if ($settings['form'] === 'select') {
            return '<select disabled="disabled"><option>' . _x('Any', 'option', 'sabai-googlemaps') . '</option></select>';
        }
        $options = $this->_getOptions($field, $settings);
        $ret = array();
        if ($settings['show_more']['num'] > 0
            && count($options) > $settings['show_more']['num']
        ) {
            foreach (array_slice($options, 0, $settings['show_more']['num'], true) as $label) {
                $ret[] = sprintf('<input type="checkbox" disabled="disabled" />%s', Sabai::h($label));
            }
            $ret[] = sprintf('<a disabled="disabled" class="sabai-googlemaps-maker-filter-option-more">%s</a>', Sabai::h($settings['show_more']['text']));
        } else {
            foreach ($options as $label) {
                $ret[] = sprintf('<input type="checkbox" disabled="disabled" />%s', Sabai::h($label));
            }
        }
        return implode($settings['inline'] ? '&nbsp;&nbsp;' : '<br />', $ret);
    }
    
    protected function _getMoreOptions(Sabai_Addon_Field_IField $field, $filterName, array $settings, $value)
    {
        $form = $this->_addon->getApplication()->Form_Build($this->_getMoreOptionsForm($filterName, $value, $this->_getOptions($field, $settings)));
        $js = sprintf(
            "jQuery(document).ready(function($){
    var link = $('#%2\$s');
    link.click(function(e){
        var modal = SABAI.modal('<form class=\"sabai-form\" id=\"%1\$s\">' + link.closest('form').find('.sabai-googlemaps-marker-filter-option-more-options-%5\$s').html() + '</form>', '%3\$s', 600);
        modal.find('input[name=\"%4\$s\"]').prop('disabled', false);
        $('#%1\$s').submit(function(e){
            var form = link.closest('form'), inputs = form.find('input[name=\"%4\$s\"]').prop('checked', false);
            $(this).find(':checked').each(function() {
                var input = inputs.filter('[value=\"' + this.value + '\"]');
                if (input.length) {
                    input.prop('checked', true).prop('disabled', false);
                }
            });
            e.preventDefault();
            modal.hide();
            form.submit();
        });
        e.preventDefault();
    });
});",
            $form->settings['#id'],
            $link_id = 'sabai-googlemaps-marker-filter-option-' . md5(uniqid(mt_rand(), true)),
            $settings['show_more']['text'],
            $filterName . '[]',
            str_replace('_', '-', $filterName)
        );
        return array(
            $this->_addon->getApplication()->LinkTo($settings['show_more']['text'], '#', array(), array('id' => $link_id, 'class' => 'sabai-googlemaps-marker-filter-option-more')),
            $js,
            $this->_addon->getApplication()->Form_Render($form, '', true)
        );
    }
    
    protected function _getMoreOptionsForm($filterName, $value, $options)
    {
        return array(
            '#build_id' => false,
            '#token' => false,
            $filterName => array(
                '#type' => 'checkboxes',
                '#options' => $options,
                '#options_disabled' => array_keys($options),
                '#default_value' => $value,
            ),
            Sabai_Addon_Form::FORM_SUBMIT_BUTTON_NAME => $this->_addon->getApplication()->Form_SubmitButtons(),
        );
    }
    
    protected function _getOptions(Sabai_Addon_Field_IField $field, array $settings)
    {
        $widget_settings = $field->getFieldWidgetSettings();
        switch ($settings['filter_by']) {
            case 'city':
                $key = 'cities';
                break;
            case 'state':
                $key = 'states';
                break;
            case 'zip':
                $key = 'zips';
                break;
            case 'country':
                $key = 'countries';
                break;
        }
        return (array)@$widget_settings[$key]['options'];
    }
}