<?php

return array(
	'title' => 'Listings directories',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="listings_directories">Listings directories</h2>
		The plugin has an ability to build multi-directory website. By default there is one "<em>Listings</em>" directory, this standard directory can not be removed.
		
		<i class="fa fa-exclamation-triangle"></i> Each directory <strong>must have</strong> own page with its unique shortcode. That page must not have any child pages, it must be public, not private, not in trash.
		
		Manage directories at the <em>"Directory Admin -> Listings Directories"</em> page.
		Each directory follows same settings from built-in settings panel. But administrator can build <a href="[base_url]/documentation/custom-home">custom home page</a> with individual shortcode parameters. Each directory has options to set up separate locations, categories and levels, those will be available for this directory. In the same way listings levels can own separate content fields, so each directory can have individual content fields.
		
		<img src="[base_url]/wp-content/uploads/directories.png" />
		
		Directory settings:
		<img src="[base_url]/wp-content/uploads/directories_slugs.png" />
		
		<strong>Directory name</strong> - the name of directory.
		
		<strong>Single form</strong> and <strong>Plural form</strong> - the name of directory items in 2 forms. Examples: plural form - "Found 5 listings", single form - "Found 1 listing".
		
		<strong>Listing slug</strong> - this is a part of URL for single listing page, for example, in this URL
		<em>https://www.yoursite.com/directory/listing/name</em>
		<em>name</em> - is the name of listing and <em>listing</em> - is the slug. Listing slug take part in some permalinks structures, see about <a href="[base_url]/documentation/settings/slugs-permalinks/">listings permalinks structure</a>.
		
		<strong>Category slug</strong> - this is a part of URL for categories sections, for example, in this URL
		<em>https://www.yoursite.com/directory/listing-category/business/</em>
		<em>business</em> - is the name of category and <em>listing-category</em> - is the slug.
		
		<strong>Location slug</strong> - this is a part of URL for locations sections, for example, in this URL
		<em>https://www.yoursite.com/directory/listing-place/united-states/los-angeles/</em>
		<em>united-states/los-angeles</em> - is the path of locations tree and <em>listing-place</em> - is the slug.
		
		<strong>Tag slug</strong> - this is a part of URL for tags sections, for example, in this URL
		<em>https://www.yoursite.com/directory/listing-tag/service/</em>
		<em>service</em> - is the name of tag and <em>listing-tag</em> - is the slug.
		
		<i class="fa fa-exclamation-triangle"></i> Slugs must contain only alpha-numeric characters, underscores or dashes. All slugs must be unique and different. Slugs must not match slugs of pages. Do not enter same slugs for different directories.
		
		<strong>Assigned categories</strong> - you can define some special categories, those will be available for this directory.
		
		<strong>Assigned locations</strong> - you can define some special locations, those will be available for this directory.
		
		<strong>Listings levels</strong> - you can  define some special levels, those will be available for this directory.
		
		In order to set up a page with needed directory - copy-paste appropriate shortcode from "<em>Directory Admin -&gt; Listings directories"</em> table. In the same way you can create separate pages for frontend submission and single listings pages for each directory. Use their shortcodes with appropriate parameters.
		
		Example for the second directory with ID=2: <strong>&#091webdirectory-submit directory=2&#093</strong>, <strong>&#091webdirectory-listing-page directory=2&#093</strong>. These are optional pages, by default the system will use frontend submission and single listings pages of the standard directory shortcodes <strong>&#091webdirectory-submit&#093</strong>, <strong>&#091webdirectory-listing-page&#093</strong>.
	
		Directories-levels structure:
		<img src="[base_url]/wp-content/uploads/directories_levels_structure.png" alt="directories_levels" class="alignnone size-full" />
	</div>
	
'
);

?>