<?php

function generate_mac($endpoint, $unixTimestamp, $payload, $privateKey, $algo = "sha256") {
	if(! is_string($payload)) {
		throw new Exception("payload is not a string");
	}
	$unhashed = $endpoint.$unixTimestamp.$payload;
	return hash_hmac($algo, $unhashed, $privateKey);
}

function send_request($apiToken, $apiSecret, $endpoint, $payload = "", $method = "POST", $testSystem=false) {
	$timestamp = time();

	// generate mac with your API secret
	$mac = generate_mac($endpoint, $timestamp, $payload, $apiSecret);
	$baseUrl = ($testSystem) ? "https://testapi.bringticket.com" : "https://api.bringticket.com";

	// make a http request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $baseUrl.$endpoint);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	// set all necessary headers
	$headers = array(
		'X-API-KEY: '.$apiToken,
		'X-API-HASH: '.$mac,
		'X-API-TIMESTAMP: '.$timestamp
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// add payload
	if($method != "GET" && strlen($payload) > 0) {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	}

	// send request
	$serverOutput = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	// print response
	echo "Response Code: ".$httpCode."\n".json_encode(json_decode($serverOutput), JSON_PRETTY_PRINT)."\n";
}

?>