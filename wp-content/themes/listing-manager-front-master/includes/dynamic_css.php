<?php if (get_option('w2theme_header_bg_color')): ?>
.header {
	background-color: <?php echo get_option('w2theme_header_bg_color'); ?>;
}
<?php endif; ?>

<?php if (get_option('w2theme_header_padding')): ?>
.header {
	padding-bottom: <?php echo get_option('w2theme_header_padding'); ?>px;
}
<?php endif; ?>

<?php if (get_option('w2theme_header_menu_padding')): ?>
.site-navigation li {
	margin-left: <?php echo get_option('w2theme_header_menu_padding'); ?>px;
}
<?php endif; ?>

<?php if (get_option('w2theme_header_menu_font_size')): ?>
.site-navigation a {
	font-size: <?php echo get_option('w2theme_header_menu_font_size'); ?>px;
}
<?php endif; ?>