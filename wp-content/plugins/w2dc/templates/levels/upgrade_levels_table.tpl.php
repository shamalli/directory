<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<script>
	(function($) {
	"use strict";

		$(function() {
			$("input[name*='level_disabled_']").each( function() {
				levelDisableChange($(this));
			});
	
			$("input[name*='level_disabled_']").change( function() {
				levelDisableChange($(this));
			});
	
			function levelDisableChange(checkbox) {
				if (checkbox.is(':checked'))
					checkbox.parent().parent().find("input:not(.level_disabled)").attr('disabled', 'true');
				else
					checkbox.parent().parent().find("input:not(.level_disabled)").removeAttr('disabled');
			}
		});
	})(jQuery);
</script>

<h2>
	<?php esc_html_e('Listings upgrade', 'w2dc'); ?>
</h2>

<form method="POST" action="<?php echo admin_url('admin.php?page=w2dc_manage_upgrades'); ?>">
	<table class="widefat w2dc-admin-table">
		<thead>
			<tr>
				<th></th>
				<?php foreach ($levels->levels_array AS $level): ?>
				<th><?php w2dc_esc_e($level->name); ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<?php $i = 0; ?>
		<?php foreach ($levels->levels_array AS $level1): ?>
		<?php $i++; ?>
		<tr <?php if ($i % 2 != 0) echo "class='alternate'"; ?>>
			<th><?php w2dc_esc_e($level1->name); ?></th>
			<?php foreach ($levels->levels_array AS $level2): ?>
			<th title="<?php esc_attr(printf(esc_html__("From %s to %s", 'w2dc'), $level1->name, $level2->name)); ?>">
				<?php if ($level1->id != $level2->id): ?>
				<?php do_action('w2dc_upgrade_meta_html', $level1, $level2); ?>
				<label><input type="checkbox" name="level_raiseup_<?php w2dc_esc_e($level1->id); ?>_<?php w2dc_esc_e($level2->id); ?>" value=1 <?php if (isset($level1->upgrade_meta[$level2->id])) checked($level1->upgrade_meta[$level2->id]['raiseup'], 1, true); ?> /> <?php esc_html_e('Raise Up after upgrade', 'w2dc'); ?></label><br />
				<label><input type="checkbox" class="level_disabled" name="level_disabled_<?php w2dc_esc_e($level1->id); ?>_<?php w2dc_esc_e($level2->id); ?>" value=1 <?php if (isset($level1->upgrade_meta[$level2->id])) checked($level1->upgrade_meta[$level2->id]['disabled'], 1, true); ?> /> <?php printf(esc_html__("Disable upgrade from %s to %s level", 'w2dc'), $level1->name, $level2->name); ?>*</label>
				<?php else: ?>
				N/A
				<?php endif; ?>
			</th>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</table>
	<p>*<?php esc_html_e('administrators and editors users roles still can change listings levels'); ?></p>
	<?php submit_button(esc_html__('Save changes', 'w2dc')); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>