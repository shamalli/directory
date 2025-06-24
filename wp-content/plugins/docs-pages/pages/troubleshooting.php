<?php

return array(
	'title' => 'Troubleshooting',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="troubleshooting">Troubleshooting</h2>
		
		<i class="fa fa-star"></i> Before troubleshooting clear cache of your browser and cache on your site, if any caching system is used. Temporarily disable all caching plugins and systems.
		
		Most of issues with the directory plugin are caused by wrong configuration in directory settings, so the best solution is to look through directory settings and set up them correctly. Another issues can be easily fixed by following below instructions.
		
		The plugin follows WordPress coding standards and compatible with all themes and plugins, those follow the same standards. But in some cases problems might be caused by a conflict with your theme or another plugin. The very first step to find the reason of this conflict is to test your site with another theme and/or disable all plugins one by one. If you are not able to change your WP theme or disable conflicting plugin, then you can try to find a setting related to current problem, that can fix it.
		
		<h3 id="critical_error">Critical error message</h3>
		
		<img src="[base_url]/wp-content/uploads/critical_error.png" />
		
		In order to diagnose the problem and get more information about this issue you need to find PHP errors log file on your site. Usually it is placed in <em>"public_html/logs/"</em> folder on your host, but can be found in hosting control panel. To get exact path to the file, please ask your hoster support.
		
		<hr />
		
		<h3 id="troubleshooting_plugin">Health Check and Troubleshooting Plugin</h3>
		
		Sometimes Web 2.0 Directory plugin can conflict with other plugins or themes. In order to troubleshoot if the issue relate to our plugin there is quite easy way - you can use Health Check and Troubleshooting Plugin.
		
		<a href="https://wordpress.org/plugins/health-check/" target="_blank">Health Check and Troubleshooting Plugin</a> allows you to have a clean WordPress session, where all plugins are disabled, and a default theme is used, but only for your user until you disable it or log out.
		
		<img src="[base_url]/wp-content/uploads/troubleshooting_plugin.png" />
		
		<ol>
			<li>Download and active <strong>Health Check and Troubleshooting Plugin</strong>.</li>
			<li>Navigate to <em>"Tools -> Site Health"</em> page.</li>
			<li>Click on the <em>"Troubleshooting"</em> tab, check the warning information, and hit <em>"Enter Troubleshooting Mode"</em>. Any changes you make don\'t take effect for the non-admin users, users will continue using the site just like the way they were using it. </li>
			<li>Enable Web 2.0 Directory plugin
			<img src="[base_url]/wp-content/uploads/troubleshooting_enable_w2dc.png" /></li>
			<li>If the issue still persists this means it comes from Directory plugin - please contact us and explain the issue, we will try to help you to fix it.</li>
			<li>But if you do not encounter any issue anymore, then try to investigate further to find the reason of the problem. On WordPress plugins page you can click <em>"Enable while troubleshooting"</em> near each plugin step by step.</li>
		</ol>
		
		<hr />
		
		<h3 id="directory_shortcode_problems">Problems with directories or listings pages</h3>
		
		Exemplary symptoms: 404 errors on pages. Categories, locations or listings pages just refreshes. 
		
		This could be caused by missing <strong>&#091;webdirectory&#093;</strong> shortcode. It is required shortcode. Create a page with this shortcode in the description. This page must not have child pages, it must be public, not private, not in trash.
		
		If you are using some kind of page builder, then make sure it processes shortcodes in the same way as it processes in the native Wordpress page description. Some builders have own special modules/elements to place shortcodes. We recommend to use <a href="[base_url]/documentation/pages/elementor/"><strong>Elementor</strong></a>, <strong>SiteOrigin page builder</strong> and <strong>WP Bakery Visual Composer</strong>.
		
		<i class="fa fa-exclamation-triangle"></i> Special attention to <a href="[base_url]/documentation/listings-directories">directory slugs</a>. Slugs must contain only alpha-numeric characters, underscores or dashes. All slugs must be unique and different.
		
		<hr />
		
		<h3 id="maps_problems">Problems with the radius search, maps, address fields autocomplete</h3>
		
		The most frequent reason is Google API keys. Please follow instructions on how to <a href="[base_url]/documentation/google-maps-keys">generate them</a> and enable needed APIs in Google console. 
		
		<i class="fa fa-exclamation-triangle"></i> To test server API key you can visit debug page and check geolocation response. Debug page is placed on your site by similar URL <strong>http://www.yoursite.com/wp-admin/admin.php?page=w2dc_debug</strong>
		
		<iframe width="912" height="600" src="https://www.youtube.com/embed/0G5Hmo8gG-w" title="Troubleshooting Google API keys" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		
		<hr />
		
		<h3 id="styles_problems">The page does not load plugin styles and scripts, errors in JS console</h3>
		
		This could be when using shortcodes in page builders like Divi builder or Oxygen builder, or built-in theme elements which can process shortcodes. Plugin shortcode was processed, but too late, so the page does not load required styles and scripts at the top of the page. 
		
		You have to enable <em>"Include directory JS and CSS files on all pages"</em> option at the <a href="[base_url]/documentation/settings/advanced/">Advanced settings tab</a>.
		
		<hr />
		
		<h3 id="emails_problems">Problems with emails sending</h3>
		
		Exemplary symptoms: users do not receive login details after first submission. Users do not receive notification emails. Admin does not receive notification emails. Emails go to spam folder.
		
		First of all check if needed notifications templates are filled in and not empty on <a href="[base_url]/documentation/settings/email-notifications/">emails notifications</a> settings tab.
		
		If notifications templates are filled in, but you still have problems with emails sending, this means, that your mail server on your site has wrong configuration. Try to install and configure SMTP plugin like this one <a href="https://wordpress.org/plugins/wp-mail-smtp/" rel="noopener noreferrer" target="_blank">WP Mail SMTP plugin</a>.
		
		<hr />
		
		<h3 id="listings_page">I want a separate page for listings. Remove all other texts and elements from listings pages.</h3>
		Create new page with <strong>&#091;webdirectory-listing-page&#093;</strong> shortcode to build separate page for single listings. Especially when you are building custom home page, so there will not be any other directory elements like on the home page.
		
		<hr />
		
		<h3 id="webdirectory_page">How to remove \'web-2-0-directory\' slug from URL?</h3>
		By default new page with <strong>&#091;webdirectory&#093;</strong> shortcode has a URL like http://www.yoursite.com/web-2-0-directory/. In order to remove \'web-2-0-directory\' part from address - select this page as home page in WordPress Settings -> Reading settings.
		
		<hr />
		
		<h3 id="expiration_problems">Listings never expire</h3>
		<strong>Exemplary symptoms:</strong> you\'ve set up listing level with limited active period. Expiration date has passed, but listings still active. This means scheduled events function does not work on your WordPress for some reason.
		
		First of all try to deactivate and then reactivate the plugin (you\'ll not lose any information). If this will not help - download and install <a href="https://wordpress.org/plugins/wp-crontrol/" rel="noopener noreferrer" target="_blank">WP Crontrol plugin</a>, it should show "scheduled_events" in the list of Cron Events.
		
		<hr />
		
		<h3 id="update">Can not update the plugin</h3>
		
		<strong>Exemplary symptoms:</strong> WordPress updater says something like "Update Failed: Update package not available".
		
		Check your <a href="[base_url]/documentation/">purchase code</a> received after purchase. Otherwise you can update manually as explained <a href="[base_url]/documentation/update/">here</a>.
		
		<hr />
		
		<h3 id="translation">Translation problems</h3>
		<strong>Question:</strong> I have made everything as you explained in <a href="[base_url]/documentation/translation/" target="_blank" rel="noopener noreferrer">translation instructions</a>, but it does want to take my translation file.
		
		<strong>Answer:</strong> Double check everything you\'ve made step by step. Special attention to the name of translation files and paths where you place them.
		There is no problem at the plugin\'s side. The plugin uses translation files in exactly the same way any other WordPress plugin does.
		
		<strong>Question:</strong> I have translated all strings from the w2dc.pot file, but it still shows some untranslated texts at the frontend, like address, phone, website, country, e.t.c.
		
		<strong>Answer:</strong> These are names of content fields. It is user-generated content, you should translate these strings at the admin dashboard at the directory management pages (Directory Admin -> Content fields, Directory Admin -> Locations levels, Directory Admin -> Listings levels)
		
		<hr />
		
		<h3 id="facebook_sharing_problems">Problems with Facebook sharing</h3>
		For sharing in Facebook any page must contain some special meta tags in its HTML source code. For correct sharing directory plugin inserts own meta tags on single listings pages. But another plugins (or themes in some cases) can add own meta tags as well. This may cause sharing issues.
		
		Try to find this conflicting plugin and/or a setting to switch off adding meta tags for Facebook. This is the only solution.
		
		<hr />
		
		<h3 id="registration">How to register?</h3>
		<strong>Question:</strong> There is only login form. I do not see how users can register at the site to submit or claim a listing. Where is registration form?
		
		<strong>Answer:</strong> This is because you disabled registration in WordPress settings of your site. Check "Anyone can register" option on the WordPress Settings -> General page. Registration link will appear below the login form.
		
		<hr />
		
		<h3 id="javascript_errors">Errors in javascript console of the browser</h3>
		Javascript errors could break different parts of functionality of the plugin: images gallery, radius slider, content fields, search forms and so on. To see errors <strong>open browser console by pressing F12 and refresh the page</strong>.
		Usually javascript errors could be caused by 3rd party plugins or installed theme. Sometimes another plugin or your theme tries to "format" the output of directory plugin, this also can give odd behaviour due to unnecessary tags in page markup, like paragraphs, divs or spans tags. The only way to fix this - to look through plugins/theme settings and find an option to disable "formatting".
		
		<img src="[base_url]/wp-content/uploads/javascript_errors.png" />
	</div>
	
'
);

?>