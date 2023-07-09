<?php global $w2rr_social_services; ?>
<script>
	(function($) {
		"use strict";
	
		$(function() {
			$('.w2rr-share-button [data-toggle="w2rr-tooltip"]').w2rr_tooltip();
		});
	})(jQuery);
</script>
<?php foreach (get_option('w2rr_share_buttons') AS $button): ?>
<div class="w2rr-share-button">
	<?php w2rr_renderSharingButton($post_id, $post_url, $button); ?>
</div>
<?php endforeach; ?>