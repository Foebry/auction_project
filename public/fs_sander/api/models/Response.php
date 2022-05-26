<?php

namespace models;

class Response {

    function __construct($response, $code) {
        print( json_encode($response, JSON_NUMERIC_CHECK) );
        header("HTTP/1.1 $code");
        exit();
    }


    /**
     * @todo Create response class
     */

}
