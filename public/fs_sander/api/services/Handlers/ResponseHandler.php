<?php

    namespace services\handlers;

    use services\DbManager;

    class ResponseHandler {

        function render($template): void{
            print(file_get_contents("./templates/$template"));
            exit();
        }

        function badRequest(DbManager $dbm=null, $msg=[]){
            $dbm && $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Bad Request"], $msg)));
            header('HTTP/1.1 400');
            exit();
        }

        function unauthorized(DbManager $dbm, $msg=[]){
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Unauthorized"], $msg)));
            header("HTTP/1.1 403");
            exit();
        }

        function notFound(DbManager $dbm=null, $msg=[]) {
            $dbm && $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Not Found"], $msg)));
            header('HTTP/1.1 404');
            exit();
        }

        function notAllowed(DbManager $dbm=null, $msg=[]){
            $dbm && $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Not Allowed"], $msg)));
            header('HTTP/1.1 405');
            exit();
        }

        function unprocessableEntity(DbManager $dbm, $msg=[]){
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Unproccessable Entity"], $msg)));
            header("HTTP/1.1 422");
            exit();
        }

        function internalServerError(DbManager $dbm, $msg=[]) {
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Internal Server Error"], $msg)));
            header("HTTP/1.1 500");
            exit();
        }
    }