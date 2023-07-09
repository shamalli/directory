<?php

include 'license-products.php';

if (!empty($_GET['product'])) {
	global $products;
	
	$product_slug = strip_tags($_GET['product']);
	
	foreach ($products AS $product) {
		if ($product['slug'] == $product_slug) {
			echo $product['version'];
			break;
		}
	}
}

?>