<?php

return array(
	'title' => 'Listings Submission',
	'content' => '
		
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="submit_tables">Submission tables</h2>
		
		This option becomes available when Frontend submission & dashboard addon was enabled.
		
		Listings submission at the frontend divided into 2 steps:
		<ol>
			<li>Choose listing level (plan). When there is more than 1 listings level.</li>
			<li>Fill in submission form. Enter data in listing fields - title, description, categories, addresses, e.t.c.</li>
		</ol>
		
		Default <strong>&#091;webdirectory-submit&#093;</strong> shortcode displays all available listings levels (plans) for the first directory.
		<img src="[base_url]/wp-content/uploads/2018/04/submission_plans.png" />
		
		Instead of default pricing tables (first submission step) it is possible to use 3rd party plugins or custom layout pages. Links to submission form you can find hovering over "Submit" buttons.
		Examples:
		<strong>http://yoursite.com/submit/?level=1</strong>
		<strong>http://yoursite.com/submit/?directory=2&level=1</strong>
		<i class="fa fa-exclamation-triangle"></i> A page with <strong>&#091;webdirectory-submit&#093;</strong> shortcode still required for the second submission step (submission form).
		
		With levels parameter it allows to build custom tables with specific levels (plans). For example:
		<strong>&#091;webdirectory-submit levels="1,2"&#093;</strong> - shows levels tables with listing levels IDs 1 and 2. Frontend users are allowed to submit listings in these levels, but administrators still allowed to manage listings in the 3rd level.
		
		Explanation of all parameters of this shortcode you can find <a href="[base_url]/documentation/shortcodes/">here</a>. Examples <a href="[base_url]/shortcodes/webdirectory-levels-table/">here</a>.
		
		<hr />
		
		<h2 id="submit_form">Submission form</h2>
		
		Submission form metaboxes and fields depend on directory settings.
		
		<img src="[base_url]/wp-content/uploads/submit_listings_form.png" width="800" />
	</div>
		
'
);

?>