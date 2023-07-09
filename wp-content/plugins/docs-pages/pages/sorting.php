<?php

return array(
	'title' => 'Sorting',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="listings_sorting">Sorting of listings</h2>
		Each frontend page that displays the list of listings has "<em>Sort by</em>" set of links, of course, if it was not disabled in settings. Clicking sorting links allows to change order direction from ascending to descending and vice versa.
		
		<img src="[base_url]/wp-content/uploads/orderby.png" alt="" class="alignnone size-full" />
		
		By default on the top appear sticky and featured listings only when they are sorted by date, in another case they are sorted exactly by title, rating, additional content fields values, but there is such option <em>"Sticky and featured listings always will be on top"</em> on "Pages & Views" settings tab. So it is additional tool for business model of the directory site - place listings of sticky or featured levels higher than other listings. Then at the second stage each list sorts by date (here may be useful <a href="[base_url]/documentation/directory-listings/#listings_raiseup">"raise up listings"</a> feature), except search by radius page. When user searches listings in radius - default sorting is by distance from center point.
		
		<i class="fa fa-star"></i> Some <a href="[base_url]/documentation/content-fields">content fields</a> types, like date-time, number, price, text string types have own setting to allow order by these fields. You may find special sorting settings including "Default order by" setting on "Pages & Views" settings tab.
		
		When ratings addon enabled - in the <em>"Sort by"</em> set of links appears new option to order by Best rating.
	
		<img src="[base_url]/wp-content/uploads/listings_sorting_settings.png" class="alignnone size-full" />
	
		Sort by date allows listings to be raised up and sorted by <em>"Sorting date"</em>, special metabox appears on listings edition screen:
		
		<img src="[base_url]/wp-content/uploads/sorting_date_metabox.png" class="alignnone size-full" />
		
		<i class="fa fa-star"></i> Sticky listings have higher priority under featured and other listings.
	
		<hr />
	
		<h2 id="categories_locations_sorting">Sorting of locations and categories</h2>
	
		Drag & drop categories and locations items by mouse and sort them as you wish. By default these terms ordered by default in the way you have created and sort them. At the <a href="[base_url]/documentation/settings/pages-views/"><em>"Pages & Views"</em> settings tab</a> you can select how to sort categories and locations: by default, alphabetically or by listings count inside each term.
	
		<img src="[base_url]/wp-content/uploads/categories_locations_sorting.png" class="alignnone size-full" />
	
		<i class="fa fa-star"></i> Sort terms in shortcodes examples:
		<strong>&#091;webdirectory-categories order=\'name\'&#093;</strong>
		<strong>&#091;webdirectory-locations order=\'count\'&#093;</strong>
	</div>
	
'
);

?>