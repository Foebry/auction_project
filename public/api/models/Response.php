<?php
// print($_SERVER["REQUEST_URI"]);
class Response
{
    function __construct()
    {
    }
}

class ResponseError
{
    function __construct(int $status_code, string $message = "")
    {
        header("HTTP/1.1 $status_code $message");
        exit();
    }
}
