<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<label class="indicator" for="<?php w2rr_esc_e($name); ?>"><span style="background-color: <?php w2rr_esc_e($value); ?>;"></span></label>
<input id="<?php w2rr_esc_e($name); ?>" class="vp-input vp-js-colorpicker"
	type="text" name="<?php w2rr_esc_e($name); ?>" value="<?php echo w2rr_esc_e($value); ?>" data-vp-opt="<?php w2rr_esc_e($opt); ?>" />

<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_foot'); ?>