<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php foreach ($items as $item): ?>
<label>
	<?php $checked = ($item->value == $value); ?>
	<input type="radio" <?php if($checked) echo 'checked'; ?> class="vp-input<?php if($checked) echo " checked"; ?>" name="<?php w2dc_esc_e($name); ?>" value="<?php w2dc_esc_e($item->value); ?>" />
	<img src="<?php echo W2DC_VP_Util_Res::img($item->img); ?>" alt="<?php w2dc_esc_e($item->label); ?>" class="vp-js-tipsy image-item" style="<?php W2DC_VP_Util_Text::print_if_exists($item_max_width, 'max-width: %spx; '); ?><?php W2DC_VP_Util_Text::print_if_exists($item_max_height, 'max-height: %spx; '); ?>" original-title="<?php w2dc_esc_e($item->label); ?>" />
</label>
<?php endforeach; ?>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>