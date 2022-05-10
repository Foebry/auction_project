<?php

    class ResponseHandler {
        function __construct(){

        }

        function badRequest($msg="Bad Request"){
            header('HTTP/1.1 400 '.$msg);
            exit();
        }

        function invalidRoute() {
            header('HTTP/1.1 404 Not Found');
            exit();
        }

        function notAllowed(){
            header('HTTP/1.1 405 Not Allowed');
            exit();
        }

        function unprocessableEntity($msg="Unprocessable Entity"){
            header("HTTP/1.1 422 $msg");
            exit();
        }

        function internalServerError($msg="Internal Server Error ENCOUNTERED") {
            header("HTTP/1.1 500 $msg");
            exit();
        }
    }