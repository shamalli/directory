<?php

return array(
	'title' => 'Shortcodes',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<i class="fa fa-exclamation-triangle"></i> Any WordPress string parameters should be wrapped in quotes (Example: order_by=\'post_date\')
		
		<h3><strong>&#091;webdirectory&#093;</strong></h3>
		This is main shortcode, required for stable functionality of the plugin. This shortcode may have <strong>"custom_home"</strong> attribute, when you set up <strong>&#091;webdirectory custom_home=1&#093;</strong> - the shortcode displays only listings, no map, no categories block, no search form. This special mode allows to build custom directory home page as you wish using additional shortcodes. Total configuration implemented from admin dashboard.
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>custom_home</strong></td><td>When set to 1 it enables special mode, that allows to build <a href="[base_url]/documentation/custom-home/">custom home page</a></td><td class="td-center">0</td></tr>
		<tr><td><strong>id</strong></td><td>ID of directory</td><td class="td-center">0</td></tr>
		</table>
		
		<a href="[base_url]/" target="_blank" rel="noopener noreferrer">Example</a>
		<a href="[base_url]/shortcodes/custom-home-page-1/" target="_blank" rel="noopener noreferrer">Example custom home page 1</a>
		<a href="[base_url]/shortcodes/custom-home-page-2/" target="_blank" rel="noopener noreferrer">Example custom home page 2</a>
		<a href="[base_url]/shortcodes/custom-home-page-3/" target="_blank" rel="noopener noreferrer">Example custom home page 3</a>
		<a href="[base_url]/shortcodes/custom-home-page-4/" target="_blank" rel="noopener noreferrer">Example custom home page 4</a>
		<a href="[base_url]/shortcodes/custom-home-page-5/" target="_blank" rel="noopener noreferrer">Example custom home page 5</a>
		<a href="[base_url]/shortcodes/custom-home-page-6/" target="_blank" rel="noopener noreferrer">Example custom home page 6</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-listings&#093;</strong></h3>
		This shortcode is used to build additional pages with listings.
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>uid</strong></td><td>Enter unique string to connect this shortcode with another shortcodes.</td><td class="td-center"></td></tr>
		<tr><td><strong>directories</strong></td><td>IDs of directories (comma separated).</td><td class="td-center"></td></tr>
		<tr><td><strong>onepage</strong></td><td>Show all possible listings on one page.</td><td class="td-center">0</td></tr>
		<tr><td><strong>perpage</strong></td><td>Number of listings to display per page. Set -1 to display all listings without paginator.</td><td class="td-center">10</td></tr>
		<tr><td><strong>paged</strong></td><td>Page number to start from.</td><td class="td-center">1</td></tr>
		<tr><td><strong>scrolling_paginator</strong></td><td>Automatically display next page of listing when the screen reaches the bottom.</td><td class="td-center">0</td></tr>
		<tr><td><strong>sticky_featured</strong></td><td>Show only sticky and featured listings.</td><td class="td-center">0</td></tr>
		<tr><td><strong>order_by</strong></td><td>Possible values: post_date, title, rand, distance - when listings search in radius. Also this is possible to order by some content fields, those types have ordering functionality: text string, date-time, digital number, price. Just need to set content field slug as this attribute.</td><td class="td-center">post_date</td></tr>
		<tr><td><strong>order</strong></td><td>Direction of sorting: ASC or DESC.</td><td class="td-center">ASC</td></tr>
		<tr><td><strong>hide_order</strong></td><td>Hide ordering navigation links.</td><td class="td-center">0</td></tr>
		<tr><td><strong>hide_count</strong></td><td>Hide number of found listings.</td><td class="td-center">0</td></tr>
		<tr><td><strong>show_views_switcher</strong></td><td>Show listings views switcher.</td><td class="td-center">1</td></tr>
		<tr><td><strong>listings_view_type</strong></td><td>Listings view by default, \'list\' or \'grid\'.</td><td class="td-center">list</td></tr>
		<tr><td><strong>listings_view_grid_columns</strong></td><td>Number of columns for listings Grid View (1,2,3 or 4).</td><td class="td-center">2</td></tr>
		<tr><td><strong>listing_thumb_width</strong></td><td>Listing thumbnail logo width in List View (in pixels).</td><td class="td-center">by setting*</td></tr>
		<tr><td><strong>grid_view_logo_ratio</strong></td><td>Thumbnail image ratio. Percents is used: 100 (1:1), 75 (4:3), 56.25 (16:9), 50 (2:1).</td><td class="td-center">by setting*</td></tr>
		<tr><td><strong>wrap_logo_list_view</strong></td><td>Wrap logo image by text content in List View.</td><td class="td-center">0</td></tr>
		<tr><td><strong>logo_animation_effect</strong></td><td>Enable/disable thumbnail animation hover effect.</td><td class="td-center">by setting*</td></tr>
		<tr><td><strong>hide_content</strong></td><td>Hide all text content except listing title.</td><td class="td-center">0</td></tr>
		<tr><td><strong>rating_stars</strong></td><td>Show rating stars. When ratings addon enabled.</td><td class="td-center">1</td></tr>
		<tr><td><strong>summary_on_logo_hover</strong></td><td>Place summary on hover layout.</td><td class="td-center">0</td></tr>
		<tr><td><strong>carousel</strong></td><td>Enable/disable carousel slider.</td><td class="td-center">0</td></tr>
		<tr><td><strong>carousel_show_slides</strong></td><td>Slides to show.</td><td class="td-center">4</td></tr>
		<tr><td><strong>carousel_slide_width</strong></td><td>Slide width (in pixels).</td><td class="td-center">250</td></tr>
		<tr><td><strong>carousel_slide_height</strong></td><td>Slide height(in pixels).</td><td class="td-center">300</td></tr>
		<tr><td><strong>carousel_full_width</strong></td><td>Carousel width (in pixels). With empty field carousel will take all possible width.</td><td class="td-center"></td></tr>
		<tr><td><strong>ajax_initial_load</strong></td><td>Load listings only after the page was completely loaded.</td><td class="td-center">by setting*</td></tr>
		<tr><td><strong>author</strong></td><td>Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or WordPress author page).</td><td class="td-center"></td></tr>
		<tr><td><strong>address</strong></td><td>Display listings near this address, recommended to set "radius" attribute.</td><td class="td-center"></td></tr>
		<tr><td><strong>radius</strong></td><td>Display listings near provided address within this radius in miles or kilometers - according to dimension parameter from directory settings.</td><td class="td-center"></td></tr>
		<tr><td><strong>categories</strong></td><td>Comma separated string of categories IDs or slugs - use only IDs or only slugs.</td><td class="td-center"></td></tr>
		<tr><td><strong>related_categories</strong></td><td>Get listings with same categories. Parameter works only on listings and categories pages.</td><td class="td-center">0</td></tr>
		<tr><td><strong>locations</strong></td><td>Comma separated string of locations IDs or slugs - use only IDs or only slugs.</td><td class="td-center"></td></tr>
		<tr><td><strong>related_locations</strong></td><td>Get listings in same locations. Parameter works only on listings and locations pages.</td><td class="td-center">0</td></tr>
		<tr><td><strong>tags</strong></td><td>Comma separated string of tags IDs or slugs - use only IDs or only slugs.</td><td class="td-center"></td></tr>
		<tr><td><strong>related_tags</strong></td><td>Get listings of same tags. Parameter works only on listings and tags pages.</td><td class="td-center">0</td></tr>
		<tr><td><strong>include_categories_children</strong></td><td>Include children of selected categories and locations. When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.</td><td class="td-center">0</td></tr>
		<tr><td><strong>include_get_params</strong></td><td>Follow params of the search form (when search form shortcode connected with this listings shortcode).</td><td class="td-center">1</td></tr>
		<tr><td><strong>related_directory</strong></td><td>Get listings of the same directory.</td><td class="td-center">0</td></tr>
		<tr><td><strong>levels</strong></td><td>Comma separated string of levels IDs. Here you may filter which listings to display by its levels.</td><td class="td-center"></td></tr>
		<tr><td><strong>post__in</strong></td><td>Comma separated string of listings IDs. Possible to display exact listings.</td><td class="td-center"></td></tr>
		<tr><td><strong>field_<em>SLUG</em></td><td colspan="2">Possible to filter by content fields values like on the search form. Filters depend on fields types:
		<ul>
			<li><strong>Text string and Textarea</strong> - filter in the following format: <strong>field_<em>SLUG</em>="string"</strong></li>
			<li><strong>Digital value</strong> - here are 2 variants: when content field was configured to search by exact values - <strong>field_<em>SLUG</em>="number"</strong>; when content field was configured to search by MIN and MAX values - <strong>field_<em>SLUG</em>_min="number"</strong> and/or <strong>field_<em>SLUG</em>_max="number"</strong></li>
			<li><strong>Price</strong> - the same as for Digital value type</li>
			<li><strong>Date-Time</strong> - define date range in the following format: <strong>field_<em>SLUG</em>_min="dd.mm.yyyy"</strong> and/or <strong>field_<em>SLUG</em>_max="dd.mm.yyyy"</strong></li>
			<li><strong>Select list, Radio buttons and Checkboxes</strong> - filter in the following format: <strong>field_<em>SLUG</em>="comma separated selection items IDs"</strong>. Select list, Radio buttons support only single ID.</li>
		</ul></td></tr>
		</table>
		<a href="[base_url]/shortcodes/connected-shortcodes/" target="_blank" rel="noopener noreferrer">Connected Shortcodes</a>
		<a href="[base_url]/shortcodes/4-columns/" target="_blank" rel="noopener noreferrer">4 Columns</a>
		<a href="[base_url]/shortcodes/only-sticky-featured/" target="_blank" rel="noopener noreferrer">Only Sticky & Featured listings</a>
		<a href="[base_url]/shortcodes/geolocation-with-listings/" target="_blank" rel="noopener noreferrer">Geolocation</a>
		<a href="[base_url]/shortcodes/listings-carousel/" target="_blank" rel="noopener noreferrer">Carousel</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-page-header&#093;</strong></h3>
		Displays page header, the same as on the demo pages: background image according to the page type, page title and breadcrumbs.
		Wordpress pages diplay featured images as background. Listings logos as background on listings single pages. On categories and locations pages it displays featured images, those you can manage at "<em>Directory listings -> Directory categories</em>" and "<em>Directory listings -> Directory locations</em>".
		<hr />
		
		<h3><strong>&#091;webdirectory-page-title&#093;</strong></h3>
		Displays just a title of a page: home page, categories, locations or tags name, search or listing name.
		<hr />
		
		<h3><strong>&#091;webdirectory-map&#093;</strong></h3>
		This shortcode is used to build google maps with listings locations as map markers. This shortcode supports most part of parameters for <strong>&#091;webdirectory-listings&#093;</strong> shortcode + following additional attributes:
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>custom_home</strong></td><td>When set to 1 it enables special mode, that allows to build <a href="[base_url]/documentation/custom-home/">custom home page</a>.</td><td class="td-center">0</td></tr>
		<tr><td><strong>directories</strong></td><td>IDs of directories (comma separated).</td><td class="td-center"></td></tr>
		<tr><td><strong>num</strong></td><td>Number of markers to display on map (-1 gives all markers).</td><td class="td-center">-1</td></tr>
		<tr><td><strong>map_markers_is_limit</strong></td><td>How many map markers to display on the map. 0 - Display all map markers. 1 - The only map markers of visible listings will be displayed (when listings shortcode is connected with map by unique string).</td><td class="td-center">0</td></tr>
		<tr><td><strong>uid</strong></td><td>Enter unique string to connect this shortcode with another shortcodes.</td><td class="td-center"></td></tr>
		<tr><td><strong>width</strong></td><td>Set map width (by default whole possible width).</td><td class="td-center"></td></tr>
		<tr><td><strong>height</strong></td><td>Set map height.</td><td class="td-center">400</td></tr>
		<tr><td><strong>radius_circle</strong></td><td>Display radius cycle on map when radius filter provided.</td><td class="td-center">1</td></tr>
		<tr><td><strong>clusters</strong></td><td>Group map markers in clusters.</td><td class="td-center">0</td></tr>
		<tr><td><strong>sticky_scroll</strong></td><td>Makes the map to be sticky on scroll.</td><td class="td-center">0</td></tr>
		<tr><td><strong>sticky_scroll_toppadding</strong></td><td>Sticky scroll top padding in pixels.</td><td class="td-center">0</td></tr>
		<tr><td><strong>map_style</strong></td><td>Google Maps style. Whole list in directory settings.</td><td class="td-center">default</td></tr>
		<tr><td><strong>show_summary_button</strong></td><td>Show "Summary" button in info window.</td><td class="td-center">0</td></tr>
		<tr><td><strong>show_readmore_button</strong></td><td>Show "Read more" button in info window.</td><td class="td-center">1</td></tr>
		<tr><td><strong>ajax_loading</strong></td><td>When map contains lots of markers - this may slow down map markers loading. Select AJAX to speed up loading. Requires Starting Address or Starting Point coordinates Latitude and Longitude.</td><td class="td-center">0</td></tr>
		<tr><td><strong>ajax_markers_loading</strong></td><td>Maps info window AJAX loading. This may additionally speed up loading.</td><td class="td-center">0</td></tr>
		<tr><td><strong>start_address</strong></td><td>When map markers load by AJAX - it should have starting point and starting zoom. Enter start address or select latitude and longitude. Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA.</td><td class="td-center"></td></tr>
		<tr><td><strong>start_latitude</strong></td><td>Starting point latitude.</td><td class="td-center"></td></tr>
		<tr><td><strong>start_longitude</strong></td><td>Starting point longitude.</td><td class="td-center"></td></tr>
		<tr><td><strong>start_zoom</strong></td><td>Starting point zoom.</td><td class="td-center">0</td></tr>
		<tr><td><strong>geolocation</strong></td><td>Enable automatic user Geolocation.</td><td class="td-center">0</td></tr>
		<tr><td><strong>draw_panel</strong></td><td>Enable Draw Panel.</td><td class="td-center">0</td></tr>
		<tr><td><strong>enable_full_screen</strong></td><td>Enable full screen button.</td><td class="td-center">1</td></tr>
		<tr><td><strong>enable_wheel_zoom</strong></td><td>Enable zoom by mouse wheel. For desktops.</td><td class="td-center">1</td></tr>
		<tr><td><strong>enable_dragging_touchscreens</strong></td><td>Enable map dragging on touch screen devices.</td><td class="td-center">1</td></tr>
		<tr><td><strong>center_map_onclick</strong></td><td>Center map on marker click.</td><td class="td-center">0</td></tr>
		<tr><td><strong>categories</strong></td><td>Categories to show on a map. Comma separated string of categories IDs or slugs - use only IDs or only slugs.</td><td class="td-center"></td></tr>
		<tr><td><strong>locations</strong></td><td>Locations to show on a map. Comma separated string of locations IDs or slugs - use only IDs or only slugs.</td><td class="td-center"></td></tr>
		<tr><td><strong>search_on_map</strong></td><td>Show search form and listings panel on the map.</td><td class="td-center">0</td></tr>
		<tr><td><strong>search_on_map_open</strong></td><td>Search form open by default.</td><td class="td-center">0</td></tr>
		<tr><td><strong>show_keywords_search</strong></td><td>Show keywords search on the search form.</td><td class="td-center">1</td></tr>
		<tr><td><strong>keywords_ajax_search</strong></td><td>Enable listings autosuggestions by keywords.</td><td class="td-center">1</td></tr>
		<tr><td><strong>what_search</strong></td><td>Default keywords on the search form.</td><td class="td-center"></td></tr>
		<tr><td><strong>keywords_placeholder</strong></td><td>Keywords placeholder.</td><td class="td-center"></td></tr>
		<tr><td><strong>show_categories_search</strong></td><td>Show categories search on the search form.</td><td class="td-center">1</td></tr>
		<tr><td><strong>categories_search_level</strong></td><td>Categories search depth level on the search form (1,2,3).</td><td class="td-center">1</td></tr>
		<tr><td><strong>category</strong></td><td>Select certain category ID on the search form.</td><td class="td-center">0</td></tr>
		<tr><td><strong>exact_categories</strong></td><td>List of categories on the search form. Comma separated string of categories slugs or IDs.</td><td class="td-center"></td></tr>
		<tr><td><strong>address</strong></td><td>Default address, recommended to set default radius.</td><td class="td-center"></td></tr>
		<tr><td><strong>address_placeholder</strong></td><td>Address placeholder.</td><td class="td-center"></td></tr>
		<tr><td><strong>show_radius_search</strong></td><td>Show radius slider on the search form.</td><td class="td-center">1</td></tr>
		<tr><td><strong>radius</strong></td><td>Display listings near provided address within this radius in miles or kilometers - according to dimension parameter from directory settings.</td><td class="td-center"></td></tr>
		<tr><td><strong>show_address_search</strong></td><td>Show address search on the search form.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_locations_search</strong></td><td>Show locations search on the search form.</td><td class="td-center">1</td></tr>
		<tr><td><strong>locations_search_level</strong></td><td>Locations search depth level on the search form (1,2,3).</td><td class="td-center">1</td></tr>
		<tr><td><strong>location</strong></td><td>Select certain location ID on the search form.</td><td class="td-center">0</td></tr>
		<tr><td><strong>exact_locations</strong></td><td>List of locations on the search form. Comma separated string of locations slugs or IDs.</td><td class="td-center"></td></tr>
		<tr><td><strong>+</strong></td><td colspan="2">parameters from <strong>&#091;webdirectory-listings&#093;</strong> shortcode, such as: sticky_featured, author, related_directory, related_categories, related_locations, related_tags, levels, post_in, include_categories_children and special content fields filters.</td></tr>
		</table>
		
		<a href="[base_url]/shortcodes/search-ajax-map-listings/" target="_blank" rel="noopener noreferrer">Search + AJAX Map + Listings</a>
		<a href="[base_url]/shortcodes/radius-circle-on-the-map/" target="_blank" rel="noopener noreferrer">Radius circle</a>
		<a href="[base_url]/shortcodes/ajax-map/" target="_blank" rel="noopener noreferrer">AJAX Map</a>
		<a href="[base_url]/shortcodes/geolocation/" target="_blank" rel="noopener noreferrer">Geolocation</a>
		<a href="[base_url]/shortcodes/all-listings-of-a-location/" target="_blank" rel="noopener noreferrer">All Listings of Location</a>
		<a href="[base_url]/shortcodes/search-form-on-map/" target="_blank" rel="noopener noreferrer">With the Search Form</a>
		<a href="[base_url]/shortcodes/draw-panel/" target="_blank" rel="noopener noreferrer">Draw Panel</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-categories&#093;</strong></h3>
		This shortcode is used to build categories tables, lists and grids. This shortcode supports following parameters:
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>custom_home</strong></td><td>When set to 1 it enables special mode, that allows to build <a href="[base_url]/documentation/custom-home/">custom home page</a>.</td><td class="td-center">0</td></tr>
		<tr><td><strong>directory</strong></td><td>ID of directory. Links will redirect to selected directory.</td><td class="td-center">0</td></tr>
		<tr><td><strong>parent</strong></td><td>ID of parent category. This will build categories tree starting from the parent as root.</td><td class="td-center">0</td></tr>
		<tr><td><strong>depth</strong></td><td>The max depth of categories tree (1,2). When set to 1 only root categories will be listed.</td><td class="td-center">1</td></tr>
		<tr><td><strong>columns</strong></td><td>Number of categories columns in the table, up to 4 categories.</td><td class="td-center">2</td></tr>
		<tr><td><strong>count</strong></td><td>Show the number of listings inside categories.</td><td class="td-center">1</td></tr>
		<tr><td><strong>hide_empty</strong></td><td>Hide empty categories.</td><td class="td-center">0</td></tr>
		<tr><td><strong>subcats</strong></td><td>This is the number of subcategories those will be displayed in the table, when category item includes more than this number, then "View all subcategories -&gt;" link appears at the bottom.</td><td class="td-center">0</td></tr>
		<tr><td><strong>categories</strong></td><td>Comma separated string of categories slugs or IDs. Possible to display exact categories.</td><td class="td-center"></td></tr>
		<tr><td><strong>icons</strong></td><td>Show/hide categories icons.</td><td class="td-center">1</td></tr>
		<tr><td><strong>grid</strong></td><td>Display larger cells of the table.</td><td class="td-center">0</td></tr>
		<tr><td><strong>grid_view</strong></td><td>3 modes to display categories table (1,2,3). This is fixed table with limited number of categories. Use \'categories\' parameter to display specific categories.</td><td class="td-center">0</td></tr>
		<tr><td><strong>menu</strong></td><td>Display as categories list without featured images background.</td><td class="td-center">0</td></tr>
		<tr><td><strong>order</strong></td><td>Display terms sorted by default (as sorted on Directory Listings -> Directory Categories), name, count.</td><td class="td-center">default</td></tr>
		</table>
		
		<a href="[base_url]/shortcodes/webdirectory-categories/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-locations&#093;</strong></h3>
		This shortcode is used to build locations tables, lists and grids. This shortcode supports following parameters:
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>custom_home</strong></td><td>When set to 1 it enables special mode, that allows to build <a href="[base_url]/documentation/custom-home/">custom home page</a>.</td><td class="td-center">0</td></tr>
		<tr><td><strong>directory</strong></td><td>ID of directory. Links will redirect to selected directory.</td><td class="td-center">0</td></tr>
		<tr><td><strong>parent</strong></td><td>ID of parent location. This will build locations tree starting from the parent as root.</td><td class="td-center">0</td></tr>
		<tr><td><strong>depth</strong></td><td>The max depth of locations tree (1,2). When set to 1 only root locations will be listed.</td><td class="td-center">1</td></tr>
		<tr><td><strong>columns</strong></td><td>Number of locations columns in the table, up to 4 locations.</td><td class="td-center">2</td></tr>
		<tr><td><strong>count</strong></td><td>Show the number of listings inside locations.</td><td class="td-center">1</td></tr>
		<tr><td><strong>hide_empty</strong></td><td>Hide empty locations.</td><td class="td-center">0</td></tr>
		<tr><td><strong>sublocations</strong></td><td>This is the number of sublocations those will be displayed in the table, when location item includes more than this number, then "View all sublocations -&gt;" link appears at the bottom.</td><td class="td-center">0</td></tr>
		<tr><td><strong>locations</strong></td><td>Comma separated string of locations slugs or IDs. Possible to display exact locations.</td><td class="td-center"></td></tr>
		<tr><td><strong>icons</strong></td><td>Show/hide locations icons.</td><td class="td-center">1</td></tr>
		<tr><td><strong>grid</strong></td><td>Display larger cells of the table.</td><td class="td-center">0</td></tr>
		<tr><td><strong>grid_view</strong></td><td>3 modes to display locations table (1,2,3). This is fixed table with limited number of locations. Use \'locations\' parameter to display specific locations.</td><td class="td-center">0</td></tr>
		<tr><td><strong>menu</strong></td><td>Display as locations list without featured images background.</td><td class="td-center">0</td></tr>
		<tr><td><strong>order</strong></td><td>Display terms sorted by default (as sorted on Directory Listings -> Directory Locations), name, count.</td><td class="td-center">default</td></tr>
		</table>
		
		<a href="[base_url]/shortcodes/webdirectory-locations/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-search&#093;</strong></h3>
		This shortcode builds directory search form. Parameters of this shortcode:
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>custom_home</strong></td><td>When set to 1 it enables special mode, that allows to build <a href="[base_url]/documentation/custom-home/">custom home page</a>.</td><td class="td-center">0</td></tr>
		<tr><td><strong>directory</strong></td><td>ID of directory. Search in this specific directory.</td><td class="td-center"></td></tr>
		<tr><td><strong>uid</strong></td><td>Enter unique string to connect this shortcode with another shortcodes.</td><td class="td-center"></td></tr>
		<tr><td><strong>form_id</strong></td><td>ID of a search form built in <a href="[base_url]/documentation/search/">Search Forms</a> section.</td><td class="td-center"></td></tr>
		</table>
		
		<a href="[base_url]/shortcodes/webdirectory-search/" target="_blank" rel="noopener noreferrer">Examples</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-submit&#093;</strong></h3>
		Works only when <a href="[base_url]/documentation/frontend/">Frontend submission & dashboard addon</a> was enabled. This shortcode builds listings submission pages. The process of listing submission divided in some steps, the number of submission steps varies according to different conditions: log in step may be missed if user was already logged in, payment step either doesn\'t required for free listings. Choose level page will be skipped when there are only one level. Also it depends on <em>"Hide choose level page"</em> <a href="[base_url]/documentation/settings/frontend-submission/">setting</a>.
		
		This shortcode supports following parameters:
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>directory</strong></td><td>ID of directory. Submission into specific directory.</td><td class="td-center"></td></tr>
		<tr><td><strong>levels</strong></td><td>Choose exact levels to display. Comma separated levels IDs.</td><td class="td-center"></td></tr>
		<tr><td><strong>columns</strong></td><td>Columns number on choose level page.</td><td class="td-center">3</td></tr>
		<tr><td><strong>columns_same_height</strong></td><td>Show/hide parameters those have negation. For example, such row in the table will be shown: Featured Listings - No. In other case this row will be hidden.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_period</strong></td><td>Show level active period on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_sticky</strong></td><td>Show is level sticky on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_featured</strong></td><td>Show is level featured on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_categories</strong></td><td>Show level\'s categories number on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_locations</strong></td><td>Show level\'s locations number on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_maps</strong></td><td>Show is level supports maps on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_images</strong></td><td>Show level\'s images number on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>show_videos</strong></td><td>Show level\'s videos number on choose level page.</td><td class="td-center">1</td></tr>
		<tr><td><strong>options</strong></td><td>Additional options in the levels table. Use following format for each level separated by \';\' symbol: ID&gt;Option name&gt;yes or no. Any string parameters should be wrapped in quotes. Example: <strong>1&gt;Advantage&gt;yes;2&gt;Advantage&gt;no</strong></td><td class="td-center"></td></tr>
		</table>
		
		<a href="[base_url]/submit-new-listing/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-levels-table&#093;</strong></h3>
		Works only when <a href="[base_url]/documentation/frontend/">Frontend submission & dashboard addon</a> was enabled and a page with <strong>&#091;webdirectory-submit&#093;</strong> shortcode exists. Works in similar way as <strong>&#091;webdirectory-submit&#093;</strong> shortcode, but it displays only pricing/levels table. Has exactly the same parameters.
		
		<a href="[base_url]/shortcodes/webdirectory-levels-table/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-dashboard&#093;</strong></h3>
		Works only when <a href="[base_url]/documentation/frontend/">Frontend submission & dashboard addon</a> was enabled. Logged in users have an ability to manage their listings, invoices and profile on the frontend dashboard page. This shortcode doesn\'t have any parameters.
		
		<a href="[base_url]/my-dashboard/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-buttons&#093;</strong></h3>
		Renders frontend buttons: submit new listing, my favourites button and these buttons on single listing page: edit listing, print listing, put in/out favourites list, save listing in PDF. This shortcode doesn\'t have any attributes.
		
		This shortcode supports following parameters:
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>directories</strong></td><td>IDs of directories. Renders submission buttons for each directory separately.</td><td class="td-center"></td></tr>
		<tr><td><strong>hide_button_text</strong></td><td>Hides the text of a button, so it will render only icon.</td><td class="td-center">0</td></tr>
		<tr><td><strong>buttons</strong></td><td>Comma delimited list of buttons. \'submit\', \'logout\' and \'favourites\' will render on all pages. \'claim\', \'edit\', \'print\', \'bookmark\' and \'pdf\' only on single listings pages.</td><td class="td-center">submit,claim,favourites,edit,
		print,bookmark,pdf</td></tr>
		</table>
		
		<a href="[base_url]/shortcodes/webdirectory-buttons/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-slider&#093;</strong></h3>
		Directory listings in slider view.
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>slides</strong></td><td>Maximum number of slides.</td><td class="td-center">5</td></tr>
		<tr><td><strong>captions</strong></td><td>Show captions on each slide</td><td class="td-center">1</td></tr>
		<tr><td><strong>pager</strong></td><td>Show thumbnails slides</td><td class="td-center">1</td></tr>
		<tr><td><strong>width</strong></td><td>Maximum width of slider in pixels. Leave empty to make it auto width.</td><td class="td-center"></td></tr>
		<tr><td><strong>height</strong></td><td>Set fixed height of the slider (in pixels). Otherwise it will adapt height for each slide.</td><td class="td-center"></td></tr>
		<tr><td><strong>slide_width</strong></td><td>Set fixed width of main slide (in pixels)</td><td class="td-center"></td></tr>
		<tr><td><strong>max_slides</strong></td><td>Show multiple slides on main slide area</td><td class="td-center">1</td></tr>
		<tr><td><strong>crop</strong></td><td>Do crop images</td><td class="td-center">1</td></tr>
		<tr><td><strong>order_by_rand</strong></td><td>Set to order listings randomly.</td><td class="td-center">0</td></tr>
		<tr><td><strong>auto_slides</strong></td><td>Enable automatic rotating slideshow.</td><td class="td-center">0</td></tr>
		<tr><td><strong>auto_slides_delay</strong></td><td>The delay in rotation (in ms).</td><td class="td-center">3000</td></tr>
		<tr><td><strong>+</strong></td><td colspan="2">Parameters from <strong>&#091;webdirectory-listings&#093;</strong> shortcode, such as: sticky_featured, order_by, order, address, radius, categories, locations, author, related_directory, related_categories, related_locations, related_tags, levels, post_in, include_categories_children and special content fields filters.</td></tr>
		</table>
		
		<a href="[base_url]/shortcodes/webdirectory-slider/" target="_blank" rel="noopener noreferrer">Example</a>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-breadcrumbs&#093;</strong></h3>
		Displays breadcrumbs in the place of this shortcode. This shortcode need when you build <a href="[base_url]/documentation/custom-home/">custom home page</a>.
		
		<hr />
		
		<h3><strong>&#091;webdirectory-term-title&#093;</strong></h3>
		Displays category, location or tag title in the place of this shortcode. This shortcode need when you build <a href="[base_url]/documentation/custom-home/">custom home page</a>.
		
		<hr />
		
		<h3><strong>&#091;webdirectory-term-description&#093;</strong></h3>
		Displays category, location or tag description in the place of this shortcode. This shortcode need when you build <a href="[base_url]/documentation/custom-home/">custom home page</a>.
		
		<hr />
		
		<h2>Place listing shortcodes at the Single Listing Page</h2>
		<h3><strong>&#091;webdirectory-listing-page&#093;</strong></h3>
		Builds special page for single listings. If you want separate "template" page for every single listing - create new page with this shortcode.
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>directory</strong></td><td>ID of directory. Possible to set up different listing page for each directory separately.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-listing-header&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays header of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-listing-fields&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays all fields of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-listing-gallery&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays images gallery of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-content-field&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays content field of current listing.</td><td class="td-center"></td></tr>
		<tr><td><strong>id</strong></td><td>ID of a content field.</td><td class="td-center"></td></tr>
		<tr><td><strong>classes</strong></td><td>CSS classes to add in wrapper div of a content field.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-content-fields-group&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays content fields group of current listing.</td><td class="td-center"></td></tr>
		<tr><td><strong>id</strong></td><td>ID of a content fields group.</td><td class="td-center"></td></tr>
		<tr><td><strong>classes</strong></td><td>CSS classes to add in wrapper div of a content fields group.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-listing-map&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays map of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		
		<h3><strong>&#091;webdirectory-listing-videos&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays videos section of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		
		<h3><strong>&#091;webdirectory-listing-contact&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays contact form of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		
		<h3><strong>&#091;webdirectory-listing-report&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays report form of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<h3><strong>&#091;webdirectory-listing-comments&#093;</strong></h3>
		
		<table>
		<tr><th>Parameter</th><th class="th-description"></th><th>Default</th></tr>
		<tr><td><strong>listing</strong></td><td>ID of a listing. When empty it displays comments section of current listing.</td><td class="td-center"></td></tr>
		</table>
		
		<hr />
		
		<i class="fa fa-exclamation-triangle"></i> <strong>by setting*</strong> - means, that there is a setting in Directory Admin -> Directory settings, it controls default value of corresponding parameter. When this parameter is missed in a shortcode - it takes from a setting.

	</div>
		
'
);

?>