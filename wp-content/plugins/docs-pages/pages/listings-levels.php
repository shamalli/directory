<?php

return array(
	'title' => 'Listings levels',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="listings_levels">Listings levels</h2>
		
		Levels of listings control the functionality and behaviour of listings and their directory/classifieds conception. It\'s some sort of listings payment plans.
	
		<img src="[base_url]/wp-content/uploads/directories_levels_structure.png" alt="directories_levels" class="alignnone size-full" />
		
		Each listing belongs to one of defined levels, some may have eternal active period, have sticky status and enabled google maps, others may have greater number of allowed attached images or videos. Select which <a href="[base_url]/documentation/directory-categories/">categories</a>, <a href="[base_url]/documentation/directory-locations/">locations</a> and <a href="[base_url]/documentation/content-fields/">content fields</a> will be included into listings level. It is perfect base for business model of your directory or classifieds site. On "<em>Directory Admin -> Listings levels"</em> page you can order existing levels by drag & drop rows in the table, the order of levels affects on <a href="[base_url]/documentation/frontend/submit/">submission tables</a>. Here is the list of listings levels options:
		
		<strong>Level name</strong> - the name of level. Special note: by default there is one standard listing level after installation of the plugin and the system doesn\'t show advertise table on the 1st step of listings creation, because it doesn\'t need to select the level for newly created listing.
		
		<i class="fa fa-star"></i> There is "<a href="[base_url]/documentation/frontend/">Hide choose level page</a>" setting at the "General settings" tab. When all listings levels are similar and all have packages of listings, user do not need to choose level to submit when he already has a package, so you can enable this option. Choose level page will be skipped only when user is logged in and has available listings in his package.
		
		<strong>Level description</strong> - uses only in the advertise table on the 1st step of listings submision.
		
		<strong>Who can view listings</strong> - specify what users can see listings in this level: any users, only logged in users, or select specific users groups. Viewing listing page disallowed users will get "Sorry, you are not allowed to view this page." message.
		
		<strong>Eternal active period</strong> - when enabled - listings of this level will never expire.
		
		<strong>Active period</strong> - in years, months and days. During this period the listing will have active status, then the status of listing become expired. After expiration listing owner or admin may prolong and renew listing.
		
		<strong>Change level after expiration</strong> - after expiration listing will change level automatically. By default listings will just suspend.
		
		<i class="fa fa-star"></i> Site admin can build such business model, when after expiration of listing of free level it will be suspended and moved to payment level. So it is some kind of trial period, users will have to pay after free period to activate their listings.
		
		<strong>Number of listings in package</strong> - enter more than 1 to allow users get packages of listings. Users will be able to use listings from their package to renew, raise up and upgrade existing listings. Also site administrators are able to manage the number of directory listings available for each user on his profile edition page.
		
		<img src="[base_url]/wp-content/uploads/2013/12/woo_listings_available.png" alt="woo_listings_available" width="620" height="303" class="alignnone size-full wp-image-1952" />
		
		<strong>Ability to raise up listings</strong> - if this option is checked - listing owner or admin may raise listing up in all lists those ordered by date.
		
		<strong>Sticky listings</strong> - if this option is checked - listings of this level will be always sticked on top of all lists those ordered by date.
		
		<strong>Featured listings</strong> - listings of this level have special CSS class "<em>w2dc-featured"</em>, may be customized to be highlighted and attract attention.
	
		<img src="[base_url]/wp-content/uploads/sticky_featured_labels.png" alt="sticky_featured_labels" class="alignnone size-full" />
		
		<strong>Do listings have own pages?</strong> - this option could disable listings self pages, so there will not be any links to listings pages, just that information on excerpt pages.
		
		<strong>Enable nofollow attribute for links to single listings pages</strong> - <a href="https://support.google.com/webmasters/answer/96569">Description from Google Webmaster Tools</a>
		
		<strong>Enable google map</strong> - users have an ability to place location(s) marker on Google map.
		
		<strong>Enable listing logo on excerpt pages</strong> - listings of this level own uploaded image as logo.
		
		<strong>Images number available</strong> - the number of images allowed to upload for listings of this level.
		
		<strong>Videos number available</strong> - the number of YouTube videos allowed to embed for listings of this level.
		
		<strong>Listings price</strong> - price for listings activation and renewal. Appears when <a href="[base_url]/documentation/payments/">payments addon</a> was enabled.
		
		<strong>Listings raise up price</strong> - price for <a href="[base_url]/documentation/directory-listings/">listings raise</a> up option. Appears when <a href="[base_url]/documentation/payments/">payments addon</a> was enabled.
		
		<strong>Ratings</strong> - enable ratings for listings of this level. Appears when ratings addon was enabled.
		
		<strong>Locations number available</strong> - the number of locations allowed to be assigned with listings of this level. Set 0 to disable locations in this level.
		
		<strong>Custom markers on google map</strong> - whether listings authors can select <a href="[base_url]/documentation/maps/markers-icons/">custom marker icons</a> on the map. Or default icon will be used.
		
		<strong>Categories number available</strong> - the number of categories allowed to be assigned with listings of this level. When during listing creation/edition user exceeded this number - the warning message will arise. Also it is possible to set unlimited number of categories. Set 0 to disable categories in this level.
		
		<strong>Tags number available</strong> - the number of tags allowed to be assigned with listings of this level. When during listing creation/edition user exceeded this number - the warning message will arise. Also it is possible to set unlimited number of tags. Set 0 to disable tags in this level.
		
		<strong>Assigned categories</strong> - admin can define some special categories, those would be available for listings of this level. When during listing creation/edition user will click unavailable category checkbox - the warning message will arise.
		
		<strong>Assigned locations</strong> - admin can define some special locations, those would be available for listings of this level.
		
		<strong>Assigned content fields</strong> - specific categories fields available in current listings level.
	</div>
'
);

?>