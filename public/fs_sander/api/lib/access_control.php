<?php

header("Access-Control-Allow-Origin: https://auction-project.surge.sh");
// header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: content-type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS"){
    header("HTTP/1.1 200 OK");
    exit();
}