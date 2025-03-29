<?php
/**
 * This example shows how to send a simple ticket order
 * URL: https://developer.bringticket.com/#tag/Ticket-order/paths/~1v1~1ticket~1order/post
 */

include("../misc.php");
$apiCreds = include("../api.php");

// define payload
$data = array(
    "categoryId" => 13,
    "email" => "test@example.com",
    "firstName" => "Max",
    "lastName" => "Muster",
    "amount" => 1
);
$payload = json_encode($data);

// send request
send_request($apiCreds["apiToken"], $apiCreds["apiSecret"], "/v1/ticket/order", $payload, "POST", $apiCreds["testSystem"]);
?>
