<?php

return array(
	'title' => 'Content fields',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="content_fields">Content fields & content fields groups</h2>
	
		Additional content fields is one of the most important part of the directory and classifieds sites. They allow to add some additional information to directory listings. <u>Content fields take part in the search and sorting of listings</u>. On <em>"Directory Admin -> Content fields</em>" page admin can order existing content fields by drag & drop rows in the table.
		
		<img src="[base_url]/wp-content/uploads/content_fields_configure_link.png" alt="content_fields_links" class="alignnone size-full" />
		
		Each field type defines own behaviour and view of a content field. There are settings to hide field name, select custom field icon, set field as required, manage visibility on pages. Listings can be <a href="[base_url]/documentation/sorting/">ordered</a> by some content fields. Note, that you can assign fields for specific categories and/or <a href="[base_url]/documentation/listings-levels/">specific levels</a>.
		
		Content fields types:
		
		<table>
		<tr><th>Field</th><th>Type name</th><th>Core</th><th>Searchable</th><th>Sortable</th></tr>
		<tr><td><strong>Content</strong></td><td>content</td><td class="td-center">+</td><td class="td-center">+</td><td class="td-center"">-</td></tr>
		<tr><td><strong>Excerpt</strong></td><td>excerpt</td><td class="td-center">+</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Listing addresses</strong></td><td>address</td><td class="td-center">+</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Listing categories</strong></td><td>categories</td><td class="td-center">+</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Listing tags</strong></td><td>tags</td><td class="td-center">+</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Text string</strong></td><td>string</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">+</td></tr>
		<tr><td><strong>Phone number</strong></td><td>phone</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">+</td></tr>
		<tr><td><strong>Textarea</strong></td><td>textarea</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Digital value</strong></td><td>number</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">+</td></tr>
		<tr><td><strong>Select list</strong></td><td>select</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Radio buttons</strong></td><td>radio</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Checkboxes</strong></td><td>checkbox</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>Website URL</strong></td><td>website</td><td class="td-center">-</td><td class="td-center">-</td><td class="td-center">-</td></tr>
		<tr><td><strong>Email</strong></td><td>email</td><td class="td-center">-</td><td class="td-center">-</td><td class="td-center">-</td></tr>
		<tr><td><strong>Date-Time</strong></td><td>datetime</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">+</td></tr>
		<tr><td><strong>Price</strong></td><td>price</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">+</td></tr>
		<tr><td><strong>Opening hours</strong></td><td>hours</td><td class="td-center">-</td><td class="td-center">+</td><td class="td-center">-</td></tr>
		<tr><td><strong>File upload</strong></td><td>fileupload</td><td class="td-center">-</td><td class="td-center">-</td><td class="td-center">-</td></tr>
		</table>
		
		There are <strong>5 core field types</strong>, during plugin installation the system creates 5 content fields and 3 additional fields:
		<ul>
			<li><strong>Content</strong> - visit <a href="[base_url]/documentation/settings/listings/#description_excerpt">listings settings tab</a> to enable/disable and switch on/off HTML and shortcodes in description field</li>
			<li><strong>Excerpt</strong> - visit <a href="[base_url]/documentation/settings/listings/#description_excerpt">listings settings tab</a> to enable/disasble excerpt, set up excerpt max length and <em>"Use cropped content as excerpt"</em> setting</li>
			<li><strong>Listing addresses</strong> - visit <a href="[base_url]/documentation/listings-levels/">listings levels</a> page to manage number of locations per listing</li>
			<li><strong>Listing categories</strong> - visit <a href="[base_url]/documentation/listings-levels/">listings levels</a> page to manage number of categories per listing</li>
			<li><strong>Listing tags</strong> - visit <a href="[base_url]/documentation/listings-levels/">listings levels</a> page to manage number of tags per listing</li>
			<li>Phone - additial field, manage at the <em>"Directory Admin -> Content fields"</em> page</li>
			<li>Website - additial field, manage at the <em>"Directory Admin -> Content fields"</em> page</li>
			<li>Email - additial field, manage at the <em>"Directory Admin -> Content fields"</em> page</li>
		</ul>
		
		Core fields have special destination. This is impossible to delete any of these fields. But it is possible to disable content and excerpt fields on <a href="[base_url]/documentation/settings/listings/#description_excerpt">Listings settings tab</a>. Listing addresses, listing categories and listings tags can be disabled in <a href="[base_url]/documentation/listings-levels/">listings levels</a> settings. You can\'t edit slugs of core fields, can\'t order by them, can\'t set specific categories list, can\'t use in search.
		
		About customization of content fields at the frontend. Each content field has following classes in their HTML output:
		<ul>
			<li><strong>w2dc-field-output-block</strong> - common class</li>
			<li><strong>w2dc-field-output-block-{type name}</strong> - specific to content field type name (take from the list above)</li>
			<li><strong>w2dc-field-output-block-{ID}</strong> - specific to content field ID</li>
		</ul>
		
		The plugin can use custom template files for each content field. Content field template files place in "<em>templates/content_fields/fields/</em>" folder. In order to customize input and output templates - create or copy needed template file with the following name structure (take type name from the list above):
		<ul>
			<li><strong>{type name}_output_{ID}.tpl.php</strong> - for the frontend markup</li>
			<li><strong>{type name}_input_{ID}.tpl.php</strong> - for the backend input markup</li>
		</ul>
		So custom template files will be used instead of native templates. Follow <a href="[base_url]/documentation/customization/">customization instructions</a>.
		
		<h3 id="content_fields_settings">Content fields settings</h3>
		
		<strong>Field name</strong> - required and used on listings administration page and in the search block.
		
		<strong>Field slug</strong> - this option required and isn\'t able to edit for core fields.
		
		<strong>Hide name</strong> - when checked - the name of field will be hidden at frontend pages.
		
		<strong>Only admins can see what was entered</strong> - this option allows to hide entered information of this field for any users except admins.
		
		<strong>Field description</strong> - this will be like a hint for users who fill in details into a field.
		
		<strong>Icon image</strong> - select an icon from Font Awesome icons list for any content field, it will be displayed at frontend pages.
		
		<strong>Field type</strong> - it is possible to change field type, but only for non-core fields.
		
		<strong>Is this field required?</strong> - most of types of fields can be set as required and some can not - listings categories, listings tags, listings addresses.
		
		<strong>Order by field</strong> - listings may be <a href="[base_url]/documentation/sorting/">ordered by content fields</a>.
		
		<strong>On excerpt pages</strong> - show this field on index, categories, locations, tags, search results pages.
		
		<strong>On listing pages</strong> - show this field on single listings pages.
		
		<strong>In map marker InfoWindow</strong> - show this field in map marker info window.
		
		<strong>Search by this field</strong> - take part in <a href="[base_url]/documentation/search/">the search of listings</a>.
	
		<strong>Assigned categories</strong> - this field will be dependent from selected categories.
	
		<strong>Listings levels</strong> - the field will appear only in selected listings levels.
		
		Now lets explain in details about each content field type:
		
		<h3 id="content_field_settings">Description  (<em>core field type</em>)</h3>
		
		At the backend this is richtext editor field to store general content of listings. Can\'t be ordered by its value, can\'t be searched by its value. By default this field is hidden on index and excerpt pages and visible only on listings pages.
		
		<h3 id="excerpt_field_settings">Summary (<em>core field type</em>)</h3>
		
		The WordPress Excerpt is an optional summary or description of a listing; in short, a listing summary. Can\'t be ordered by its value, can\'t be searched by its value. By default this field is shown on index and excerpt pages and hidden only on listings pages. It is possible to set up max length of output, also possible to use cropped content as excerpt, when excerpt field is empty - cropped main content will be used (look at the <a href="[base_url]/documentation/settings/listings/#description_excerpt">Listings settings tab</a>).
		
		<h3 id="addresses_field_settings">Listings addresses (<em>core field type</em>)</h3>
		
		This is a block of listing locations and addresses. Can\'t be ordered by its value, can\'t be required, has special search block. This block of fields is controlled by <a href="[base_url]/documentation/directory-locations">locations manager</a> and <a href="[base_url]/documentation/listings-levels">listings levels settings</a>.
		
		<h3 id="categories_field_settings">Listings categories (<em>core field type</em>)</h3>
		
		This is a block of categories, those were assigned to listing. Can\'t be ordered by its value, can\'t be required, has special search block. This block of fields is controlled by <a href="[base_url]/documentation/directory-categories">categories manager</a> and <a href="[base_url]/documentation/listings-levels">listings levels settings</a>.
		
		<h3 id="tags_field_settings">Listings tags (<em>core field type</em>)</h3>
		
		This is a block of tags, those were assigned to listing. Can\'t be ordered by its value, can\'t be required.
		
		<h3 id="text_field_settings">Text string</h3>
		
		Uses to insert short text/string data. Can be ordered by its value, can be required, can take part in search.
		
		<strong>Max length</strong> - max number of characters allowed in this field.
		
		<strong>PHP RegEx template</strong> - this interesting option allows to set the format of field. For example, such RegEx: <em>\(?([1-9]\d{2})(\)?)(-|.|\s)?([1-9]\d{2})(-|.|\s)?(\d{4})</em> matches phone number format: (xxx) xxx-xxxx
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_string.png" alt="" class="alignnone size-medium" />
	
		<h3 id="phone_field_settings">Phone number</h3>
		Uses to insert <span style="text-decoration: underline;">phone/fax number</span>. Or make WhatsApp/Viber/Telegram chat. Can be ordered by its value, can be required, can take part in search.
		
		<strong>Max length</strong> - max number of characters allowed in this field.
		
		<strong>PHP RegEx template</strong> - this interesting option allows to set the format of field. For example, such RegEx: <em>\(?([1-9]\d{2})(\)?)(-|.|\s)?([1-9]\d{2})(-|.|\s)?(\d{4})</em> matches phone number format: (xxx) xxx-xxxx
	
		<strong>Phone mode</strong> - for mobile devices adds special tag to call directly from phone or open needed app.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_phone.png" alt="" class="alignnone size-medium" />

		<h3 id="textarea_field_settings">Textarea</h3>
		Uses to insert long text and/or HTML. Listings can\'t be ordered by this field, but it can take part in the search (as a separate search field). Has following configuration options:
		
		<strong>Max length</strong> - max number of characters allowed in this field.
		
		<strong>HTML editor enabled</strong> - enable richtext editor.
		
		<strong>Run shortcodes</strong> - enable to process shortcodes inside this field.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_textarea.png" alt="" class="alignnone size-medium" />
		
		<h3 id="number_field_settings">Digital value</h3>
		Uses to insert numeric data. Can be ordered by its value, can be required, can take part in search. Has own special configuration options:
		
		<strong>Is integer or decimal</strong> - choose how to format the value of this field.
		
		<strong>Decimal separator</strong> - possible values: dot or comma.
		
		<strong>Thousands separator</strong> - possible values: no separator, dot, comma or space.
		
		<strong>Min</strong> - you may set minimum bound of this field. Leave empty if you do not need to limit this field.
		
		<strong>Max</strong> - you may set maximum bound of this field. Leave empty if you do not need to limit this field.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_number.png" alt="" class="alignnone size-medium" />
		
		<h3 id="select_field_settings">Select list</h3>
		
		At the backend displays as selectbox HTML input element. To show this field - first of all on the configuration page admin must complete selection items. Listings can\'t be ordered by this content field, but can be searched by selected items. On the search form these items will be displayed as a group of checkboxes inputs or selectbox or radio buttons group.
		
		<h3 id="radio_field_settings">Radio buttons</h3>
		
		Fields of this type inherit all features and settings of "<em>select list</em>" field type. The only difference is that the backend displays as radio buttons group. To show this field - first of all on the configuration page admin must complete selection items. Listings can\'t be ordered by this content field, but can be searched by selected items. On the search form these items will be displayed as a group of checkboxes inputs or selectbox or radio buttons group.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_select_radio.png" alt="" class="alignnone size-medium" />
		
		<h3 id="checkbox_field_settings">Checkboxes</h3>
		
		Fields of this type inherit all features and settings of "<em>select list</em>" field type. The only difference is that the backend displays as checkboxes group of HTML input elements, so it is possible to choose more than one option. To show this field - first of all on the configuration page admin must complete selection items. Listings can\'t be ordered by this content field, but can be searched by selected items. On the search form these items will be displayed as a group of checkboxes inputs or selectbox or radio buttons group.
	
		<img src="[base_url]/wp-content/uploads/checkboxes_frontend.png" alt="" class="alignnone size-medium" />
		
		Configuration options:
		
		<strong>Number of columns on single listing page</strong> - display items in 1, 2 or columns on the single listing page.
		
		<strong>How to display items</strong> - display all items with checked/unchecked marks or only checked items. Example of all items with checked/unchecked marks:
		
		<img src="[base_url]/wp-content/uploads/content_field_conf_checkboxes.png" alt="" class="alignnone size-medium" />
		
		<h3 id="website_field_settings">Website URL</h3>
		
		At the backend this is combination of 2 HTML inputs: the first input for a URL of link and the second for a text of link. Can\'t be ordered by its value, can\'t take part in search. At the frontend looks like a link. Has 5 configuration settings:
		
		<strong>Open link in new window</strong> - when checked - the system adds <em>target="blank"</em> attribute to the link.
		
		<strong>Add nofollow attribute</strong> - when checked - the system adds <em>rel="nofollow"</em> attribute to the link.
		
		<strong>Enable link text field</strong> - whether to use link text: entered by user or default link text (when next option enabled).
		
		<strong>Use default link text when empty</strong> - use default link text when user did not fill in own link text.
		
		<strong>Placeholder link text</strong> - default link text is used when user did not fill in own link text.
		
		When no link text available, it was not filled in, it is disabled and default text is not entered or was disabled - whole URL will be displayed as link text.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_website.png" alt="" class="alignnone size-medium" />
		
		<h3 id="email_field_settings">Email</h3>
		
		At the backend displays as pure HTML input element. Can\'t be ordered by its value, can\'t take part in search. At the frontend looks like <em>mailto</em> link.
		
		<h3 id="datetime_field_settings">Date-Time</h3>
		
		Implemented in 2 date fields - start and end date. Time dropboxes fields: hour and minute.
		
		<img src="[base_url]/wp-content/uploads/search_calendar_widget.png" />
		
		At the backend this field inherits the behaviour of jQuery UI datepicker widget. Has special configuration setting to include time-selection feature.
		
		Can be ordered by its value. Also in the search block this field renders as 2 separate inputs to search by date range.
		
		<strong>Enable time in field</strong> - whether to work with time, hours and minutes. Date and time format depends on WordPress General settings.
		
		<strong>Hide listings with passed dates</strong> - after selected date has passed it can exclude a listing from directory lists, but it still will have active status and working listing page.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_datetime.png" alt="" class="alignnone size-medium" />
		
		<h3 id="price_field_settings">Price</h3>
		
		Fields of this type has very much like behaviour as digital value field type, but it is always decimal and besides "<em>Decimal separator</em>" and "<em>Thousands separator</em>" settings it owns additional configuration settings.
		
		<strong>Currency symbol</strong> - this symbol will appear on frontend/backend pages.
		
		<strong>Currency symbol</strong> - choose preferred position of currency symbol/code.
		
		<strong>Decimal separator</strong> - decimal separator of price value, possible values: dot or comma.
		
		<strong>Hide decimals</strong> - show/hide decimals (cents) at the frontend.
		
		<strong>Thousands separator</strong> - the separator for thousands, millions, billions, ... Possible values: no separator, dot, comma or space.
		
		<img src="[base_url]/wp-content/uploads/content_field_conf_price.png" alt="" class="alignnone size-medium" />
		
		<h3 id="hours_field_settings">Opening hours</h3>
		
		The only configuration option is <em>"Time convention"</em> - 12-hours clock or 24-hours clock. Can\'t be ordered by its value, but this field can take part in search. Search form places <em>"open now"</em> element which shows listings matched opening hours by current time.
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_hours.png" alt="" class="alignnone size-medium" />
		
		<img class="alignnone size-full" src="[base_url]/wp-content/uploads/2013/12/opening_hours-1.png" alt="opening_hours" />
		
		<h3 id="fileupload_field_settings">File upload</h3>
		
		This field type a bit similar to website type. But instead of filling URL user uploads a file, which then could be downloaded at the frontend.
		
		<strong>Enable file title field</strong> - whether to use file title: entered by user or default file title text (when next option enabled).
		
		<strong>Use default file title text when empty</strong> - use default file title text when user did not fill in own file title.
		
		<strong>Default file title text</strong> - default file title text is used when user did not fill in own file title.
		
		When no file title text available, it was not filled in, it is disabled and default text is not entered or was disabled - real file name will be displayed.
		
		<strong>Allowed file types</strong> - select file types, those allowed to be uploaded:
		<ul>
			<li>Images (jpg, png, gif) (images)</li>
			<li>Text (txt)</li>
			<li>Microsoft Word Document (doc)</li>
			<li>Microsoft Word Open XML Document (docx)</li>
			<li>Excel Spreadsheet (xls)</li>
			<li>Microsoft Excel Open XML Spreadsheet (xlsx)</li>
			<li>Portable Document Format File (pdf)</li>
			<li>Adobe Photoshop Document (psd)</li>
			<li>Comma Separated Values File (csv)</li>
			<li>PowerPoint Presentation (ppt)</li>
			<li>PowerPoint Open XML Presentation (pptx)</li>
			<li>MP3 Audio File (mp3)</li>
			<li>Audio Video Interleave File (avi)</li>
			<li>MPEG-4 Video File (mp4)</li>
			<li>MPEG-4 Audio File (m4a)</li>
			<li>Apple QuickTime Movie (mov)</li>
			<li>MPEG Video File (mpg)</li>
			<li>MIDI File (mid)</li>
			<li>WAVE Audio File (wav)</li>
			<li>Windows Media Audio File (wma)</li>
			<li>Windows Media Video File (wmv)</li>
		</ul>
	
		<img src="[base_url]/wp-content/uploads/content_field_conf_fileupload.png" alt="" class="alignnone size-medium" />
		
		<h3 id="category_specific_content_fields">Category-specific content fields</h3>
		It is possible configure additional content fields (except core fields) to display their inputs only when exact specific categories were checked on listings edition page. This is important and powerful feature allows to build category-specific content fields.
		
		<strong>For instance:</strong> there may be one "<em>price</em>" field configured especially for "<em>Classifieds -> For sale</em>" category. In such case this field appears only in listings, those were assigned with specific category.
	
		<hr />
		
		<h3 id="content_fields_groups">Content fields groups</h3>
		<img class="size-full wp-image-4225 alignleft" src="[base_url]/wp-content/uploads/fields_groups.png" alt="content_fields_groups" width="401" height="474" />
		
		This functionality allows to combine separate content fields into groups (including core fields) at the frontend listings single pages. There is an ability to place content fields group on a separate tab on single listing page, also ability to hide content fields group from anonymous users, they will only see the link to login page "<em>You must be logged in to see this info</em>".
	
		<img src="[base_url]/wp-content/uploads/content_fields_groups_settings.png" alt="" class="alignnone size-medium" />
	</div>
	
'
);

?>