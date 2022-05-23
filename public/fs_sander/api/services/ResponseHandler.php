<?php

    use services\DbManager;

    class ResponseHandler {

        function badRequest(DbManager $dbm, $msg=[]){
            $dbm->closeConnection();
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

        function invalidRoute(DbManager $dbm, $msg=[]) {
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Not Found"], $msg)));
            header('HTTP/1.1 404');
            exit();
        }

        function notAllowed(DbManager $dbm, $msg=[]){
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Not Allowed"], $msg)));
            header('HTTP/1.1 405');
            exit();
        }

        function unprocessableEntity(DbManager $dbm, $msg=[]){
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Unproccessable Entity"], $msg)));
            header("HTTP/1.1 422 Unproccessable Entity");
            exit();
        }

        function internalServerError(DbManager $dbm, $msg=[]) {
            $dbm->closeConnection();
            print(json_encode(array_merge(["message"=>"Internal Server Error"], $msg)));
            header("HTTP/1.1 500 $msg");
            exit();
        }
    }