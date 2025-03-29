<?php

class BringticketMessageValidator {

	private $requiredKeys = [
		'version',
		'eventId',
		'event',
		'timestamp',
		'signature',
		'publicKeyURL',
		'message'
	];

	private $hostPattern = '/^[a-zA-Z0-9\-.]+\.bringticket\.com$/';

	private $algo = OPENSSL_ALGO_SHA256;

	private function generateSignableString(array $message) : string {
		$signableKeys = [
			'version',
			'eventId',
			'event',
			'timestamp',
			'message'
		];

		$signableString = '';
		foreach ($signableKeys as $key) {
			if (isset($message[$key])) {
				$signableString .= "{$key}\n{$message[$key]}\n";
			}
		}
		return $signableString;
	}

	private function validateRequiredKeys(array $message) : bool {
		foreach($this->requiredKeys as $key) {
			if(! isset($message[$key])) {
				return false;
			}
		}
		return true;
	}

	private function validateURL(string $url) : bool {
		$parsedUrl = parse_url($url);

		return ! (empty($parsedUrl['scheme'])
			|| empty($parsedUrl['host'])
			|| $parsedUrl["scheme"] != "https"
			|| substr($url, -4) !== '.pem'
			|| ! preg_match($this->hostPattern, $parsedUrl["host"])
		);
	}

	public function validate(array $message) : bool {
		if(! $this->validateRequiredKeys($message)
			|| ! $this->validateURL($message['publicKeyURL'])
		) {
			return false;
		}

		$certificate = @file_get_contents($message['publicKeyURL']);
		if($certificate === false) {
			return false;
		}

		$key = openssl_get_publickey($certificate);
		$signableString = $this->generateSignableString($message);
		$signature = base64_decode($message['signature']);

		return (openssl_verify($signableString, $signature, $key, $this->algo) === 1);
	}
}
