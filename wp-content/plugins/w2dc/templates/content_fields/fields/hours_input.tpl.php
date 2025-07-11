<?php

// @codingStandardsIgnoreFile

?>
<div class="w2dc-form-group w2dc-field w2dc-field-input-block w2dc-field-input-block-<?php w2dc_esc_e($content_field->id); ?>">
	<div class="w2dc-col-md-2">
		<label class="w2dc-control-label">
			<?php w2dc_esc_e($content_field->name); ?>
		</label>
	</div>
	<div class="w2dc-col-md-10">
		<?php foreach ($week_days AS $key=>$day): ?>
		<div class="w2dc-week-day-wrap">
			<span class="w2dc-week-day"><?php w2dc_esc_e($content_field->week_days_names[$key]); ?></span>
			<span class="w2dc-week-day-controls">
				<select name="<?php w2dc_esc_e($day); ?>_from_hour_<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-week-day-input w2dc-week-day-input-from-hour"><?php echo $content_field->getOptionsHour($day.'_from'); ?></select>
				<?php if ($content_field->hours_clock == 12): ?>
				<select name="<?php w2dc_esc_e($day); ?>_from_am_pm_<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-week-day-input w2dc-week-day-input-from-am-pm"><?php echo $content_field->getOptionsAmPm($day.'_from'); ?></select>
				<?php endif; ?>
			</span>
			
			&nbsp;&nbsp;-&nbsp;&nbsp;
			
			<span class="w2dc-week-day-controls">
				<select name="<?php w2dc_esc_e($day); ?>_to_hour_<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-week-day-input w2dc-week-day-input-to-hour"><?php echo $content_field->getOptionsHour($day.'_to'); ?></select>
				<?php if ($content_field->hours_clock == 12): ?>
				<select name="<?php w2dc_esc_e($day); ?>_to_am_pm_<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-week-day-input w2dc-week-day-input-to-am-pm"><?php echo $content_field->getOptionsAmPm($day.'_to'); ?></select>
				<?php endif; ?>
			</span>
			<label>
				<input type="checkbox" name="<?php w2dc_esc_e($day); ?>_closed_<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-closed-day-option" <?php checked($content_field->value[$day.'_closed'], 1); ?> class="closed_cb" value="1" /> <?php esc_html_e('Closed', 'w2dc'); ?>
			</label>
		</div>
		<?php endforeach; ?>
		<div class="w2dc-week-day-clear-button">
			<button class="w2dc-btn w2dc-btn-primary w2dc-clear-hours"><?php esc_html_e('Reset hours & minutes', 'w2dc'); ?></button>
		</div>
	</div>
</div>