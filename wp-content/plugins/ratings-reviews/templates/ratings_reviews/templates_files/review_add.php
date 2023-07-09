<?php
	if (!defined('ABSPATH')) die('You cannot access this template file directly');
?>

<?php 
$controller = new w2rr_add_review_controller();
$controller->init(array(
	'comments_template' => true
));
w2rr_setFrontendController(W2RR_ADD_REVIEW_PAGE_SHORTCODE, $controller);

echo $controller->display();

?>