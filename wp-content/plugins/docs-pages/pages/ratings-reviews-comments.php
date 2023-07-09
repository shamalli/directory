<?php

return array(
	'title' => 'Ratings, comments and reviews',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		
		<h2 id="ratings_comments">Ratings and comments</h2>
		
		By default the plugin uses native WordPress comments system, using theme\'s template and styles. Simple "Leave a Reply" form is used to leave comments for a listing.

		<img src="[base_url]/wp-content/uploads/native_comments_form.png" width="500" alt="" class="alignnone size-full" />
		
		Whether to show comments form is controlled by the "Listings comments (reviews) mode" setting you can find on the <em>"Listings"</em> settings tab.
		
		<img src="[base_url]/wp-content/uploads/listings_comments_mode_setting.png" alt="" class="alignnone size-full" />
		
		"As configured in WP settings" - means comments are controlled by "Discussion" metabox on listings edition screen.
		
		<img src="[base_url]/wp-content/uploads/native_listings_comments_metabox.png" alt="" class="alignnone size-full" />
		
		<hr />
		
		Web 2.0 Directory plugin includes "<em>Ratings & Comments addon</em>". It allows to place 5-star ratings for any listings and use own comments templates. After you enabled addon refresh directory settings page - Ratings & Reviews tab will appear. Each <a href="[base_url]/documentation/listings-levels">listings level</a> has separate option to enable/disable ratings in this level.
		
		<img src="[base_url]/wp-content/uploads/rating.png" alt="" class="alignnone size-full" />
		
		<img src="[base_url]/wp-content/uploads/ratings_comments_settings.png" alt="" class="alignnone size-full" />
		
		<strong>Only registered users may place ratings</strong> - this setting restricts unregistered users to rate listings, when this setting unchecked - anyone can rate any listing. Please note, that when user places new rating, the plugin creates new record with ID of registered member, for anonymous users - the plugin stores their IPs, also the plugin saves cookie in user\'s browser. User can change his rating later.
		
		<strong>Allow users to flush ratings of own listings</strong> - when this option was checked - listing owner has ability to flush current rating of his listing.
		
		<strong>Allow sorting by ratings</strong> - switch on/off sorting by ratings.
		
		<strong>Comments mode</strong>:
		<ul>
			<li><strong>disabled</strong> - no comments at the listings</li>
			<li><strong>comments system of installed theme or another plugin</strong> - there is a way to use 3rd party plugins for comments</li> 
			<li><strong>use simple directory comments</strong> - the simplest comments</li>
		</ul>
		
		<img src="[base_url]/wp-content/uploads/comments_tree.png" alt="" class="alignnone size-full" />
		
		<hr />
		
		<h2 id="reviews">Reviews</h2>
		
		The best solution to collect and show feedback for directory listings on your site is our standalone<br /><a href="https://www.salephpscripts.com/ratings-reviews/">Ratings & Reviews plugin for WordPress</a>
		
		Attach reviews and place ratings to any post on your site including WooCommerce products. Just select post types you need to work with. The plugin displays all needed information and elements: list of reviews, add review button, submission form, stars and ratings. 
		
		<img src="[base_url]/wp-content/uploads/reviews_grid_view.png" width="600" alt="" class="alignnone size-full" />
		
		Review submission form:
		<img src="[base_url]/wp-content/uploads/review_frontend_submission.png" width="600" alt="" class="alignnone size-full" />
			
		<img src="[base_url]/wp-content/uploads/reviews_widget.png" alt="" class="alignnone size-full" />
		
		<i class="fa fa-exclamation-triangle"></i> When "Ratings & Reviews plugin" is used "Ratings & Comments addon" should be disabled, otherwise it will show both ratings.
	</div>
		
'
);

?>