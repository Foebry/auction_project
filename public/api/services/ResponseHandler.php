<?php

    class ResponseHandler {
        function __construct(){

        }

        function notAllowed(){
            header('HTTP/1.1 405 Not Allowed');
            exit();
        }

        function invalidRoute() {
            header('HTTP/1.1 404 Not Found');
            exit();
        }
    }