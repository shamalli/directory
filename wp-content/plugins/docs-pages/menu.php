<?php

$menu_out = '
<div class="w2dc-theme-sticky">
	<h4 class="w2dc-table-of-contents-heading">Table of Contents</h4>
	<ul class="w2dc-table-of-contents">
		<li><a href="[base_url]/documentation/">Installation</a>
			<ul>
				<li><a href="[base_url]/documentation/demo-content/">Demo data import</a></li>
				<li><a href="[base_url]/documentation/update/">Plugin update</a></li>
				<li><a href="[base_url]/documentation/update-from-free/">Update from free version</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/shortcodes/">Shortcodes</a></li>
		<li><a href="[base_url]/documentation/directory-listings/">Listings management</a>
			<ul>
				<li><a href="[base_url]/documentation/listings-directories/">Multi-Directory site</a></li>
				<li><a href="[base_url]/documentation/listings-levels/">Listings levels</a></li>
				<li><a href="[base_url]/documentation/directory-categories/">Directory categories</a></li>
				<li><a href="[base_url]/documentation/directory-locations/">Directory locations</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/maps/">Maps management</a>
			<ul>
				<li><a href="[base_url]/documentation/maps/google-maps-keys/">Google API keys</a></li>
				<li><a href="[base_url]/documentation/maps/mapbox/">MapBox (OpenStreetMap)</a></li>
				<li><a href="[base_url]/documentation/maps/markers-icons/">Map markers & InfoWindow</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/settings/">Directory settings</a>
			<ul>
				<li><a href="[base_url]/documentation/settings/slugs-permalinks/">Titles, Slugs & Permalinks</a></li>
				<li><a href="[base_url]/documentation/settings/listings/">Listings settings</a></li>
				<li><a href="[base_url]/documentation/settings/listings-logos-images/">Listings logos & images</a></li>
				<li><a href="[base_url]/documentation/settings/pages-views/">Pages & views</a></li>
				<li><a href="[base_url]/documentation/settings/email-notifications/">Email notifications</a></li>
				<li><a href="[base_url]/documentation/settings/advanced/">Advanced settings</a></li>
				<li><a href="[base_url]/documentation/settings/customization/">Customization settings</a></li>
				<li><a href="[base_url]/documentation/settings/social/">Social Sharing</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/content-fields/">Content fields</a></li>
		<li><a href="[base_url]/documentation/claim/">Claim Functionality</a></li>
		<li><a href="[base_url]/documentation/search-engines-optimization/">SEO and Meta information</a></li>
		<li><a href="[base_url]/documentation/contact-forms/">Contact Forms</a></li>
		<li><a href="[base_url]/documentation/search/">Search forms</a></li>
		<li><a href="[base_url]/documentation/sorting/">Sorting of listings</a></li>
		<li><a href="[base_url]/documentation/pages/">Custom pages</a>
			<ul>
				<li><a href="[base_url]/documentation/pages/custom-home/">Custom Home pages</a></li>
				<li><a href="[base_url]/documentation/pages/single-listing-page/">Single Listing page</a></li>
				<li><a href="[base_url]/documentation/pages/elementor/">Building with Elementor</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/frontend/">Frontend submission & dashboard</a>
			<ul>
				<li><a href="[base_url]/documentation/frontend/submit/">Listings Submission</a></li>
				<li><a href="[base_url]/documentation/frontend/listing-live-cycle/">Listing live cycle</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/payments/">Payments</a>
			<ul>
				<li><a href="[base_url]/documentation/payments/woocommerce/">WooCommerce</a></li>
				<li><a href="[base_url]/documentation/payments/woocommerce-subscriptions/">WooCommerce Subscriptions</a></li>
			</ul>
		</li>
		<li><a href="[base_url]/documentation/ratings-reviews-comments/">Ratings, comments and reviews</a></li>
		<li><a href="[base_url]/documentation/directory-widgets/">Directory widgets</a></li>
		<li><a href="[base_url]/documentation/customization/">Customization styles & templates</a></li>
		<li><a href="[base_url]/documentation/change-texts/">How to modify texts</a></li>
		<li><a href="[base_url]/documentation/translation/">Translation</a></li>
		<li><a href="[base_url]/documentation/import/">CSV Import</a></li>
		<li><a href="[base_url]/documentation/troubleshooting/">Troubleshooting</a></li>
	</ul>
</div>';

		
$search_term = '';

if (isset($_GET['search'])) {
	if ($search_term = sanitize_text_field($_GET['search'])) {
		$search_term = stripslashes($search_term);
	}
} elseif (isset($_GET['highlight'])) {
	if ($search_term = sanitize_text_field($_GET['highlight'])) {
		$search_term = stripslashes($search_term);
	}
}
		
$search_form = '<div class="wcsearch-content w2dc-docs-search-input">
<form>
<div class="wcsearch-has-feedback">
<input name="search" value="' . esc_attr($search_term) . '" placeholder="Search..." class="wcsearch-form-control"><span class="wcsearch-form-control-feedback wcsearch-fa wcsearch-fa-search"></span>
</div>
</form>
</div>';
		
$menu_out = $search_form . $menu_out; 

return $menu_out;
		
?>