<?php

return array(
	'title' => 'Map markers & InfoWindow',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="map_infowindow_settings">Map markers & InfoWindow settings</h2>
	
		So you have successfully configured <a href="[base_url]/documentation/maps/">maps setting</a>, selected <a href="[base_url]/documentation/maps/google-maps-keys/">Google Maps</a> or <a href="[base_url]/documentation/maps/mapbox/">MapBox</a> maps engine, now lets manage map markers icons on the "<em>Maps & Addresses</em>" settings tab of "<em>Directory Admin -> Directory settings</em>" page.
	
		<img src="[base_url]/wp-content/uploads/maps_settings_markers_infowindow.png" alt="" class="alignnone size-full " />
		
		<strong>Type of Map Markers</strong> - 2 possible types:
		<ul>
			<li>Font Awesome icons (recommended) - icons from the Font Awesome set will be used.</li>
			<li>PNG images - images files from <em>"resources/images/map_icons/icons/"</em> folder of the plugin. Site administrator can upload custom icons into "<em>w2dc-plugin/resources/images/map_icons/icons/</em>" folder of your child theme via the Files manager of hosting control panel or via FTP.</li>
		</ul>
	
		<i class="fa fa-exclamation-triangle"></i> The plugin uses only one folder for PNG icons: native folder or custom folder in your child theme when exists.
		
		Using Font Awesome icons it is possible to select default icon and color of map marker. When "Custom markers on the map" option enabled in listings levels settings - users will be able to select specific icon for each marker. On <em>"Directory listings -&gt; Directory categories"</em> page it is allowed to select specific marker icon and color for each category.
		
		<img src="[base_url]/wp-content/uploads/2018/04/category_icons.png" alt="" class="alignnone size-full " />
		
		Other settings related to custom PNG images. Do not touch these settings to avoid breaking the layout. Modification of these settings needed when you use own custom map markers icons with own sizes. If you are using custom markers PNG images, it is recommended, they all be of same size.
		
		<img class="alignnone size-full" src="[base_url]/wp-content/uploads/2013/12/map_marker_structure.png" alt="map_marker_structure" />
		
		Here is simple example of how Google map looks with custom marker icons and radius search cycle:
		
		<img src="[base_url]/wp-content/uploads/2018/04/google_map.png" alt="" width="850" height="591" class="alignnone size-full wp-image-16881" />
		
		Attention to the left side search panel. Visitors can search listings and view map markers directly on the map plus a list of found listings below search form.
		
		When "Custom markers on google map" <a href="[base_url]/documentation/listings-levels">level setting</a> is checked - on listings submission/edition pages users are able to select custom marker icons.
		
		On the listings <a href="[base_url]/documentation/frontend/submit/">submission page</a> there is an option to set marker coordinates (latitude and longitude) manually or by mouse drag & drop of existing marker.
		Country, state, city, e.t.c. - these are <a href="[base_url]/documentation/directory-locations/#locations_levels">locations levels</a> and you can manage them at the <em>"Directory Admin -> Locations levels"</em> page. Please manage <a href="[base_url]/documentation/directory-locations/">Directory locations</a> tree (Unites States, New York) at the "Directory listings -> Directory locations" page.
		
		<img src="[base_url]/wp-content/uploads/location_enter.png" />
		
		Clicking <em>"Generate on google map"</em> button processes targeting and compiling of addresses to render markers on the map.
		
		The map on main directory pages (with <strong>&#091;webdirectory&#093;</strong> shortcode) follows settings from built-in settings panel. But <strong>&#091;webdirectory-map&#093;</strong> shortcode has a bunch of own parameters. With this shortcode you can configure what to display and how to display on a separate map for your needs. This separate map can be connected with a search form and/or listings by "uID" parameter in shortcode.

		<i class="fa fa-star"></i> Complete list of <strong>&#091;webdirectory-map&#093;</strong> shortcode parameters you can find <a href="[base_url]/documentation/shortcodes/">here</a>.
	</div>
		
'
);

?>