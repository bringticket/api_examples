<?php
/**
 * This example shows how to send a ticket order with personalised tickets
 * URL: https://developer.bringticket.com/#tag/Ticket-order/paths/~1v1~1ticket~1order~1personalised/post
 */

include("misc.php");
$apiCreds = include("api.php");

// define payload
$data = array(
    "categoryId" => 12,
    "email" => "test@example.com",
    "firstName" => "Max",
    "lastName" => "Muster",
    "guests" => array(
        array(
            "firstName" => "Max",
            "lastName" => "Muster"
        ),
        array(
            "firstName" => "Karl",
            "lastName" => "Muster"
        )
    )  
);
$payload = json_encode($data);

// send request
send_request($apiCreds["apiToken"], $apiCreds["apiSecret"], "/v1/ticket/order/personalised", $payload, "POST", $apiCreds["testSystem"]);
?>
