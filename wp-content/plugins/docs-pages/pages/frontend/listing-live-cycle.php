<?php

return array(
	'title' => 'Listing live cycle',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="listing_live_cycle">Listing live cycle</h2>
		
		Listing submission starts on the choose level page. How to build choose level pages explained <a href="[base_url]/documentation/frontend/submit/">here</a>.
		
		<img src="[base_url]/wp-content/uploads/2018/04/submission_plans.png" />
		
		After successfull frontend submission listing gets one of the following statuses:
		<ol>
			<li><strong><em>unpaid - Pending payment</em></strong> - when listing requires payment</li>
			<li><strong><em>active - Pending approval</em></strong> - when enabled pre-moderation of listings (this setting is on General settings tab). Listing already might be paid.</li>
			<li><strong><em>active</em></strong> - when listing does not require payment and pre-moderation was not enabled. So listing becomes active and published automatically.
		
			<img src="[base_url]/wp-content/uploads/dashboard_statuses.png" />
			</li>
		
		<li><strong><em>expired</em></strong> status listing gets when active period of listing has ended. Listing has special option to renew, renewal can be payment for users.</li>
		</ol>
		
		Also <a href="[base_url]/documentation/listings-levels/">listings level</a> can be set up in a special way to change level after expiration automatically, there is <em>"Change level after expiration"</em> setting - after expiration listing will change level automatically. By default listings will just suspend.
		
		<i class="fa fa-star"></i> Site admin can build such business model, when after expiration of listing of free level it will be suspended and moved to payment level. So it is some kind of <u>trial period</u>, users will have to pay after free period to activate their listings again.
		
		Next step: when listing requires payment - after submission it redirects to invoice page at the <a href="[base_url]/documentation/frontend/">Frontend dashboard page</a>. A page with <strong>&#091;webdirectory-dashboard&#093;</strong> shortcode required.
		<img src="[base_url]/wp-content/uploads/invoice.png" />
	</div>
		
'
);

?>