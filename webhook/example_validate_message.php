<?php
include(__DIR__."/BringticketMessageValidator.php");

$webhookMsg = [
  'version' => 1,
  'eventId' => '260d208b-0f56-4333-b58b-856125b43a54',
  'event' => 'category.reservation.created',
  'timestamp' => 1743099881043,
  'message' => '{"amount":1,"category":{"categoryId":"tc_7Q3gwypJCIOHeqHzCXNb3C","current":971,"max":1000}}',
  'publicKeyURL' => 'https://example.com/certificate/example.pem',
  'signature' => 'example_signature',
];

$validator = new BringticketMessageValidator();
if(! $validator->validate($webhookMsg)) {
	echo "Message is not valid\n";
	exit(1);
}

echo "Message is valid\n";
