<?php

return array(
	'title' => 'Custom Home Pages',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="custom_home">Custom Home Page</h2>
		By default the order and position of elements of <strong>&#091;webdirectory&#093;</strong> main shortcode is static: frontpanel buttons, search form, categories list, locations list, google map, listings block. But there is a possibility to set up custom layout.
		
		<img src="[base_url]/wp-content/uploads/webdirectory_shortcode.png" />
		
		<iframe width="912" height="600" src="https://www.youtube.com/embed/Rcrf_XupmpY" title="Custom Home page" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		
		Two ways to build custom home page:
	<ol>
		<li>
		Using shortcodes with <strong>custom_home=1</strong> parameter. When you set up <strong>&#091;webdirectory custom_home=1&#093;</strong> the shortcode displays only listings, no map, no categories list, no locations list, no search form. This special mode allows to build custom directory home page as you wish using additional shortcodes:

		<strong>&#091;webdirectory-search custom_home=1&#093;</strong> - custom search form gives search results into main <strong>&#091;webdirectory custom_home=1&#093;</strong> element.
		
		<strong>&#091;webdirectory-categories custom_home=1&#093;</strong> - categories shortcode renders corresponding categories navigation menu.
		
		<strong>&#091;webdirectory-locations custom_home=1&#093;</strong> - locations shortcode renders corresponding locations navigation menu.
		
		<strong>&#091;webdirectory-map custom_home=1&#093;</strong> - Google map with markers from listings.
		
		<strong>&#091;webdirectory-breadcrumbs&#093;</strong> - displays breadcrumbs in the place of this shortcode. <strong>custom_home=1</strong> parameter does not need.
		
		<strong>&#091;webdirectory-buttons&#093;</strong> - renders following buttons: Submit new listing, My bookmarks button and buttons on single listing page: Claim listing, Edit listing, Print listing, Add/Remove Bookmark, Save listing in PDF. <strong>custom_home=1</strong> parameter does not need.
		
		<strong>&#091;webdirectory-term-title&#093;</strong> - displays category, location or tag title in the place of this shortcode. <strong>custom_home=1</strong> parameter does not need.
		
		<strong>&#091;webdirectory-term-description&#093;</strong> - displays category, location or tag description in the place of this shortcode. <strong>custom_home=1</strong> parameter does not need.
		
		Lets try to rearrange some elements: move breadcrumbs and buttons to place after the locations table and put down the map. Use shortcodes with <strong>custom_home=1</strong> parameter.
		
		<img src="[base_url]/wp-content/uploads/custom_homepage_shortcodes.png" class="alignnone size-full" />
		
		You can build unique layout, wrap and re-structure these shortcodes in WordPress blocks using Gutenberg editor.
		</li>
		
		<li>
		Also the plugin allows to build custom home page using <a href="[base_url]/documentation/directory-widgets/">directory widgets</a> or third party builders like WPBakery Page Builder, SiteOrigin page builder or <a href="[base_url]/documentation/pages/elementor/">Elementor plugin</a>.</li>
		</li>
	</ol>
			
		<i class="fa fa-star"></i> Detailed explanation of all shortcodes you can find <a href="[base_url]/documentation/shortcodes/">here</a>.
	</div>
		
'
);

?>