<?php
class Sabai_Addon_GoogleMaps_Helper_RenderMap extends Sabai_Helper
{
    protected $_count = 0, $_jsLoaded = false, $_autocompleteLoaded = false;
    
    public function help(Sabai $application, array $locations, array $options)
    {
        $options += array(
            'height' => 200,
            'type' => 'roadmap',
            'directions' => false,
            'scrollwheel' => false,
            'zoom' => 15,
            'icon' => null,
            'style' => null,
            'infobox_width' => 250,
        );
        $id = 'sabai-googlemaps-map-' . $this->_count++;
        $markers = array();
        foreach ($locations as $key => $location) {
            if (!$location['lat'] || !$location['lng']) continue;
            $markers[$key] = array(
                'content' => isset($location['address']) ? '<div class="sabai-googlemaps-map-address">' . $location['address'] . '</div>' : null,
                'lat' => $location['lat'],
                'lng' => $location['lng'],
                'trigger' => '#' . $id . ' .sabai-googlemaps-directions-destination',
                'triggerEvent' => 'change'
            );
        }
        if (empty($markers)) {
            return '';
        }
        if (!$this->_jsLoaded) {
            $application->GoogleMaps_LoadApi(array('map' => true, 'style' => $options['style']));
        }
        if (!$options['directions']) {
            $application->getPlatform()->addJs($this->_getJs($id, $markers, $options), $id);
            return sprintf(
                '<div id="%s"><div class="sabai-googlemaps-map" style="height:%dpx;" data-map-type="%s"></div></div>',
                $id,
                $options['height'],
                $options['type']
            );
        }
        
        if (!$this->_autocompleteLoaded) {
            $application->GoogleMaps_LoadApi(array('autocomplete' => true));
            $this->_autocompleteLoaded = true;
        }
        $application->getPlatform()->addJs($this->_getJs($id, $markers, $options), $id);
        $multi_address = count($markers) > 1; 
        if ($multi_address) {
            $addr_options = array();
            foreach (array_keys($markers) as $key) {
                $option = isset($locations[$key]['address']) ? Sabai::h($locations[$key]['address']) : $locations[$key]['lat'] . ',' . $locations[$key]['lat'];
                $addr_options[] = '<option value="' . $key . '">' . $option . '</option>';
            }
            $addr_select = sprintf(
                '<div class="sabai-col-xs-12">
    <select class="sabai-googlemaps-directions-destination">
    %s
    </select>
</div>',
                implode(PHP_EOL, $addr_options)
            );
        } else {
            $addr_select = '<input type="hidden" value="0" class="sabai-googlemaps-directions-destination" />';
        }
        return sprintf(
            '<div id="%s">
    <div class="sabai-googlemaps-map" style="height:%dpx;" data-map-type="%s"></div>
    <div class="sabai-googlemaps-directions-search">
        <form class="sabai-search%s">
            <div class="sabai-row">
                <div class="sabai-col-xs-12%s">
                    <input type="text" class="sabai-googlemaps-directions-input" value="" placeholder="%s" />
                </div>
                %s
                <div class="sabai-col-xs-12 sabai-col-sm-4%s">
                    <div class="sabai-btn-group sabai-btn-block">
                        <a class="sabai-btn sabai-btn-sm sabai-btn-primary sabai-col-xs-10 sabai-directory-btn-directions sabai-googlemaps-directions-trigger">%s</a>
                        <a class="sabai-btn sabai-btn-sm sabai-btn-primary sabai-col-xs-2 sabai-dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="sabai-caret"></span></a>
                        <ul class="sabai-dropdown-menu sabai-btn-block" role="menu">
                            <li><a class="sabai-googlemaps-directions-trigger" data-travel-mode="TRANSIT">%s</a></li>
                            <li><a class="sabai-googlemaps-directions-trigger" data-travel-mode="WALKING">%s</a></li>
                            <li><a class="sabai-googlemaps-directions-trigger" data-travel-mode="BICYCLING">%s</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="sabai-googlemaps-directions-panel" style="height:300px; overflow-y:auto; display:none;"></div>
</div>',
            $id,
            $options['height'],
            $options['type'],
            empty($options['mini']) ? '' : ' sabai-search-mini',
            $multi_address ? '' : ' sabai-col-sm-8',
            Sabai::h(__('Enter a location', 'sabai-googlemaps')),
            $addr_select,
            $multi_address ? ' sabai-col-sm-offset-8' : '',
            __('Get Directions', 'sabai-googlemaps'),
            //__('By car', 'sabai-googlemaps'),
            __('By public transit', 'sabai-googlemaps'),
            __('Wakling', 'sabai-googlemaps'),
            __('Bicycling', 'sabai-googlemaps')
        );
    }
    
    protected function _getJs($id, $markers, $options)
    {
        return sprintf(
            '(function ($) {
    var googlemaps = function () {
        SABAI.GoogleMaps.map(
            "#%1$s .sabai-googlemaps-map",
            %2$s,
            null,
            %3$d,
            %4$s
        );
        SABAI.GoogleMaps.autocomplete("#%1$s .sabai-googlemaps-directions-input");
    }
    var $map = $("#%1$s");
    if ($map.is(":visible")) {
        googlemaps();
    } else {
        var pane = $map.closest(".sabai-tab-pane");
        if (pane.length) {
            $("#" + pane.attr("id") + "-trigger").on("shown.bs.sabaitab", function(e, data){
                googlemaps();
            });
        }
    }
    $(SABAI).bind("loaded.sabai", function (e, data) {
        if (data.target.find("#%1$s").length) {
            googlemaps();
        }
    });
} ($));',
            $id,
            json_encode($markers),
            $options['zoom'],
            json_encode(array(
                'marker_clusters' => false,
                'enable_directions' => empty($options['directions']) ? false : '#' . $id,
                'icon' => $options['icon'],
                'default_marker' => isset($options['default_marker']) ? $options['default_marker'] : null,
                'scrollwheel' => (bool)$options['scrollwheel'],
                'infobox_width' => $options['infobox_width'],
            ))
        );
    }
}
