<?php

use models\Container;
    
    /**
     * checkPayloadPOST
     *
     * @param  array $fields
     * @param  array $payload
     * @param  Container $container
     * @return void
     */
    function checkPayloadPOST(array $fields, array $payload, Container $container): void {

        foreach($fields as $field){
            if ( !in_array($field, array_keys($payload)) ){
                $container->getDbManager()->closeConnection();
                $container->getResponseHandler()->badRequest();
            }
        }
    }

    function checkPayloadPATCH(array $fields, array $payload, Container $container): string {

        $matching_fields = [];

        foreach($payload as $key=>$value) {
            if ( in_array($key, array_keys($fields)) ){
                $matching_fields[$key] = $value;
            }
        }
        if( $matching_fields === 0 ) $container->getResponseHandler()->badRequest();

        $update = [];

        foreach($matching_fields as $key=>$value) {
            if ($key === "usr_password") $value = password_hash($value, 1);
            $update[] = sprintf("$key='%s'", $value);
        }

        return implode(", ", $update);
    }

    function validateJWT(Container $container):array {

        //check if a HTTP_BEARER was sent
        if ( !isset( $_SERVER["HTTP_BEARER"] ) )
            $container->getResponseHandler()->unauthorized("no token present");
        
        $token = $_SERVER["HTTP_BEARER"];

        //check if token has correct structure
        if ( count( explode( ".", $token ) ) != 3 )
            $container->getResponseHandler()->unauthorized("incorrect token");

        [$header, $payload, $signature] = explode(".", $token);
        
        $header_decoded = json_decode(base64_decode($header), true);

        // if signature is faked, error code 
        if (hash_hmac($header_decoded["alg"], "BOO", "$header.$payload") !== $signature)
            $container->getResponseHandler()->unauthorized("incorrect token");
        
        // if signature is correct, return the userInformation + tokenExp as array
        return json_decode(base64_decode($payload), true);
    }

    function AdminRoute(Container $container) {
        $user_info = validateJWT($container);

        // check if user is admin
        if ( $user_info["isAdmin"] !== "1" )
            $container->getResponseHandler()->unauthorized();
    }

    function ProtectedRoute(Container $container) {

        return validateJWT($container);
    }
    