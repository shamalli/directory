<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<input class="vp-input" type="text" readonly id="<?php w2rr_esc_e($name); ?>" name="<?php w2rr_esc_e($name); ?>" value="<?php w2rr_esc_e($value); ?>" />
<div class="buttons">
	<input class="vp-js-upload vp-button button" type="button" value="<?php esc_attr_e('Choose File', 'w2rr'); ?>" />
	<input class="vp-js-remove-upload vp-button button" type="button" value="x" />
</div>
<div class="image">
	<img src="<?php w2rr_esc_e($preview); ?>" alt="" />
</div>

<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_foot'); ?>