<?php

return array(
	'title' => 'Customization styles and templates',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="customization">Customization styles and templates</h2>
		
		The customization of the directory does require some experience in HTML, CSS and even PHP to change the templates around to an arbitrary theme look. Plugin\'s styles and templates are designed to work relatively well with most themes, but if you do have the need to modify any template and add or remove styles - try to follow these conditions:
		<ul>
			<li>Create new folder in your child theme <em>"w2dc-plugin/"</em>. You will place custom files in this folder.</li>
		
			<li>If you want to change the layout or styles of directory section on your site do not modify existing CSS files, instead create new file and give it exactly the same name, just add <strong>-custom</strong> postfix to the end of name before file\'s extension. For example, <em>resources/css/frontend.css</em> file from the plugin folder must have following name and placed into <em>w2dc-plugin/resources/css/frontend-custom.css</em> folder of your child theme. Using this method will save your modifications and custom code during further updates.</li>
		
			<li>The same convention for any templates - .tpl files in <em>templates/</em> folder. For example, custom <em>templates/frontend/index.tpl.php</em> template must have following name and placed into <em>w2dc-plugin/templates/frontend/index-custom.tpl.php</em> folder of your child theme.
		
			<i class="fa fa-exclamation-triangle"></i> Relative path of custom file in your child theme <em>"w2dc-plugin/"</em> folder must be exactly the same as the path of original file. <em>resources/css/</em> will be <em>w2dc-plugin/resources/css/</em>, and <em>templates/frontend/</em> will be
			<em>w2dc-plugin/templates/frontend/</em>.
		
			Templates of addons place in own folders. For example, <em>addons/w2dc_fsubmit/templates/</em> will be <em>w2dc-plugin/templates/w2dc_fsubmit/</em> in your child theme.</li>
		
			<li>Other part of customization is that you can manage <a href="[base_url]/documentation/directory-categories">categories icons</a>, <a href="[base_url]/documentation/directory-locations">locations icons</a> and <a href="[base_url]/documentation/settings/maps-addresses/#map_infowindow_settings">map markers icons</a>.
		
			Custom icons files place in the same way as CSS and templates, in your child theme <em>"w2dc-plugin/"</em> folder.
		
			<em>w2dc-plugin/resources/images/categories_icons/</em>, <em>w2dc-plugin/resources/images/locations_icons/</em>, <em>w2dc-plugin/resources/images/map_icons/</em> folders for categories icons, locations icons and map markers icons accordingly.
		
			This is the structure of folders with custom resources and templates:
			<img src="[base_url]/wp-content/uploads/custom_files_structure.png" />
			</li>
		
			<li>Inside <em>resources/sass/</em> folder the plugin contains SASS files for the frontend and backend parts including RTL styles.</li>
		</ul>
		
		The directory has special customization settings to change some elements on frontend pages like links and buttons colors, background of the search form, primary and secondary colors, jQuery UI style.
	</div>
	
'
);

?>