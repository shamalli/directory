<?php

return array(
	'title' => 'Titles, Slugs and Permalinks',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="titles_slugs_permalinks">Titles, Slugs and Permalinks</h2>
	
		Manage directory title and permalinks structure at the General Settings tab of <em>"Directory Admin -> Directory Settigns"</em> page.
		<img src="[base_url]/wp-content/uploads/title_slugs_permalinks.png" />
		
		<strong>Directory title</strong> - this string will appear in the title of all frontend pages related with the directory plugin. This could be overwritten by <a href="[base_url]/documentation/search-engine-optimization/">Yoast SEO plugin</a>.
		
		<strong>Sticky listing label</strong> - easy to change word "STICKY" in this setting.
		
		<strong>Featured listing label</strong> - easy to change word "FEATURED" in this setting.
		<img src="[base_url]/wp-content/uploads/sticky_featured_labels.png" />
		
		<strong>Notice about slugs:</strong>
		You can manage listings, categories, locations and tags slugs in <a href="[base_url]/documentation/listings-directories">listings directories</a> setting.
		<img src="[base_url]/wp-content/uploads/directories_slugs.png" />
		
		<strong>Listings permalinks structure</strong> - set up permalinks structure of single listings pages. Examples of listings URLs:
		<strong>/%postname%/</strong> - example of listing "Business in LA", it\'s slug "business-in-la"
		<strong>/%listing_slug%/</strong> - example "business-listing"
	
		<table>
		<tr><td width="40%"><strong>/%postname%/</strong></td><td>https://www.yoursite.com/directory/business-in-la/</td></tr>
		<tr><td><strong>/%post_id%/%postname%%/</strong></td><td>https://www.yoursite.com/directory/644/business-in-la/</td></tr>
		<tr><td><strong>/%listing_slug%/%postname%/</strong></td><td>https://www.yoursite.com/directory/business-listing/business-in-la/</td></tr>
		<tr><td><strong>/%listing_slug%/%category%/%postname%/</strong></td><td>https://www.yoursite.com/directory/business-category/subcategory/business-in-la/</td></tr>
		<tr><td><strong>/%listing_slug%/%location%/%postname%/</strong></td><td>https://www.yoursite.com/directory/usa/california/los-angeles/business-in-la/</td></tr>
		<tr><td><strong>/%listing_slug%/%tag%/</strong></td><td>https://www.yoursite.com/directory/business-tag/business-in-la/</td></tr>
		</table>
		<strong>/%postname%/</strong> works only when directory page is not front page.
		Otherwise displayed as <strong>/%post_id%/%postname%/</strong> - https://www.yoursite.com/644/business-in-la/
		
		<i class="fa fa-exclamation-triangle"></i> in above examples <em>/directory/</em> - is the slug of directory page with main <strong>&#091;webdirectory&#093;</strong> shortcode. You can change it on this page edition screen. <em>/business-listing/</em>, <em>/business-category/</em>, <em>/business-place/</em>, <em>/business-tag/</em> - these are listing, category, location and tag  slugs, manage them in <a href="[base_url]/documentation/listings-directories">listings directories</a> settings. In appropriate permalinks structures they are required and can not be removed from URLs.
	
		<img src="[base_url]/wp-content/uploads/webdirectory_shortcode.png" />
	</div>
	
'
);

?>