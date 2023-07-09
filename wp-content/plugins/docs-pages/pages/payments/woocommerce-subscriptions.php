<?php

return array(
	'title' => 'WooCommerce Subscriptions',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="woocommerce_subscriptions">WooCommerce Subscriptions</h2>
		
		Subscriptions with WooCommerce <strong>ONLY</strong> allows to receive recurring payments for listings automatically, no trial periods, no signup fees.
		
		How to set up subscriptions:
		<ol>
			<li>Install and configure WooCommerce according to <a href="[base_url]/documentation/payments/woocommerce/">instructions</a></li>
			<li>Install <a href="https://woocommerce.com/products/woocommerce-subscriptions" rel="noopener noreferrer" target="_blank">WooCommerce Subscriptions plugin</a></li>
			<li>That is all. It will not create any new product types or anything else. Just pay for a listing in usual way.</li>
		</ol>
		
		After listing submission (or renewal) on the checkout page "enable subscription" checkbox will appear. You can find setting to make it checked by default on the <a href="[base_url]/documentation/settings/advanced/#woocommerce_settings">Advanced settings tab</a>.
		
		<img src="[base_url]/wp-content/uploads/woocommerce_subscription_checkout.png" />
		
		After successfull payment the system will create new subscription. Users manage scubscription on their account page, in the same way as other orders. At the backend manage listings subscriptions items in the same way <a href="https://docs.woocommerce.com/documentation/plugins/woocommerce/woocommerce-extensions/woocommerce-subscriptions/" rel="noopener noreferrer" target="_blank">as any other subscriptions</a>.
		<img src="[base_url]/wp-content/uploads/woocommerce_subscription_management.png" />
		
		Subscriptions available only for <span style="text-decoration: underline;">listings, those do not have eternal (unlimited) active period</span>. Subscription period becomes equal to active period of the listing.
	</div>
'
);

?>