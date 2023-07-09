<?php if (w2rr_get_dynamic_option('w2rr_links_color')): ?>
div.w2rr-content a,
div.w2rr-content a:visited,
div.w2rr-content a:focus,
div.w2rr-content.w2rr-widget a,
div.w2rr-content.w2rr-widget a:visited,
div.w2rr-content.w2rr-widget a:focus,
div.w2rr-content .w2rr-btn-default, div.w2rr-content div.w2rr-btn-default:visited, div.w2rr-content .w2rr-btn-default:focus {
	color: <?php echo w2rr_get_dynamic_option('w2rr_links_color'); ?>;
}
<?php endif; ?>
<?php if (w2rr_get_dynamic_option('w2rr_links_hover_color')): ?>
div.w2rr-content a:hover,
div.w2rr-content .w2rr-pagination > li > a:hover {
	color: <?php echo w2rr_get_dynamic_option('w2rr_links_hover_color'); ?>;
}
<?php endif; ?>

<?php if (w2rr_get_dynamic_option('w2rr_button_1_color') && w2rr_get_dynamic_option('w2rr_button_2_color') && w2rr_get_dynamic_option('w2rr_button_text_color')): ?>
<?php if (!w2rr_get_dynamic_option('w2rr_button_gradient')): ?>
div.w2rr-content .w2rr-btn-primary,
div.w2rr-content a.w2rr-btn-primary,
div.w2rr-content input[type="submit"],
div.w2rr-content input[type="button"],
div.w2rr-content .w2rr-btn-primary:visited,
div.w2rr-content a.w2rr-btn-primary:visited,
div.w2rr-content input[type="submit"]:visited,
div.w2rr-content input[type="button"]:visited,
div.w2rr-content .w2rr-btn-primary:focus,
div.w2rr-content a.w2rr-btn-primary:focus,
div.w2rr-content input[type="submit"]:focus,
div.w2rr-content input[type="button"]:focus,
div.w2rr-content .w2rr-btn-primary:disabled,
div.w2rr-content a.w2rr-btn-primary:disabled,
div.w2rr-content .w2rr-btn-primary:disabled:focus,
div.w2rr-content a.w2rr-btn-primary:disabled:focus,
div.w2rr-content .w2rr-btn-primary:disabled:hover,
div.w2rr-content a.w2rr-btn-primary:disabled:hover,
form.w2rr-content .w2rr-btn-primary,
form.w2rr-content a.w2rr-btn-primary,
form.w2rr-content input[type="submit"],
form.w2rr-content input[type="button"],
form.w2rr-content .w2rr-btn-primary:visited,
form.w2rr-content a.w2rr-btn-primary:visited,
form.w2rr-content input[type="submit"]:visited,
form.w2rr-content input[type="button"]:visited,
form.w2rr-content .w2rr-btn-primary:focus,
form.w2rr-content a.w2rr-btn-primary:focus,
form.w2rr-content input[type="submit"]:focus,
form.w2rr-content input[type="button"]:focus,
form.w2rr-content .w2rr-btn-primary:disabled,
form.w2rr-content a.w2rr-btn-primary:disabled,
form.w2rr-content .w2rr-btn-primary:disabled:focus,
form.w2rr-content a.w2rr-btn-primary:disabled:focus,
form.w2rr-content .w2rr-btn-primary:disabled:hover,
form.w2rr-content a.w2rr-btn-primary:disabled:hover,
div.w2rr-content .wpcf7-form .wpcf7-submit,
div.w2rr-content .wpcf7-form .wpcf7-submit:visited,
div.w2rr-content .wpcf7-form .wpcf7-submit:focus {
	color: <?php echo w2rr_get_dynamic_option('w2rr_button_text_color'); ?>;
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?>;
	background-image: none;
	border-color: <?php echo w2rr_adjust_brightness(w2rr_get_dynamic_option('w2rr_button_1_color'), -20); ?>;
}
div.w2rr-content .w2rr-btn-primary:hover,
div.w2rr-content a.w2rr-btn-primary:hover,
div.w2rr-content input[type="submit"]:hover,
div.w2rr-content input[type="button"]:hover,
form.w2rr-content .w2rr-btn-primary:hover,
form.w2rr-content a.w2rr-btn-primary:hover,
form.w2rr-content input[type="submit"]:hover,
form.w2rr-content input[type="button"]:hover,
div.w2rr-content .wpcf7-form .wpcf7-submit:hover {
	color: <?php echo w2rr_get_dynamic_option('w2rr_button_text_color'); ?>;
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?>;
	background-image: none;
	border-color: <?php echo w2rr_adjust_brightness(w2rr_get_dynamic_option('w2rr_button_2_color'), -20); ?>;
	text-decoration: none;
}
<?php else: ?>
div.w2rr-content .w2rr-btn-primary:not(.w2rr-review-votes-button),
div.w2rr-content a.w2rr-btn-primary:not(.w2rr-review-votes-button),
div.w2rr-content input[type="submit"],
div.w2rr-content input[type="button"],
div.w2rr-content .w2rr-btn-primary:visited,
div.w2rr-content a.w2rr-btn-primary:visited,
div.w2rr-content input[type="submit"]:visited,
div.w2rr-content input[type="button"]:visited,
div.w2rr-content .w2rr-btn-primary:focus,
div.w2rr-content a.w2rr-btn-primary:focus,
div.w2rr-content input[type="submit"]:focus,
div.w2rr-content input[type="button"]:focus,
div.w2rr-content .w2rr-btn-primary:disabled,
div.w2rr-content a.w2rr-btn-primary:disabled,
div.w2rr-content .w2rr-btn-primary:disabled:focus,
div.w2rr-content a.w2rr-btn-primary:disabled:focus,
form.w2rr-content .w2rr-btn-primary,
form.w2rr-content a.w2rr-btn-primary,
form.w2rr-content input[type="submit"],
form.w2rr-content input[type="button"],
form.w2rr-content .w2rr-btn-primary:visited,
form.w2rr-content a.w2rr-btn-primary:visited,
form.w2rr-content input[type="submit"]:visited,
form.w2rr-content input[type="button"]:visited,
form.w2rr-content .w2rr-btn-primary:focus,
form.w2rr-content a.w2rr-btn-primary:focus,
form.w2rr-content input[type="submit"]:focus,
form.w2rr-content input[type="button"]:focus,
form.w2rr-content .w2rr-btn-primary:disabled,
form.w2rr-content a.w2rr-btn-primary:disabled,
form.w2rr-content .w2rr-btn-primary:disabled:focus,
form.w2rr-content a.w2rr-btn-primary:disabled:focus,
div.w2rr-content .w2rr-review-frontpanel input[type="button"],
div.w2rr-content .wpcf7-form .wpcf7-submit,
div.w2rr-content .wpcf7-form .wpcf7-submit:visited,
div.w2rr-content .wpcf7-form .wpcf7-submit:focus {
	background: <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> !important;
	background: -moz-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 100%) !important;
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?>), color-stop(100%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?>)) !important;
	background: -webkit-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 100%) !important;
	background: -o-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 100%) !important;
	background: -ms-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 100%) !important;
	background: linear-gradient(to bottom, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr= <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> , endColorstr= <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> ,GradientType=0 ) !important;
	color: <?php echo w2rr_get_dynamic_option('w2rr_button_text_color'); ?>;
	background-position: center !important;
	border: none;
}
div.w2rr-content .w2rr-btn-primary:hover,
div.w2rr-content a.w2rr-btn-primary:hover,
div.w2rr-content input[type="submit"]:hover,
div.w2rr-content input[type="button"]:hover,
form.w2rr-content .w2rr-btn-primary:hover,
form.w2rr-content a.w2rr-btn-primary:hover,
form.w2rr-content input[type="submit"]:hover,
form.w2rr-content input[type="button"]:hover,
div.w2rr-content .w2rr-review-frontpanel input[type="button"]:hover,
div.w2rr-content .wpcf7-form .wpcf7-submit:hover {
	background: <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> !important;
	background: -moz-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 100%) !important;
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?>), color-stop(100%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?>)) !important;
	background: -webkit-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 100%) !important;
	background: -o-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 100%) !important;
	background: -ms-linear-gradient(top, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 100%) !important;
	background: linear-gradient(to bottom, <?php echo w2rr_get_dynamic_option('w2rr_button_2_color'); ?> 0%, <?php echo w2rr_get_dynamic_option('w2rr_button_1_color'); ?> 100%) !important;
	color: <?php echo w2rr_get_dynamic_option('w2rr_button_text_color'); ?>;
	background-position: center !important;
	border: none;
	text-decoration: none;
}
<?php endif; ?>
<?php endif; ?>

<?php if (w2rr_get_dynamic_option('w2rr_primary_color')): ?>
div.w2rr-content .w2rr-pagination > li.w2rr-active > a,
div.w2rr-content .w2rr-pagination > li.w2rr-active > span,
div.w2rr-content .w2rr-pagination > li.w2rr-active > a:hover,
div.w2rr-content .w2rr-pagination > li.w2rr-active > span:hover,
div.w2rr-content .w2rr-pagination > li.w2rr-active > a:focus,
div.w2rr-content .w2rr-pagination > li.w2rr-active > span:focus {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
	border-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
	color: #FFFFFF;
}
.w2rr-rating-avgvalue .w2rr-rating-avgvalue-digit {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-loader:before {
	border-top-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
	border-bottom-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-review-rating-criterias .w2rr-progress-bar {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-progress-circle span {
	color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-progress-circle.w2rr-over50 .w2rr-first50-bar {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-progress-circle .w2rr-value-bar {
	border-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-ratings-overall .w2rr-progress-bar {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
input[type="range"].w2rr-range-slider-input,
ul.w2rr-range-slider-labels .w2rr-range-slider-labels-selected::before {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-bx-pager a.active img {
	border: 1px solid <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
.w2rr-review-dialog.ui-dialog .ui-widget-header {
	background-color: <?php echo w2rr_get_dynamic_option('w2rr_primary_color'); ?>;
}
<?php endif; ?>

<?php if (w2rr_get_dynamic_option('w2rr_stars_color')): ?>
label.w2rr-rating-icon {
	color: <?php echo w2rr_get_dynamic_option('w2rr_stars_color'); ?>;
}
<?php endif; ?>

<?php if (w2rr_get_dynamic_option('w2rr_share_buttons_width')): ?>
.w2rr-content .w2rr-share-button img {
	max-width: <?php echo get_option('w2rr_share_buttons_width'); ?>px;
}
.w2rr-content .w2rr-share-buttons {
	height: <?php echo get_option('w2rr_share_buttons_width')+10; ?>px;
}
<?php endif; ?>

<?php if (!w2rr_get_dynamic_option('w2rr_100_single_logo_width')): ?>
/* It works with devices width more than 768 pixels. */
@media screen and (min-width: 768px) {
	.w2rr-single-review-logo-wrap {
		max-width: <?php echo w2rr_get_dynamic_option('w2rr_single_logo_width'); ?>px;
		float: left;
		margin: 0 20px 20px 0;
	}
	.rtl .w2rr-single-review-logo-wrap {
		float: right;
		margin: 0 0 20px 20px;
	}
}
<?php endif; ?>