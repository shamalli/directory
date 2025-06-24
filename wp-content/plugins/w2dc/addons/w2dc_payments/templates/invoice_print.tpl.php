<?php

// @codingStandardsIgnoreFile

$invoice_id = $_GET['invoice_id'];
$invoice = getInvoiceByID($invoice_id);

$bg_color = '#FFF';

?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="background-color: {$bg_color}">
	<div id="page" class="site w2dc-content w2dc-print">
		<div id="main" class="wrapper">
			<div class="w2dc-container-fluid entry-content">
				<?php the_custom_logo(); ?>
				
				<div class="w2dc-print-buttons w2dc-row w2dc-clearfix">
					<div class="w2dc-col-sm-12">
						<input type="button" onclick="window.print();" value="<?php esc_attr_e('Print invoice', 'w2dc'); ?>">
						<input type="button" onclick="window.close();" value="<?php esc_attr_e('Close window', 'w2dc'); ?>">
					</div>
				</div>

				<?php if (get_option('w2dc_allow_bank') && get_option('w2dc_bank_info')): ?>
				<h4><?php esc_html_e('Bank transfer information', 'w2dc'); ?></h4>
				<?php echo nl2br(get_option('w2dc_bank_info')); ?>
				<?php endif; ?>
				
				<br />
				<br />
				<br />
				<h4><?php esc_html_e('Invoice Info', 'w2dc'); ?></h4>
				<?php w2dc_renderTemplate(array(W2DC_PAYMENTS_TEMPLATES_PATH, 'info_metabox.tpl.php'), array('invoice' => $invoice)); ?>
				
				<br />
				<br />
				<br />
				<h4><?php esc_html_e('Invoice Log', 'w2dc'); ?></h4>
				<?php w2dc_renderTemplate(array(W2DC_PAYMENTS_TEMPLATES_PATH, 'log_metabox.tpl.php'), array('invoice' => $invoice)); ?>

				<div class="w2dc-print-buttons w2dc-row w2dc-clearfix">
					<div class="w2dc-col-sm-12">
						<input type="button" onclick="window.print();" value="<?php esc_attr_e('Print invoice', 'w2dc'); ?>">
						<input type="button" onclick="window.close();" value="<?php esc_attr_e('Close window', 'w2dc'); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
<?php wp_footer(); ?>
</body>
</html>