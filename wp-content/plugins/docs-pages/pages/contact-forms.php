<?php

return array(
	'title' => 'Contact Forms',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="contact_forms">Contact Forms</h2>
		The plugin has own default contact form and has ability to integrate contact form of the <a href="https://wordpress.org/plugins/contact-form-7/" target="_blank" rel="noopener noreferrer">Contact Form 7 plugin</a>
	
		At the "Listings" settings tab admin can fill in Contact Form 7 shortcode setting like <strong>&#091;contact-form-7 id="6900" title="Contact form 1"&#093;</strong>
	
		<img src="[base_url]/wp-content/uploads/contact_forms_settings.png" alt="" class="alignnone size-full" />
		
		By default contact email will be sent to email entered in user profile:
		<img src="[base_url]/wp-content/uploads/user_profile_email.png" alt="" class="alignnone size-full" />
	
		<em>"Allow custom contact emails"</em> setting enables special metabox on listing edition where user can enter specific contact email. Otherwise email will be send to user email.
	
		<img src="[base_url]/wp-content/uploads/custom_email_metabox.png" alt="" class="alignnone size-full" />
	
		<hr />
	
		See example CF7 form at the screenshot. "To" field is not required as an email will be sent to email address of a listing owner. 
	
		<img src="[base_url]/wp-content/uploads/contact_form7.png" alt="" class="alignnone size-full" />
	
		<i class="fa fa-star"></i> <strong>&#091;webdirectory-listing-contact&#093;</strong> shortcode controls contact form on a <a href="[base_url]/documentation/single-listing-page/">single listing page</a>.
	</div>
	
'
);

?>