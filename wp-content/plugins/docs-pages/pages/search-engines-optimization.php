<?php

return array(
	'title' => 'SEO and Meta information',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="seo">Compatibility with Yoast SEO plugin</h2>
	
		Web 2.0 Directory plugin compatible with <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank" rel="noopener noreferrer">Yoast SEO plugin</a> when "Imitation mode" settings disabled at the <em>"Advanced settings"</em> tab. Imitation mode makes WordPress to behave pages with &#091;webdirectory&#093; shortcode as a simple WordPress pages, not like taxonomy pages, single listing pages as required to scan meta information for search engines and web crawlers.
	
		Open "Yoast SEO -> Settings" page and click "Directory listings" tab in menu.
		
		<img src="[base_url]/wp-content/uploads/yoast_seo_listings_settings.png" class="alignnone size-full" />
	
		Enter <strong>"%%cf_custom_field_ID%%"</strong> as a snippet variable to place data from listing content fields, replace ID with <a href="[base_url]/documentation/content-fields/">content field</a> ID number.
	
		<a href="[base_url]/documentation/directory-categories/">Listings categories</a>, <a href="[base_url]/documentation/directory-locations/">listings locations</a> and listings tags taxonomies have the same settings to configure meta tags for directory pages.
	
		<hr />
	
		Yoast SEO metabox appears for directory listings on their edition screen at the admin dashboard. Same metabox appears for directory categories and locations taxonomy terms.
	
		<img src="[base_url]/wp-content/uploads/yoast_seo_single_listing_settings.png" class="alignnone size-full" />
	
		Meta information appears in the source code of the page.
		
		<img src="[base_url]/wp-content/uploads/yoast_seo_single_listing_meta.png" class="alignnone size-full" />
	
		<i class="fa fa-exclamation-triangle"></i> Note, when <a href="[base_url]/documentation/settings/advanced/#miscellaneous">Imitation mode</a> enabled - SEO plugins like Yost SEO plugin</a> aren\'t able to enter correct meta tags in directory pages, "Imitation mode" should be disabled.
	</div>
		
'
);

?>