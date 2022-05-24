<?php

    use services\DbManager;

    function validateString(string $table, string $value, string $key, array $headers, DbManager $dbm){

        $value = htmlentities(trim($value), ENT_QUOTES);

        $not_null = $headers["is_null"] === "NO";
        $max_size = $headers["max_size"];
        $unique = $headers["key"] === "UNI";

        $str_len = strlen($value);

        if( $str_len > $max_size ){
            $dbm->getResponseHandler()->badRequest($dbm, ["$key"=>"value too long, max length is $max_size"]);
        }
        if($not_null && $str_len == 0){
            $dbm->getResponseHandler()->badRequest($dbm, ["$key"=>"value can not be empty"]);
        }
        if( $unique ){
            if( $dbm->getSQL(sprintf("SELECT $key from %s where $key = '%s'", $table, $value)) ){
                $dbm->getResponseHandler()->unprocessableEntity($dbm, ["$key"=>"$value is already taken"]);
            }
        }

        return $value;
    }

    function validateInteger(string $value, string $key, DbManager $dbm){

        if ( !is_numeric($value) ){
            $dbm->getResponseHandler()->badRequest($dbm, ["$key"=>"This is a numeric field"]);
            $dbm->closeConnection();
        }

        return intval($value);
    }

    function validateFloat(string $value, string $key, DbManager $dbm){

        if( !is_numeric($value) ){
            $dbm->getResponseHandler()->badRequest($dbm, ["$key"=>"This is a numeric field"]);
            $dbm->closeConnection();
        }

        return floatval($value);
    }