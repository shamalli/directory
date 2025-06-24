<?php

return array(
	'title' => 'Search Forms',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="search">Search system</h2>
		
		Search system has flexible tools to build any search form for your directory. Look at the <em>"Search Forms"</em> page at the admin backend, following elements available by default: Keywords, Submit button, Reset button, More filters, Categories, Locations, Tags, Ratings checkboxes. Address and Radius available when maps service enabled and configured properly (Google Maps or MapBox).
		
		<img src="[base_url]/wp-content/uploads/search_form_home.png" alt="" class="alignnone size-full" />
		
		Also it is possible to create additional elements as content fields of following types: select, checkbox, radio, price, number, string, textarea, phone and datetime. Create content fields at the <a href="[base_url]/documentation/content-fields/"><em>Directory Admin -> Content fields</em></a> page.
		
		<img src="[base_url]/wp-content/uploads/search_builder.png" alt="" class="alignnone size-full" />
		
		Drag and drop elements through the builder panel, set needed number of columns (up to 5 columns available), add placeholders. Make elements wider or narrower by left/right arrow buttons. Make elements placeholder taller/lower by up/down buttons. All this allows to make beautiful layout and position elements as you wish.
		
		Search filters types:
		<ul>
			<li>Keywords - search by keywords in listings title and description body.</li>
			<li>Text - search by keywords in <a href="[base_url]/documentation/content-fields/">content fields</a> of text string and textare types.</li>
			<li>Address - enter address and search nearby, use radius element to get search in radius. Autocomplete helps in this field.</li>
			<li>Radius - use with address element.</li>
			<li>Taxonomies - they include directory categories, locations and tags, also this type of search filters can be applied to <a href="[base_url]/documentation/content-fields/">content fields</a>: checkboxes, selectboxes, radio buttons</li>
			<li>Number - content fields of digit value type.</li>
			<li>Date - content fields of date-time type.</li>
			<li>Price - content fields of price type.</li>
			<li>Opening hours - content fields of opening hours type.</li></li>
			<li>Ratings checkboxes - search by listings ratings, works when <a href="[base_url]/documentation/ratings-reviews-comments/"><em>"Ratings & Comments addon"</em></a> enabled.</li>
			<li>Submit button</li>
			<li>Reset button</li>
			<li>More filters - place this link on a search form and "hide" elements to be visible when link was clicked.</li>
		</ul>
		
		<h4 id="keywords">Keywords</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_keywords_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_keywords.png" alt="" class="alignnone size-full" />
		
		Search by keywords using autocomplete functionality. Autocomplete suggests listings based on their titles and description body field.
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="text">Text</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_string_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_string.png" alt="" class="alignnone size-full" />
		
		Text search field has the same functionality as Keywords input except autocomplete functionality.
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="address">Address</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_address_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_address.png" alt="" class="alignnone size-full" />
		
		Enter address and search nearby, use radius element to get search in radius. Autocomplete helps in this field.
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="radius">Radius</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_radius_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_radius.png" alt="" class="alignnone size-full" />
		
		Search by radius on the map.
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="taxonomies">Taxonomies</h4>
		
		One of the most important type of search filters. Taxonomies include directory categories, locations and tags, also this type of search filters can be applied to <a href="[base_url]/documentation/content-fields/">content fields</a>: checkboxes, selectboxes, radio buttons.
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_options.png" alt="" class="alignnone size-full" />
		</div>
		
		Search mode option allows to display taxonomy terms in following ways:
		
		<strong>Single dropdown</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_input.png" alt="" class="alignnone size-full" />
		
		<strong>Single dropdown + keywords</strong>
		Search by keywords in listings title and description body or select taxonomy term
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_keywords.png" alt="" class="alignnone size-full" />
		
		<strong>Single dropdown + address</strong>
		Autocomplete suggests known addresses and locations
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_address.png" alt="" class="alignnone size-full" />
		
		<strong>Heirarhical dropdown</strong>
		Use categories and locations tree
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_hierarhical.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<p></p>
		
		<div style="float: left; margin-right: 50px;">
			<strong>Multi dropdown</strong>
			Select multiple terms
			<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_multiselect.png" alt="" class="alignnone size-full" />
		</div>
		
		<strong>Radios</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_radios.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<p></p>
		
		<strong>Radio buttons</strong> and <strong>Checkboxes buttons</strong>
		Display terms as buttons, checkboxes buttons allows to select multiple terms. Also their options you can build search form using different colors.
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_options_colors.png" alt="" class="alignnone size-full" />
		
		<div style="float: left; margin-right: 45px;">
			<strong>Checkboxes</strong>
			<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_checkboxes_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<p></p>
		
		"Checkboxes" and "Checkboxes buttons" modes have "Relation" option to search OR or AND items. AND - means to find listings matching ALL selected checkboxes items in every listing, OR - means listings with ANY of selected checkboxes.
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_checkboxes.png" alt="" class="alignnone size-full" />
		
		Floating pointer - is the search button appearing near checkboxes/radios for some seconds to start searching just after user selected needed items.
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_checkboxes_floating_pointer.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<p></p>
		
		<strong>Range slider</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_range_slider.png" alt="" class="alignnone size-full" />
		
		<strong>Single slider</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_taxonomies_single_slider.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<p></p>
		
		<hr />
		
		<h4 id="number">Number</h4>
		
		<div style="float: left; margin-right: 40px;">
			<img src="[base_url]/wp-content/uploads/search_filter_number_options.png" alt="" class="alignnone size-full" />
		</div>
		
		Search mode option allows to display numbers search in following ways:
		
		<strong>Range slider</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_number_range_slider.png" alt="" class="alignnone size-full" />
		
		<strong>Single slider</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_number_single_slider.png" alt="" class="alignnone size-full" />
		
		<strong>Min-max options in one dropdown</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_number_selectbox.png" alt="" class="alignnone size-full" />
		
		<strong>Min-max options in two dropdowns</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_number_selectboxes.png" alt="" class="alignnone size-full" />
		
		<strong>Min-max options in radios</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_number_radios.png" alt="" class="alignnone size-full" />
		
		<strong>Two inputs</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_number_inputs.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="date">Date</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_date_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_date.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="price">Price</h4>
		
		Price filter has the same options and types of view as the Number filter.
		
		<div style="float: left; margin-right: 40px;">
			<img src="[base_url]/wp-content/uploads/search_filter_price_options.png" alt="" class="alignnone size-full" />
		</div>
		
		Search mode option allows to display price search in following ways:
		
		<strong>Range slider</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_price_range_slider.png" alt="" class="alignnone size-full" />
		
		<strong>Single slider</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_price_single_slider.png" alt="" class="alignnone size-full" />
		
		<strong>Min-max options in one dropdown</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_price_selectbox.png" alt="" class="alignnone size-full" />
		
		<strong>Min-max options in two dropdowns</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_price_selectboxes.png" alt="" class="alignnone size-full" />
		
		<strong>Min-max options in radios</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_price_radios.png" alt="" class="alignnone size-full" />
		
		<strong>Two inputs</strong>
		<img src="[base_url]/wp-content/uploads/search_filter_price_inputs.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4  id="opening_hours">Opening hours</h4>
		
		Search form places "open now" element which shows listings matched opening hours by current time.
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_hours_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_hours.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="ratings_checkboxes">Ratings checkboxes</h4>
		
		Search by listings ratings, works when <a href="[base_url]/documentation/ratings-reviews-comments/"><em>"Ratings & Comments addon"</em></a> enabled.
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_ratings_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_ratings.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="submit_button">Submit button</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_button_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_button.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="reset_button">Reset button</h4>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_reset_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_reset.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h4 id="more_filter">More filters</h4>
		
		Place this link on a search form and "hide" elements to be visible when link was clicked.
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_filter_morefilters_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<img src="[base_url]/wp-content/uploads/search_filter_morefilters.png" alt="" class="alignnone size-full" />
		
		Every search element has <a href="[base_url]/documentation/search/#visibility_options"><em>"Visibility"</em></a> option allows to select how element will be presented on a search form.
		<img src="[base_url]/wp-content/uploads/search_visible_option.png" alt="" class="alignnone size-full" />
		
		<div style="clear: both;"></div>
		
		<hr />
		
		<h3 id="dependency_options">Dependency options</h3>
		
		<ol>
			<li>Select needed taxonomy.
				<img src="[base_url]/wp-content/uploads/search_dependency_option.png" alt="" class="alignnone size-full" />
			</li>
			<li>Select needed terms. This is some kind of condition to show search filter. Dependent fields can be totaly hidden or just shaded.
				<img src="[base_url]/wp-content/uploads/search_dependency_visible_option.png" alt="" class="alignnone size-full" />
			</li>
		</ol>
		
		<hr />
		
		<h3 id="visibility_options">Visibility options</h3>
		
		Every search element has <em>"Visibility"</em> option allows to select how element will be presented on a search form.
		
		<ul>
			<li><strong>Always opened</strong> - just show an element, no options to hide/show</li>
			<li><strong>Opened</strong> - an element is opened, but it has "-" (minus) option to hide it.</li>
			<li><strong>Closed</strong> - an element is closed, but it has "+" (plus) option to show it.</li>
			<li><strong>Always closed</strong> - do not display search element at all. Best way to add default and hidden values to the search form.</li>
			<li><strong>In \'more filters\' section</strong> - an element is hidden under special section displaying when \'more filters\' link was clicked.</li>
		</ul>
		
		<img src="[base_url]/wp-content/uploads/search_visible_option.png" alt="" class="alignnone size-full" />
		
		<hr />
		
		<h3 id="form_options">Form options</h3>
		
		<div style="float: left; margin-right: 50px;">
			<img src="[base_url]/wp-content/uploads/search_form_options.png" alt="" class="alignnone size-full" />
		</div>
		
		<p></p>
		
		<strong>Auto submit</strong> - each time a user makes any changes in search field - it sends search request automatically, no need to click submit button.
		
		<strong>Use AJAX</strong> - use AJAX search form or search request will redirect to another page.
		
		<strong>Target URL</strong> - send search request to this URL instead of AJAX search.
		
		<strong>Background color, text color, elements color, show overlay, overlay transparency, use border</strong> - style a form by background color, text color, elements color, overlay image, border usage and search form overlay transparency.
		
		<strong>Scroll to results after submit</strong> - automatically scroll to search results, works when AJAX enabled.
		
		<strong>Sticky scroll</strong> - fix the search form on one place on a page.
		
		<strong>Sticky scroll top padding</strong> - make some padding from the top of a page.
		
		<div style="clear: both;"></div>
		
		<hr />
		
		Complete search form and use it as directory search form in the Search settings:
		<img src="[base_url]/wp-content/uploads/search_settings.png" alt="" class="alignnone size-full" />
		
		Also <strong>&#091;webdirectory-search&#093;</strong> shortcode uses certain search form by its ID, like <strong>&#091;webdirectory-search form_id=124&#093;</strong>
		
		<img src="[base_url]/wp-content/uploads/search_forms.png" alt="" class="alignnone size-full" />
	</div>	
'
);

?>