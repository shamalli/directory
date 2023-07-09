<?php

return array(
	'title' => 'Social Sharing',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="social_tab">Social Sharing</h2>
		
		This settings tab places on "<em>Directory Admin -> Directory settings</em>" page on the <em>"Social Sharing"</em> settings tab.
		
		<img class="alignnone size-full" src="[base_url]/wp-content/uploads/2013/12/social_buttons.png" alt="social_buttons" />
		
		<strong>Buttons style</strong> - there are 3 sets of buttons, image files place in subfolders of <em>"resources/images/social/"</em>.
		
		<strong>Include and order buttons</strong> - choose which social sharing services you need and order their buttons.
		
		<strong>Enable counter</strong> - enable/disable counter near social sharing buttons. Note, that enabled counter takes some time to load social sharing block on the page.
		
		<strong>Buttons place</strong> - some possible places for social sharing block on the page.
		
		<strong>Social buttons width</strong> - this setting controls the size of buttons.
		
		<i class="fa fa-exclamation-triangle"></i> Note, when <a href="[base_url]/documentation/settings/advanced/#miscellaneous">Imitation mode</a> enabled - 3rd party social sharing plugins and SEO plugins like <a href="[base_url]/documentation/search-engined-optiomization/">Yost SEO plugin</a> aren\'t able to share single listings pages, so instead you have to use these built-in social sharing buttons.
		
		<i class="fa fa-exclamation-triangle"></i> Problems with Facebook sharing: for sharing in Facebook any page must contain some special meta tags in HTML source code. For correct sharing the directory plugin inserts own meta tags on single listings pages. But another plugins (or themes in some cases) can add own meta tags as well. This may cause s conflict and sharing issues.
		
		<img src="[base_url]/wp-content/uploads/social_sharing_settings.png" alt="" class="alignnone size-full" />
	</div>
	
'
);

?>