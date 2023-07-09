<?php

return array(
	'title' => 'Pages & Views',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="pages_views">Pages &amp; views tab</h2>
		
		Following settings are placed on "<em>Directory Admin -> Directory settings</em>" page on the <em>"Pages & Views"</em> settings tab.
		
		<h4 id="excerpt_views">Excerpt views</h4>
		
		<img src="[base_url]/wp-content/uploads/excerpt_views_settings.png" class="alignnone size-full" />
		
		<strong>Show listings number</strong> - show/hide label <em>"Found N listings"</em> at the top of listings block.
		
		<strong>Enable views switcher</strong> - show/hide views switcher at the top of listings block.
		
		<strong>Listings view by default</strong> - user can change default view. Selected view will be stored in cookies.
		
		<strong>Listing title mode</strong> - how to display listing title and rating stars (when ratings addon enabled) on excerpt pages: inside listing logo or outside it. See examples:
		<div style="float: left; margin-right: 50px">
			<img src="[base_url]/wp-content/uploads/listing_title_inside.png" class="alignnone size-full" />
		</div>
		<div style="float: left;">
			<img src="[base_url]/wp-content/uploads/listing_title_outside.png" class="alignnone size-full" />
		</div>
		<div style="clear: both;"></div>
		
		Other settings for logo images on excerpt pages described by the <a href="[base_url]/documentation/settings/listings-logos-images/#listings_logos_on_excerpt">link</a>.
		
		<hr />
		
		<h4 id="categories_settings">Categories settings</h4>
		
		<img src="[base_url]/wp-content/uploads/categories_views_settings.png" class="alignnone size-full" />
		
		<strong>Show categories list on index and excerpt pages</strong> - whether to show categories list on directory pages or not.
		
		<strong>Categories nesting level</strong> - when set to 1 - only root categories will be listed.
		
		<strong>Categories columns number</strong> - divide categories into 1, 2, 3 or 4 columns.
		
		<strong>Show subcategories items number</strong> - this is the number of subcategories those will be displayed in the table, when category item includes more than this number "View all subcategories -&gt;" link appears at the bottom.
		
		<strong>Show category listings count</strong> - whether to show number of listings assigned with current category in brackets.
		
		<strong>Order by</strong> - <a href="[base_url]/documentation/sorting/#categories_locations_sorting">sort categories</a> by default, alphabetically or by listings count inside each term.
		
		<hr />
		
		<h4 id="locations_settings">Locations settings</h4>
		
		<img src="[base_url]/wp-content/uploads/locations_views_settings.png" class="alignnone size-full" />
		
		<strong>Show locations list on index and excerpt pages</strong> - whether to show locations list on directory pages or not.
		
		<strong>Locations nesting level</strong> - when set to 1 - only root locations will be listed.
		
		<strong>Locations columns number</strong> - divide locations into 1, 2, 3 or 4 columns.
		
		<strong>Show sublocations items number</strong> - this is the number of sublocations those will be displayed in the table, when location item includes more than this number "View all slocations -&gt;" link appears at the bottom.
		
		<strong>Show location listings count</strong> - whether to show number of listings assigned with current location in brackets.
		
		<strong>Order by</strong> - <a href="[base_url]/documentation/sorting/#categories_locations_sorting">sort locations</a> by default, alphabetically or by listings count inside each term.
		
		<hr />
		
		Sorting settings on excerpt pages described by the <a href="[base_url]/documentation/sorting/">link</a>.
	</div>
	
'
);

?>