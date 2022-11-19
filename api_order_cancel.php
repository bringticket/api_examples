<?php
/**
 * This example shows how to cancel a order
 * URL: https://developer.bringticket.com/#tag/Ticket-order/paths/~1v1~1order~1cancel/delete
 */

include("misc.php");
$apiCreds = include("api.php");

// define payload
$data = array(
    "orderId" => 30233
);
$payload = json_encode($data);

// send request
send_request($apiCreds["apiToken"], $apiCreds["apiSecret"], "/v1/order/cancel", $payload, "DELETE", $apiCreds["testSystem"]);
?>
