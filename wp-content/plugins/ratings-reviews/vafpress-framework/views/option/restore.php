<div class="vp-field">
	<div class="label">
		<label>
			<?php esc_html_e('Restore Default Options', 'w2rr') ?>
		</label>
		<div class="description">
			<p><?php esc_html_e('Restore options to initial default values.', 'w2rr') ?></p>
		</div>
	</div>
	<div class="field">
		<div class="input">
			<div class="buttons">
				<input class="vp-js-restore vp-button button button-primary" type="button" value="<?php esc_attr_e('Restore Default', 'w2rr') ?>" />
				<p><?php esc_html_e('** Please make sure you have already make a backup data of your current settings. Once you click this button, your current settings will be gone.', 'w2rr'); ?></p>
				<span class="w2rr-margin-left-10">
					<span class="vp-field-loader vp-js-loader w2rr-display-none"><img src="<?php W2RR_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>"  class="w2rr-vertical-align-middle"></span>
					<span class="vp-js-status w2rr-display-none"></span>
				</span>
			</div>
		</div>
	</div>
</div>