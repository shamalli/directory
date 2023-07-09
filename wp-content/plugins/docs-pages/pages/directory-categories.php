<?php

return array(
	'title' => 'Directory categories',
	'content' => '
		
		<div class="w2dc-docs w2dc-docs-side">
			<h2 id="directory_categories">Directory categories</h2>
			
			Site admin may create/edit/delete special categories items. Management of directory categories tree has exactly the same functionality as standard WordPress categories, but these are separate items and have special administration page "<em>Directory listings -&gt; Directory categories"</em>.
			
			<i class="fa fa-star"></i> Directory categories might have custom icons. Default icons files are placed in "<em>resources/images/categories_icons/</em>" folder of the plugin. Site administrator can upload custom icons into "<em>w2dc-plugin/resources/images/categories_icons/</em>" folder of your child theme using Files manager of hosting control panel or via FTP.
			<i class="fa fa-exclamation-triangle"></i> But the plugin can use only one folder for icons: native folder or custom folder in your child theme when exists.
			
			Using <a href="[base_url]/documentation/maps/markers-icons/">Font Awesome icons</a> it is possible to select specific marker icon and color for each category.
			
			<img src="[base_url]/wp-content/uploads/2018/04/category_icons.png" alt="" class="alignnone size-full" />
		
			<img src="[base_url]/wp-content/uploads/edit_category_term.png" alt="" class="alignnone size-full" />
			
			<strong>&#091;webdirectory-categories&#093;</strong> shortcode has a <a href="[base_url]/documentation/shortcodes/">bunch of parameters</a>. By default it allows to build nice looking table. Category image selected in category settings is used as a background of root categories.
			
			<img src="[base_url]/wp-content/uploads/2018/04/categories_table.png" alt="" class="alignnone size-full" />
			
			<i class="fa fa-star"></i> Additional content fields can be <a href="[base_url]/documentation/content-fields/">dependent from categories</a>. Admin configure specific fields to display when appropriate category was selected. By the way, content fields can be dependent from listings levels as well.
		</div>
'
);

?>