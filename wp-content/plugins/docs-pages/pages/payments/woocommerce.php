<?php

return array(
	'title' => 'WooCommerce',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="woocommerce">WooCommerce</h2>
		
		Web 2.0 Directory plugin system is compatible with WooCommerce. Let\'s list some advantages of using WooCommerce with Directory plugin. With WooCommerce payments system you can:
		<ul>
			<li>manage orders and products on WooCommerce dashboard</li>
			<li>set up additional payment gateways available as WooCommerce Extensions</li>
			<li><a href="[base_url]/documentation/payments/woocommerce-subscriptions/">WooCommerce Subscriptions plugin</a> partially is supported as well (<strong>ONLY</strong> allows to receive recurring payments for listings automatically, no trial periods, no signup fees)</li>
			<li>make scheduled sales - regular and sale prices, set up sale price dates</li>
			<li>guest checkout - allow customers to place orders without an account</li>
			<li>give users discount coupons</li>
			<li>manage fees and taxes for listings products</li>
			<li>build reports of sales</li>
			<li>give refunds to users</li>
			<li>realize lots of ideas for your business model with WooCommerce Extensions</li>
		</ul>
		
		Plugin extends WooCommerce product and adds new product type called "Directory listing". You can create listings plans in the same way as you add regular WooCommerce products. Please, read <a href="https://docs.woocommerce.com/documentation/plugins/woocommerce/getting-started/" target="_blank" rel="noopener noreferrer">WooCommerce documentation</a> on how to manage products and orders.
		
		<img src="[base_url]/wp-content/uploads/2018/04/woo_products.png" alt="" class="alignnone size-full" />
		
		<i class="fa fa-exclamation-triangle"></i> Directory listing products would not appear in the WooCommerce shop. The plugin just creates usual WooCommerce orders after listing submission, which user has to pay through installed WooCommerce payment gateways.
		
		<h3 id="woo_installation">How to configure</h3>
		<ol>
			<li>First of all <a href="https://wordpress.org/plugins/woocommerce/" target="_blank" rel="noopener noreferrer">WooCommerce plugin</a> must be installed.</li>
		
			<li>Web 2.0 Directory plugin Payments addon must be disabled in directory plugin settings (if you enabled it before).</li>
		
			<li><a href="[base_url]/documentation/frontend/">Frontend submission addon</a> must be enabled and pages with <strong>&#091;webdirectory-submit&#093;</strong> and <strong>&#091;webdirectory-dashboard&#093;</strong> shortcodes exist.</li>
		
			<li>Enable <em>"WooCommerce payments for the directory"</em> setting on <a href="[base_url]/documentation/settings/advanced/#woocommerce_settings">Advanced settings tab</a>.</li>
		
			<li>It is required to install 3 WooCommerce pages: my account, checkout and cart. Look at <em>"WooCommerce -> System Status -> Tools"</em>.</li>
		</ol>
		
		<i class="fa fa-star"></i> If you still do  not see new setting on Advanced settings tab - this means you made something wrong, double-check all instructions above, triple-check if needed...
		
		After the first activation of <em>"WooCommerce payments for the directory"</em> setting on Advanced settings tab the plugin will create new WooCommerce products according to existing listings levels. One "Directory listing" product for each existing listings level. Look through each product and set up prices.
		
		With "Directory listing" product you can set regular, sale prices and the value of raise up price. After that users have to pay WooCommerce orders for listings activation, renewal, raise up and upgrade. Separate order for each action.
		
		<i class="fa fa-star"></i> WooCommerce Subscriptions requires additional <a href="[base_url]/documentation/payments/woocommerce-subscriptions/">subscriptions plugin</a> installed.
	</div>
		
'
);

?>