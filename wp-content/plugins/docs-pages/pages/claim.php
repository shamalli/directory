<?php

return array(
	'title' => 'Claim Functionality',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		
		<h2 id="claim">Claim Functionality</h2>
		
		Following settings appear at the General Settings tab of <em>"Directory Admin -> Directory Settings"</em> page on the <em>"General settings"</em> tab when <em>"Frontend submission & dashboard addon"</em> was enabled.
		
		<strong>Enable claim functionality</strong> - enable/disable claim functionality at the frontend. When enabled - each listing has option <em>"Allow claim"</em>, by checking this option you allow registered users to claim this listing. When claim allowed - the button "Is this you ad?" appears on listing\'s details page, this button opens claim form. <span style="text-decoration: underline;">This button appears</span> only when user is not logged in as current listing owner, Frontend submission addon was enabled and when page with <strong>&#091;webdirectory-dashboard&#093;</strong> <a href="[base_url]/documentation/frontend/">shortcode exists</a>.
		
		<img src="[base_url]/wp-content/uploads/claim_button.png" />
		
		So to see this button, follow instructions:
		<ol>
			<li>Enable <a href="[base_url]/documentation/frontend/">Frontend submission addon</a> and create a page with <strong>&#091;webdirectory-dashboard&#093;</strong> shortcode.</li>
			<li>Enable claim functionality in the Claim Functionality settings on the <em>"General settings"</em> tab.</li>
			<li>Go to listing edition page and click <em>"Allow claim"</em> option in <em>"Listing claim"</em> metabox.
			<img src="[base_url]/wp-content/uploads/listing_claim_metabox.png" class="alignnone size-full" />
			</li>
			<li>Log out if you are owner of this listing.</li>
		</ol>
		
		When visitor sends claim request - notification about claim for this listing will be sent to the current listing owner.
		After approval claimer will become owner of this listing and receive email notification about successful approval.
		
		<img src="[base_url]/wp-content/uploads/listing_administration_row_claim.png" class="alignnone size-full" />
		
		<strong>Approval of claim required</strong> - when switched on any claimed listing requires approval of claim by current listing owner. In other case claim will be processed immediately without any notifications.
		
		<strong>What will be with listing status after successful approval?</strong> - when it was set to <em>"just approval"</em> option - the status of claimed listing will not be changed after approval. <em>"expired status"</em> option means that after approval of claimed listing it becomes expired and new owner have to renew it to make listing active. Renewal of listing may be <a href="[base_url]/documentation/payments/">payment option</a>.
		
		<strong>Hide contact form on claimable listings</strong> - just hide contact form when listing is set to be claimed.
		
		<strong>Hide claim metabox at the frontend dashboard</strong> - with this setting only admin may set up listing to be claimed.
		
		<img src="[base_url]/wp-content/uploads/claim_settings.png" />
		
		<i class="fa fa-star"></i> By the way, there is the option in <a href="[base_url]/documentation/import/">CSV importer</a> to set up all imported listings as claimable.
	</div>
'
);

?>