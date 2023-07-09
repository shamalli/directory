<?php

return array(
	'title' => 'Payments',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="payments_system">Payments system</h2>
		
		This option becomes available only when Payments addon was enabled. Instead of plugin\'s payments addon you may use <a href="[base_url]/documentation/payments/woocommerce/">WooCommerce payments system</a> with all its advantages.
		
		<i class="fa fa-exclamation-triangle"></i> When listing requires payment - after submission it redirects to invoice page at the <a href="[base_url]/documentation/frontend/">Frontend dashboard</a> page. <strong>This requires Frontend submission & dashboard addon to be enabled and a page with &#091;webdirectory-dashboard&#093; shortcode must be created.</strong>
		
		<i class="fa fa-exclamation-triangle"></i> Only registered and logged in users can pay invoice.
		
		After activation of Payments addon - on directory settings page <a href="[base_url]/documentation/payments/#payments_settings">Payments settings</a> tab will appear with payments settings.
		
		Invoices management page appears at the backend. Through the frontend dashboard page authors have access only to their own invoices, administrators have permissions to manage any invoices at the backend.
		
		<img src="[base_url]/wp-content/uploads/directory_invoices.png" class="size-full" />
		
		Invoice log box contains information about payment transactions including failed transactions. Look at invoice log to get more information when payment on PayPal/Stripe side completed, but invoice still has <em>"unpaid"</em> status.
		Each invoice has one of following statuses: <em>"unpaid"</em>, <em>"pending"</em> or <em>"paid"</em>. Invoice item - is an object to which this invoice belongs to.
		
		There are 5 types of payment services:
		<ul>
			<li><strong>listings activation</strong> - this type of service available for subscription and one time payment. After successful payment the listing status becomes <em>"active"</em> and displays at the frontend.</li>
			<li><strong>listings renewal</strong> - this type of service available for subscription and one time payment. This feature processes directory listing renewal. After renew process was completed successfully the listing status becomes <em>"active"</em> and the system sets new expiration date.</li>
			<li><strong>listings raise up</strong> - this is the service for one time payment. This feature will raise up the listing to the top of all lists, those ordered by date. For more information look at the <a href="[base_url]/documentation/sorting-of-listings/">sorting section</a>.</li>
			<li><strong>listings upgrade</strong> - this is one time payment service. Charge users if they wish to upgrade their simple listings to featured or sticky.</li>
			<li><strong>listings claim</strong> - after successful approval of claim new owner need to pay to renew the listing.</li>
		</ul>
		
		Users are allowed to process some actions with invoices, such as print invoice with all assigned information or reset selected gateway. Also there is special action button "<em>Set as paid</em>" only for administrators. This allows to set up invoice status as paid manually and processes further actions. Usually this needed to complete invoices with chosen <em>"Bank transfer"</em> payment gateway.
		
		<img src="[base_url]/wp-content/uploads/2013/12/payment_gateways.png" />
		
		Available payment gateways:
		<ul>
			<li><strong>PayPal</strong> - this method for one time payment.</li>
			<li><strong>PayPal subscription</strong> - users may use this method to process automatic recurring payments. Look at additional information below.</li>
			<li><strong>Stripe</strong> - a beautiful, optimized, cross-device, payment form. Stripe subscriptions option is not available.</li>
			<li><strong>Bank transfer</strong> - this is semi-automatic method of payment. User selects this method, prints invoice, transfers the payment to vendor, then when site administrator will receive payment - he will manually set invoice as paid by special action button "<em>Set as paid</em>".</li>
		</ul>
		
		<h4 id="paypal_subscriptions">PayPal Subscriptions</h4>
		Using this payment gateway directory listings owners do not need to prolong their ads each time they have been expired. They may choose to create subscription and pay automatically by recurring cycle. PayPal subscriptions available only for <span style="text-decoration: underline;">listings, those do not have eternal (unlimited) active period</span>. Subscription period becomes equal to active period of the listing.
		
		<i class="fa fa-exclamation-triangle"></i> PayPal single payment and PayPal subscriptions require enabled permalinks on WordPress "<em>Settings -&gt; Permalinks</em>" page.
		
		<hr />
		
		<h2 id="payments_settings">Payments settings</h2>
		
		This settings tab places on "<em>Directory Admin -> Directory settings</em>" page on the <em>"Payments settings"</em> tab.

		<i class="fa fa-exclamation-triangle"></i> This tab appears after activation of <a href="[base_url]/documentation/payments/">payments addon</a>.
		
		<i class="fa fa-star"></i> There is alternative payments system. You can use <a href="[base_url]/documentation/payments/woocommerce">WooCommerce payments</a>. It has lots of advantages and features based on WooCommerce plugin power.
		
		<h4 id="general_payments_settings">General payments setting</h4>
		
		<strong>Currency</strong> - the list of possible currencies used for payments.
		
		<i class="fa fa-exclamation-triangle"></i> Following settings are not related to price content fields. To see content fields settings - click on "<em>Configure</em>" link near <a href="[base_url]/documentation/content-fields">price content field</a>.
		
		<strong>Currency symbol or code</strong> - this symbol or code will appear on frontend/backend pages.
		
		<strong>Currency symbol or code position</strong> - choose preferred position of currency symbol/code.
		
		<strong>Decimal separator</strong> - decimal separator of price value, possible values: dot or comma.
		
		<strong>Hide decimals in levels price table</strong> - show/hide decimals (cents) on levels price table at the frontend.
		
		<strong>Thousands separator</strong> - the separator for thousands, millions, billions, ... Possible values: no separator, dot, comma or space.
		
		<h4 id="sales_tax">Sales tax</h4>
		
		<strong>Enable taxes</strong> - enable/disable taxes functionality.
		
		<strong>Selling company information</strong> - this information will appear on invoice page.
		
		<strong>Tax name</strong> - abbreviation, e.g. "VAT".
		
		<strong>Tax rate</strong> - insert tax rate in percents.
		
		<strong>Include or exclude value added taxes</strong> - do you want prices on the website to be quoted including or excluding value added taxes?
		<h4 id="bank_transfer">Bank transfer settings</h4>
		<strong>Allow bank transfer</strong> - allow users to select "<em>Bank transfer</em>" payment method.
		
		<strong>Bank transfer information</strong> - this information appear on print invoice page. Provide whole instructions and payment requisite.
		
		<h4 id="paypal_settings">PayPal settings</h4>
		
		<strong>Business email</strong> - PayPal merchant email.
		
		<strong>Allow single payment</strong> - when this option is checked - "<em>PayPal</em>" payment gateway available.
		
		<strong>Allow subscriptions</strong> - when this option is checked - "<em>PayPal subscription</em>" payment gateway available. Only for listings with limited active period.
		
		<strong>Test Sandbox mode</strong> - allows to test the process of payment using PayPal sandbox credentials. You must have a <a href="https://developer.paypal.com/" target="_blank" rel="noopener noreferrer">PayPal Sandbox</a> account setup before using this feature.
		
		<h4 id="stripe_settings">Stripe settings</h4>
		
		<strong>Test secret key</strong>
		
		<strong>Test publishable key</strong>
		
		<strong>Live secret key</strong>
		
		<strong>Live publishable key</strong>
		
		The publishable key is used to generate credit card tokens and should be included with the HTML form. The secret key is used for all other API calls on the server-side.
		
		<strong>Test Sandbox mode</strong> - Before activating your account, you can only interact with <a href="https://www.stripe.com" target="_blank" rel="noopener noreferrer">Stripe</a> in test mode. With the exception of the ability to make a real charge to a credit card, all of Stripe\'s features are available in test mode.
		
		<img src="[base_url]/wp-content/uploads/payments_settings.png" />
	</div>
	
'
);

?>