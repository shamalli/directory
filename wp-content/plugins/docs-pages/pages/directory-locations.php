<?php

return array(
	'title' => 'Directory locations',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="directory_locations">Directory locations</h2>
		
		<iframe width="912" height="600" src="https://www.youtube.com/embed/0jjGN7F_piM" title="Address & Locations search" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		
		There are 3 ways to provide locations functionality on directory site:
		<ol>
		<li>
				<strong>Use predefined locations</strong> - this way users are able to use <a href="#predefined_locations">previously defined locations</a> for their listings. Autocomplete on addresses fields and "Get my location" button on addresses fields should be disabled in <a href="[base_url]/documentation/settings/advanced/#miscellaneous">advanced settings</a>. So addresses fields will be used by users to manually fill in streets, buildings, postal codes, e.t.c. Visitors will search listings only by previously defined locations drop-down menu. Actually radius search is not necessary in this method.
		</li>
		<li>
			<strong>Use addresses fields</strong> - do not need to insert predefined locations. Users will use only addresses fields, <a href="[base_url]/documentation/settings/advanced/#miscellaneous">autocomplete function</a> and "Get my location" button on addresses fields can help them. Listings addresses fields (address line 1, address line 2, zip code) should contain whole information about country, state, city, region, streets, buildings, postal codes e.t.c. To get correct search results with nearby locations it is quite recommended to enable search by radius and set up default radius value in the <a href="[base_url]/documentation/search/">search forms</a>.
			<img src="[base_url]/wp-content/uploads/autocomplete_field.png" alt="" class="alignnone size-full" />
		</li>
		<li>
			<strong>Both methods</strong> <em>(default)</em> - usage of predefined locations + addresses fields. But in this case information in addresses fields may contain country, state, city, region, the same as selected predefined locations. It is recommended to exclude <a href="#locations_levels">locations levels</a> from address line.
		</li>
		</ol>
		
		<img src="[base_url]/wp-content/uploads/2018/04/locations_search_options.png" alt="" width="867" height="211" class="alignnone size-full wp-image-16790" />
		
		Some additional explanation about plugin\'s search engine and its fields <a href="[base_url]/documentation/search/">here</a>.
		
		<h3 id="predefined_locations">Predefined locations</h3>
		Site admin may create/edit/delete special predefined locations items. Management of directory locations tree has exactly the same functionality as standard WordPress categories, but these are separate items and have special administration page "<em>Directory listings -&gt; Directory locations</em>"
		
		<i class="fa fa-star"></i> Directory locations might have custom icons. Default icons files are placed in "<em>resources/images/locations_icons/</em>" folder of the plugin. Site administrator can upload custom icons into "<em>w2dc-plugin/resources/images/locations_icons/</em>" folder of your child theme using Files manager of hosting control panel or via FTP.
		<i class="fa fa-exclamation-triangle"></i> But the plugin can use only one folder for icons: native folder or custom folder in your child theme when exists.
		
		<img src="[base_url]/wp-content/uploads/2018/04/location_icons.png" alt="" class="alignnone size-full" />
		
		<img src="[base_url]/wp-content/uploads/edit_location_term.png" alt="" class="alignnone size-full" />
		
		<strong>&#091;webdirectory-locations&#093;</strong> shortcode has a <a href="[base_url]/documentation/shortcodes/">bunch of parameters</a>. By default it allows to build nice looking table. Location image selected in location settings is used as a background of root locations.
		
		<img src="[base_url]/wp-content/uploads/2018/04/locations_table.png" alt="" class="alignnone size-full" />
		
		After <a href="#locations_levels">locations levels</a> were successfully configured and locations tree completed - users may select any predefined location from select boxes group on create/edit listing page.
		
		<img src="[base_url]/wp-content/uploads/predefined_locations.png" />
		
		<i class="fa fa-star"></i> <a href="[base_url]/documentation/listings-levels/">Listings levels</a> have an option to allow users to select more than 1 location for each listing.
		
		<h3 id="locations_levels">Locations levels</h3>
		
		Just in some words, locations levels - these are names of nesting levels of directory locations tree. By default there are 3 locations levels: <strong>Country, State and City</strong>. Site admin can manage locations levels and exclude any of them from address strings. Also it is possible users can add new locations at the frontend submission form, "Add Country", "Add State" e.t.c. links appear below locations dropdowns.
		
		<em>"Directory Admin -> Locations levels"</em> page
		<img src="[base_url]/wp-content/uploads/locations_level.png" />
		
		When your maps site will be used locally, for example, for visitors from one country or one state/region - do not delete unnecessary locations levels and predefined locations, they are required to set correct location point at the Google map during listings creation/edition. You can just <u>exclude needed locations levels from address line</u> - there is <em>"In address line"</em> option for each locations level, it allows to build custom address line at the frontend. See examples:
		
		<img src="[base_url]/wp-content/uploads/locations_levels_addresses.png" />
		
		Also when you set up local maps site - it is recommended to fill in <em>"Default country/state for correct geocoding"</em> <a href="[base_url]/documentation/maps/">setting</a>.
	</div>
'
);

?>