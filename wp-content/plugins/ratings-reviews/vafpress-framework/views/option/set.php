<?php

// @codingStandardsIgnoreFile

?>
<div class="wrap">
	<h2><?php echo $set->get_title(); ?></h2>
	<?php echo do_action('w2rr_settings_panel_top'); ?>
	<div id="vp-wrap" class="vp-wrap">
		<div id="vp-option-panel"class="vp-option-panel <?php echo ($set->get_layout() === 'fixed') ? 'fixed-layout' : 'fluid-layout' ; ?>">
			<div class="vp-left-panel">
				<div id="vp-logo" class="vp-logo">
					<img src="<?php echo W2RR_VP_Util_Res::img($set->get_logo()); ?>" alt="<?php echo $set->get_title(); ?>" />
				</div>
				<div id="vp-menus" class="vp-menus">
					<ul class="vp-menu-level-1">
						<?php foreach ($set->get_menus() as $menu): ?>
						<?php $menus          = $set->get_menus(); ?>
						<?php $is_first_lvl_1 = $menu === reset($menus); ?>
						<?php if ($is_first_lvl_1): ?>
						<li class="vp-current">
						<?php else: ?>
						<li>
						<?php endif; ?>
							<?php if ($menu->get_menus()): ?>
							<a href="#<?php echo $menu->get_name(); ?>" class="vp-js-menu-dropdown vp-menu-dropdown">
							<?php else: ?>
							<a href="#<?php echo $menu->get_name(); ?>" class="vp-js-menu-goto vp-menu-goto">
							<?php endif; ?>
								<?php
								$icon = $menu->get_icon();
								$font_awesome = W2RR_VP_Util_Res::is_font_awesome($icon);
								if ($font_awesome !== false):
									W2RR_VP_Util_Text::print_if_exists($font_awesome, '<i class="w2rr-fa %s"></i>');
								else:
									W2RR_VP_Util_Text::print_if_exists(W2RR_VP_Util_Res::img($icon), '<i class="custom-menu-icon" style="background-image: url(\'%s\');"></i>');
								endif;
								?>
								<span><?php echo $menu->get_title(); ?></span>
							</a>
							<?php if ($menu->get_menus()): ?>
							<ul class="vp-menu-level-2">
								<?php foreach ($menu->get_menus() as $submenu): ?>
								<?php $submenus = $menu->get_menus(); ?>
								<?php if ($is_first_lvl_1 and $submenu === reset($submenus)): ?>
								<li class="vp-current">
								<?php else: ?>
								<li>
								<?php endif; ?>
									<a href="#<?php echo $submenu->get_name(); ?>" class="vp-js-menu-goto vp-menu-goto">
										<?php
										$sub_icon = $submenu->get_icon();
										$font_awesome = W2RR_VP_Util_Res::is_font_awesome($sub_icon);
										if ($font_awesome !== false):
											W2RR_VP_Util_Text::print_if_exists($font_awesome, '<i class="w2rr-fa %s"></i>');
										else:
											W2RR_VP_Util_Text::print_if_exists(W2RR_VP_Util_Res::img($sub_icon), '<i class="custom-menu-icon" style="background-image: url(\'%s\');"></i>');
										endif;
										?>
										<span><?php echo $submenu->get_title(); ?></span>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="vp-right-panel">
				<form id="vp-option-form" class="vp-option-form vp-js-option-form" method="POST">
					<div id="vp-submit-top" class="vp-submit top">
						<div class="inner">
							<input class="vp-save vp-button button button-primary" type="submit" value="<?php esc_attr_e('Save Changes', 'w2rr'); ?>" />
							<p class="vp-js-save-loader save-loader w2rr-display-none"><img src="<?php W2RR_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /><?php esc_html_e('Saving Now', 'w2rr'); ?></p>
							<p class="vp-js-save-status save-status w2rr-display-none"></p>
						</div>
					</div>
					<?php foreach ($set->get_menus() as $menu): ?>
					<?php $menus = $set->get_menus(); ?>
					<?php if ($menu === reset($menus)): ?>
						<?php echo $menu->render(array('current' => 1)); ?>
					<?php else: ?>
						<?php echo $menu->render(array('current' => 0)); ?>
					<?php endif; ?>
					<?php endforeach; ?>
					<div id="vp-submit-bottom" class="vp-submit bottom">
						<div class="inner">
							<input class="vp-save vp-button button button-primary" type="submit" value="<?php esc_attr_e('Save Changes', 'w2rr'); ?>" />
							<p class="vp-js-save-loader save-loader w2rr-display-none"><img src="<?php W2RR_VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /><?php esc_html_e('Saving Now', 'w2rr'); ?></p>
							<p class="vp-js-save-status save-status w2rr-display-none"></p>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php echo do_action('w2rr_settings_panel_bottom'); ?>
</div>