<?php

// @codingStandardsIgnoreFile

?>
<h3>
	<?php echo sprintf(esc_html__('Change level of listing "%s"', 'w2dc'), $w2dc_instance->current_listing->title()); ?>
</h3>

<p><?php esc_html_e('The level of listing will be changed. You may upgrade or downgrade the level. If new level has an option of limited active period - expiration date of listing will be recalculated automatically.', 'w2dc'); ?></p>

<form action="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'upgrade_listing', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'upgrade_action' => 'upgrade', 'referer' => urlencode($frontend_controller->referer))); ?>" method="POST">
	<?php if ($frontend_controller->action == 'show'): ?>
	<h3><?php esc_html_e('Choose new level', 'w2dc'); ?></h3>
	<?php foreach ($w2dc_instance->levels->levels_array AS $level): ?>
	<?php
	if (
		$w2dc_instance->current_listing->level->id != $level->id &&
		(
			!isset($w2dc_instance->current_listing->level->upgrade_meta[$level->id]) ||
			!$w2dc_instance->current_listing->level->upgrade_meta[$level->id]['disabled'] ||
			(current_user_can('editor') || current_user_can('manage_options'))
		)
		&&
		w2dc_is_user_allowed($level->who_can_submit)
	): ?>
	<p>
		<label><input type="radio" name="new_level_id" value="<?php w2dc_esc_e($level->id); ?>" /> <?php echo apply_filters('w2dc_level_upgrade_option', $level->name, $w2dc_instance->current_listing->level, $level); ?></label>
	</p>
	<?php endif; ?>
	<?php endforeach; ?>

	<input type="submit" value="<?php esc_attr_e('Change level', 'w2dc'); ?>" class="w2dc-btn w2dc-btn-primary" id="submit" name="submit">
	&nbsp;&nbsp;&nbsp;
	<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
	<?php elseif ($frontend_controller->action == 'upgrade'): ?>
	<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
	<?php endif; ?>
</form>