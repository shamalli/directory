<div class="w2dc-content">
	<?php w2dc_renderMessages(); ?>

	<h3><?php esc_html_e('Enter your new password below.', 'w2dc') ?></h3>

	<div class="w2dc-submit-section-adv">
		<?php w2dc_resetpassword_form(array('rp_key' => $rp_key)); ?>
	</div>
</div>