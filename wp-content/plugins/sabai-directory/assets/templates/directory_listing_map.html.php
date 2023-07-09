<?php
if (!$entity->directory_location) return;
$markers = array();
foreach ($entity->directory_location as $key => $location) {
    if (!$location['lat'] || !$location['lng']) continue;
    $markers[$key] = array(
        'content' => $this->renderTemplate($entity->getBundleType() . '_single_infobox', array('entity' => $entity, 'address_weight' => $key)),
        'lat' => $location['lat'],
        'lng' => $location['lng'],
        'trigger' => '#sabai-directory-map-directions .sabai-googlemaps-directions-destination',
        'triggerEvent' => 'change'
    );
}
$multi_address = count($markers) > 1;
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var googlemaps = function () {
        SABAI.GoogleMaps.map(
            "#sabai-directory-map",
            <?php echo json_encode($markers);?>,
            null,
            <?php echo isset($map_settings['listing_default_zoom']) ? intval($map_settings['listing_default_zoom']) : 15;?>,
            <?php echo json_encode(array('marker_clusters' => false, 'enable_directions' => '#sabai-directory-map-directions', 'icon' => $this->Directory_ListingMapMarkerUrl($entity)) + $map_settings['options']);?>
        );
        SABAI.GoogleMaps.autocomplete(".sabai-googlemaps-directions-input");
    }
    if ($('#sabai-directory-map').is(':visible')) {
        googlemaps();
    } else {
        $('#sabai-inline-content-map-trigger').on('shown.bs.sabaitab', function(e, data){
            googlemaps();
        });
    }
});
</script>
<div id="sabai-directory-map-directions">
    <div id="sabai-directory-map" class="sabai-googlemaps-map" style="height:300px;" data-map-type="<?php echo $map_settings['type'];?>"></div>
    <div class="sabai-googlemaps-directions-search">
        <form class="sabai-search">
            <div class="sabai-row">
                <div class="sabai-col-xs-12<?php if (!$multi_address):?> sabai-col-sm-6<?php endif;?>"><input type="text" class="sabai-googlemaps-directions-input" value="" placeholder="<?php Sabai::_h(__('Enter a location', 'sabai-directory'));?>" /></div>
<?php if ($multi_address):?>
                <div class="sabai-col-xs-12">
                    <select class="sabai-googlemaps-directions-destination">
<?php   foreach (array_keys($markers) as $key):?>
                        <option value="<?php echo $key;?>"><?php Sabai::_h($entity->directory_location[$key]['address']);?></option>
<?php   endforeach;?>
                    </select>
                </div>
<?php else:?>
                <input type="hidden" value="0" class="sabai-googlemaps-directions-destination" />
<?php endif;?>
                <div class="sabai-col-xs-12 sabai-col-sm-4<?php if ($multi_address):?> sabai-col-sm-offset-6<?php endif;?>">
                    <div class="sabai-btn-group sabai-btn-block">
                        <a class="sabai-btn sabai-btn-sm sabai-btn-primary sabai-col-xs-10 sabai-directory-btn-directions sabai-googlemaps-directions-trigger"><?php echo __('Get Directions', 'sabai-directory');?></a>
                        <a class="sabai-btn sabai-btn-sm sabai-btn-primary sabai-col-xs-2 sabai-dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="sabai-caret"></span></a>
                        <ul class="sabai-dropdown-menu sabai-btn-block" role="menu">
                            <li><a class="sabai-googlemaps-directions-trigger" data-travel-mode="TRANSIT"><?php echo __('By public transit', 'sabai-directory');?></a></li>
                            <li><a class="sabai-googlemaps-directions-trigger" data-travel-mode="WALKING"><?php echo __('Walking', 'sabai-directory');?></a></li>
                            <li><a class="sabai-googlemaps-directions-trigger" data-travel-mode="BICYCLING"><?php echo __('Bicycling', 'sabai-directory');?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="sabai-googlemaps-directions-panel" style="height:300px; overflow-y:auto; display:none;"></div>
</div>