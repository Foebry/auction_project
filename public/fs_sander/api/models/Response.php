<?php

namespace models;

class Response {

    function __construct($response) {

        print( json_encode($response, JSON_NUMERIC_CHECK) );
        exit();
    }


    /**
     * @todo Create response class
     */

}
