<div class="vp-field vp-textarea" data-vp-type="vp-textarea">
	<div class="label">
		<label>
			<?php esc_html_e('Import', 'w2rr') ?>
		</label>
		<div class="description">
			<p><?php esc_html_e('Import Options', 'w2rr') ?></p>
		</div>
	</div>
	<div class="field">
		<div class="input">
			<textarea id="vp-js-import_text"></textarea>
			<div class="buttons">
				<input id="vp-js-import" class="vp-button button" type="button" value="<?php esc_attr_e('Import', 'w2rr') ?>" />
				<span class="w2rr-margin-left-10">
					<span id="vp-js-import-loader" class="vp-field-loader w2rr-display-none"><img src="<?php W2RR_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" class="w2rr-vertical-align-middle"></span>
					<span id="vp-js-import-status w2rr-display-none"></span>
				</span>
			</div>
		</div>
	</div>
</div>

<div class="vp-field vp-textarea" data-vp-type="vp-textarea">
	<div class="label">
		<label>
			<?php esc_html_e('Export', 'w2rr') ?>
		</label>
		<div class="description">
			<p><?php esc_html_e('Export Options', 'w2rr') ?></p>
		</div>
	</div>
	<div class="field">
		<div class="input">
			<textarea id="vp-js-export_text" onclick="this.focus();this.select()" readonly="readonly"></textarea>
			<div class="buttons">
				<input id="vp-js-export" class="vp-button button" type="button" value="<?php esc_attr_e('Export', 'w2rr') ?>" />
				<span class="w2rr-margin-left-10">
					<span id="vp-js-export-loader" class="vp-field-loader w2rr-display-none"><img src="<?php W2RR_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" class="w2rr-vertical-align-middle"></span>
					<span id="vp-js-export-status w2rr-display-none"></span>
				</span>
			</div>
		</div>
	</div>
</div>