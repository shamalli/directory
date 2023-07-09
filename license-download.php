<?php

include 'license-products.php';

if (!empty($_GET['purchase_code'])) {

	$purchase_code = strip_tags($_GET['purchase_code']);
	$product_id = strip_tags($_GET['product_id']);
	$expires = strip_tags($_GET['expires']);
	$token = strip_tags($_GET['token']);
	$referer = strip_tags($_GET['referer']);

	$url = "https://salephpscripts.com/license-check-download-url?token=" . $token . '&expires=' . $expires . '&product_id=' . $product_id . '&purchase_code=' . $purchase_code . '&referer=' . $referer;
	
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
	
	if (($product_id = curl_exec($curl)) !== false) {
		curl_close($curl);
	
		global $products;
	
		if (array_key_exists($product_id, $products)) {
			$file = 'downloads/' . $products[$product_id]['file'];
	
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . basename($file) . '"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			//Clear system output buffer
			flush();
			echo (file_get_contents($file));
				
				
				
			$url = "https://salephpscripts.com/license-increase-downloads?purchase_code=" . $purchase_code;
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
				
			curl_close($curl);
		}
	}
} elseif (!empty($_GET['product_id'])) {

	$product_id = strip_tags($_GET['product_id']);
	$expires = strip_tags($_GET['expires']);
	$token = strip_tags($_GET['token']);
	$referer = strip_tags($_GET['referer']);
	
	$url = "https://salephpscripts.com/license-check-download-url?token=" . $token . '&expires=' . $expires . '&product_id=' . $product_id . '&referer=' . $referer;
	
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
	
	if (($product_id = curl_exec($curl)) !== false) {
		curl_close($curl);
	
		global $products;
	
		if (array_key_exists($product_id, $products)) {
			$file = 'downloads/' . $products[$product_id]['file'];
	
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . basename($file) . '"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			//Clear system output buffer
			flush();
			echo (file_get_contents($file));
				
				
				
			logFreeDownloadsAccess('SUCCESS DOWNLOAD');
		}
	}
}

function logFreeDownloadsAccess($result = 'SUCCESS') {

	// Timestamp
	$text = '[' . date('m/d/Y g:i A').'] - ';

	$text .= "Result: " . $result . "\n";

	// Log the GET variables
	$text .= "GET:\n";
	$text .= serialize($_GET);

	// Write to log
	$fp = fopen('free_downloads_access.log','a');
	fwrite($fp, $text . "\n\n");
	fclose($fp);
}


?>