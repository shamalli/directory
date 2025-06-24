<?php

return array(
	'title' => 'Maps Management',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="maps_tab">Maps &amp; Addresses</h2>
		
		This settings tab places on "<em>Directory Admin -> Directory settings</em>" page.
		
		<strong>&#091;webdirectory-map&#093;</strong> <a href="[base_url]/documentation/shortcodes/">shortcode</a> and <a href="[base_url]/documentation/directory-widgets/">map widget</a> do not follow some of these settings (they follow only when they were set up to be a part of <a href="[base_url]/documentation/pages/custom-home/">custom home page</a>). They have own parameters to configure.
	
		<i class="fa fa-exclamation-triangle"></i> Frontend page displays empty map when there aren\'t any listings with locations. Just add listings with map markers.
		
		<h4 id="map_type">Map type</h4>
	
		<img src="[base_url]/wp-content/uploads/map_type_setting.png" alt="" class="alignnone size-full " />
		
		<strong>Select map engine</strong> - 3 options available:
		<ol>
			<li><strong>No maps</strong> - no maps will be loaded, address autocomplete and geolocation will not work as well.</li>
	
			<li><a href="[base_url]/documentation/maps/google-maps-keys/"><strong>Google Maps</strong></a> - since 2018 Google Maps is no longer free. You must enable billing with a credit card and have a valid API key for all of your projects
			<a href="https://developers.google.com/maps/billing/understanding-cost-of-use" rel="noopener noreferrer" target="_blank">https://developers.google.com/maps/billing/understanding-cost-of-use</a>
			This allows to get free usage of near 28K maps services requests monthly.</li>
		
			<li><a href="[base_url]/documentation/maps/mapbox/"><strong>MapBox (OpenStreetMap)</strong></a> - has limit 50.000 maps services requests of free usage without need to enable billing with a credit card.</li>
		</ol>
		
		<hr />
	
		<h4 id="general_maps_settings">General Maps Settings</h4>
		
		<img src="[base_url]/wp-content/uploads/maps_settings_general.png" alt="" class="alignnone size-full " />
		
		<strong>Show map on home page</strong> - whether to show the map on index (home) directory page.
		
		<strong>Show map on excerpt page</strong> - whether to show the map on excerpt directory pages: search, categories, locations pages.
		
		<strong>How many map markers to display on the map</strong> - choose what map markers to display:
		<ul>
			<li>The only map markers of visible listings will be displayed</li>
			<li>Display all map markers (lots of markers on one page may slow down page loading)</li>
		</ul>
		
		<strong>Show directions panel on a single listing page</strong> - frontend users may pave the route on the map and get the list of directions for selected location separately, there may be more than one location of each listing.
		
		<strong>Default map zoom level (for submission page)</strong> - this zoom level is used during listing submission, the range is 1-19. 1 - the lowest zoom (whole world), 19 - the highest zoom (individual buildings, if available).
		
		<strong>Default map height (in pixels)</strong> - default map height on main directory pages.
		
		<strong>Show cycle during radius search</strong> - by this option you may hide red transparent cycle that appears on map during locations search in radius.
		<img src="[base_url]/wp-content/uploads/radius_map.png" alt="" width="500" class="alignnone size-full " />
		
		<strong>Enable clusters of map markers</strong> - when checked - map markers will be grouped in clusters.
		<img src="[base_url]/wp-content/uploads/clusters.png" alt="" width="500" class="alignnone size-full " />
		
		<strong>Make map markers mandatory during submission of listings</strong> - when checked - listing must have at least one map marker.
		
		<strong>Enable default user Geolocation</strong> - this functionality requires HTTPS enabled.
		
		<strong>Default zoom level</strong> - recommended to keep it "Auto", so map will zooms to display all available markers in the map window.
	
		<strong>The farest zoom level</strong> - How far we can zoom out: 1 - the farest (whole world)
	
		<strong>The closest zoom level</strong> - How close we can zoom in: 19 - the closest
		
		<hr />
		
		<h4 id="map_controls_settings">Maps controls settings</h4>
	
		<img src="[base_url]/wp-content/uploads/maps_settings_controls.png" alt="" class="alignnone size-full " />
		
		<strong>Enable Draw Panel</strong> - users can draw a shape on the map and find map markers inside drawn area. Very important: MySQL version must be 5.6.1 and higher or MySQL server variable "thread stack" must be 256K and higher. Ask your hoster about it if "Draw Area" does not work. 99% it should be available on your host.
	
		<img src="[base_url]/wp-content/uploads/draw_panel.png" alt="" width="500" class="alignnone size-full " />
		
		<strong>Show search form and listings sidebar on the map</strong> - search and display listings information directly on the left-side panel inside map window.
	
		<strong>Select search form</strong> - what search form we are using near map. Select from existing <a href="[base_url]/documentation/search/">search forms</a>.
		
		<strong>Enable full screen button</strong> - enable/disable full screen button.
		
		<strong>Enable zoom by mouse wheel</strong> - this setting only for desktops.
		
		<strong>Enable map dragging on touch screen devices</strong> - when enabled - users can zoom and pan by using two-finger movements on the map for touchscreen devices.
		
		<strong>Center map on marker click</strong> - the map will center on marker.
		
		<strong>Hide compact search form on the map for mobile devices</strong> - this setting will affect all maps: directory pages, map shortcodes, map widgets.
		
		<hr />
		
		<h4 id="addresses_settings">Addresses settings</h4>
		
		
	
		<img src="[base_url]/wp-content/uploads/maps_settings_addresses.png" alt="" class="alignnone size-full " />
		
		<strong>Default country/state for correct geocoding</strong> - this value needed when you build local directory, all your listings place in one local area - country, state or city. This hidden string will be automatically added to the address for correct geocoding when users create/edit listings and when they search by address.
		
		<strong>Address format</strong> - order address elements as you wish, commas and spaces help to build address line.
		
		<strong>Restriction of address fields for one specific country (autocomplete submission and search fields)</strong> - restrict autocomplete functionality by maps service only to one selected country or keep it worldwide.
		
		<strong>Enable address line 1 field</strong> - enabled/disable address line 1 field in locations metaboxes.
		
		<strong>Enable address line 2 field</strong> - enabled/disable address line 2 field in locations metaboxes.
		
		<strong>Enable zip code</strong> - enabled/disable zip code field in locations metaboxes.
		
		<strong>Enable additional info field</strong> - enabled/disable additional info field in locations metaboxes.
		
		<strong>Enable manual coordinates fields</strong> - enabled/disable manual coordinates fields in locations metaboxes.
	
		<strong>Use Zip or Postal code label</strong> - zip code or postal code.
	</div>
	
'
);

?>