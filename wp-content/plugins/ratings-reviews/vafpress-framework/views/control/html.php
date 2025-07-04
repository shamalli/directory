<?php

// @codingStandardsIgnoreFile

?>
<?php extract($head_info); ?>

<div class="vp-field <?php w2rr_esc_e($type); ?><?php echo !empty($container_extra_classes) ? (' ' . $container_extra_classes) : ''; ?>"
	data-vp-type="<?php w2rr_esc_e($type); ?>"
	<?php echo W2RR_VP_Util_Text::print_if_exists(isset($binding) ? $binding : '', 'data-vp-bind="%s"'); ?>
	<?php echo W2RR_VP_Util_Text::print_if_exists(isset($dependency) ? $dependency : '', 'data-vp-dependency="%s"'); ?>
	id="<?php w2rr_esc_e($name); ?>">
	<div class="field" style="height: <?php w2rr_esc_e($height); ?>;">
		<div class="input" id="<?php w2rr_esc_e($name . '_dom'); ?>">
			<?php echo W2RR_VP_WP_Util::kses_html($value); ?>
		</div>
		<textarea name="<?php w2rr_esc_e($name); ?>" class="vp-hide"><?php echo W2RR_VP_WP_Util::kses_html($value); ?></textarea>
		<div class="vp-js-bind-loader vp-field-loader vp-hide"><img src="<?php W2RR_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /></div>
	</div>
</div>