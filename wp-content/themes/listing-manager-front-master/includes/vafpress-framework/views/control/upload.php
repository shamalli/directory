<?php if(!$is_compact) echo VP_W2THEME_View::instance()->load('control/template_control_head', $head_info); ?>

<input class="vp-input" type="text" readonly id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
<div class="buttons">
	<input class="vp-js-upload vp-button button" type="button" value="<?php esc_attr_e('Choose File', 'vp_w2theme_textdomain'); ?>" />
	<input class="vp-js-remove-upload vp-button button" type="button" value="x" />
</div>
<div class="image">
	<img src="<?php echo $preview; ?>" alt="" />
</div>

<?php if(!$is_compact) echo VP_W2THEME_View::instance()->load('control/template_control_foot'); ?>