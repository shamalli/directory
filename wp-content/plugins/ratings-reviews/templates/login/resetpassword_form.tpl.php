<div class="w2rr-content">
	<?php w2rr_renderMessages(); ?>

	<h3><?php esc_html_e('Enter your new password below.', 'w2rr') ?></h3>

	<div class="w2rr-submit-section-adv">
		<?php w2rr_resetpassword_form(array('rp_key' => $rp_key)); ?>
	</div>
</div>