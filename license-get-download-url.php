<?php

include 'license-products.php';



if (!empty($_GET['purchase_code'])) {

	$purchase_code = strip_tags($_GET['purchase_code']);
	$host = strip_tags($_GET['host']);

	$url = "https://salephpscripts.com/license-get-download-url?purchase_code=" . $purchase_code . "&host=" . $host;
	
} elseif (!empty($_GET['product'])) {

	$product = strip_tags($_GET['product']);
	$host = strip_tags($_GET['host']);

	$url = "https://salephpscripts.com/license-get-download-url?product=" . $product . "&host=" . $host;
}




if (!empty($_GET['purchase_code']) || !empty($_GET['product'])) {
	
	$curl = curl_init($url);
	
	$header = array();
	$header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0';
	$header[] = 'timeout: 20';
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
	curl_setopt($curl, CURLOPT_REFERER, $_SERVER["HTTP_HOST"]);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($curl, CURLOPT_TIMEOUT, 20);
	
	if (($salephpscripts_res = curl_exec($curl)) !== false) {
	
		$salephpscripts_res = str_replace("https://salephpscripts.com/license-download", "https://webdev-cdn.com/license-download.php", $salephpscripts_res);
	
		echo $salephpscripts_res;
	}
	
	curl_close($curl);
}

?>