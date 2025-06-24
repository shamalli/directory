<p><?php echo wp_kses(__("By checking this option you allow registered users to claim this listing.", 'w2dc'), 'post'); ?></p>

<div class="w2dc-content">
	<div class="w2dc-checkbox">
		<label>
			<input type="checkbox" name="is_claimable" value=1 <?php checked(1, $listing->is_claimable, true); ?> />
			<?php esc_html_e('Allow claim', 'w2dc'); ?>
		</label>
	</div>
</div>
	
<?php do_action('w2dc_claim_metabox_html', $listing); ?>