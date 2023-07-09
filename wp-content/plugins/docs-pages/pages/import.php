<?php

return array(
	'title' => 'CSV Import',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="import">CSV Import</h2>
		
		We placed sample CSV file in "<strong><em>documentation/</em></strong>" folder in the plugin archive.
		
		<ol>
			<li>On the second step of importing you\'ll collate CSV headers of columns with existing listings fields, this means there isn\'t fixed format for CSV files.</li>
		
			<li>The only required columns in CSV file, those will define new listings titles and level IDs. Also information about author must be provided - in any column of CSV file or by setting default author in settings.</li>
		
			<li>In order to assign some categories/locations/tags with each listing - specify existing category/location/tag name, slug or ID in one CSV column and separate them with special delimiter. This delimiter must be any string character, but not the same as the delimiter for separation of CSV columns.</li>
		
			<li>You may set to auto-create new category/subcategory/location/sublocation/tag. In such case, when there isn\'t any existing category/subcategory/location/sublocation/tag with provided slug - new category/subcategory/location/sublocation/tag will be created automatically.</li>
		
			<li>Example of multiple subcategories import: "<em>Business services > Advertising, Marketing & PR ; Real estate > Properties > Commercial</em>". 2 root categories will be created, if they were not existed before import: "<em>Business services</em>" and "<em>Real estate</em>". And all their subcategories will be created in this hierarchy: "<em>Advertising, Marketing & PR</em>", "<em>Properties</em>" and "<em>Commercial</em>". Locations import works in the same way.</li>
		
			<li>MultiValues - are such fields, those may have more than one value, for example, categories, locations, tags, images, YouTube videos, checkboxes content field items. Separate them in one CSV column with special delimiter in the same way as for assigned categories.</li>
		
			<li>Also you may upload ZIP archive with images files for new listings. Specify names of images files in one CSV column and separate them with special delimiter in the same way as for assigned categories. In order to import images titles - specify them after each image file name by ">" symbol, example: "<em>goldengate_1024x768.jpg>Golden Gate</em>". Note, that images files must be in the root inside ZIP archive, not inside folder.</li>
		
			<li>By default listings authors will be specified in one of CSV columns, there must be existing user ID, user login or user email. Or you can switch to assign all new listings with one specific existing user.</li>
		
			<li>Locations import works in the same way as categories import. Define already existing directory location name, slug or ID or set new locations names. Use ">" symbol for locations-sublocations hierarchy. Example of multiple sublocations import: "<em>United States > Lousiana ; Canada > Ottawa > Ottawa</em>".
			There are 2 fields for addresses: address line 1 and address line 2. So you can import in 2 ways: predefined locations (countries, states, cities, e.t.c.) in couple with addresses (street, building number, flat, e.t.c.) or only addresses fields with whole address. Also you may set special column for names of existed map icons files: for example, there is such map marker icon file "<em>w2dc/resources/images/map_icons/icons/_new/Boat.png</em>", so you have to place "<em>_new/Boat.png</em>" into CSV column. Using Font Awesome icons just place the name of icon "<em>w2dc-fa-automobile</em>".</li>
		
			<li>When you do not have latitude/longitude information for map markers - geocoding service is used to get coordinates for map markers from addresses (CURL extention required). There is useful option "Geocode imported listings by address parts" on the second step of importing.
			<strong>Since 2018 Google Geocoding services is no longer free.</strong> You must enable billing with a credit card and have a valid API key for all of your projects <a href="https://developers.google.com/maps/billing/understanding-cost-of-use" rel="noopener noreferrer" target="_blank">https://developers.google.com/maps/billing/understanding-cost-of-use</a>. This allows to get free usage of near 28K maps services requests monthly. Otherwise you can enable <a href="[base_url]/documentation/settings/maps-addresses/">MapBox map engine</a>, it has limit 50.000 maps services requests of free usage without need to enable billing with a credit card.</li>
		
			<li>All dates with or without time must be formatted in following way: "dd.mm.yyyy HH:MM" (time is optional)</li>
		
			<li>For YouTube videos specify full video URL or only its ID. You can separate some videos in one CSV column with special delimiter in the same way as for assigned categories.</li>
		
			<li>Opening hours content field import format: "Mon 01:00 AM - 12:59 PM". Days of week: Mon, Tue, Wed, Thu, Fri, Sat, Sun. Separate each day of week by comma. Missing days of week will be set as "closed".</li>
		
			<li>There is an option to configure all imported listings as claimable, this option is shown when frontend submission addon was enabled and also claim functionality was switched on.</li>
		
			<li>When the size of your CSV file is very large - this may slow down the server and break the process of import, you may try to split the file into smaller CSV files.</li>
		
			<li>Recommended to make whole backup of the database before import.</li>
		</ol>
	</div>
	
'
);

?>