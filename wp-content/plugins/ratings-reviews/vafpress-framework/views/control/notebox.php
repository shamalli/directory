<?php

// @codingStandardsIgnoreFile

?>
<?php extract($head_info); ?>

<?php if(!$is_compact): ?>
<div class="vp-field <?php w2rr_esc_e($type); ?><?php echo !empty($container_extra_classes) ? (' ' . $container_extra_classes) : ''; ?>"
	data-vp-type="<?php w2rr_esc_e($type); ?>"
	<?php echo W2RR_VP_Util_Text::print_if_exists(isset($dependency) ? $dependency : '', 'data-vp-dependency="%s"'); ?>
	<?php $is_hidden ? 'style="display: none);"' : ''; ?>
	id="<?php w2rr_esc_e($name); ?>">
<?php endif; ?>
	<?php switch ($status) {
		case 'normal':
			$icon_class = 'fa-lightbulb-o';
			break;
		case 'info':
			$icon_class = 'fa-info-circle';
			break;
		case 'success':
			$icon_class = 'fa-check-circle';
			break;
		case 'warning':
			$icon_class = 'fa-exclamation-triangle';
			break;
		case 'error':
			$icon_class = 'fa-times-circle';
			break;
		default:
			$icon_class = 'fa-lightbulb-o';
			break;
	} ?>
	<i class="w2rr-fa w2rr-<?php w2rr_esc_e($icon_class); ?>"></i>
	<div class="label"><?php echo esc_html($label); ?></div>
	<?php W2RR_VP_Util_Text::print_if_exists($description, '<div class="description">%s</div>'); ?>

<?php if(!$is_compact): ?>
</div>
<?php endif; ?>