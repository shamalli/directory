=== Web 2.0 Directory ===
Contributors: Mihail Chepovskiy
Donate link: https://www.salephpscripts.com/
Tags: business directory, cars directory, classifieds, classifieds directory, directory, events directory, google maps, listings directory, locations, pets directory, real estate directory, vehicles dealers directory, wordpress directory, yellow pages, youtube videos
Tested up to: 6.8
Stable tag: 2.10.9
License: Commercial

== Description ==

Build Directory or Classifieds site in some minutes. The plugin combines flexibility of WordPress and functionality of Directory and Classifieds

Look at our [demo](https://www.salephpscripts.com/wordpress_directory/demo/)

Plugin [documentation](https://www.salephpscripts.com/wordpress_directory/demo/documentation/)

== Changelog ==

= Version 2.10.9 =
* bug fix: upgrade/downgrade listings level option did not work on certain occasions

= Version 2.10.8 =
* improvement: dependency terms and exact terms lists in the search system fields were rebuilt
* improvement: "Search button" name in the search system now "Submit button"
* bug fix: problems with frontend files upload fixed

= Version 2.10.7 =
* security update

= Version 2.10.6 =
* improvement: updater supports Auto-updates now
* improvement: level ID will be inserted in listings on CSV re-import, if it was missing in initial import
* improvement: MapBox Geocoding API was updated to v6
* bug fix: Elementor map widget and map shortcode now supports map styles

= Version 2.10.5 =
* improvement: open address links on Google Maps and OpenStreetMap sites when maps disabled on directory pages
* improvement: "All day long" mark when opening hours set from 00:00 to 00:00 time
* improvement: Contact Form 7 now uses hash in ID parameter in their shortcodes

= Version 2.10.4 =
* improvement: empty output on single listings pages for some WP themes
* bug fix: missing rating stars
* bug fix: wrong Elementor control for checkboxes content field when only 2 items

= Version 2.10.3 =
* bug fix: PHP error using WPML
* bug fix: missing buttons on single listing pages

= Version 2.10.2 =
* improvement: empty output on single listings pages for some WP themes
* bug fix: "Hide listings with passed dates" feature worked wrongly

= Version 2.10.1 =
* security update

= Version 2.10.0 =
* improvement: MapBox GL version was updated
* improvement: MapBox styles were updated and new styles added
* improvement: radius search filter now can be displayed as a selectbox
* improvement: adapted for new versions of Elementor plugin
* new shortcodes and Elementor widgets:
[webdirectory-page-title]
[webdirectory-category-page]
[webdirectory-category-lisitngs
[webdirectory-category-map]
[webdirectory-category-search]

* bug fix: wrong author on the listing page header element
* bug fix: content fields Elementor widgets ID parameters conflicting
* bug fix: listings widget in WPBakery Page Builder had wrong default order setting

= Version 2.9.25 =
* improvement: new parameter "start_listings" for directory, map and listings shortcodes. Display specific listings by default, then directory searches as usual.
* improvement: categories and locations grids styles improved
* improvement: better compatibility with Yoast SEO plugin in "Imitation mode" for some themes
* bug fix: address line autocomplete option did not work on MapBox engine

= Version 2.9.24 =
* improvement: buttons group at the frontend dashboard listings table now does not apply line breaks
* bug fix: address line autocomplete option did not work

= Version 2.9.23 =
* bug fix: fixed error "Call to undefined function is_plugin_active()" at the frontend
* bug fix: 404 error on taxonomy pages in Imitation mode on some WP themes

= Version 2.9.22 =
* improvement: search reset sets the radius slider to its default value instead of zero 0
* improvement: better compatibility with WooCommerce plugin on PHP 8.2
* improvement: compatibility with Yoast SEO plugin in "Imitation mode"
* bug fix: special HTML characters decoded in keywords search auto-suggestion output

= Version 2.9.21 =
* new feature: hide listings with passed dates by date-time content field
* improvement: map infoWindow max width responsive to map width
* bug fix: "no listings" error when random sorting

= Version 2.9.20 =
* bug fix: date-time content field range parameters were corrected
* bug fix: load scripts and styles for directory elementor widgets
* bug fix: error messages while create/edit listings under "editor" user role

= Version 2.9.19 =
* improvement: better compatibility with PHP 8.2
* improvement: better performance when custom home shortcodes are used
* improvement: do not include radius search in URL when no address was entered
* bug fix: compatiblity issues with some themes were fixed

= Version 2.9.18 =
* improvement: better compatibility with PHP 8.2
* improvement: adapted for new versions of Elementor plugin
* bug fix: "Show more listings" button gave wrong results when "Display all map markers" mode was enabled on the map

= Version 2.9.17 =
* new setting: Images required

= Version 2.9.16 =
* new setting: The farest zoom level. How far we can zoom out: 1 - the farest (whole world) - min_zoom parameter
* new setting: The closest zoom level. How close we can zoom in: 19 - the closest - max_zooom parameter
* new parameter [webdirectory-map enable_infowindow=1] 
* new parameter [webdirectory-map close_infowindow_out_click=1]
* bug fix: listings carousel did not update on search request

= Version 2.9.15 =
* improvement: display locations with same coordinates in one scrolling infoWindow using clusters on the map (Google Maps and MapBox)

= Version 2.9.14 =
* bug fix: search by phone numbers in search forms
* bug fix: 768px min width incorrect CSS on list view mode

= Version 2.9.13 =
* new feature: sorting date metabox at admin dashboard to edit listings sorting date manually
* improvement: follow custom_home parameter on taxonomy pages (categories, locations, tags)
* bug fix: drawing panel incorrect search requests in polygon area
* bug fix: multi-select fields did not work in WPBakery Page Builder directory widgets settings

= Version 2.9.12 =
* bug fix: using start_address parameter returns incorrect results

= Version 2.9.11 =
* New updater
* improvement: do not auto-scroll to listings on search forms when clicking reset buttons
* improvement: whatsapp number link opens in new window
* bug fix: broken string/textarea fields search

= Version 2.9.10 =
* bug fix: inappropriate automatic frontend dashboard pages mass creation

= Version 2.9.9 =
* improvement: added distance from center when search by radius
* improvement: address search visible parameter was added
* bug fix: problem of mapbox directions on single listing page was fixed
* bug fix: search radius slider field value by default
* bug fix: adapted for latest Elementor plugin
* bug fix: php error in payments addon

= Version 2.9.8 =
* improvement: added 'use_wrapper' parameter in [webdirectory-dashboard] shortcode
* bug fix: 5-columns layout of a search form could not be saved
* bug fix: missing subcategories search in single dropdowns

= Version 2.9.7 =
* bug fix: some MapBox infoWindow CSS issues
* bug fix: possible javascript errors

= Version 2.9.6 =
* bug fix: missing javascript files on load after previous updates

= Version 2.9.5 =
* bug fix: demo content CSS fixes

= Version 2.9.4 =
* improvement: edit "Try to search" and "Search in radius" labels in search forms options
* improvement: "Page Header" WP widget and Elementor widget was added
* improvement: now decimal values available when search by radius
* bug fix: follow content fields shortcode parameters
* bug fix: follow current directory on keywords search suggestions
* bug fix: hours field was displaying when empty
* bug fix: show listings by categories/locations at the admin backend
* bug fix: search field select dependency terms problem
* bug fix: hierarhical and multi-select search fields reset error

= Version 2.9.3 =
* bug fix: incorrect search by single dates was fixed
* bug fix: correct link in password reset emails
* bug fix: incorrect shortcodes processing after textarea fields

= Version 2.9.2 =
* improvement: updater now shows error messages
* bug fix: incorrect textarea content fields value

= Version 2.9.1 =
* bug fix: php errors on elementor pages

= Version 2.9.0 =
* improvement: search by opening hours field
* improvement: sticky-scroll search forms on map now have fixed position in the map sidebar
* improvement: pan the map to entered address when search in radius
* improvement: now users can enable WooCommerce subscription directly on listing upgrade checkout
* improvement: bounce map markers on address hover
* improvement: 24 Elementor widgets added
* new shortcodes:
[webdirectory-listing-header]
[webdirectory-listing-fields]
[webdirectory-listing-gallery]
[webdirectory-listing-map]
[webdirectory-listing-videos]
[webdirectory-listing-contact]
[webdirectory-listing-report]
[webdirectory-listing-comments]
- use with [webdirectory-listing-page]

* improvement: placeholder setting implemented into taxonomy search fields
* new setting: Use Zip or Postal code label
* bug fix: disable to open links in new window setting, did not work for keywords search results
* bug fix: scroll to results after search submission did not work for maps
* bug fix: WooCommerce orders did not recognize on latest WC versions

= Version 2.8.2 =
* new settings: Categories & Locations tables colors - links, hover links, terms and heading terms background colors
* improvement: select color for the taxonomies terms in search forms
* improvement: new search mode for taxonomies - checkboxes and radios buttons
* bug fix: misprint in the name of search shortcode [webdirectory-search] in Search Forms table

= Version 2.8.1 =
* bug fix: broken post types functions on the last update

= Version 2.8.0 =
* improvement: new search system
* improvement: new Google Maps style: No default Points Of Interest on the map
* improvement: follow miles/kilometers setting on directions/route panel in MapBox
* improvement: listing title on a single listing page now displays again
* new settings: order categories and locations tables by default (drag & drop on admin pages), alphabetically or by count

= Version 2.7.8 =
* security update

= Version 2.7.7 =
* improvement: MapBox GL version was updated
* bug fix: php error in directory_controller.php after last update

= Version 2.7.6 =
* new shortcode: [webdirectory-page-title]
* improvement: 'hide_listings' parameter in listings shortcode to hide listings on load before search
* bug fix: noindex meta enabled in Yoast SEO plugin in Imitation mode
* bug fix: [webdirectory-listings] shortcode 'order_by' parameter did not follow on search

= Version 2.7.5 =
* new feature: Imitation mode - some themes require imitation mode to get working listings/categories/locations/tags pages
* bug fix: slider shortcode was not working after previous update
* bug fix: show search button by default on custom home pages
* bug fix: close button at the map marker info window did not work on MapBox maps

= Version 2.7.4 =
* improvement: better compatibility with popular themes
* new feature: directories="ID" parameter was added into [webdirectory-dashboard] shortcode
* improvement: paid listing will not become expired after auto-downgrade to free level
* bug fix: "Save listing in PDF" button was not working in Chrome
* bug fix: bulk frontend submission page creation
* bug fix: [webdirectory-listing-page] shortcode did not follow directory=ID parameter

= Version 2.7.3 =
* new setting: hide search button on the form
* new setting: auto-scroll to listings on search submit
* improvement: map marker info window generated in template (customize it now)
* bug fix: do shortcodes on [webdirectory-listing-page]

= Version 2.7.2 =
* improvement: adapted for Elementor
* bug fix: wrong content on categories pages

= Version 2.7.1 =
* improvement: flush rewrite rules on update

= Version 2.7.0 =
* improvement: custom post type pages used now
* bug fix: PDFmyURL service URL repaired
* bug fix: wrong CSS in grid columns on iPad

= Version 2.6.13 =
* improvement: MapBox geolocation service follows language
* improvement: WooCommerce Subscriptions updated to fit new listings level subscription on listings upgrades
* improvement: display sibling categories and locations when current term does not have neither children, nor listings
* bug fix: removed wrong opengraph tags of the SEO plugin

= Version 2.6.12 =
* improvement: updater message was added
* improvement: additional map marker info field was added in CSV import
* bug fix: sticky-scroll maps have not been resized after page load

= Version 2.6.11 =
* bug fix: wrong categories and locations listings counts

= Version 2.6.10 =
* improvement: custom sorting of Categories and Locations items
* improvement: reCAPTCHA v3 was added
* bug fix: listings did not apply from listings packages 

= Version 2.6.9 =
* improvement: added levels parameter into the [webdirectory] shortcode
* bug fix: wrong UK address autocomplete code for the MapBox geocoder
* bug fix: php errors on listings level creation
* bug fix: wrong categories and locations listings counts

= Version 2.6.8 =
* improvement: added scroll to the map when "show on map" icon was clicked on a listing
* improvement: [webdirectory-submit] shortcode with levels parameter was not working in SiteOrigin editor
* improvement: added invoice ID column in the Directory invoices table and search by invoice ID
* new setting: enable/disable HTML and shortcodes in the listing description field
* bug fix: MapBox clusters did not clear after map update

= Version 2.6.7 =
* new feature: specify which users can submit listings by user roles
* improvement: better compatibility with the new version of Yoast SEO plugin v14 (Open Graph meta tags)
* bug fix: separate translation strings of expiration email notification subjects
* bug fix: missing CSS slider on certain occasions

= Version 2.6.6 =
* bug fix: error message after v2.6.4 update

= Version 2.6.5 =
* bug fix: jQuery deprecated methods were removed
* bug fix: lighbox gallery did not open on some mobile devices

= Version 2.6.4 =
* improvement: categories and locations listings count related to their directory only, listings count per each directory individually
* improvement: rating_stars parameter in [webdirectory-listings] shortcode
* improvement: MapBox library version was updated
* bug fix: compatibility with wpDiscuz plugin
* bug fix: wp_update_post() in payments checkout fall into inifinite loop on certain occasions
* bug fix: RTL support on delete image button

= Version 2.6.3 =
* improvement: ability to set post status along with the listing status in CSV file
* improvement: better compatibility with the new version of Yoast SEO plugin v14 (canonical URLs)
* bug fix: show login form after logout from the invoices dashboard tab
* bug fix: payments addon templates missing customization paths
* bug fix: summary field does not show since 2.6.0
* integration_hooks.php file explaining some w2dc filters

= Version 2.6.2 =
* bug fix: pagination of related listings shortcode did not work on certain occasions
* our plugins section updated

= Version 2.6.1 =
* improvement: listing level name on the WooCommerce checkout page
* bug fix: listings comments template appear in regular WP posts and pages on certain occasions
* bug fix: empty places when "No Maps" selected

= Version 2.6.0 =
* new feature: add predefined locations at the frontend submission form
* new feature: specify which users can see listings by user roles
* improvement: better compatibility with the new version of Yoast SEO plugin v14 (follow default titles of taxonomies items)
* improvement: load bxslider on single listing only when multiple images
* bug fix: broken comments counter at the single listings page
* bug fix: wrong "select map marker" dialog
* bug fix: duplicate listings when order by ratings

= Version 2.5.20 =
* improvement: better compatibility with the new version of Yoast SEO plugin v14 (content fields snippets support)

= Version 2.5.19 =
* improvement: ability to limit number of tags per listings level
* improvement: better compatibility with the new version of Yoast SEO plugin v14 (robots metadata)

= Version 2.5.18 =
* bug fix: CSS issue after 2.5.17

= Version 2.5.17 =
* improvement: license keys information was added to the debug
* bug fix: breadcrumbs have left a home link even disabled
* bug fix: do not auto-zoom on a map when auto-geolocation enabled

= Version 2.5.16 =
* bug fix: website content fields type was broken after latest updates

= Version 2.5.15 =
* bug fix: map markers icons by category problem
* bug fix: implode() php error in ajax controller

= Version 2.5.14 =
* improvement: related_listing parameter was added to slider shortcode to display images of current listing
* improvement: text value instead of ID in the checkboxes/select/radio content fields CSV export
* improvement: Contact Form 7 _post_ shortcodes compatibility
* improvement: ability to delete pending listings at the frontend dashboard
* improvement: take listings map markers icons from the most relevant category on the search
* improvement: adapted for the new version of Yoast SEO plugin v14
* new setting: hide listing title on a single listing page
* bug fix: map AJAX search on certain occasions
* bug fix: CSS issue on checkboxes on mobile devices

= Version 2.5.13 =
* new shortcodes: [webdirectory-content-field] and [webdirectory-content-fields-group]
* new widgets: display certain content field and content fields group on a single listing page
* new setting: enable/disable map on a single listing page
* bug fix: 0 value in CSV import of digital content field was missed
* bug fix: contact form does not appear on certain occasions

= Version 2.5.12 =
* improvement: images slider was updated
* improvement: upload own image icons to content fields
* improvement: 'more filters' search section appears only when filters ready for the search
* bug fix: hide empty categories does not work on certain occasions
* bug fix: hidden content fields in the metabox on certain occasions
* bug fix: 'w2dc-listing-level-{LEVEL_ID}' CSS class was moved to relevant div

= Version 2.5.11 =
* improvement: 'search nearby' label was added in addresses search dropdown
* improvement: 'w2dc-listing-level-{LEVEL_ID}' CSS class was added
* improvement: Vafpress Framework was updated to avoid conflict with select2 
* bug fix: listings links in WPML
* bug fix: bounce map markers animation on hover a listing when clusters enabled
* bug fix: avoid conflicts in WP Query from another plugins on sertain occasions

= Version 2.5.10 =
* improvement: the plugin was adapted to work with Ratings & Reviews plugin for WordPress
* deprecated: richtext reviews in Ratings addon
* bug fix: php warnings and error messages after the previous update

= Version 2.5.9 =
* bug fix: REST API and Loopback Request issues were fixed
* bug fix: missing Listings Directories section after the previous update

= Version 2.5.8 =
* improvement: setting to change the size of Font Awesome map markers
* improvement: automatic update by access token

= Version 2.5.7 =
* improvement: correct redirect on login/registration/claim listing
* improvement: avoid broken lazyload images of some optimization plugins
* improvement: dashboard notice on how many listings a user has in his packages
* improvement: review info metabox at the frontend dashboard
* improvement: bounce map markers on hover a listing
* improvement: listing-thumbnail (800x600) image size was added into WordPress
* bug fix: breadcrumbs micro-data schema issue on sertain occasions

= Version 2.5.6 =
* improvement: breadcrumbs micro-data schema was improved

= Version 2.5.5 =
* bug fix: javascript errors on widgets page on certain occasions
* bug fix: force to convert json input into UTF-8 on AJAX responses
* bug fix: the setting to hide Listing ratings metabox did not work

= Version 2.5.4 =
* improvement: scroll to search input top on click on touch devices
* bug fix: search input reset did not work on certain occasions

= Version 2.5.3 =
* bug fix: JS error in conflict with Revolution Slider after the last update
* bug fix: PHP warnings on update
* bug fix: PHP warnings on checkboxes content fields

= Version 2.5.2 =
* improvement: re-calculate listings ratings after reset action or reviews changes
* improvement: highlight map markers on hover a listing
* bug fix: paypal IPN was not valid when French characters persist in serialized metadata
* bug fix: php warning on tags pages
* bug fix: missing search field on the mapbox full screen mode

= Version 2.5.1 =
* improvement: 'ratings' parameter was added to [webdirectory-listings] shortcode
* bug fix: hide export options when reviews disabled, use listings export by default
* bug fix: images upload AJAX response was not converted into JSON for some reason

= Version 2.5.0 =
* new feature: checkboxes content field has ability to add icons near items
* new feature: new content field type "phone", allows to add special meta tags to make call by click or open needed app (Viber, WhatsApp, Telegram)
* new feature: content fields groups on submission page now have own metaboxes and could be sorted
* new feature: listing info metabox at the frontend dashboard
* new feature: added images metadata info (file size and dimensions) on the submission form
* new feature: import images by URLs in CSV file
* new setting: PDF page orientation - either portrait or landscape
* improvement: MapBox library version was updated
* improvement: listings counter in checkboxes search field follows directory parameter
* improvement: added notice to enable maps first when no maps is used for the maps shortcode
* improvement: Google Places autocomplete service displays more relevant suggestions
* improvement: layout wraps images gallery by the first fields group
* improvement: removed empty space when all fields names are hidden in fields group
* bug fix: submit and manage images on Android devices
* bug fix: conflict with WooCommerce Admin plugin