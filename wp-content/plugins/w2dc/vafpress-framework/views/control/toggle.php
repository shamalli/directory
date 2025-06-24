<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<label>
	<input <?php if( $value ) echo 'checked'; ?> class="vp-input<?php if( $value ) echo ' checked'; ?>" type="checkbox" name="<?php w2dc_esc_e($name); ?>" value="1" />
	<span></span>
</label>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>