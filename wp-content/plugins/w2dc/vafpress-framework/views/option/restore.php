<div class="vp-field">
	<div class="label">
		<label>
			<?php esc_html_e('Restore Default Options', 'w2dc') ?>
		</label>
		<div class="description">
			<p><?php esc_html_e('Restore options to initial default values.', 'w2dc') ?></p>
		</div>
	</div>
	<div class="field">
		<div class="input">
			<div class="buttons">
				<input class="vp-js-restore vp-button button button-primary" type="button" value="<?php w2dc_esc_e('Restore Default', 'w2dc') ?>" />
				<p><?php esc_html_e('** Please make sure you have already make a backup data of your current settings. Once you click this button, your current settings will be gone.', 'w2dc'); ?></p>
				<span class="w2dc-margin-left-10">
					<span class="vp-field-loader vp-js-loader w2dc-display-none"><img src="<?php W2DC_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>"  class="w2dc-vertical-align-middle"></span>
					<span class="vp-js-status w2dc-display-none"></span>
				</span>
			</div>
		</div>
	</div>
</div>