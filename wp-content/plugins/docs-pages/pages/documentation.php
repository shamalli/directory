<?php

return array(
	'title' => 'Documentation',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="installation">Installation</h2>
		
		To add a WordPress Plugin using the built-in plugin installer:
		<ol>
		 	<li>Go to "<em>Plugins -&gt; Add New</em>".</li>
		
		 	<li>Click "<em>Upload Plugin</em>" button.</li>
		
		 	<li>Choose downloaded ZIP file and click "Install Now" button.</li>
		
		 	<li>Make sure that you click on "Activate the plugin". Now you have installed directory plugin.</li>
		
		 	<li>
			<em>(required)</em> Take your purchase code, go to Directory Admin -&gt; Directory Settings page and enter purchase code into "Purchase code" setting field.
			<img src="[base_url]/wp-content/uploads/purchase_code.png" alt="" width="685" height="350" class="alignnone size-full" /></li>
		
		 	<li><em>(required)</em> Create new page and enter <strong>&#091;webdirectory&#093;</strong> shortcode or <strong>&#091;webdirectory custom_home=1&#093;</strong> shortcode if you wish to build <a href="[base_url]/documentation/custom-home/">custom home page</a>. Also you might want to create additional pages for frontend submission and dashboard using <strong>&#091;webdirectory-submit&#093;</strong> and <strong>&#091;webdirectory-dashboard&#093;</strong> shortcodes if you wish your logged in users to manage their listings, invoices and profile on the <a href="[base_url]/documentation/frontend/">frontend dashboard page</a>.
			<img src="[base_url]/wp-content/uploads/webdirectory_shortcode.png" /></li>
		
		 	<li><em>(optional)</em> Create new page and enter <strong>&#091;webdirectory-listing-page&#093;</strong> shortcode to build separate page for <a href="[base_url]/documentation/pages/single-listing-page/">single listings</a>. Especially when you are building custom home page, so there will not be any other directory elements like on the home page.</li>
		</ol>
		
		<iframe width="912" height="600" src="https://www.youtube.com/embed/EyMQLcMmhUs?si=qDG9b_aP2mumR1Ea" title="Setup guide" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
	
		<i class="fa fa-exclamation-triangle"></i> Mandatory page with <strong>&#091;webdirectory&#093;</strong> or with <strong>&#091;webdirectory custom_home=1&#093;</strong> shortcode should not have child pages, it must be public, not private, not in trash, must be unique - only one page with this shortcode allowed.
		
		<hr />
		
		<h4 id="multisite">WordPress Multisite installation</h4>
		
		Upload the plugin on Network Admin plugins page, <strong>but don\'t activate it</strong>. It is not allowed to enable "Network Activate" for the plugin on Network plugins page, instead activate it on the plugins page of each sub-site. Also note, that each activation on each sub-site requires separate license.
	
		<hr />
		
		<iframe width="912" height="600" src="https://www.youtube.com/embed/8r41yn1BT5Q?si=14rTjUgW2dXBIe6Y" title="Quick overview" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		
		<h2 id="demos">Demo pages</h2>
		
		<h3>Custom layout of directory elements</h3>
		<ul>
			<li><a href="[base_url]/custom-home-page-1/">Custom Home Page 1</a></li>
			<li><a href="[base_url]/custom-home-page-2/">Custom Home Page 2</a></li>
			<li><a href="[base_url]/custom-home-page-3/">Custom Home Page 3</a></li>
			<li><a href="[base_url]/custom-home-page-4/">Custom Home Page 4</a></li>
			<li><a href="[base_url]/custom-home-page-5/">Custom Home Page 5</a></li>
			<li><a href="[base_url]/custom-home-page-6/">Custom Home Page 6</a></li>
		</ul>
		<ul>
			<h3>Listings shortcodes</h3>
			<li><a href="[base_url]/search-ajax-map-listings/">Search + AJAX Map + Listings</a></li>
			<li><a href="[base_url]/connected-sticky-">Connected Sticky Shortcodes</a></li>
			<li><a href="[base_url]/4-columns/">4 Columns</a></li>
			<li><a href="[base_url]/only-sticky-featured/">Only Sticky & Featured</a></li>
			<li><a href="[base_url]/geolocation-with-listings/">Geolocation with Listings</a></li>
			<li><a href="[base_url]/listings-carousel/">Listings Carousel</a></li>
		</ul>
		<ul>
			<h3>Maps shortcodes</h3>
			<li><a href="[base_url]/radius-circle-on-the-map/">Radius circle on the map</a></li>
			<li><a href="[base_url]/ajax-map/">Ajax Map</a></li>
			<li><a href="[base_url]/geolocation/">Geolocation</a></li>
			<li><a href="[base_url]/all-listings-of-location/">All listings of a location</a></li>
			<li><a href="[base_url]/search-form-on-map/">Search Form on Map</a></li>
			<li><a href="[base_url]/categories-search-on-map/">Categories search on map</a></li>
			<li><a href="[base_url]/draw-panel/">Draw Panel</a></li>
		</ul>
		<ul>
			<h3>Other different shortcodes</h3>
			<li><a href="[base_url]/webdirectory-search/">&#091;webdirectory-search&#093;</a></li>
			<li><a href="[base_url]/webdirectory-categories/">&#091;webdirectory-categories&#093;</a></li>
			<li><a href="[base_url]/webdirectory-locations/">&#091;webdirectory-locations&#093;</a></li>
			<li><a href="[base_url]/webdirectory-slider/">&#091;webdirectory-slider&#093;</a></li>
			<li><a href="[base_url]/webdirectory-levels-table/">&#091;webdirectory-levels-table&#093;</a></li>
			<li><a href="[base_url]/webdirectory-buttons/">&#091;webdirectory-buttons&#093;</a></li>
		</ul>
		<ul>
			<h3>Search forms shortcodes</h3>
			<li><a href="[base_url]/categories-search/">Categories Search</a></li>
			<li><a href="[base_url]/buttons-colors/">Buttons & Colors</a></li>
			<li><a href="[base_url]/locations-search-the-map/">Locations search & the Map</a></li>
			<li><a href="[base_url]/search-in-radius/">Search in radius</a></li>
			<li><a href="[base_url]/prices-search/">Prices search</a></li>
			<li><a href="[base_url]/dependent-search/">Dependent search</a></li>
			<li><a href="[base_url]/datepicker/">Datepicker</a></li>
			<li><a href="[base_url]/ratings-search/">Ratings search</a></li>
			<li><a href="[base_url]/more-filters/">More filters</a></li>
			<li><a href="[base_url]/opened-closed/">Opened & Closed</a></li>
			<li><a href="[base_url]/checkboxes-search/">Checkboxes Search</a></li>
		</ul>
	</div>
'
);

?>