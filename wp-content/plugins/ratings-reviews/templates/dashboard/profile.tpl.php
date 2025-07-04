	<form action="" method="POST" role="form" class="w2rr-dashboard-profile">
		<input type="hidden" name="referer" value="<?php w2rr_esc_e($frontend_controller->referer); ?>" />
		<input type="hidden" name="rich_editing" value="<?php echo ($frontend_controller->user->rich_editing) ? 1 : 0; ?>" />
		<input type="hidden" name="admin_color" value="<?php echo ($frontend_controller->user->admin_color) ? $frontend_controller->user->admin_color : 'fresh'; ?>" />
		<input type="hidden" name="admin_bar_front" value="<?php echo ($frontend_controller->user->show_admin_bar_front) ? 1 : 0; ?>" />

		<div class="w2rr-form-group">
			<p>
				<label for="user_login"><?php esc_html_e('Username', 'w2rr'); ?></label>
				<input type="text" name="user_login" class="w2rr-form-control" value="<?php echo esc_attr($frontend_controller->user->user_login); ?>" disabled="disabled" /> <span class="description"><?php esc_html_e('Usernames cannot be changed.', 'w2rr'); ?></span>
			</p>
			<p>
				<label for="first_name"><?php esc_html_e('First Name', 'w2rr') ?></label>
				<input type="text" name="first_name" class="w2rr-form-control" value="<?php echo esc_attr($frontend_controller->user->first_name); ?>" />
			</p>
			<p>
				<label for="last_name"><?php esc_html_e('Last Name', 'w2rr') ?></label>
				<input type="text" name="last_name" class="w2rr-form-control" value="<?php echo esc_attr($frontend_controller->user->last_name); ?>" />
			</p>
			<p>
				<label for="nickname"><?php esc_html_e('Nickname', 'w2rr') ?> <span class="description"><?php esc_html_e('(required)', 'w2rr'); ?></span></label>
				<input type="text" name="nickname" class="w2rr-form-control" value="<?php echo esc_attr($frontend_controller->user->nickname); ?>" />
			</p>
			<p>
				<label for="display_name"><?php esc_html_e('Display to Public as', 'w2rr') ?></label>
				<select name="display_name" class="w2rr-form-control">
				<?php
					foreach ($public_display as $id => $item) {
				?>
					<option id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($item); ?>"<?php selected($frontend_controller->user->display_name, $item); ?>><?php echo esc_html($item); ?></option>
				<?php
					}
				?>
				</select>
			</p>
			<p>
				<label for="email"><?php esc_html_e('E-mail', 'w2rr'); ?> <span class="description"><?php esc_html_e('(required)', 'w2rr'); ?></span></label>
				<input type="text" name="email" class="w2rr-form-control" value="<?php echo esc_attr($frontend_controller->user->user_email); ?>" />
			</p>
			<?php if (!get_option('w2rr_hide_author_link')): ?>
			<p>
				<label for="email"><?php esc_html_e('Website', 'w2rr'); ?></label>
				<input type="text" name="url" class="w2rr-form-control" value="<?php echo esc_url(get_the_author_meta('url')); ?>" />
			</p>
			<?php endif; ?>
			<p>
				<label><?php esc_html_e('User picture', 'w2rr'); ?></label>
				<?php $upload_avatar->display_form(); ?>
			</p>
			<div>
				<label for="pass1"><?php esc_html_e('New Password', 'w2rr'); ?></label>
				<div class="user-pass1-wrap">
					<button type="button" class="button w2rr-btn w2rr-btn-primary wp-generate-pw hide-if-no-js"><?php esc_html_e('Generate Password', 'w2rr'); ?></button>
					<div class="wp-pwd hide-if-js">
						<span class="password-input-wrapper">
							<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr(wp_generate_password(24)); ?>" aria-describedby="pass-strength-result" />
							<div class="user-pass2-wrap hide-if-js"><input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" /></div>
						</span>
						<button type="button" class="button w2rr-btn w2rr-btn-primary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e('Hide password', 'w2rr'); ?>">
							<span class="dashicons dashicons-hidden"></span>
							<span class="text"><?php esc_html_e('Hide', 'w2rr'); ?></span>
						</button>
						<button type="button" class="button w2rr-btn w2rr-btn-primary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e('Cancel password change', 'w2rr'); ?>">
							<span class="text"><?php esc_html_e('Cancel', 'w2rr'); ?></span>
						</button>
						<div class="w2rr-display-none" id="pass-strength-result" aria-live="polite"></div>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($frontend_controller->user->ID); ?>" />
		<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
		<?php submit_button(esc_html__('Save changes', 'w2rr'), 'w2rr-btn w2rr-btn-primary'); ?>
	</form>