<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#the-list").sortable({
				delay: 50,
				placeholder: "ui-sortable-placeholder",
				helper: function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				},
				start: function(e, ui){
					ui.placeholder.height(ui.item.height());
				},
				update: function( event, ui ) {
					$("#content_fields_order").val($(".content_field_weight_id").map(function() {
						return $(this).val();
					}).get());
				}
	    	});
		});
	})(jQuery);
</script>

<h2>
	<?php esc_html_e('Content fields', 'w2dc'); ?>
	<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . esc_html__('Create new field', 'w2dc') . '</a>', $_GET['page'], 'add'); ?>
</h2>
<?php esc_html_e('You may order content fields by drag & drop.', 'w2dc'); ?>
<form method="POST" action="<?php echo admin_url('admin.php?page=w2dc_content_fields'); ?>">
	<input type="hidden" id="content_fields_order" name="content_fields_order" value="" />
	<?php 
		$content_fields_table->display();
		
		submit_button(esc_html__('Save changes', 'w2dc'), 'primary', 'submit_table');
	?>
</form>
<br />
<br />

<h2>
	<?php esc_html_e('Content fields groups', 'w2dc'); ?>
	<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . esc_html__('Create new fields group', 'w2dc') . '</a>', $_GET['page'], 'add_group'); ?>
</h2>
<form method="POST" action="<?php echo admin_url('admin.php?page=w2dc_content_fields'); ?>">
	<?php $content_fields_groups_table->display(); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>