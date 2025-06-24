<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<input class="vp-input" type="text" readonly id="<?php w2dc_esc_e($name); ?>" name="<?php w2dc_esc_e($name); ?>" value="<?php w2dc_esc_e($value); ?>" />
<div class="buttons">
	<input class="vp-js-upload vp-button button" type="button" value="<?php w2dc_esc_e('Choose File', 'w2dc'); ?>" />
	<input class="vp-js-remove-upload vp-button button" type="button" value="x" />
</div>
<div class="image">
	<img src="<?php w2dc_esc_e($preview); ?>" alt="" />
</div>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>