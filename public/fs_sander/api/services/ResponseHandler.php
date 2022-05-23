<?php

    class ResponseHandler {
        function __construct(){

        }

        function badRequest($msg=["message"=>"Bad Request"]){
            print(json_encode($msg));
            header('HTTP/1.1 400');
            exit();
        }

        function unauthorized($msg=["message"=>"Unauthorized"]){
            print(json_encode($msg));
            header("HTTP/1.1 403");
            exit();
        }

        function invalidRoute($msg=["message"=>"Not Found"]) {
            print(json_encode($msg));
            header('HTTP/1.1 404');
            exit();
        }

        function notAllowed($msg=["message"=>"Not Allowed"]){
            print(json_encode($msg));
            header('HTTP/1.1 405');
            exit();
        }

        function unprocessableEntity($msg=["message"=>"Unprocessable Entity"]){
            print(json_encode($msg));
            header("HTTP/1.1 422 Unproccessable Entity");
            exit();
        }

        function internalServerError($msg="Internal Server Error") {
            header("HTTP/1.1 500 $msg");
            exit();
        }
    }