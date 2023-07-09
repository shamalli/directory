<?php

return array(
	'title' => 'Google API keys',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="google_maps_keys">Google API keys</h2>
		<strong>Since 2018 Google Maps is no longer free.</strong> You must enable billing with a credit card and have a valid API key for all of your projects <a href="https://developers.google.com/maps/billing/understanding-cost-of-use" rel="noopener noreferrer" target="_blank">https://developers.google.com/maps/billing/understanding-cost-of-use</a>. This allows to get free usage of near 28K maps services requests monthly. Otherwise you can enable <a href="[base_url]/documentation/settings/maps-addresses/">MapBox map engine</a>, it has limit 50.000 maps services requests of free usage without need to enable billing with a credit card.
		
		<strong>Google requires mandatory Maps API keys</strong> for maps created on new and existing websites/domains. Otherwise it may cause problems with Google Maps, Geocoding, addition/edition listings locations, autocomplete on addresses fields, search by radius.

		<hr />
		
		<h4 id="google_maps_settings">Google Maps Settings</h4>
		<img src="[base_url]/wp-content/uploads/google_maps_settings.png" alt="google_maps_settings" class="alignnone size-full" />
		
		<strong>Directions functionality</strong> - select how to provide directions functionality, display route schema directly on your site or redirect a user to Google Maps.
		
		<hr />
		
		<h4>Browser API key</h4>
		<a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,static_maps_backend&keyType=CLIENT_SIDE&reusekey=true" target="_blank" rel="noopener noreferrer">Create browser API key</a> in new project or in existing one.
			
		<img src="[base_url]/wp-content/uploads/2013/12/Create_project2.png" alt="create_project2" class="alignnone size-full wp-image-1946" />
			
		Step 2
		<img src="[base_url]/wp-content/uploads/api_key_step2.png" alt="" class="alignnone size-full wp-image-23733" />
			
		The next screen allows you set to a name for the browser key, and restrict the usage of the browser key to the provided referrers. If you leave the referrer field empty, then it is possible for other users to use your key on their domains.
			
		<img src="[base_url]/wp-content/uploads/api_key_browser.png" alt="" class="alignnone size-full wp-image-23736" />
			
		Set the referrer to <strong>*.yourdomain.com/*</strong> to cover all pages on your site.
		
		<hr />
			
		<h4>Server API key</h4>
		<a href="https://console.developers.google.com/flows/enableapi?apiid=geocoding_backend,places_backend&keyType=SERVER_SIDE&reusekey=true" target="_blank" rel="noopener noreferrer">Create server API key</a> in new project or in existing one. Select the same project you used when you created the browser key and click \'Continue\'.
			
		<i class="fa fa-exclamation-triangle"></i>To test server API key you can visit debug page and check geolocation response. Debug page is placed on your site by similar URL <strong>http://www.yoursite.com/wp-admin/admin.php?page=w2dc_debug</strong>
		
		On the next screen set the referrer to the IP address of your server (this is optinal) to restrict the usage of the key. <a href="https://www.site24x7.com/find-ip-address-of-web-site.html" target="_blank" rel="noopener noreferrer">Here</a> you may find IP address of your site.
			
		<img src="[base_url]/wp-content/uploads/api_key_server.png" alt="" class="alignnone size-full wp-image-23743" />
			
		Enter both keys in appropriate settings on the <a href="[base_url]/documentation/settings/maps-addresses/">Maps & Addresses settings tab</a> of the plugin settings page.
			
		Take special attention to "Accept requests from these HTTP referrers (web sites)" (for browser key) and "Accept requests from these server IP addresses" (for server key) fields. If they will be wrongly filled in - it may cause problems with Google Maps and their functionality. You can try to leave them blank.
			
		<img src="[base_url]/wp-content/uploads/api_key_dashboard.png" alt="" class="alignnone size-full wp-image-23748" />
		
		<hr />
			
		<h4>When you are using existing project</h4>
		You have to enable following APIs in the console: Maps JavaScript API, Static Maps API, Places API, Maps Geocoding API and Directions API.
			
		<img src="[base_url]/wp-content/uploads/api_key_apis.png" alt="" class="alignnone size-full wp-image-23735" />
			
		Click "VIEW ALL" link
		<img src="[base_url]/wp-content/uploads/api_keys_apis2.png" alt="" class="alignnone size-full wp-image-23739" />
		
		<i class="fa fa-exclamation-triangle"></i> Sometimes it takes some time for keys activation. Also you could try to speed up the process (as some users did) in the following way: disable, delete, re-enable and re-create all your APIs and keys (or, at least, the ones that give you problems), and see if this fixes the issue for you. If you prefer, you could try with API keys from different account instead, but both keys from one project.
	</div>
		
'
);

?>