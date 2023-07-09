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
	
		<hr />
	
		<i class="fa fa-exclamation-triangle"></i> Mandatory page with <strong>&#091;webdirectory&#093;</strong> or with <strong>&#091;webdirectory custom_home=1&#093;</strong> shortcode should not have child pages, it must be public, not private, not in trash, must be unique - only one page with this shortcode allowed.
		
		<h4 id="multisite">WordPress Multisite installation</h4>
		
		Upload the plugin on Network Admin plugins page, <strong>but don\'t activate it</strong>. It is not allowed to enable "Network Activate" for the plugin on Network plugins page, instead activate it on the plugins page of each sub-site. Also note, that each activation on each sub-site requires separate license.
	
	</div>
'
);

?>