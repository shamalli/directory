<?php

return array(
	'title' => 'Advanced settings',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="advanced_tab">Advanced settings</h2>
		
		This settings tab places on "<em>Directory Admin -> Directory settings</em>" page on the <em>"Advanced settings"</em> tab.
		
		<h4 id="javascript_settings">JavaScript &amp; CSS</h4>
		
		<img src="[base_url]/wp-content/uploads/advanced_js_css_settings.png" alt="" class="alignnone size-full" />
		
		<strong>Include directory JS and CSS files on all pages</strong> - sometimes it is required to enable this option.
		
		<strong>Enable lightbox slideshow</strong> - this adds functionality to watch listings images as full size animated slideshow. Also may be disabled in order to avoid conflicts with other javascript slideshow plugins.
		
		<strong>Do not include jQuery UI CSS</strong> - some themes and 3rd party plugins include own jQuery UI CSS - this may cause conflicts in styles.
		
		<hr />
		
		<h4 id="miscellaneous">Miscellaneous settings</h4>
		
		<img src="[base_url]/wp-content/uploads/advanced_miscellaneous_settings.png" alt="" class="alignnone size-full" />
		
		<strong>Enable imitation mode</strong> - explanation about <em>"Imitation mode"</em> feature:
		
		<ul>
			<li>When Imitation mode enabled - the plugin uses a page with <strong>&#091;webdirectory&#093;</strong> shortcode for all directory pages, in this case WordPress routing system, <a href="[base_url]/documentation/search-engines-optimization/">Yoast SEO plugin</a> and other plugins interpret all pages as a page object, not real categories, locations, listings.</li>

			<li>Disabled Imitation mode (<strong>quite recommended</strong>) allows to interpret directory pages as it should be: categories/locations/tags pages as real categories/locations/tags (taxonomy) pages, and listings pages as real single post pages.</li>

			<li>You can see <em>"Edit page"</em> or <em>"Edit category"</em> links at the top admin menu when visit directory categories.
			
			<strong>Imitation mode enabled</strong>
			<img src="[base_url]/wp-content/uploads/imitation_mode_bar_enabled.png" alt="" class="alignnone size-full" />
			<strong>Imitation mode disabled</strong>
			<img src="[base_url]/wp-content/uploads/imitation_mode_bar_disabled.png" alt="" class="alignnone size-full" />
			This means that page uses "categories/taxonomy" features, it is not a "page" as when you are using Imitation mode. And we are able to render content of a custom home page.
			But some themes require imitation mode to get working listings/categories/locations/tags pages.
		
			<i class="fa fa-exclamation-triangle"></i> Please note, that <a href="[base_url]/documentation/search-engines-optimization/">Yoast SEO plugin</a> requires Imiatation mode to be <u>switched off</u>.
			</li>
		</ul>
		
		<strong>Overwrite WordPress page title by directory page title</strong> - some themes do not allow this or may cause issues.
		
		<strong>Prevent users to see media items of another users</strong> - by default WordPress allows users to manage ANY attachments owned by other users at the backend dashboard panel. This option prevent such behaviour.
		
		<strong>Enable autocomplete on addresses fields</strong> - helps to enter address and location into Address line fields and search address inputs.
		
		<strong>Enable "Get my location" button on addresses fields</strong> - enable/disable geolocation button on addresses fields. Requires HTTPS.
		
		<hr />
		
		<h4 id="recaptcha_settings">reCaptcha settings</h4>
		
		<img src="[base_url]/wp-content/uploads/advanced_recaptcha_settings.png" alt="" class="alignnone size-full" />
		
		reCaptcha is used on contact listing owner forms and frontend submission form. You may get your reCAPTCHA API Keys <a href="https://www.google.com/recaptcha" target="_blank" rel="noopener noreferrer">here</a>
		
		<strong>What is the difference between reCAPTCHA v2 and v3?</strong>
		ReCAPTCHA v2 requires the user to click the "I\'m not a robot" checkbox and can serve the user an image recognition challenge. ReCAPTCHA v3 runs in the background and generates a score based on a user\'s behavior. The higher the score, the more likely the user is human. A webmaster has to decide (and program) whether to block, challenge, or do nothing when a user\'s score drops below a certain threshold.
		
		<strong>Is reCAPTCHA v3 better than v2?</strong>
		Neither of them is good at blocking bots. While reCAPTCHA v3 is less obsessive than v2 for a user, it places a significant burden on the webmaster to determine when to let users through and when to block or challenge them. There\'s no right answer to this.
		
		<hr />
		
		<h4 id="woocommerce_settings">Woocommerce settings</h4>
		
		<img src="[base_url]/wp-content/uploads/advanced_woocommerce_settings.png" alt="" class="alignnone size-full" />
		
		This section appears when WooCommerce plugin is active and directory plugin <a href="[base_url]/documentation/payments/">payments addon</a> disabled. Additional information you can find in <a href="[base_url]/documentation/payments/woocommerce/">WooCommerce section</a>.
		
		<strong>WooCommerce payments for the directory</strong> - enable this option to use Woocommerce payment system along with Web 2.0 Directory plugin.
		
		<strong>On checkout page subscription enabled by default</strong> - the setting for WooCommerce Subscriptions plugin. With WooCommerce Subscriptions plugin installed - directory would be able to create subscriptions for listings with limited active period (not eternal listings) to charge users for their listings through some period of time, e.g. daily, monthly, annually. By default on checkout page "enable subscription" empty checkbox appears, with enabled setting, this checkbox will be checked.
		<img src="[base_url]/wp-content/uploads/woocommerce_subscription_checkout.png" alt="" class="alignnone size-full" />
	</div>
	
'
);

?>