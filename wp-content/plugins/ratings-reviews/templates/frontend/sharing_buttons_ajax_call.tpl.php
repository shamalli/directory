<?php if (get_option('w2rr_share_buttons')): ?>
<div class="w2rr-share-buttons">
	<script>
		(function($) {
			"use strict";
	
			$(function() {
				$('.w2rr-share-buttons').addClass('w2rr-ajax-loading');
				$.ajax({
					type: "POST",
					url: w2rr_js_objects.ajaxurl,
					data: {'action': 'w2rr_get_sharing_buttons', 'post_id': <?php echo $post_id; ?>, 'post_url': "<?php echo $post_url; ?>"},
					dataType: 'html',
					success: function(response_from_the_action_function){
						if (response_from_the_action_function != 0)
							$('.w2rr-share-buttons').html(response_from_the_action_function);
					},
					complete: function() {
						$('.w2rr-share-buttons').removeClass('w2rr-ajax-loading').css('height', 'auto');
					}
				});
			});
		})(jQuery);
	</script>
</div>
<?php endif; ?>