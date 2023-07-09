<?php

return array(
	'title' => 'Directory listings',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="directory_listings">Directory listings</h2>
		
		Directory listings are very much like standard WordPress posts, except some things and additional features. In wordpress terminology "Directory listings" are posts of a custom post type, they store in the database, in wordpress tables with all their meta data. "Directory listings" custom post type can be used by another 3rd party plugins, in the same way as native WP posts. For example customize listings meta information in <a href="[base_url]/documentation/search-engine-optimization/">Yoast SEO plugin</a>. This gives huge space for compatibility and custom development. For some 3rd party plugins it requires special adaptation.
		
		<h3 id="listings_creation">Listings creation and management</h3>
		Creation of new listing begins with choosing of listing level and directory (when there are more than 1 directory and level in the system). This is the first step and it defines functionality and behaviour of newly created listing.
		
		<ol>
			<li>To have an ability to create listings at the frontend - it is required to enable Frontend submission and dashboard addon and create a <a href="[base_url]/documentation/frontend/submit/">page with &#091;webdirectory-submit&#093; shortcode</a>.
		<img src="[base_url]/wp-content/uploads/2018/04/submission_plans.png" />
		
		After successfull submission at the frontend listing gets special status. You can read more in the <a href="[base_url]/documentation/frontend/listing-live-cycle/">listing live cycle</a>.
		</li>
			<li>At the backend just choose listing level and directory (when there are more than 1 directory and level in the system)
		<img src="[base_url]/wp-content/uploads/listing_backend.png" /></li>
		</ol>
		
		Listings administration page may contain standard WordPress fields and metaboxes such as: title field, richtext editor for listing description, slug and excerpt fields, author metabox, comments metabox. Also, according to the level of current listing, this page contains special metaboxes: listing categories, listing locations, content fields, media metabox with forms for images uploading and YouTube videos embedding, ratings stats, contact email field, claim options metabox.
		
		Each directory listing has special metabox on its administration page:
		
		<img src="[base_url]/wp-content/uploads/2018/04/listing_info_metabox.png" alt="" class="alignnone size-full" />
		
		"<em>Listing Info</em>" metabox have some information fields: directory, chosen listing level, listing status, total clicks, sorting date and expiration date.
		
		<i class="fa fa-exclamation-triangle"></i> listing status is not the same thing as post status, listing status can be "<em>active</em>", "<em>expired</em>" or "<em>unpaid</em>". Post status can be "<em>published</em>", "<em>pending review</em>" or "<em>draft</em>".
		
		<img src="[base_url]/wp-content/uploads/listing_row_admin.png" alt="administration_listing_row" class="alignnone size-full" />
		
		Listing row on "<em>Directory listings</em>" page and "<em>Listing Info</em>" metabox have "<em>raise up listing</em>" and "<em>renew listing</em>" links. Clicking on level link opens a form to change listing level. Description of these options below:
		
		<h3 id="listings_raiseup">Raise up listing option</h3>
		
		This option displays when current listing is active and <a href="[base_url]/documentation/listings-levels/">listings level</a> of this listing has "<em>Ability to raise up listings</em>" enabled setting.
		
		This feature will raise up a listing to the top of all lists, those ordered by date. After raise up a listing becomes higher than all other listings. Actually when listings are sorted by date - they are sorted by "Sorting date" (look at the screenshot above), and not by creation date. But just after listing creation these dates are the same. Also raise up will be processed just after listing renewal. More information about <a href="[base_url]/documentation/sorting/">sorting</a>.
		
		<i class="fa fa-star"></i> This feature can be <a href="[base_url]/documentation/payments/">payment</a>. Site owner can charge for raise up option a separate from activation price. When payments addon enabled - listings level has "<em>Listings raise up price</em>" setting.
		
		<h3 id="listings_renew">Renew listing option</h3>
		
		This option displays when <a href="[base_url]/documentation/listings-levels/">listings level</a> of current listing has not enabled "<em>Eternal active period</em>" setting and current listing is under "<em>expired</em>" status. This feature processes directory listing renewal. After renew process was completed successfully the listing status becomes "<em>active</em>" and the system sets new expiration date. Also this function raises up the listing to the top of all lists, those ordered by date.
		
		<i class="fa fa-star"></i> This feature can be <a href="[base_url]/documentation/payments/">payment</a>. Renewal price is the price for listing activation. Site admin can build such business model, when after expiration of listing of free level it will be suspended and moved to payment level. There is such setting in listings levels. So it is some kind of trial period, users will have to pay after free period to renew their listings.
		
		<h3 id="listings_upgrade">Listings upgrade</h3>
		Upgrade of listings means switching from one listings level to another. By default users have ability to change levels of their existing listings. There are some rules listings will follow after upgrade:
		<ul>
			<li>Switching from free to payment level requires payment before listing will become active.</li>
			<li>Switching to free level will activate listing immediately.</li>
			<li>When new level has an option of limited active period - expiration date of a listing will be recalculated automatically: current time + active period</li>
		</ul>
		
		<em>"Directory Admin -> Listings upgrade"</em> page contains following table with "level-to-level" options:
		
		<img src="[base_url]/wp-content/uploads/2013/12/listings_upgrade-1.png" alt="listings_upgrade" class="alignnone size-full" />
		
		It is possible to disable levels upgrade/downgrade from a certain level. By default all levels enabled for level change. Also after successful upgrade listing may be raised up.
		
		<i class="fa fa-star"></i> This feature can be <a href="[base_url]/documentation/payments/">payment</a>. Price fields in the table appear when payments addon was enabled. When this service is not free - successful upgrade means when invoice was completed and paid. Before payment a listing would be staying on the old level.
		
		<i class="fa fa-exclamation-triangle"></i> Administrators and editors users roles still can change disabled listings levels.
	</div>
		
'
);

?>