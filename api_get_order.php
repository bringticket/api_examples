<?php
/**
 * This example shows how to get a order status
 * URL: https://developer.bringticket.com/#tag/Ticket-order/paths/~1v1~1ticket~1order~1status/get
 */

include("misc.php");
$apiCreds = include("api.php");

$orderId = 30233;

// send request
send_request($apiCreds["apiToken"], $apiCreds["apiSecret"], "/v1/ticket/order/status?orderId=".$orderId, "", "GET", true);
?>
