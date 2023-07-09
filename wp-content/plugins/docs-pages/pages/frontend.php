<?php

return array(
	'title' => 'Frontend submission & dashboard',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="frontend_submission_dashboard">Frontend submission & dashboard</h2>
		
		These features become available when "<em>Frontend submission &amp; dashboard addon</em>" was enabled.
		
		Create new page with <strong>&#091;webdirectory-dashboard&#093;</strong> shortcode if you wish your logged in users to manage their listings, invoices and profile on the frontend dashboard page.
		
		"<em>Submit new listing</em>" button appears on front panel, clicking this button - users start the process of listing creation divided in some steps. Note, that the page with <strong>&#091;webdirectory-submit&#093;</strong> shortcode required.
		
		<i class="fa fa-exclamation-triangle"></i> Pages with <strong>&#091;webdirectory-submit&#093;</strong> and <strong>&#091;webdirectory-dashboard&#093;</strong> shortcodes should not have main directory page with <strong>&#091;webdirectory&#093;</strong> shortcode as parent, should not have child pages, they should be public, not private, not in trash. It is quite recommended to place them on own separate pages.
		
		<img src="[base_url]/wp-content/uploads/2018/04/submission_plans.png" alt="" width="1252" height="668" class="alignnone size-full wp-image-16941" />
		
		There are some settings for frontend submission addon on General settings tab.
		
		<img src="[base_url]/wp-content/uploads/frontend_submission_settings.png" />
		
		The process of listing submission divided in some steps, the number of submission steps varies according to different conditions: log in step may be missed if user was already logged in, payment step either doesn\'t required for free listings. Choose level page will be skipped when there are only one level. Also it depends on <em>"Hide choose level page"</em> setting.
		
		After successful submission new listing will be created and in case of payment listing user will be redirected to invoice page to select payment gateway. According to <em>"Enable pre-moderation of listings"</em> setting - listing post status will become: Pending Review or Published.
		
		<strong>Select frontend submission login mode</strong> -
		<ul>
			<li><strong>login required</strong> - logged in users have an ability to manage their listings, invoices and profile on the frontend dashboard page.</li>
		
			<li><strong>necessary to fill in user info form</strong> - user info form asks user to fill in his name and email fields. After successful submission Wordpress creates new user profile. If user with entered email already exists in the system - it isn\'t required to create new profile and listing will just be assigned with existed user. Later admin may manage and contact new user when needed. For new user registration email with automatically generated password will be sent.</li>
		
			<li><strong>not necessary to fill in user info form</strong> - the same behaviour as for previous option, but it is not required to enter contact info. For empty contact form the system creates anonymous user profile. Registration email will be sent only when user enters his email.</li>
		
			<li><strong>do not even show user info form</strong></strong> - Wordpress creates new anonymous user profile in the system, but no login information will be sent, just because there is no email to send.</li>
		</ul>
		<strong>Enable pre-moderation of listings</strong> - moderation will be required for all listings even after payment.
		
		<strong>Enable moderation after a listing was modified</strong> - with enabled moderation listing status become pending.
		
		<strong>Hide choose level page</strong> - when all <a href="[base_url]/documentation/listings-levels">listings levels</a> are similar and all have packages of listings, user do not need to choose level to submit when he already has a package, so you can enable this option. Choose level page will be skipped only when user is logged in and has available listings in his package.
		
		<strong>Enable submit listing button</strong> - show/hide submission button on directory pages. In some cases web developers can place own custom submission link or button somewhere else, for instance in main menu of a site. Also the page with <strong>&#091;webdirectory-submit&#093;</strong> shortcode is required to show this button.
		
		<strong>Hide top admin bar at the frontend for regular users</strong> - when this option enabled - regular user will never see backend of your site. It is recommended to enable when you have the page with <strong>&#091;webdirectory-dashboard&#093;</strong> shortcode.
		
		<strong>Allow users to manage own profile at the frontend dashboard</strong> - enable this option if you wish your users to manage own profile at the frontend dashboard page.
		
		<strong>Require Terms of Services on submission page?</strong> - select or create new WordPress page containing your TOS agreement and assign it using this setting.
		
		<strong>Use custom login page for listings submission process</strong> - when submission requires login - user has to login using default login form. But web developer can use 3rd party plugin to make custom login page and then assign it with submission process using this setting.
	</div>
'
);

?>