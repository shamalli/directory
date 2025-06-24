<?php

// @codingStandardsIgnoreFile

?>
<div class="vp-field <?php w2rr_esc_e($type); ?><?php echo !empty($container_extra_classes) ? (' ' . $container_extra_classes) : ''; ?>"
	data-vp-type="<?php w2rr_esc_e($type); ?>"
	<?php echo W2RR_VP_Util_Text::print_if_exists($validation, 'data-vp-validation="%s"'); ?>
	<?php echo W2RR_VP_Util_Text::print_if_exists(isset($binding) ? $binding : '', 'data-vp-bind="%s"'); ?>
	<?php echo W2RR_VP_Util_Text::print_if_exists(isset($items_binding) ? $items_binding : '', 'data-vp-items-bind="%s"'); ?>
	<?php echo W2RR_VP_Util_Text::print_if_exists(isset($dependency) ? $dependency : '', 'data-vp-dependency="%s"'); ?>
	id="<?php w2rr_esc_e($name); ?>">
	<div class="label">
		<label><?php echo esc_html($label); ?></label>
		<?php W2RR_VP_Util_Text::print_if_exists($description, '<div class="description">%s</div>'); ?>
	</div>
	<div class="field">
		<div class="input">