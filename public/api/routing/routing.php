<?php

$uri = $_SERVER["REQUEST_URI"];
$route = explode("/", $uri)[2];

switch ($route) {
    case "auctions":
        if ($uri === "/api/$route") handleAuctions();
        break;
    default:
        new ResponseError(404, "invalid Route");
        break;
}
