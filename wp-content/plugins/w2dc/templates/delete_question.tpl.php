<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php echo $heading; ?>
</h2>

<form action="" method="POST">
	<p>
		<?php echo $question; ?>
	</p>

	<?php submit_button(esc_html__('Delete', 'w2dc')); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>