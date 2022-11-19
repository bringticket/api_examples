<?php
/**
 * This example shows how get all available events
 * URL: https://developer.bringticket.com/#tag/Events/paths/~1v1~1events/get
 */

include("misc.php");
$apiCreds = include("api.php");

// send request
send_request($apiCreds["apiToken"], $apiCreds["apiSecret"], "/v1/events", "", "GET", $apiCreds["testSystem"]);
?>
