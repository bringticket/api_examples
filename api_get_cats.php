<?php
/**
 * This example shows how to get ticket categories of a event
 * URL: https://developer.bringticket.com/#tag/Events/paths/~1v1~1event~1categories/get
 */

include("misc.php");
$apiCreds = include("api.php");

$eventId = 20;

// send request
send_request($apiCreds["apiToken"], $apiCreds["apiSecret"], "/v1/event/categories?eventId=".$eventId, "", "GET", $apiCreds["testSystem"]);
?>
