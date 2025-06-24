<?php

// @codingStandardsIgnoreFile

?>
<?php if ((!get_option('w2dc_payments_addon') && !w2dc_isWooActive()) && $args['show_period']): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php echo $level->getActivePeriodString(); ?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_sticky'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->sticky))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php if ($level->sticky): ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php else: ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php endif; ?>
			<?php esc_html_e('Sticky', 'w2dc'); ?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_featured'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->featured))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php if ($level->featured): ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php else: ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php endif; ?>
			<?php esc_html_e('Featured', 'w2dc'); ?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_categories'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && ($level->categories_number || $level->unlimited_categories)))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php
			if (!$level->unlimited_categories) {
				if ($level->categories_number == 1) {
				?>
				<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
				<?php 
					esc_html_e('1 category', 'w2dc');
				} elseif ($level->categories_number != 0) {
				?>
				<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
				<?php 
					printf(w2dc_esc_('Up to <strong>%d</strong> categories', 'w2dc'), $level->categories_number);
				} else {
				?>
				<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
				<?php  
					esc_html_e('No categories', 'w2dc');
				}
			} else {
			?>
				<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				esc_html_e('Unlimited categories', 'w2dc');
			}
			?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_locations'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->locations_number))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php
			if ($level->locations_number == 1) {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				esc_html_e('1 location', 'w2dc');
			} elseif ($level->locations_number != 0) {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				printf(w2dc_esc_('Up to <strong>%d</strong> locations', 'w2dc'), $level->locations_number);
			} else {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php 
				esc_html_e('No locations', 'w2dc');
			}
			?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_maps'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->map))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php if ($level->map): ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php else: ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php endif; ?>
			<?php esc_html_e('Map', 'w2dc'); ?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_images'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->images_number))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php
			if ($level->images_number == 1) {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				esc_html_e('1 image', 'w2dc');
			} elseif ($level->images_number != 0) {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				printf(w2dc_esc_('Up to <strong>%d</strong> images', 'w2dc'), $level->images_number);
			} else {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php 
				esc_html_e('No images', 'w2dc'); ?>
			<?php
			} 
			?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['show_videos'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->videos_number))): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php
			if ($level->videos_number == 1) {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				esc_html_e('1 video', 'w2dc');
			} elseif ($level->videos_number != 0) {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php 
				printf(w2dc_esc_('Up to <strong>%d</strong> videos', 'w2dc'), $level->videos_number);
			} else {
			?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php 
				esc_html_e('No videos', 'w2dc');
			}
			?>
		</div>
	</li>
<?php endif; ?>
<?php if ($args['options'] && !empty($args['options'][$level->id]) && ($options = $args['options'][$level->id])): ?>
<?php foreach ($options AS $option_name=>$option_value): ?>
	<li class="w2dc-list-group-item w2dc-choose-plan-option">
		<div class="w2dc-choose-plan-option-wrapper">
			<?php if ($option_value == 'yes'): ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-yes"></span>
			<?php elseif ($option_value == 'no'): ?>
			<span class="w2dc-choose-plan-option-icon w2dc-choose-plan-option-no"></span>
			<?php endif; ?>
			<?php w2dc_esc_e($option_name); ?>
		</div>
	</li>
<?php endforeach; ?>
<?php endif; ?>